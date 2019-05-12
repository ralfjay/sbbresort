<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_room_number_booking extends Model
{
    //
    protected $table 		= 'tbl_room_number_booking';
	protected $primaryKey 	= "room_number_booking_id";
    public $timestamps 		= false;

   public function scopegetroomnumbers($query,$bookingcode)
   {
   		$query->select('tbl_room_number_booking.room_number')
   		->join('tbl_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
   		->where('tbl_booking.booking_code',$bookingcode);
   		return $query;
   }
}
