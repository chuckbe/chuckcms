<?php

namespace Chuckbe\Chuckcms\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $this->info('Generating roles and permissions...');

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $roles = array_keys(config('chuckcms.permissions'));
        $permissions = [];

        foreach ($roles as $role) {
            $permissions = [...$permissions, ...config('chuckcms.permissions.'.$role)];
        }

        $permissions = array_unique($permissions);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ($roles as $role) {
            $roleObj = Role::firstOrCreate(['name' => $role]);
            $roleObj->revokePermissionTo(Permission::all());
            $roleObj->givePermissionTo(config('chuckcms.permissions.'.$role));
        }

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
