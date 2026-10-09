<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Mail\FormActionMail;
use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Models\FormEntry;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Spatie\Honeypot\EncryptedTime;

class FormTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->seedCms();
        Mail::fake();
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('files'));

        parent::tearDown();
    }

    public function test_form_can_be_created_and_saved_from_the_builder(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/forms/create', ['title' => 'Contact', 'slug' => 'contact'])
            ->assertRedirect();

        $form = Form::where('slug', 'contact')->firstOrFail();
        $this->assertTrue($form->form['actions']['store']);
        $this->assertFalse($form->form['actions']['send']);

        $this->actingAs($this->admin)
            ->post('/dashboard/forms/save', $this->builderPayload($form))
            ->assertRedirect(route('dashboard.forms'));

        $form->refresh();
        $this->assertSame(['contact_name', 'contact_email', 'contact_cv'], array_keys($form->form['fields']));
        $this->assertSame('required|email', $form->form['fields']['contact_email']['validation']);
        $this->assertSame(['id' => 'cv'], $form->form['fields']['contact_cv']['attributes']);
        $this->assertTrue($form->form['actions']['store']);
        $this->assertTrue($form->form['files']);
        $this->assertSame('admin@smoke.test', $form->form['actions']['send']['notify']['to']);
        $this->assertNull($form->form['actions']['send']['notify']['from_name']);
        $this->assertSame('http://smoke.test/thanks', $form->form['actions']['redirect']);
    }

    public function test_submission_is_stored_and_mailed_with_placeholders_filled_in(): void
    {
        $form = $this->savedForm();

        $this->submit($form, ['contact_name' => 'Jane', 'contact_email' => 'jane@example.test'])
            ->assertRedirect('http://smoke.test/thanks');

        $entry = FormEntry::where('slug', 'contact')->firstOrFail();
        $this->assertSame('Jane', $entry->entry['contact_name']);

        Mail::assertSent(FormActionMail::class, function (FormActionMail $mail) {
            return $mail->mailData['to'] === 'admin@smoke.test'
                && $mail->mailData['subject'] === 'New message from Jane'
                && $mail->mailData['from_name'] === null;
        });
    }

    public function test_form_that_does_not_store_entries_still_sends_mail(): void
    {
        $form = $this->savedForm(['action_store' => 'false']);

        $this->submit($form, ['contact_name' => 'Jane', 'contact_email' => 'jane@example.test'])
            ->assertRedirect('http://smoke.test/thanks');

        $this->assertSame(0, FormEntry::count());
        Mail::assertSent(FormActionMail::class, 1);
    }

    public function test_uploaded_file_is_stored_and_attached(): void
    {
        $form = $this->savedForm(['action_send_files' => ['true']]);

        $this->submit($form, [
            'contact_name'  => 'Jane',
            'contact_email' => 'jane@example.test',
            'contact_cv'    => UploadedFile::fake()->create('cv.pdf', 10, 'application/pdf'),
        ])->assertRedirect('http://smoke.test/thanks');

        $path = FormEntry::firstOrFail()->entry['contact_cv'];
        $this->assertMatchesRegularExpression('#^/files/uploads/\d+_\w{8}\.pdf$#', $path);
        $this->assertFileExists(public_path($path));

        Mail::assertSent(FormActionMail::class, fn (FormActionMail $mail) => $mail->mailData['files'] === [$path]);
    }

    public function test_form_without_redirect_sends_visitor_to_site_root(): void
    {
        $form = $this->savedForm(['action_redirect' => '']);

        $this->submit($form, ['contact_name' => 'Jane', 'contact_email' => 'jane@example.test'])
            ->assertRedirect('http://localhost');
    }

    public function test_invalid_submission_is_rejected(): void
    {
        $form = $this->savedForm();

        $this->submit($form, ['contact_name' => 'Jane', 'contact_email' => 'not-an-email'])
            ->assertSessionHasErrors('contact_email');

        $this->assertSame(0, FormEntry::count());
        Mail::assertNothingSent();
    }

    public function test_honeypot_rejects_bots(): void
    {
        $form = $this->savedForm();

        // Filled-in hidden field.
        $this->submit($form, ['contact_name' => 'Bot', 'contact_email' => 'bot@example.test', 'my_name_x1' => 'spam'])
            ->assertOk()
            ->assertContent('');

        // Submitted before the form's valid-from time.
        $this->submit($form, ['contact_name' => 'Bot', 'contact_email' => 'bot@example.test', 'valid_from' => EncryptedTime::create(now()->addMinute())])
            ->assertOk()
            ->assertContent('');

        $this->assertSame(0, FormEntry::count());
        Mail::assertNothingSent();
    }

    public function test_rendered_form_contains_the_honeypot_fields(): void
    {
        $form = $this->savedForm();

        $html = app(\Chuckbe\Chuckcms\Chuck\PageBlockRepository::class)
            ->getRenderedByPageBlock((object) ['id' => 1, 'page_id' => 1, 'name' => 'f', 'slug' => 'f', 'lang' => 'nl', 'body' => '[FORM='.$form->slug.']'])['body'];

        $this->assertStringContainsString('name="my_name_', $html);
        $this->assertStringContainsString('name="valid_from"', $html);
    }

    public function test_legacy_honeypot_generate_call_renders_the_new_fields(): void
    {
        // Templates written for msurguy/honeypot still call this.
        $html = (string) \Honeypot::generate('chuck_telephone', 'chuck_email');

        $this->assertStringContainsString('name="my_name_', $html);
        $this->assertStringContainsString('name="valid_from"', $html);
    }

    public function test_form_can_be_deleted_with_its_entries(): void
    {
        $form = $this->savedForm();
        $this->submit($form, ['contact_name' => 'Jane', 'contact_email' => 'jane@example.test']);

        $this->actingAs($this->admin)
            ->post('/dashboard/forms/delete', ['form_id' => $form->id])
            ->assertOk()
            ->assertSeeText('success');

        $this->assertSame(0, Form::count());
        $this->assertSame(0, FormEntry::count());
    }

    private function savedForm(array $overrides = []): Form
    {
        $this->actingAs($this->admin)->post('/dashboard/forms/create', ['title' => 'Contact', 'slug' => 'contact']);
        $form = Form::where('slug', 'contact')->firstOrFail();

        $this->actingAs($this->admin)->post('/dashboard/forms/save', array_replace($this->builderPayload($form), $overrides));
        auth()->logout();

        return $form->refresh();
    }

    private function submit(Form $form, array $fields)
    {
        return $this->post('/forms/validate', array_replace([
            '_form_slug' => $form->slug,
            'my_name_x1' => '',
            'valid_from' => EncryptedTime::create(now()->subMinute()),
        ], $fields));
    }

    /**
     * What forms/edit.blade.php posts: one row per field, one per send action.
     * The sender name is left empty on purpose (stored as null).
     */
    private function builderPayload(Form $form): array
    {
        return [
            'form_id'                 => $form->id,
            'form_title'              => 'Contact',
            'form_slug'               => 'contact',
            'fields_slug'             => ['name', 'email', 'cv'],
            'fields_label'            => ['Name', 'Email', 'CV'],
            'fields_type'             => ['text', 'email', 'file'],
            'fields_class'            => ['form-control', 'form-control', 'form-control'],
            'fields_parentclass'      => ['', '', ''],
            'fields_placeholder'      => ['Name', 'Email', ''],
            'fields_validation'       => ['required', 'required|email', 'nullable|file'],
            'fields_value'            => ['', '', ''],
            'fields_attributes_name'  => ['', '', 'id'],
            'fields_attributes_value' => ['', '', 'cv'],
            'fields_required'         => ['true', 'true', 'false'],
            'action_store'            => 'true',
            'files_allowed'           => 'true',
            'action_redirect'         => 'http://smoke.test/thanks',
            'action_send'             => 'true',
            'action_send_slug'        => ['notify'],
            'action_send_to'          => ['admin@smoke.test'],
            'action_send_to_name'     => ['Admin'],
            'action_send_from'        => ['noreply@smoke.test'],
            'action_send_from_name'   => [''],
            'action_send_subject'     => ['New message from [contact_name]'],
            'action_send_body'        => ['[contact_name] wrote in.'],
            'action_send_files'       => ['false'],
            'action_send_template'    => ['chuckcms::backend.emails.form'],
            'button_class'            => 'btn btn-primary',
            'button_label'            => 'Send',
            'button_id'               => 'send',
        ];
    }
}
