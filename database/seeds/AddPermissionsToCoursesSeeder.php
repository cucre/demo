<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToCoursesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'cursos.index'], ['description' => 'Índice de cursos']);
        Permission::firstOrCreate(['name' => 'cursos.create'], ['description' => 'Creación de un nuevo curso']);
        Permission::firstOrCreate(['name' => 'cursos.edit'], ['description' => 'Edición del curso']);
        Permission::firstOrCreate(['name' => 'cursos.delete'], ['description' => 'Eliminar curso']);
        Permission::firstOrCreate(['name' => 'cursos.restore'], ['description' => 'Restaurar curso']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('cursos.index');
        $role->givePermissionTo('cursos.create');
        $role->givePermissionTo('cursos.edit');
        $role->givePermissionTo('cursos.delete');
        $role->givePermissionTo('cursos.restore');

        $role_academic_coordination = Role::findByName('Coordinación académica');

        $role_academic_coordination->givePermissionTo('cursos.index');
        $role_academic_coordination->givePermissionTo('cursos.create');
        $role_academic_coordination->givePermissionTo('cursos.edit');
        $role_academic_coordination->givePermissionTo('cursos.delete');
        $role_academic_coordination->givePermissionTo('cursos.restore');
    }
}