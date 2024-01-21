<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\general\Marca;
use App\Models\PermissionUser;
use Illuminate\Database\Seeder;
use App\Models\general\Laboratorio;
use App\Models\general\TipoProducto;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Role::create([
            'rol_name' => 'Administrador',
            'permisos_defecto' => 'ALL'
        ]);
        Role::create([
            'rol_name' => 'Ventas',
            'permisos_defecto' => '01|03|05'
        ]);
        Role::create([
            'rol_name' => 'SubAdministrador',
            'permisos_defecto' => '00|01|05'
        ]);

        // Permisos
        Permission::create([
            'cod_permission' => '00',
            'name_permission' => 'Acceso'
        ]);
        Permission::create([
            'cod_permission' => '01',
            'name_permission' => 'Dashboard'
        ]);
        Permission::create([
            'cod_permission' => '02',
            'name_permission' => 'Almacen'
        ]);
        Permission::create([
            'cod_permission' => '03',
            'name_permission' => 'Ventas'
        ]);
        Permission::create([
            'cod_permission' => '04',
            'name_permission' => 'Compras'
        ]);
        Permission::create([
            'cod_permission' => '05',
            'name_permission' => 'Reportes'
        ]);


        User::create([
            'name' => 'Kevin',
            'user' => 'admin',
            'password' => '$2y$10$LtORkCXrh4sQXc/lMtQxw.F9jqJu3iGQu.gnhorH7NoSKY/dfUVQq', // password
            'email' => 'cblash14@gmail.com',
            'role_id' => 1,
            'file_foto' => null
        ]);

        PermissionUser::create([
            'user_id' => 1,
            'permission_id' =>  1
        ]);
        PermissionUser::create([
            'user_id' => 1,
            'permission_id' =>  2
        ]);
        PermissionUser::create([
            'user_id' => 1,
            'permission_id' =>  3
        ]);
        PermissionUser::create([
            'user_id' => 1,
            'permission_id' =>  4
        ]);

        // Tipo Producto
        TipoProducto::create([
            'tipo_producto' => 'PRODUCTO BASICO',
            'state' => 1
        ]);
        TipoProducto::create([
            'tipo_producto' => 'PRODUCTO FARMACIA',
            'state' => 1
        ]);

        //MARCAS
        Marca::create([
            'marca' => 'Laive',
            'state' => 1
        ]);
        Marca::create([
            'marca' => 'Coca Cola',
            'state' => 1
        ]);

        // LABORATORIOS
        Laboratorio::create([
            'laboratorio' => 'FARMINDUSTRIA',
            'state' => 1
        ]);
        Laboratorio::create([
            'laboratorio' => 'NIVEA',
            'state' => 1
        ]);
    }
}
