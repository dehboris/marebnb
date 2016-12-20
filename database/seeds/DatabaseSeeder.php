<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Tables to truncate before running the seeder.
     *
     * @var array
     */
    private $tables = ['objects', 'categories', 'users', 'rooms', 'reservations'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ObjectsTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
    }

    /**
     * Truncate the tables before running seeder.
     */
    private function truncate()
    {
        Schema::disableForeignKeyConstraints();

        collect($this->tables)->each(function ($table) {
            DB::table($table)->truncate();

            $this->command->getOutput()->writeln("<info>Truncated:</info> $table");
        });

        Schema::enableForeignKeyConstraints();
    }
}
