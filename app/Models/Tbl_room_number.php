<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_room_number extends Model
{
    protected $table 		= 'tbl_room_number';
	protected $primaryKey 	= "room_number_id";
    public $timestamps 		= false;

     public function scopegetroomnumber($query,$checkin,$checkout,$roomid,$roomqnt)
    {
    	$query->select('tbl_room_number.room_number')
    	->from('tbl_room_number')
    	->whereNotIn('tbl_room_number.room_number',function($query2) use($checkin,$checkout)
    	{
    		$query2->select('tbl_room_number_booking.room_number')
    		->from('tbl_room_number_booking')
    		->whereIn('tbl_room_number_booking.booking_id',function($query3) use($checkin,$checkout)
    		{
    			$query3->select('tbl_booking.booking_id')
                ->from('tbl_booking')
                ->where(function($query4) use ($checkin,$checkout)
                  {
                    $query4->whereBetween('tbl_booking.checkin_date',[$checkin,$checkout])
                      ->orWhereBetween('tbl_booking.checkout_date',[$checkin,$checkout])
                      ->orWhere(function($query6) use ($checkin,$checkout){
                        $query6->whereDate('tbl_booking.checkin_date','<=',$checkout)
                        ->whereDate('tbl_booking.checkout_date','>=',$checkout);
                      });
                  })
                ->where(function($query5)
                  {
                    $query5->where('tbl_booking.booking_status','!=','Cancelled')
                    ->where('tbl_booking.booking_status','!=','Check Out');
                  });
    		});
    	})
    	->where('tbl_room_number.room_id',$roomid)
        ->where('tbl_room_number.status','Available')
    	->limit($roomqnt);

    	return $query;
    }

}

// SELECT tbl_room_number.room_number FROM tbl_room_number WHERE tbl_room_number.room_number NOT IN
// (SELECT tbl_room_number_booking.room_number FROM tbl_room_number_booking 
// 	WHERE tbl_room_number_booking.booking_id IN
// 	(		SELECT tbl_booking.booking_id FROM tbl_booking WHERE ( (tbl_booking.checkin_date BETWEEN '2019-03-25' AND '2019-03-26') OR (tbl_booking.checkout_date 			BETWEEN '2019-03-26' AND '2019-03-25') OR (tbl_booking.checkin_date = '2019-03-25')) AND (tbl_booking.booking_status != 'Cancelled' OR 							tbl_booking.booking_status != 'Check Out')
// 	)
// )
// AND tbl_room_number.room_id = 2 AND tbl_room_number.status = 'Available' LIMIT 2
