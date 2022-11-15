<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'name' => 'Administrador'
        ]);
        //Admin user
        $admin = User::factory([
            "name" => "Administrador",
            "surnames" => "Apellido Administrador",
            "user_name" => "admin",
            "email" => "sistema_egestion@itslerdo.edu.mx",
            'RFC' => 'KAHO641101B39',
            "aws_user_id" => 11
        ])->create();
        $admin->assignRole($adminRole);

        $signerRole = Role::create([
            'name' => 'Firmante'
        ]);
        //Signer user
        /* $signer = User::factory([
            'name' => 'Firmante',
            'surnames' => 'Apellido Firmante',
            'user_name' => 'signer',
            'email' => 'signer@signer.com',
            'RFC' => 'SAUL010720JN8'
        ])->create();
        $signer->assignRole($signerRole); */
    }
}
