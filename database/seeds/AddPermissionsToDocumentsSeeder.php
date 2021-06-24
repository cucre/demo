<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToDocumentsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'documentos.index'], ['description' => 'Índice de documentos']);
        Permission::firstOrCreate(['name' => 'documentos.create'], ['description' => 'Creación de un nuevo documento']);
        Permission::firstOrCreate(['name' => 'documentos.edit'], ['description' => 'Edición del documento']);
        Permission::firstOrCreate(['name' => 'documentos.delete'], ['description' => 'Eliminar documento']);
        Permission::firstOrCreate(['name' => 'documentos.restore'], ['description' => 'Restaurar documento']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('documentos.index');
        $role->givePermissionTo('documentos.create');
        $role->givePermissionTo('documentos.edit');
        $role->givePermissionTo('documentos.delete');
        $role->givePermissionTo('documentos.restore');

        $role_instructor = Role::findByName('Instructor');

        $role_instructor->givePermissionTo('documentos.index');
        $role_instructor->givePermissionTo('documentos.create');
        $role_instructor->givePermissionTo('documentos.edit');
        $role_instructor->givePermissionTo('documentos.delete');
        $role_instructor->givePermissionTo('documentos.restore');

        $role_academic_coordination = Role::findByName('Coordinación académica');

        $role_academic_coordination->givePermissionTo('documentos.index');
        $role_academic_coordination->givePermissionTo('documentos.create');
        $role_academic_coordination->givePermissionTo('documentos.edit');
        $role_academic_coordination->givePermissionTo('documentos.delete');
        $role_academic_coordination->givePermissionTo('documentos.restore');
    }
}