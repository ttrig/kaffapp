<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceDataTable extends Migration
{
    public function up()
    {
        Schema::create('device_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('device_id')->index();
            // TODO remove nullable
            $table->unsignedTinyInteger('value')->nullable();
            $table->string('ip', 15);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('device_data');
    }
}
