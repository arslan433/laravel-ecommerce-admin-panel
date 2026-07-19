<?php

namespace App\Console\Commands\Admin;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Signature('app:insert-permissions')]
#[Description('Command to insert permissions and roles dynamically.')]
class InsertPermissions extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $actions = ['index', 'create', 'edit', 'delete'];
        $guardName = config('permission.default.guard', 'web');

        foreach ($this->permissions() as $module) {
            foreach ($actions as $action) {
                $permissionName = "{$module}-{$action}"; 
                
                Permission::updateOrCreate(
                    ['name' => $permissionName], 
                    ['guard_name' => $guardName]
                );
            }
        }

        foreach ($this->roles() as $role) {
            Role::updateOrCreate(
                ['name' => $role], 
                ['guard_name' => $guardName]
            );
        }

        $this->info('All Permissions (with index, create, edit, delete) and Roles are inserted successfully.');
    }

    /**
     * Just enter the module names here.
     * The loop will automatically create 4 permissions for each word.
     */
    private function permissions(): array
    {
        return [
            'user',
            'role',
            'permission',
            'language',
            'category'
        ];
    }

    private function roles(): array
    {
        return [
            'super-admin',
            'manager',
        ];
    }
}
