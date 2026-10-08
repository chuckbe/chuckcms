<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Models\MenuItems;
use Chuckbe\Chuckcms\Models\Menus;
use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Tests\TestCase;

class MenuTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->seedCms();
    }

    public function test_menu_can_be_created_and_deleted(): void
    {
        $this->menuPost('createnewmenu', ['menuname' => 'header'])->assertOk()->assertJson(['resp' => 1]);
        $this->assertSame('header', Menus::firstOrFail()->name);

        $this->menuPost('deletemenug', ['id' => 1])->assertOk();
        $this->assertSame(0, Menus::count());
    }

    public function test_custom_and_page_items_can_be_added(): void
    {
        $menu = $this->createMenu();
        $page = $this->createPage();

        $this->menuPost('addcustommenu', ['labelmenu' => 'Home', 'linkmenu' => '/', 'idmenu' => $menu->id])->assertOk();
        $this->menuPost('addpagemenu', ['labelmenu' => 'Over', 'linkmenu' => $page->id, 'idmenu' => $menu->id])->assertOk();

        $items = MenuItems::orderBy('sort')->get();
        $this->assertSame(['/', 'page:'.$page->id], $items->map(fn ($item) => $item->getRawOriginal('link'))->all());
        $this->assertSame('http://smoke.test/over', $items[1]->link);
        $this->assertSame([1, 2], $items->pluck('sort')->map(fn ($s) => (int) $s)->all());
    }

    public function test_single_item_update(): void
    {
        $item = $this->createItem();

        $this->menuPost('updateitem', ['id' => $item->id, 'label' => 'Start', 'url' => '/start', 'clases' => 'nav-home'])->assertOk();

        $item->refresh();
        $this->assertSame(['Start', '/start', 'nav-home'], [$item->label, $item->link, $item->class]);
    }

    public function test_batch_save_clears_an_emptied_class_and_keeps_empty_links(): void
    {
        $page = $this->createPage();
        $item = $this->createItem();
        $item->class = 'old-class';
        $item->link = 'page:'.$page->id;
        $item->save();

        // What "Save menu" posts for a page item: the link input is not
        // part of the batch, so it arrives empty.
        $this->menuPost('updateitem', ['arraydata' => [
            ['id' => $item->id, 'label' => 'Home', 'link' => '', 'class' => ''],
        ]])->assertOk();

        $item->refresh();
        $this->assertNull($item->class);
        $this->assertSame('page:'.$page->id, $item->getRawOriginal('link'));
    }

    public function test_items_can_be_reordered_and_deleted(): void
    {
        $menu = $this->createMenu();
        $this->menuPost('addcustommenu', ['labelmenu' => 'One', 'linkmenu' => '/one', 'idmenu' => $menu->id]);
        $this->menuPost('addcustommenu', ['labelmenu' => 'Two', 'linkmenu' => '/two', 'idmenu' => $menu->id]);
        [$one, $two] = MenuItems::orderBy('sort')->get()->all();

        $this->menuPost('generatemenucontrol', [
            'idmenu'    => $menu->id,
            'menuname'  => 'main',
            'arraydata' => [
                ['id' => $two->id, 'parent' => 0, 'sort' => 0, 'depth' => 0],
                ['id' => $one->id, 'parent' => $two->id, 'sort' => 1, 'depth' => 1],
            ],
        ])->assertOk();

        $this->assertSame('main', $menu->fresh()->name);
        $this->assertSame([(int) $two->id, 1, 1], [(int) $one->fresh()->parent, (int) $one->fresh()->sort, (int) $one->fresh()->depth]);

        $this->menuPost('deleteitemmenu', ['id' => $one->id])->assertOk();
        $this->assertSame(['Two'], MenuItems::pluck('label')->all());
    }

    private function createPage(): Page
    {
        $page = new Page();
        $page->template_id = 1;
        $page->setTranslation('title', 'nl', 'Over');
        $page->setTranslation('slug', 'nl', 'over');
        $page->active = 1;
        $page->isHp = 0;
        $page->meta = [];
        $page->save();

        return $page;
    }

    private function createMenu(): Menus
    {
        $this->menuPost('createnewmenu', ['menuname' => 'header']);

        return Menus::firstOrFail();
    }

    private function createItem(): MenuItems
    {
        $menu = $this->createMenu();
        $this->menuPost('addcustommenu', ['labelmenu' => 'Home', 'linkmenu' => '/', 'idmenu' => $menu->id]);

        return MenuItems::firstOrFail();
    }

    private function menuPost(string $action, array $data)
    {
        // config('menu.route_path') is '/admin/', which the package
        // concatenates into 'admin//{action}'.
        return $this->actingAs($this->admin)->postJson('/admin//'.$action, $data);
    }
}
