<?php

use Illuminate\Database\Seeder;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();

        App\Room::all()->random(15)->each(function($room) use ($users) {
            factory(App\Reservation::class, 5)->create(['room_id' => $room->id, 'user_id' => $users->random()->id]);
        });
    }
}
