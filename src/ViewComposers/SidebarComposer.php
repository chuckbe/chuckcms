<?php

namespace Chuckbe\Chuckcms\ViewComposers;

use Illuminate\View\View;
use Chuckbe\Chuckcms\Chuck\ModuleRepository;

class SidebarComposer
{
    /**
     * The modules repository implementation.
     *
     * @var ModuleRepository
     */
    protected $modules;

    /**
     * Create a new sidebar composer.
     *
     * @param  ModuleRepository  $modules
     * @return void
     */
    public function __construct(ModuleRepository $modules)
    {
        // Dependencies automatically resolved by service container...
        $this->modules = $modules;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('modules', $this->modules->get());
    }
}