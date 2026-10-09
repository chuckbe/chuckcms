<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\Menus\AddCustomMenuItemAction;
use Chuckbe\Chuckcms\Actions\Menus\AddPageMenuItemAction;
use Chuckbe\Chuckcms\Actions\Menus\CreateMenuAction;
use Chuckbe\Chuckcms\Actions\Menus\DeleteMenuAction;
use Chuckbe\Chuckcms\Actions\Menus\DeleteMenuItemAction;
use Chuckbe\Chuckcms\Actions\Menus\GenerateMenuControlAction;
use Chuckbe\Chuckcms\Actions\Menus\UpdateMenuItemAction;
use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Requests\Menus\AddCustomMenuItemRequest;
use Chuckbe\Chuckcms\Requests\Menus\AddPageMenuItemRequest;
use Chuckbe\Chuckcms\Requests\Menus\CreateMenuRequest;
use Chuckbe\Chuckcms\Requests\Menus\DeleteMenuItemRequest;
use Chuckbe\Chuckcms\Requests\Menus\DeleteMenuRequest;
use Chuckbe\Chuckcms\Requests\Menus\GenerateMenuControlRequest;
use Chuckbe\Chuckcms\Requests\Menus\UpdateMenuItemRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class MenuController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct(protected Page $page)
    {
    }

    /**
     * Show the dashboard -> menus index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pages = $this->page->get();

        return view('chuckcms::backend.menus.index', compact('pages'));
    }

    public function createnewmenu(CreateMenuRequest $request, CreateMenuAction $createMenu): JsonResponse
    {
        $menu = $createMenu($request);

        return response()->json(['resp' => $menu->id]);
    }

    public function deleteitemmenu(DeleteMenuItemRequest $request, DeleteMenuItemAction $deleteMenuItem): JsonResponse
    {
        $deleteMenuItem($request);

        return response()->json(['resp' => 'ok']);
    }

    public function deletemenug(DeleteMenuRequest $request, DeleteMenuAction $deleteMenu): JsonResponse
    {
        $result = $deleteMenu($request);

        return match ($result) {
            DeleteMenuAction::RESULT_DELETED   => response()->json(['resp' => 'you delete this item']),
            DeleteMenuAction::RESULT_HAS_ITEMS => response()->json(['resp' => 'You have to delete all items first', 'error' => 1]),
            default                            => response()->json(['resp' => 'not found', 'error' => 1]),
        };
    }

    public function updateitem(UpdateMenuItemRequest $request, UpdateMenuItemAction $updateMenuItem): JsonResponse
    {
        $updateMenuItem($request);

        return response()->json(['resp' => 'ok']);
    }

    public function addcustommenu(AddCustomMenuItemRequest $request, AddCustomMenuItemAction $addCustomMenuItem): JsonResponse
    {
        $addCustomMenuItem($request);

        return response()->json(['resp' => 'ok']);
    }

    public function addpagemenu(AddPageMenuItemRequest $request, AddPageMenuItemAction $addPageMenuItem): JsonResponse
    {
        $addPageMenuItem($request);

        return response()->json(['resp' => 'ok']);
    }

    public function generatemenucontrol(GenerateMenuControlRequest $request, GenerateMenuControlAction $generateMenuControl): JsonResponse
    {
        $generateMenuControl($request);

        return response()->json(['resp' => 1]);
    }
}
