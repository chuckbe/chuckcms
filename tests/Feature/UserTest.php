<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Mail\UserActivationMail;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UserTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->seedCms();
        Mail::fake();
    }

    public function test_invited_user_can_activate_their_account(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/user/invite', ['name' => 'Editor', 'email' => 'editor@smoke.test', 'role' => 'moderator'])
            ->assertRedirect();

        $user = User::where('email', 'editor@smoke.test')->firstOrFail();
        $this->assertSame(0, (int) $user->active);
        $this->assertTrue($user->hasRole('moderator'));
        Mail::assertSent(UserActivationMail::class);

        auth()->logout();

        $this->get('/activate/user/'.$user->token)->assertOk();

        $this->post('/activate/user', [
            '_user_token'    => $user->token,
            '_user_id'       => $user->id,
            'password'       => 'Str0ng!Pass',
            'password_again' => 'Str0ng!Pass',
        ])->assertRedirect(route('login'));

        $user->refresh();
        $this->assertSame(1, (int) $user->active);
        $this->assertTrue(Hash::check('Str0ng!Pass', $user->password));
    }

    public function test_weak_password_is_rejected_on_activation(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/user/invite', ['name' => 'Editor', 'email' => 'editor@smoke.test', 'role' => 'moderator']);
        $user = User::where('email', 'editor@smoke.test')->firstOrFail();
        auth()->logout();

        $this->post('/activate/user', [
            '_user_token'    => $user->token,
            '_user_id'       => $user->id,
            'password'       => 'abcdefg1',
            'password_again' => 'abcdefg1',
        ])->assertSessionHasErrors('password');

        $this->assertSame(0, (int) $user->fresh()->active);
    }

    public function test_invitation_can_be_resent_and_user_deleted(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/user/invite', ['name' => 'Editor', 'email' => 'editor@smoke.test', 'role' => 'moderator']);
        $user = User::where('email', 'editor@smoke.test')->firstOrFail();

        $this->actingAs($this->admin)
            ->post('/dashboard/user/resend-invation', ['user_id' => $user->id])
            ->assertOk()
            ->assertSeeText('success');
        Mail::assertSent(UserActivationMail::class, 2);

        $this->actingAs($this->admin)
            ->post('/dashboard/user/delete', ['user_id' => $user->id])
            ->assertOk()
            ->assertSeeText('success');
        $this->assertNull(User::find($user->id));
    }

    public function test_role_can_be_created_and_its_permissions_saved(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/users/role/create', ['role_name' => 'editor', 'role_redirect' => '/dashboard/pages'])
            ->assertRedirect();
        $role = Role::findByName('editor');

        $this->actingAs($this->admin)
            ->post('/dashboard/users/role/save', [
                'role_id'            => $role->id,
                'role_name'          => 'editor',
                'role_redirect'      => '/dashboard',
                'permissions_name'   => ['show pages', 'edit pages'],
                'permissions_active' => ['1', '0'],
            ])
            ->assertRedirect();

        $role = Role::findByName('editor');
        $this->assertTrue($role->hasPermissionTo('show pages'));
        $this->assertFalse($role->hasPermissionTo('edit pages'));
        $this->assertSame('/dashboard', $role->redirect);
    }
}
