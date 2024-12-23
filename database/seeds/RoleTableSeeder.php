<?php

use Illuminate\Database\Seeder;
use anuncielo\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->nombre = 'admin';
        $role->descripcion = "Es el rol administrador";
        $role->save();

        $role = new Role();
        $role->nombre = 'usuario';
        $role->descripcion = "Es el rol de cliente";
        $role->save();
    }
}
