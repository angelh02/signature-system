<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User
        User::factory([
            "name" => "Administrador",
            "surnames" => "Root",
            "user_name" => "admin"
        ])->create();
    }
}
