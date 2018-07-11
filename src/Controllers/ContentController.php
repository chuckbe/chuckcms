<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Repeater;

use Chuckbe\Chuckcms\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    private $content;
    private $resource;
    private $repeater;
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

    public function repeaterIndex()
    {
        $repeaters = $this->repeater->get();
        return view('chuckcms::backend.content.repeater.index', compact('repeaters'));
    }
}
