<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;

use ChuckSite;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContentController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $content;
    private $resource;
    private $repeater;
    private $template;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Content $content, Resource $resource, Repeater $repeater, Template $template, User $user)
    {
        $this->content = $content;
        $this->resource = $resource;
        $this->repeater = $repeater;
        $this->template = $template;
        $this->user = $user;
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

    public function resourceSave(Request $request)
    {
        //validate the request
        $this->validate(request(), [//@todo create custom Request class for site validation
            'slug' => 'required',
            'resource_key.*' => 'required',
            'resource_value.*' => 'required'
        ]);

        $resource = Resource::firstOrNew(['slug' => $request->get('slug')[0]]);
        $resource->slug = $request->get('slug')[0];
        $json = [];
        foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue){
            $count = count($request->get('resource_key')[$langKey]);
            for ($i=0; $i < $count; $i++) { 
                $json[$langKey][$request->get('resource_key')[$langKey][$i]] = $request->get('resource_value')[$langKey][$i];

            }
        }
        $resource->json = $json;
        $resource->save();

        return redirect()->route('dashboard.content.resources');
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

    public function repeaterSave(Request $request)
    {
        //add validation / move to repository...
        $content = [];
        $content_slug = $request->get('content_slug');
        $fields_slug = $request->get('fields_slug');
        $count = count($fields_slug);
        for ($i=0; $i < $count; $i++) { 
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['label'] = $request->get('fields_label')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['type'] = $request->get('fields_type')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['class'] = $request->get('fields_class')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['placeholder'] = $request->get('fields_placeholder')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['validation'] = $request->get('fields_validation')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['value'] = $request->get('fields_value')[$i];
            $fieldsCount = count(explode(';',$request->get('fields_attributes_name')[$i]));
            for ($k=0; $k < $fieldsCount; $k++) { 
                $content['fields'][$content_slug . '_' . $fields_slug[$i]]['attributes'][explode(';',$request->get('fields_attributes_name')[$i])[$k]] = explode(';',$request->get('fields_attributes_value')[$i])[$k];
            }
            $content['fields'][$content_slug . '_' . $fields_slug[$i]]['required'] = $request->get('fields_required')[$i];
            $content['fields'][$content_slug . '_' . $fields_slug[$i]]['table'] = $request->get('fields_table')[$i];
        }

        $content['actions']['store'] = $request->get('action_store');
        if ($request->get('action_detail') == 'true') {
            $content['actions']['detail']['url'] = $request->get('action_detail_url');
            $content['actions']['detail']['page'] = $request->get('action_detail_page');
        } else {
            $content['actions']['detail'] = 'false';
        }

        $content['files'] = $request->get('files_allowed');

        Content::updateOrCreate(
            ['id' => $request->get('content_id')],
            ['slug' => $request->get('content_slug'),
            'type' => $request->get('content_type'),
            'content' => $content]
        );
        
        return redirect()->route('dashboard.content.repeaters');
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

    public function repeaterEntriesSave(Request $request)
    {
        $slug = $request->get('content_slug');
        $content = $this->content->getBySlug($slug);
        $rules = $content->getRules();
        $this->validate(request(), $rules);
        $store = $content->storeEntry($request);
        if ($store == 'success') {
            return redirect()->route('dashboard.content.repeaters.entries', ['slug' => $slug]);
        } else {
            // error catching ... ?
        }
    }

    public function repeaterEntriesEdit($slug, $id)
    {
        $content = Content::where('slug', $slug)->first();
        $repeater = Repeater::where('id', $id)->first();
        return view('chuckcms::backend.content.repeater.entries.edit', compact('content', 'repeater'));
    }

    /**
     * Delete the resource from the page.
     *
     * @param  Request $request
     * @return string $status
     */
    public function repeaterEntriesDelete(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $status = $this->content->deleteById($request->get('repeater_id'));
        return $status;
    }
}
