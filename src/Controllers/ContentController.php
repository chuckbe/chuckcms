<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Repeater;

use Chuckbe\Chuckcms\Models\User;

use ChuckSite;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    private $content;
    private $resource;
    private $repeater;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Content $content, Resource $resource, Repeater $repeater, User $user)
    {
        $this->content = $content;
        $this->resource = $resource;
        $this->repeater = $repeater;
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
        $this->validate(request(), [ //@todo create custom Request class for site validation
            'slug' => 'required',
            'resource_key.*' => 'required',
            'resource_value.*' => 'required'
        ]);

        $resource = Resource::where('slug', $request->get('slug')[0])->first();
        $resource->page_block_id = 1;
        $resource->slug = $request->get('slug')[0];
        $json = [];
        foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue){

            for ($i=0; $i < count($request->get('resource_key')[$langKey]); $i++) { 
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
        return view('chuckcms::backend.content.repeater.create');
    }

    public function repeaterEdit($slug)
    {
        $repeater = Content::where('slug', $slug)->first();
        return view('chuckcms::backend.content.repeater.edit', compact('repeater'));
    }

    public function repeaterSave(Request $request)
    {
        $content = [];
        $content_slug = $request->get('content_slug');
        $fields_slug = $request->get('fields_slug');

        for ($i=0; $i < count($fields_slug); $i++) { 
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['label'] = $request->get('fields_label')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['type'] = $request->get('fields_type')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['class'] = $request->get('fields_class')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['placeholder'] = $request->get('fields_placeholder')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['validation'] = $request->get('fields_validation')[$i];
            $content['fields'][$content_slug.'_'.$fields_slug[$i]]['value'] = $request->get('fields_value')[$i];

            for ($k=0; $k < count(explode(';',$request->get('fields_attributes_name')[$i])); $k++) { 
                $content['fields'][$content_slug . '_' . $fields_slug[$i]]['attributes'][explode(';',$request->get('fields_attributes_name')[$i])[$k]] = explode(';',$request->get('fields_attributes_value')[$i])[$k];
            }
            $content['fields'][$content_slug . '_' . $fields_slug[$i]]['required'] = $request->get('fields_required')[$i];
            $content['fields'][$content_slug . '_' . $fields_slug[$i]]['table'] = $request->get('fields_table')[$i];
        }

        $content['actions']['store'] = $request->get('action_store');
        if($request->get('action_detail') == true) {
            $content['actions']['detail']['url'] = $request->get('action_detail_url');
            $content['actions']['detail']['page'] = $request->get('action_detail_page');
        }

        $content['files'] = $request->get('files_allowed');

        // updateOrCreate the site
        $result = Content::updateOrCreate(
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
        return view('chuckcms::backend.content.repeater.entries.index', compact('content','repeaters'));
    }
}
