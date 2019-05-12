<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblDiscountVoucherBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_discount_voucher_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->nullable(false);
            $table->integer('percentage')->nullable(false);
            $table->integer('description')->nullable(false);
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
        Schema::dropIfExists('tbl_discount_voucher_booking');
    }
}
