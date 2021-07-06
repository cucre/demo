<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToInstructorsCoursesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'instructors_courses.index'], ['description' => 'Índice de instructores por curso']);
        Permission::firstOrCreate(['name' => 'instructors_courses.create'], ['description' => 'Creación de un nuevo instructor por curso']);
        Permission::firstOrCreate(['name' => 'instructors_courses.edit'], ['description' => 'Edición del instructor por curso']);
        Permission::firstOrCreate(['name' => 'instructors_courses.delete'], ['description' => 'Eliminar instructor por curso']);
        Permission::firstOrCreate(['name' => 'instructors_courses.restore'], ['description' => 'Restaurar instructor por curso']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('instructors_courses.index');
        $role->givePermissionTo('instructors_courses.create');
        $role->givePermissionTo('instructors_courses.edit');
        $role->givePermissionTo('instructors_courses.delete');
        $role->givePermissionTo('instructors_courses.restore');

        $role_academic_coordination = Role::findByName('Coordinación académica');

        $role_academic_coordination->givePermissionTo('instructors_courses.index');
        $role_academic_coordination->givePermissionTo('instructors_courses.create');
        $role_academic_coordination->givePermissionTo('instructors_courses.edit');
        $role_academic_coordination->givePermissionTo('instructors_courses.delete');
        $role_academic_coordination->givePermissionTo('instructors_courses.restore');
    }
}