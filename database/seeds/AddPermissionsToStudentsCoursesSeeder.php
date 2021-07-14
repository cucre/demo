<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToStudentsCoursesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'students_courses.index'], ['description' => 'Índice de estudiantes por curso']);
        Permission::firstOrCreate(['name' => 'students_courses.create'], ['description' => 'Creación de un nuevo estudiante por curso']);
        Permission::firstOrCreate(['name' => 'students_courses.delete'], ['description' => 'Eliminar estudiante por curso']);
        Permission::firstOrCreate(['name' => 'students_courses.restore'], ['description' => 'Restaurar estudiante por curso']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('students_courses.index');
        $role->givePermissionTo('students_courses.create');
        $role->givePermissionTo('students_courses.delete');
        $role->givePermissionTo('students_courses.restore');

        $role_academic_coordination = Role::findByName('Coordinación académica');

        $role_academic_coordination->givePermissionTo('students_courses.index');
        $role_academic_coordination->givePermissionTo('students_courses.create');
        $role_academic_coordination->givePermissionTo('students_courses.delete');
        $role_academic_coordination->givePermissionTo('students_courses.restore');
    }
}