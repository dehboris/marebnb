<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'first_name' => 'Marin', 
            'last_name' => 'Grbić', 
            'email' => 'marin.grbic@fer.hr',
            'street' => 'Unska 3',
            'country' => 'Hrvatska',
            'city' => 'Zagreb',
            'zip' => 10000,
            'user_type' => 2
        ]);

        factory(App\User::class)->create([
            'first_name' => 'Andrej', 
            'last_name' => 'Kovar', 
            'email' => 'andrej.kovar@fer.hr',
            'street' => 'Luke Tadića 33',
            'country' => 'Hrvatska',
            'city' => 'Donji Miholjac',
            'zip' => 31540,
            'user_type' => 1
        ]);

        factory(App\User::class)->create([
            'first_name' => 'Marin', 
            'last_name' => 'Piskač', 
            'email' => 'marin.piskac@fer.hr',
            'street' => 'Don Ivana Tokića 6',
            'country' => 'Hrvatska',
            'city' => 'Soblinec',
            'zip' => 42000,
            'user_type' => 1
        ]);

        factory(App\User::class)->create([
            'first_name' => 'Luka', 
            'last_name' => 'Tadić', 
            'email' => 'luka.tadic@fer.hr',
            'street' => 'Baruna Filipa Klepe 2',
            'country' => 'Hrvatska',
            'city' => 'Vrlika',
            'zip' => 43500,
            'user_type' => 1
        ]);

        factory(App\User::class, 10)->create(['user_type' => 0]);
    }
}
