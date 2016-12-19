<?php

use App\Object;
use Illuminate\Database\Seeder;

class ObjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Object::create(['label' => 'A']);
        Object::create(['label' => 'B']);
        Object::create(['label' => 'C']);
        Object::create(['label' => 'D']);
    }
}
