<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToStudentsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'estudiantes.index'], ['description' => 'Índice de estudiantes']);
        Permission::firstOrCreate(['name' => 'estudiantes.show'], ['description' => 'Detalles de los estudiantes']);
        Permission::firstOrCreate(['name' => 'estudiantes.create'], ['description' => 'Creación de un nuevo estudiante']);
        Permission::firstOrCreate(['name' => 'estudiantes.edit'], ['description' => 'Edición del estudiante']);
        Permission::firstOrCreate(['name' => 'estudiantes.delete'], ['description' => 'Eliminar estudiante']);
        Permission::firstOrCreate(['name' => 'estudiantes.restore'], ['description' => 'Restaurar estudiante']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('estudiantes.index');
        $role->givePermissionTo('estudiantes.show');
        $role->givePermissionTo('estudiantes.create');
        $role->givePermissionTo('estudiantes.edit');
        $role->givePermissionTo('estudiantes.delete');
        $role->givePermissionTo('estudiantes.restore');

        $role_academic_coordination = Role::findByName('Coordinación académica');

        $role_academic_coordination->givePermissionTo('estudiantes.index');
        $role_academic_coordination->givePermissionTo('estudiantes.show');
        $role_academic_coordination->givePermissionTo('estudiantes.create');
        $role_academic_coordination->givePermissionTo('estudiantes.edit');
        $role_academic_coordination->givePermissionTo('estudiantes.delete');
        $role_academic_coordination->givePermissionTo('estudiantes.restore');
    }
}