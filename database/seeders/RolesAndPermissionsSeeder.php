<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //create permissions
        Permission::create(['name'=>'superadmin']); //Este permiso es una total
        Permission::create(['name'=>'landings_maketator']); //Este permiso sera para los maquetadores
        
        //create roles 
        $admin=Role::create(['name'=>'admin']);
        $admin->givePermissionTo('superadmin');

        $userRole = Role::create(['name'=>'user']);
        $userRole->givePermissionTo('landings_maketator');


    }
}
