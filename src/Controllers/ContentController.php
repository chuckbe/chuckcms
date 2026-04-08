<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\Repeaters\DeleteRepeaterAction;
use Chuckbe\Chuckcms\Actions\Repeaters\DeleteRepeaterEntryAction;
use Chuckbe\Chuckcms\Actions\Repeaters\ImportRepeaterAction;
use Chuckbe\Chuckcms\Actions\Repeaters\SaveRepeaterAction;
use Chuckbe\Chuckcms\Actions\Repeaters\StoreRepeaterEntryAction;
use Chuckbe\Chuckcms\Actions\Resources\DeleteResourceAction;
use Chuckbe\Chuckcms\Actions\Resources\SaveResourceAction;
use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Requests\Content\DeleteRepeaterRequest;
use Chuckbe\Chuckcms\Requests\Content\DeleteResourceRequest;
use Chuckbe\Chuckcms\Requests\Content\ImportRepeaterRequest;
use Chuckbe\Chuckcms\Requests\Content\SaveResourceRequest;
use Chuckbe\Chuckcms\Requests\Repeaters\DeleteRepeaterEntryRequest;
use Chuckbe\Chuckcms\Requests\Repeaters\SaveRepeaterRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ContentController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct(
        private Content $content,
        private Resource $resource,
        private Repeater $repeater,
        private Template $template,
    ) {
    }

    public function resourceIndex()
    {
        $resources = $this->resource->get();

        return view('chuckcms::backend.content.resource.index', compact('resources'));
    }

    public function resourceCreate()
    {
        return view('chuckcms::backend.content.resource.create');
    }

    public function resourceEdit($slug)
    {
        $resource = Resource::where('slug', $slug)->first();

        return view('chuckcms::backend.content.resource.edit', compact('resource'));
    }

    public function resourceSave(SaveResourceRequest $request, SaveResourceAction $saveResource)
    {
        $saveResource($request);

        return redirect()->route('dashboard.content.resources');
    }

    public function resourceDelete(DeleteResourceRequest $request, DeleteResourceAction $deleteResource): string
    {
        return $deleteResource($request);
    }

    public function repeaterIndex()
    {
        $repeaters = $this->content->where('type', 'repeater')->get();

        return view('chuckcms::backend.content.repeater.index', compact('repeaters'));
    }

    public function repeaterCreate()
    {
        $pageViews = $this->template->getPageViews();

        return view('chuckcms::backend.content.repeater.create', compact('pageViews'));
    }

    public function repeaterEdit($slug)
    {
        $pageViews = $this->template->getPageViews();
        $repeater = Content::where('slug', $slug)->first();

        return view('chuckcms::backend.content.repeater.edit', compact('pageViews', 'repeater'));
    }

    public function repeaterJson($slug)
    {
        $repeater = Content::where('slug', $slug)->first();

        $filename = $repeater->slug.'.json';
        $handle = fopen($filename, 'w+');
        fputs($handle, $repeater->toJson(JSON_PRETTY_PRINT));
        fclose($handle);
        $headers = ['Content-type' => 'application/json'];

        return response()->download($filename, $filename, $headers)->deleteFileAfterSend();
    }

    public function repeaterSave(SaveRepeaterRequest $request, SaveRepeaterAction $saveRepeater)
    {
        $saveRepeater($request);

        return redirect()->route('dashboard.content.repeaters');
    }

    public function repeaterImport(ImportRepeaterRequest $request, ImportRepeaterAction $importRepeater)
    {
        $importRepeater($request);

        $notification = ['type' => 'success', 'message' => 'The JSON file was successfully imported.'];

        return redirect()->route('dashboard.content.repeaters')->with('notification', $notification);
    }

    public function repeaterDelete(DeleteRepeaterRequest $request, DeleteRepeaterAction $deleteRepeater): string
    {
        return $deleteRepeater($request);
    }

    public function repeaterEntriesIndex($slug)
    {
        $content = Content::where('slug', $slug)->first();
        $repeaters = $this->repeater->where('slug', $slug)->get();

        return view('chuckcms::backend.content.repeater.entries.index', compact('content', 'repeaters'));
    }

    public function repeaterEntriesCreate($slug)
    {
        $content = Content::where('slug', $slug)->first();

        return view('chuckcms::backend.content.repeater.entries.create', compact('content'));
    }

    public function repeaterEntriesSave(Request $request, StoreRepeaterEntryAction $storeRepeaterEntry)
    {
        $slug = $request->input('content_slug');
        $content = Content::where('slug', $slug)->firstOrFail();

        // Dynamic rules come from the stored content definition; can't
        // be moved into a FormRequest without recursive coupling back
        // onto the Content model lookup that this action also does.
        $rules = [];
        foreach ($content->content['fields'] as $fieldKey => $fieldValue) {
            $rules[$fieldKey] = $fieldValue['validation'];
        }
        $this->validate($request, $rules);

        $storeRepeaterEntry($request);

        return redirect()->route('dashboard.content.repeaters.entries', ['slug' => $slug]);
    }

    public function repeaterEntriesEdit($slug, $id)
    {
        $content = Content::where('slug', $slug)->first();
        $repeater = Repeater::find($id);

        return view('chuckcms::backend.content.repeater.entries.edit', compact('content', 'repeater'));
    }

    public function repeaterEntriesDelete(DeleteRepeaterEntryRequest $request, DeleteRepeaterEntryAction $deleteRepeaterEntry): string
    {
        return $deleteRepeaterEntry($request);
    }
}
