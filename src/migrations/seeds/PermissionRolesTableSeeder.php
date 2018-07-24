<?php

namespace Chuckbe\Chuckcms\migrations\seeds;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// php artisan db:seed --class=Chuckbe\\Chuckcms\\migrations\\seeds\\PermissionRolesTableSeeder
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        // pages
        Permission::create(['name' => 'show pages']);
        Permission::create(['name' => 'create pages']);
        Permission::create(['name' => 'edit pages']);
        Permission::create(['name' => 'delete pages']);
        Permission::create(['name' => 'show pagebuilder']);
        Permission::create(['name' => 'edit pagebuilder']);
        Permission::create(['name' => 'code pagebuilder']);
        // menus
        Permission::create(['name' => 'show menus']);
        Permission::create(['name' => 'create menus']);
        Permission::create(['name' => 'edit menus']);
        Permission::create(['name' => 'delete menus']);
        Permission::create(['name' => 'create links']);
        Permission::create(['name' => 'edit links']);
        Permission::create(['name' => 'delete links']);
        // templates
        Permission::create(['name' => 'show templates']);
        Permission::create(['name' => 'create templates']);
        Permission::create(['name' => 'edit templates']);
        Permission::create(['name' => 'delete templates']);
        // forms
        Permission::create(['name' => 'show forms']);
        Permission::create(['name' => 'create forms']);
        Permission::create(['name' => 'edit forms']);
        Permission::create(['name' => 'delete forms']);
        // form entries
        Permission::create(['name' => 'show formentry']);
        Permission::create(['name' => 'show formentries']);
        Permission::create(['name' => 'create formentries']);
        Permission::create(['name' => 'edit formentries']);
        Permission::create(['name' => 'delete formentries']);
        // media
        Permission::create(['name' => 'show media']);
        Permission::create(['name' => 'create media']);
        Permission::create(['name' => 'edit media']);
        Permission::create(['name' => 'delete media']);
        // user
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        // content
        Permission::create(['name' => 'show content']);
        Permission::create(['name' => 'create content']);
        Permission::create(['name' => 'edit content']);
        Permission::create(['name' => 'delete content']);
        // resource
        Permission::create(['name' => 'show resource']);
        Permission::create(['name' => 'create resource']);
        Permission::create(['name' => 'edit resource']);
        Permission::create(['name' => 'delete resource']);
        // repeaters
        Permission::create(['name' => 'show repeaters']);
        Permission::create(['name' => 'create repeaters']);
        Permission::create(['name' => 'edit repeaters']);
        Permission::create(['name' => 'delete repeaters']);
        // settings
        Permission::create(['name' => 'show settings']);
        Permission::create(['name' => 'create settings']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'delete settings']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'user']);
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

        	'show settings'
        ]);

        $role = Role::create(['name' => 'moderator']);
        $role->givePermissionTo([
        	'show pages',
        	'create pages',
        	'edit pages',
        	'show pagebuilder',

        	'show menus',
        	'create menus',
        	'edit menus',
        	'create links',
        	'edit links',
        	'delete links',

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

        	'show settings'
        ]);

        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo([
        	'show pages',
        	'create pages',
        	'edit pages',
        	'delete pages',
        	'show pagebuilder',
        	'edit pagebuilder',

        	'show menus',
        	'create menus',
        	'edit menus',
        	'delete menus',
        	'create links',
        	'edit links',
        	'delete links',

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

        	'show content',
        	'create content',
        	'edit content',
        	'delete content',

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

        	'show settings',
        	'create settings',
        	'edit settings',
        	'delete settings'
        ]);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
