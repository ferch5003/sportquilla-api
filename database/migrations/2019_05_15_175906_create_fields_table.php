<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->bigIncrements('cid');
            $table->string('name',50);
            $table->string('location',50);
            $table->text('description');
            $table->integer('rating')->unsigned();
            $table->time('begin_time');
            $table->time('final_time');

            $table->foreign('cid')->references('cid')->on('photos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
