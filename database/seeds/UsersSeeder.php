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
        $jdRole = Role::create(['name' => 'JuntaDirectiva']);
        $asistentejdRole = Role::create(['name' => 'AsistenteJD']);
        $gerenciaRole = Role::create(['name' => 'Gerencia']);
        $jefecontabilidadRole = Role::create(['name' => 'JefeContabilidad']);
        $contabilidadRole = Role::create(['name' => 'Contabilidad']);
        $auditoriaRole = Role::create(['name' => 'Auditoria']);
        $jefeinformaticaRole = Role::create(['name' => 'JefeInformatica']);
        $soporteinformaticaRole = Role::create(['name' => 'SoporteInformatica']);
        $asistenteRole = Role::create(['name' => 'Asistente']);
        $subsedeRole = Role::create(['name' => 'Subsede']);
        $coordinacionsubsedeRole = Role::create(['name' => 'CoordinacionSubSede']);
        $jefecomisionesRole = Role::create(['name' => 'JefeComisiones']);
        $comisionesRole = Role::create(['name' => 'Comisiones']);
        $jeferrhhRole = Role::create(['name' => 'JefeRRHH']);
        $rrhhRole = Role::create(['name' => 'RRHH']);
        $cajaRole = Role::create(['name' => 'Caja']);
        $tribunalhonorRole = Role::create(['name' => 'TribunalHonor']);
        $tribunalelectoralRole = Role::create(['name' => 'TribunalElectoral']);
        $comprasRole = Role::create(['name' => 'Compras']);
        $jefeceducaRole = Role::create(['name' => 'JefeCeduca']);
        $ceducaRole = Role::create(['name' => 'Ceduca']);
        $jefetimbresRole = Role::create(['name' => 'JefeTimbres']);
        $timbreRole = Role::create(['name' => 'Timbre']);

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
