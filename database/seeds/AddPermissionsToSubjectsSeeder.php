<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToSubjectsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'materias.index'], ['description' => 'Índice de materias']);
        Permission::firstOrCreate(['name' => 'materias.create'], ['description' => 'Creación de una nueva materia']);
        Permission::firstOrCreate(['name' => 'materias.edit'], ['description' => 'Edición de la materia']);
        Permission::firstOrCreate(['name' => 'materias.show'], ['description' => 'Detalles de las materias']);
        Permission::firstOrCreate(['name' => 'materias.delete'], ['description' => 'Eliminar materia']);
        Permission::firstOrCreate(['name' => 'materias.restore'], ['description' => 'Restaurar materia']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('materias.index');
        $role->givePermissionTo('materias.create');
        $role->givePermissionTo('materias.edit');
        $role->givePermissionTo('materias.show');
        $role->givePermissionTo('materias.delete');
        $role->givePermissionTo('materias.restore');

        $role_academic_coordination = Role::findByName('Coordinación académica');

        $role_academic_coordination->givePermissionTo('documentos.index');
        $role_academic_coordination->givePermissionTo('documentos.create');
        $role_academic_coordination->givePermissionTo('documentos.edit');
        $role_academic_coordination->givePermissionTo('documentos.delete');
        $role_academic_coordination->givePermissionTo('documentos.restore');

        $role_academic_coordination->givePermissionTo('materias.index');
        $role_academic_coordination->givePermissionTo('materias.create');
        $role_academic_coordination->givePermissionTo('materias.edit');
        $role_academic_coordination->givePermissionTo('materias.delete');
        $role_academic_coordination->givePermissionTo('materias.restore');
    }
}