<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	private $tables = ['objects', 'categories', 'users', 'rooms', 'reservations'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ObjectsTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
    }

    private function truncate() {
        \Schema::disableForeignKeyConstraints();

        foreach ($this->tables as $table) {
        	\DB::table($table)->truncate();
        }

        \Schema::enableForeignKeyConstraints();
    }
}
