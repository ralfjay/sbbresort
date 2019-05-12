<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblRoomNumberBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_room_number_booking', function (Blueprint $table) {
            $table->increments('room_number_booking_id');
            $table->string('room_number_id')->nullable(false);
            $table->string('room_number')->nullable(false);
            $table->string('booking_id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_room_number_booking');
    }
}
