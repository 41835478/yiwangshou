<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plot_properties', function($table) {
            $table->increments('id');
            $table->integer('property_id')->unsigned();
            $table->integer('plot_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plot_id')->references('id')->on('plots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plot_properties');
    }
}
