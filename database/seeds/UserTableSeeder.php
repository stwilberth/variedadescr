<?php

use Illuminate\Database\Seeder;
use anuncielo\Role;
use anuncielo\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('nombre', 'usuario')->first();
        $role_admin = Role::where('nombre', 'admin')->first();

        $user = new User();
        $user->name = "User";
        $user->email = "user@user.com";
        $user->password = bcrypt('82398udhss');
        $user->save();
        $user->roles()->attach($role_user);
        
        $user = new User();
        $user->name = "Admin";
        $user->email = "max@variedadescr.com";
        $user->password = bcrypt('casTroMaX1990');
        $user->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->name = "Admin";
        $user->email = "w@wilberth.com";
        $user->password = bcrypt('Jair2018Ymes1997');
        $user->save();
        $user->roles()->attach($role_admin);
    }
}
