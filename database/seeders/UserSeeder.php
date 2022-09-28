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
            "surnames" => "Root",
            "user_name" => "admin",
            "email" => "admin@admin.com"
        ])->create();
        $admin->assignRole($adminRole);

        $signerRole = Role::create([
            'name' => 'Firmante'
        ]);
        //Signer user
        $signer = User::factory([
            'name' => 'Firmante',
            'surnames' => 'Usuario',
            'user_name' => 'signer',
            'email' => 'signer@signer.com'
        ])->create();
        $signer->assignRole($signerRole);
    }
}
