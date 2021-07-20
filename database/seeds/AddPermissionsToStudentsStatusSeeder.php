<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermissionsToStudentsStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate(['name' => 'estatus.index'], ['description' => 'Índice de estatus']);
        Permission::firstOrCreate(['name' => 'estatus.create'], ['description' => 'Creación de un nuevo estatus']);
        Permission::firstOrCreate(['name' => 'estatus.edit'], ['description' => 'Edición del estatus']);
        Permission::firstOrCreate(['name' => 'estatus.delete'], ['description' => 'Eliminar estatus']);
        Permission::firstOrCreate(['name' => 'estatus.restore'], ['description' => 'Restaurar estatus']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('estatus.index');
        $role->givePermissionTo('estatus.create');
        $role->givePermissionTo('estatus.edit');
        $role->givePermissionTo('estatus.delete');
        $role->givePermissionTo('estatus.restore');
    }
}