<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToChangePasswordSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'change_password'], ['description' => 'Cambiar contraseña']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('change_password');

        $role_academic_coordination = Role::findByName('Coordinación académica');

        $role_academic_coordination->givePermissionTo('change_password');

        $role_instructor = Role::findByName('Instructor');

        $role_instructor->givePermissionTo('change_password');
    }
}