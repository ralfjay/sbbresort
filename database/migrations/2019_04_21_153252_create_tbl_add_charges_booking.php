<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAddChargesBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_add_charges_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->nullable(false);
            $table->string('description')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->integer('rate')->nullable(false);
            $table->integer('amount')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_add_charges_booking');
    }
}
