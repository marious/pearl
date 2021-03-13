<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CounterCreateCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('key', 120);
            $table->string('description', 255)->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('counter_items', function (Blueprint $table) {
           $table->id();
           $table->bigInteger('counter_id')->unsigned();
           $table->string('name', 120);
           $table->integer('count');
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('counter_id')->references('id')->on('counters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counters');
        Schema::dropIfExists('counter_items');
    }
}
