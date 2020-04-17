<?php

namespace Chuckbe\Chuckcms\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GenerateRolesPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chuckcms:generate-roles-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates all default roles and permissions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Generating your roles and permissions...');

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        // pages
        Permission::firstOrCreate(['name' => 'show pages']);
        Permission::firstOrCreate(['name' => 'create pages']);
        Permission::firstOrCreate(['name' => 'edit pages']);
        Permission::firstOrCreate(['name' => 'delete pages']);
        Permission::firstOrCreate(['name' => 'show pagebuilder']);
        Permission::firstOrCreate(['name' => 'edit pagebuilder']);
        Permission::firstOrCreate(['name' => 'code pagebuilder']);
        Permission::firstOrCreate(['name' => 'delete pagebuilder']);
        // menus
        Permission::firstOrCreate(['name' => 'show menus']);
        Permission::firstOrCreate(['name' => 'create menus']);
        Permission::firstOrCreate(['name' => 'edit menus']);
        Permission::firstOrCreate(['name' => 'delete menus']);
        // templates
        Permission::firstOrCreate(['name' => 'show templates']);
        Permission::firstOrCreate(['name' => 'create templates']);
        Permission::firstOrCreate(['name' => 'edit templates']);
        Permission::firstOrCreate(['name' => 'delete templates']);
        // forms
        Permission::firstOrCreate(['name' => 'show forms']);
        Permission::firstOrCreate(['name' => 'create forms']);
        Permission::firstOrCreate(['name' => 'edit forms']);
        Permission::firstOrCreate(['name' => 'delete forms']);
        // form entries
        Permission::firstOrCreate(['name' => 'show formentry']);
        Permission::firstOrCreate(['name' => 'show formentries']);
        Permission::firstOrCreate(['name' => 'create formentries']);
        Permission::firstOrCreate(['name' => 'edit formentries']);
        Permission::firstOrCreate(['name' => 'delete formentries']);
        // media
        Permission::firstOrCreate(['name' => 'show media']);
        Permission::firstOrCreate(['name' => 'create media']);
        Permission::firstOrCreate(['name' => 'edit media']);
        Permission::firstOrCreate(['name' => 'delete media']);
        // user
        Permission::firstOrCreate(['name' => 'show users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        // roles
        Permission::firstOrCreate(['name' => 'show roles']);
        Permission::firstOrCreate(['name' => 'create roles']);
        Permission::firstOrCreate(['name' => 'edit roles']);
        Permission::firstOrCreate(['name' => 'delete roles']);
        // content
        Permission::firstOrCreate(['name' => 'show content']);
        Permission::firstOrCreate(['name' => 'create content']);
        Permission::firstOrCreate(['name' => 'edit content']);
        Permission::firstOrCreate(['name' => 'delete content']);
        // redirects
        Permission::firstOrCreate(['name' => 'show redirects']);
        Permission::firstOrCreate(['name' => 'create redirects']);
        Permission::firstOrCreate(['name' => 'edit redirects']);
        Permission::firstOrCreate(['name' => 'delete redirects']);
        // resource
        Permission::firstOrCreate(['name' => 'show resource']);
        Permission::firstOrCreate(['name' => 'create resource']);
        Permission::firstOrCreate(['name' => 'edit resource']);
        Permission::firstOrCreate(['name' => 'delete resource']);
        // repeaters
        Permission::firstOrCreate(['name' => 'show repeaters']);
        Permission::firstOrCreate(['name' => 'create repeaters']);
        Permission::firstOrCreate(['name' => 'edit repeaters']);
        Permission::firstOrCreate(['name' => 'delete repeaters']);

        Permission::firstOrCreate(['name' => 'show repeaters entries']);
        Permission::firstOrCreate(['name' => 'create repeaters entry']);
        Permission::firstOrCreate(['name' => 'edit repeaters entry']);
        Permission::firstOrCreate(['name' => 'delete repeaters entry']);
        // settings
        Permission::firstOrCreate(['name' => 'show settings']);
        Permission::firstOrCreate(['name' => 'create settings']);
        Permission::firstOrCreate(['name' => 'edit settings']);
        Permission::firstOrCreate(['name' => 'delete settings']);

        // create roles and assign created permissions
        $role = Role::firstOrCreate(['name' => 'user']);
        $role->revokePermissionTo(Permission::all());
        $role->givePermissionTo([
            'show pages',

            'show menus',

            'show templates',

            'show forms',
            
            'show formentry',

            'show formentries',

            'show media',

            'show users',

            'show content',

            'show resource',

            'show repeaters',

            'show repeaters entries',

            'show settings',

            'show redirects'
        ]);

        $role = Role::firstOrCreate(['name' => 'moderator']);
        $role->revokePermissionTo(Permission::all());
        $role->givePermissionTo([
            'show pages',
            'create pages',
            'edit pages',
            'show pagebuilder',

            'show menus',
            'create menus',
            'edit menus',

            'show templates',
            'create templates',
            'edit templates',

            'show forms',
            'create forms',
            'edit forms',

            'show formentries',
            'show formentry',

            'show media',
            'create media',
            'edit media',

            'show users',
            'create users',
            'edit users',

            'show content',
            'create content',
            'edit content',

            'show resource',
            'create resource',
            'edit resource',

            'show repeaters',
            'create repeaters',
            'edit repeaters',

            'show repeaters entries',
            'create repeaters entry',
            'edit repeaters entry',

            'show settings',

            'show redirects',
            'create redirects',
            'edit redirects'
        ]);

        $role = Role::firstOrCreate(['name' => 'administrator']);
        $role->revokePermissionTo(Permission::all());
        $role->givePermissionTo([
            'show pages',
            'create pages',
            'edit pages',
            'delete pages',
            'show pagebuilder',
            'edit pagebuilder',
            'delete pagebuilder',

            'show menus',
            'create menus',
            'edit menus',
            'delete menus',

            'show templates',
            'create templates',
            'edit templates',
            'delete templates',

            'show forms',
            'create forms',
            'edit forms',
            'delete forms',

            'show formentries',
            'show formentry',
            'create formentries',
            'edit formentries',
            'delete formentries',

            'show media',
            'create media',
            'edit media',
            'delete media',

            'show users',
            'create users',
            'edit users',
            'delete users',

            'show roles',

            'show content',
            'create content',
            'edit content',
            'delete content',

            'show resource',
            'create resource',
            'edit resource',
            'delete resource',

            'show repeaters',
            'create repeaters',
            'edit repeaters',
            'delete repeaters',

            'show repeaters entries',
            'create repeaters entry',
            'edit repeaters entry',
            'delete repeaters entry',

            'show settings',
            'create settings',
            'edit settings',
            'delete settings',

            'show redirects',
            'create redirects',
            'edit redirects',
            'delete redirects'
        ]);

        $role = Role::firstOrCreate(['name' => 'super-admin']);
        $role->revokePermissionTo(Permission::all());
        $role->givePermissionTo(Permission::all());

        $this->info('   .      .');
        $this->info('  ..       ..');
        $this->info(' ...        ...');
        $this->info('.... AWESOME ....');
        $this->info('...         ...');
        $this->info('..         ..');
        $this->info('.         .');
        $this->info('.         .');
        $this->info('..         ..');
        $this->info('...         ...');
        $this->info('....   JOB   ....');
        $this->info('...         ...');
        $this->info('..         ..');
        $this->info('.         .');
        $this->info('───────────────▄▄───▐█');
        $this->info('───▄▄▄───▄██▄──█▀───█─▄');
        $this->info('─▄██▀█▌─██▄▄──▐█▀▄─▐█▀');
        $this->info('▐█▀▀▌───▄▀▌─▌─█─▌──▌─▌');
        $this->info('▌▀▄─▐──▀▄─▐▄─▐▄▐▄─▐▄─▐▄');
        $this->info(' ');
        $this->info('Successfully generated all default roles and permissions.');
        $this->info(' ');
    

        
    }
}
