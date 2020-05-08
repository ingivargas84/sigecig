<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        User::truncate();

        $superadminRole = Role::create(['name' => 'Super-Administrador']);
        $adminRole = Role::create(['name' => 'Administrador']);

        $sigecig_users = new user;
        $sigecig_users->name = 'Super Administrador';
        $sigecig_users->email= 'superadmin@gmail.com';
        $sigecig_users->password = bcrypt('superadmin');
        $sigecig_users->username = 'superadmin';
        $sigecig_users->estado = 1;
        $sigecig_users->save();
        $sigecig_users->assignRole($superadminRole); 

        $sigecig_users = new user;
        $sigecig_users->name = 'Administrador';
        $sigecig_users->email= 'admin@1gmail.com';
        $sigecig_users->password = bcrypt('admin');
        $sigecig_users->username = 'admin';
        $sigecig_users->estado = 1;
        $sigecig_users->save();
        $sigecig_users->assignRole($adminRole);

        
        
    }
}
