<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('api_token', 80)->unique()->nullable();
            $table->unsignedTinyInteger('value_when_empty');
            $table->unsignedTinyInteger('value_when_full');
            // TODO remove nullable
            $table->unsignedTinyInteger('capacity_in_cl')->nullable();
            $table->unsignedTinyInteger('minutes_to_brew')->nullable();
            $table->unsignedTinyInteger('fresh_for_minutes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
