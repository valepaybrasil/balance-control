<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        *@Todo - Trocar os hash abaixo
        */
        User::create([
            'name' => 'System',
            'email' => 'teste@teste.com',
            'api_token' => '7ca840127ca5a1264a588d4da8c0aa751780f33d73db484fe9251d68c60f5427',
            'access_token' => '7ca840127ca5a1264a588d4da8c0aa751780f33d73db484fe9251d68c60f5427',
        ]);
    }
}
