<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('object_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('label')->unique();
            $table->float('price', 5, 2);
            $table->smallInteger('max_people');
            $table->smallInteger('min_people');
            $table->boolean('seaside');
            $table->timestamp('last_reservation')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
