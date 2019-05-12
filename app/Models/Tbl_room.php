<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_room extends Model
{
    
    protected $table 		= 'tbl_room';
	protected $primaryKey 	= "room_id";
    public $timestamps 		= true;

   	public function scopegetavailableroom($query, $checkindate, $checkoutdate)
   	{
   		$query->select('tbl_room.*',DB::raw('count(*) as availableroom'))
   		->join('tbl_room_number','tbl_room.room_id','=','tbl_room_number.room_id')
   		->where('tbl_room_number.status','Available')
   		->whereNotIn('tbl_room_number.room_number',function($query2) use ($checkindate,$checkoutdate)
   			{
   				$query2->select('tbl_room_number_booking.room_number')->from('tbl_room_number_booking')->whereIn('tbl_room_number_booking.booking_id',function ($query3) use ($checkindate,$checkoutdate){
   					$query3->select('tbl_booking.booking_id')
   					->from('tbl_booking')
   					->where(function($query4) use ($checkindate,$checkoutdate)
	   					{
	   						$query4->whereBetween('tbl_booking.checkin_date',[$checkindate,$checkoutdate])
                  ->orWhereBetween('tbl_booking.checkout_date',[$checkindate,$checkoutdate])
                  ->orWhere(function($query6) use ($checkindate,$checkoutdate){
                    $query6->whereDate('tbl_booking.checkin_date','<=',$checkoutdate)
                    ->whereDate('tbl_booking.checkout_date','>=',$checkoutdate);
                  });
	   					})
   					->where(function($query5)
	   					{
	   						$query5->where('tbl_booking.booking_status','!=','Cancelled')
	   						->where('tbl_booking.booking_status','!=','Check Out');
	   					});
   				});
   			})
   		->groupBy('room_id');
   		return $query;
   	}

    public function scopegetmodifyavailableroom($query, $checkindate, $checkoutdate,$bookingid)
    {
      $query->select('tbl_room.*',DB::raw('count(*) as availableroom'))
      ->join('tbl_room_number','tbl_room.room_id','=','tbl_room_number.room_id')
      ->where('tbl_room_number.status','Available')
      ->whereNotIn('tbl_room_number.room_number',function($query2) use ($checkindate,$checkoutdate,$bookingid)
        {
          $query2->select('tbl_room_number_booking.room_number')->from('tbl_room_number_booking')->whereIn('tbl_room_number_booking.booking_id',function ($query3) use ($checkindate,$checkoutdate,$bookingid){
            $query3->select('tbl_booking.booking_id')
            ->from('tbl_booking')
            ->where(function($query4) use ($checkindate,$checkoutdate)
              {
                $query4->whereBetween('tbl_booking.checkin_date',[$checkindate,$checkoutdate])
                  ->orWhereBetween('tbl_booking.checkout_date',[$checkindate,$checkoutdate])
                  ->orWhere(function($query6) use ($checkindate,$checkoutdate){
                    $query6->whereDate('tbl_booking.checkin_date','<=',$checkoutdate)
                    ->whereDate('tbl_booking.checkout_date','>=',$checkoutdate);
                  });
              })
            ->where(function($query5)
              {
                $query5->where('tbl_booking.booking_status','!=','Cancelled')
                ->where('tbl_booking.booking_status','!=','Check Out');
              })
            ->where('tbl_booking.booking_id','!=',$bookingid);
          });
        })
      ->groupBy('room_id');
      return $query;
    }

    public function scopegetextramattress($query,$room_id,$qnt)
    {
      $query->select(DB::raw('SUM(tbl_room.capacity + tbl_room.extra_mattress) as tcp'),DB::raw('SUM(tbl_room.capacity) as cp'))
        ->from('tbl_room')
        ->join(DB::raw("(SELECT tbl_room_number.room_id FROM tbl_room_number WHERE tbl_room_number.room_id = $room_id AND tbl_room_number.status = 'Available' LIMIT $qnt) as rn"),'tbl_room.room_id','=','rn.room_id');
        return $query;
    }
    
    public function scopegetbookingdetailsofguest($query,$bookingcode)
    {
        $query->select('*',DB::raw('COUNT(*) AS roomqnt'))
        ->join('tbl_room_number','tbl_room.room_id','=','tbl_room_number.room_id')
        ->join('tbl_room_number_booking','tbl_room_number.room_number','=','tbl_room_number_booking.room_number')
        ->join('tbl_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
        ->join('tbl_guest_infos','tbl_guest_infos.guest_id','=','tbl_booking.guest_id')
        ->where('tbl_booking.booking_code',$bookingcode)
        ->groupBy('tbl_room.room_id');

        return $query;
    }	
    
}


//scopegetavailableroom
// SELECT tbl_room.*,COUNT(*) as availableroom FROM tbl_room JOIN tbl_room_number  ON tbl_room.room_id = tbl_room_number.room_id WHERE tbl_room_number.status = 'Available' AND tbl_room_number.room_number NOT IN  
// (
//     SELECT tbl_room_number_booking.room_number FROM tbl_room_number_booking  WHERE tbl_room_number_booking.booking_id IN 
//         (
//         SELECT tbl_booking.booking_id FROM tbl_booking  WHERE ((tbl_booking.checkin_date BETWEEN '2019-04-06' AND '2019-04-10') OR (tbl_booking.checkout_date BETWEEN '2019-04-10' AND '2019-04-06') OR (tbl_booking.checkin_date < '2019-04-10' AND tbl_booking.checkout_date > '2019-04-10')) AND (tbl_booking.booking_status != 'Cancelled' OR tbl_booking.booking_status != 'Check Out')
//         )
// ) GROUP BY room_id


//scopegetmodifyavailableroom
// SELECT tbl_room.*,COUNT(*) as availableroom FROM tbl_room JOIN tbl_room_number  ON tbl_room.room_id = tbl_room_number.room_id WHERE tbl_room_number.status = 'Available' AND tbl_room_number.room_number NOT IN  
// (
//     SELECT tbl_room_number_booking.room_number FROM tbl_room_number_booking  WHERE tbl_room_number_booking.booking_id IN 
//         (
//         SELECT tbl_booking.booking_id FROM tbl_booking  WHERE ((tbl_booking.checkin_date BETWEEN '2019-04-08' AND '2019-04-09') OR (tbl_booking.checkout_date BETWEEN '2019-04-08' AND '2019-04-09')) AND (tbl_booking.booking_status != 'Cancelled' OR tbl_booking.booking_status != 'Check Out')
//             AND ( tbl_booking.booking_id != 2)
//         )
// ) GROUP BY room_id


//scopegetbookingdetailsofguest
// SELECT  *,COUNT(*) FROM tbl_room JOIN tbl_room_number on tbl_room.room_id = tbl_room_number.room_id JOIN tbl_room_number_booking ON tbl_room_number.room_number = tbl_room_number_booking.room_number JOIN tbl_booking ON tbl_room_number_booking.booking_id = tbl_booking.booking_id JOIN tbl_guest_infos ON tbl_guest_infos.guest_id = tbl_booking.guest_id GROUP BY tbl_room.room_id
