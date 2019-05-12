<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tbl_booking;
use Carbon\Carbon;

class CancelUnconfirmedReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CancelUnconfirmedReservation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This comamand will cancel all the reservation that past 1 day and still unconfirm';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cancel = Tbl_booking::whereDate('tbl_booking.created_at','<',Carbon::now()->subHours(24))->where('tbl_booking.confirmation_status','Pending')
        ->update([
            'tbl_booking.booking_status' => 'Cancelled',
            'tbl_booking.cancel_date'=> Carbon::now(),
            'tbl_booking.confirmation_status' => 'Cancelled'
        ]);
    }
}
