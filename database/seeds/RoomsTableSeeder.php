<?php

use App\{
    Object, Category
};
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objects = Object::all();
        $categories = Category::all();

        $objects->each(function ($object) use ($categories) {
            factory(App\Room::class, 5)->create(['object_id' => $object->id, 'category_id' => $categories->random()->id]);
        });
    }
}
