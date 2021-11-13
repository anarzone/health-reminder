<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'create'],['name' => 'create']);
        Permission::firstOrCreate(['name' => 'read'], ['name' => 'read']);
        Permission::firstOrCreate(['name' => 'update'],['name' => 'update']);
        Permission::firstOrCreate(['name' => 'delete'],['name' => 'delete']);

        $adminRole = Role::firstOrCreate(['name' => 'admin'],['name' => 'admin']);

        $adminRole->givePermissionTo('update');
        $adminRole->givePermissionTo('create');
        $adminRole->givePermissionTo('read');
        $adminRole->givePermissionTo('delete');

        $superAdmin = User::firstOrCreate(['email' => 'admin@admin.com'],[
            'name' => 'Admin',
            'is_admin' => true,
            'email' => 'admin@admin.com',
            'password' => Hash::make(12345678),
        ]);

        $superAdmin->assignRole('admin');

        Schema::enableForeignKeyConstraints();
    }
}
