<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_booking', function (Blueprint $table) {
            $table->increments('booking_id');
            $table->string('guest_id')->nullable(false);
            $table->date('checkin_date')->nullable(false);
            $table->date('checkout_date')->nullable(false);
            $table->dateTime('booking_date')->nullable(false);
            $table->string('payment_status')->default('Pending');
            $table->string('booking_status')->default('Pending');
            $table->string('confirmation_status')->default('Pending');
            $table->string('cancel_date')->default(null);
            $table->string('prev_checkin')->default(null);
            $table->string('prev_checkout')->default(null);
            $table->string('walkin_online')->default('Online');
            $table->double('total_amount')->nullable(false);
            $table->double('paid_amount')->default(0);
            $table->double('req_deposit')->nullable(false);
            $table->double('discount_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_booking');
    }
}
