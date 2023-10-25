<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    const SUFFIX = [
        'list' => 'Display',
        'create' => 'Create',
        'update' => 'Update',
        'delete' => 'Delete',
        'restore' => 'Restore',
        'forcedelete' => 'Force Delete',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permission `super admin`
        $roleSuperAdmin = Role::firstOrCreate([
            'name' => config('laravel-generate-repository-api.super_admin'),
            'guard_name' => 'admin',
        ]);

        $userSuperAdmin = Admin::query()->firstOrCreate(
            [
                'name' => 'Super Admin',
                'email' => 'waad_mawlood@outlook.com',
            ],
            [
                'password' => '12345678',
            ]
        );

        $userSuperAdmin->assignRole($roleSuperAdmin);

        // create permission `admin`
        $this->setPermissionsModel('Admin', 'admin', 'Admins');
        $this->setPermissionsModel('User', 'admin', 'Users');
        $this->setPermissionsModel('Role', 'admin', 'Roles');
        $this->setPermission('permission_list', 'admin', 'Permissions', 'Display Permission');
        $this->setPermission('permission_list', 'user', 'Permissions', 'Display Permission');

        // create permission `user` for Workspace
        $this->setPermission('user_update', 'user', 'Workspaces', 'Update User');
        $this->setPermission('user_delete', 'user', 'Workspaces', 'Delete User');
        $this->setPermission('workspace_assign_users', 'user', 'Workspaces', 'Assign User');
        $this->setPermission('workspace_invite_users', 'user', 'Workspaces', 'Invite User');

        // create permission `user` for Project
        $this->setPermission('project_create', 'user', 'Projects', 'Create Project');
        $this->setPermission('project_update', 'user', 'Projects', 'Update Project');
        $this->setPermission('project_delete', 'user', 'Projects', 'Delete Project');
        $this->setPermission('project_restore', 'user', 'Projects', 'Restore Project');

        // create permission `user` for Tasks of Projects
        $this->setPermission('task_create', 'user', 'Tasks', 'Create Task');
        $this->setPermission('task_update', 'user', 'Tasks', 'Update Task');
        $this->setPermission('task_delete', 'user', 'Tasks', 'Delete Task');
        $this->setPermission('task_restore', 'user', 'Tasks', 'Restore Task');
    }

    private function setPermissionsModel(string $model, string|array $guards, string $group = null)
    {
        $guards = Arr::wrap($guards);

        foreach ($guards as $guard) {
            foreach (self::SUFFIX as $key => $value) {
                $this->setPermission(str($model)->snake()->value() . '_' . $key, $guard, $group ?? str($model)->snake()->replace('_', ' ')->title()->value(), $value . ' ' . $model);
            }
        }
    }

    private function setPermission(string $name, string|array $guard, string $group = null, string $display = null)
    {
        $permission = Permission::query()->firstOrCreate([
            'name' => $name,
            'guard_name' => $guard,
        ], [
            'group' => $group,
            'display' => $display,
        ]);
    }
}
