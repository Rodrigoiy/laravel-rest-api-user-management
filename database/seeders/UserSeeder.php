<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'rodrigo@issamu.com.br')->first()){
            User::create([
                'name' => 'Rodrigo',
                'email' => 'rodrigo@issamu.com.br',
                'password' => Hash::make('123456a', ['rounds' => 12]),
            ]); 
        }
        if(!User::where('email', 'celke@issamu.com.br')->first()){
            User::create([
                'name' => 'Cesar',
                'email' => 'celke@celke.com.br',
                'password' => Hash::make('123456a', ['rounds' => 12]),
            ]); 
        }
        if(!User::where('email', 'jessica@issamu.com.br')->first()){
            User::create([
                'name' => 'Jessica',
                'email' => 'jessica@issamu.com.br',
                'password' => Hash::make('123456a', ['rounds' => 12]),
            ]); 
        }
        if(!User::where('email', 'isabelly@issamu.com.br')->first()){
            User::create([
                'name' => 'Isabelly',
                'email' => 'isabelly@issamu.com.br',
                'password' => Hash::make('123456a', ['rounds' => 12]),
            ]); 
        }
    }
}
