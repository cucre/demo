<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesPermissionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //usuarios
        Permission::firstOrCreate(['name' => 'usuarios.index'], ['description' => 'Índice de usuarios']);
        Permission::firstOrCreate(['name' => 'usuarios.show'], ['description' => 'Detalles del usuario']);
        Permission::firstOrCreate(['name' => 'usuarios.create'], ['description' => 'Creación de un nuevo usuario']);
        Permission::firstOrCreate(['name' => 'usuarios.edit'], ['description' => 'Edición del usuario']);
        Permission::firstOrCreate(['name' => 'usuarios.delete'], ['description' => 'Eliminar usuario']);
        Permission::firstOrCreate(['name' => 'usuarios.restore'], ['description' => 'Restaurar usuario']);

        //roles
        Permission::firstOrCreate(['name' => 'roles.index'], ['description' => 'Índice de roles']);
        Permission::firstOrCreate(['name' => 'roles.show'], ['description' => 'Detalles del rol']);
        Permission::firstOrCreate(['name' => 'roles.create'], ['description' => 'Creación de un nuevo rol']);
        Permission::firstOrCreate(['name' => 'roles.edit'], ['description' => 'Edición del rol']);
        Permission::firstOrCreate(['name' => 'roles.delete'], ['description' => 'Eliminar rol']);

        //corporaciones
        Permission::firstOrCreate(['name' => 'corporaciones.index'], ['description' => 'Índice de corporaciones']);
        Permission::firstOrCreate(['name' => 'corporaciones.show'], ['description' => 'Detalles de las corporaciones']);
        Permission::firstOrCreate(['name' => 'corporaciones.create'], ['description' => 'Creación de una nueva corporación']);
        Permission::firstOrCreate(['name' => 'corporaciones.edit'], ['description' => 'Edición de la corporación']);
        Permission::firstOrCreate(['name' => 'corporaciones.delete'], ['description' => 'Eliminar corporación']);
        Permission::firstOrCreate(['name' => 'corporaciones.restore'], ['description' => 'Restaurar corporación']);

        //instructores
        Permission::firstOrCreate(['name' => 'instructores.index'], ['description' => 'Índice de instructores']);
        Permission::firstOrCreate(['name' => 'instructores.show'], ['description' => 'Detalles de los instructores']);
        Permission::firstOrCreate(['name' => 'instructores.create'], ['description' => 'Creación de un nuevo instructor']);
        Permission::firstOrCreate(['name' => 'instructores.edit'], ['description' => 'Edición del instructor']);
        Permission::firstOrCreate(['name' => 'instructores.delete'], ['description' => 'Eliminar instructor']);
        Permission::firstOrCreate(['name' => 'instructores.restore'], ['description' => 'Restaurar instructor']);

        $role = Role::firstOrCreate(['name' => 'Administrador'], ['description' => 'Administrador del sistema']);
        $role->syncPermissions(Permission::all());

        $user = User::findOrFail(1);
        $user->assignRole('Administrador');

        $role_instructor = Role::firstOrCreate(['name' => 'Instructor'], ['description' => 'Instructor']);
        $role_academic_coordination = Role::firstOrCreate(['name' => 'Coordinación académica'], ['description' => 'Coordinación académica']);

        $role_academic_coordination->givePermissionTo('instructores.index');
        $role_academic_coordination->givePermissionTo('instructores.create');
        $role_academic_coordination->givePermissionTo('instructores.edit');
        $role_academic_coordination->givePermissionTo('instructores.show');
        $role_academic_coordination->givePermissionTo('instructores.delete');
        $role_academic_coordination->givePermissionTo('instructores.restore');

        $role_academic_coordination->givePermissionTo('corporaciones.index');
        $role_academic_coordination->givePermissionTo('corporaciones.create');
        $role_academic_coordination->givePermissionTo('corporaciones.edit');
        $role_academic_coordination->givePermissionTo('corporaciones.show');
        $role_academic_coordination->givePermissionTo('corporaciones.delete');
        $role_academic_coordination->givePermissionTo('corporaciones.restore');
    }
}