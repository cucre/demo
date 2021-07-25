<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToStudentsControlSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'control_estudiantes.index'], ['description' => 'Índice de control de estudiantes']);
        Permission::firstOrCreate(['name' => 'control_estudiantes.score'], ['description' => 'Índice de calificaciones']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('control_estudiantes.index');
        $role->givePermissionTo('control_estudiantes.score');

        $role_academic_coordination = Role::findByName('Coordinación académica');

        $role_academic_coordination->givePermissionTo('control_estudiantes.index');
        $role_academic_coordination->givePermissionTo('control_estudiantes.score');

        $role_instructor = Role::findByName('Instructor');

        $role_instructor->givePermissionTo('control_estudiantes.index');
        $role_instructor->givePermissionTo('control_estudiantes.score');
    }
}