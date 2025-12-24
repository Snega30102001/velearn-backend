<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /** ----------------------------------------
         *  Permissions List
         * ---------------------------------------- */
        $permissions = [
            // Course permissions
            'course.view',
            'course.create',
            'course.edit',
            'course.delete',

            // Course Type permissions
            'coursetype.view',
            'coursetype.create',
            'coursetype.edit',
            'coursetype.delete',

            // Lead permissions
            'lead.view',
            'lead.create',
            'lead.edit',
            'lead.delete',

            // Lead Timeline permissions
            'timeline.view',
            'timeline.create',
            'timeline.delete',

            // User management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
        ];

        /** ----------------------------------------
         *  Create Permissions
         * ---------------------------------------- */
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /** ----------------------------------------
         *  Create Roles
         * ---------------------------------------- */
        $roles = [
            'admin',
            'counselor',
            'telecaller',
            'support executive',
            'technical staff',
            'manager and digital marketing',
            'placement staff',
            'student',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Retrieve roles for permission assignment
        $adminRole = Role::where('name', 'admin')->first();
        $counselorRole = Role::where('name', 'counselor')->first();
        $telecallerRole = Role::where('name', 'telecaller')->first();

        /** ----------------------------------------
         * Assign Permissions to Roles
         * ---------------------------------------- */

        // Admin gets everything
        $adminRole->givePermissionTo(Permission::all());

        // Staff limited permissions
        $telecallerRole->givePermissionTo([
            'lead.view',
            'lead.create',
            'lead.edit',

            'timeline.view',
            'timeline.create',

            'course.view',
            'coursetype.view',
        ]);

        // Counsellor permissions
        $counselorRole->givePermissionTo([
            'lead.view',
            'lead.edit',
            'timeline.create',
            'timeline.view',
        ]);

        /** ----------------------------------------
         *  Assign default roles to users
         * ---------------------------------------- */
        $admin = User::where('email', 'admin@gmail.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
        }

        $telecaller = User::where('email', 'telecaller@gmail.com')->first();
        if ($telecaller) {
            $telecaller->assignRole('telecaller');
        }
    }
}
