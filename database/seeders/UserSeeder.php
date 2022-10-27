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
            "email" => "admin@admin.com",
            'RFC' => 'LAN7008173R5'
        ])->create();
        $admin->assignRole($adminRole);

        $signerRole = Role::create([
            'name' => 'Firmante'
        ]);
        //Signer user
        $signer = User::factory([
            'name' => 'Firmante',
            'surnames' => 'Apellido Firmante',
            'user_name' => 'signer',
            'email' => 'signer@signer.com',
            'RFC' => 'SUL010720JN8'
        ])->create();
        $signer->assignRole($signerRole);
    }
}
