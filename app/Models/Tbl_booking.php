<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_booking extends Model
{
    //
    protected $table 		= 'tbl_booking';
	protected $primaryKey 	= "booking_id";
    public $timestamps 		= true;

    public function scopegetpendingdata($query,$start,$limit,$order,$dir)
    {
    	$query->select('*')
		->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Pending')
		->offset($start)
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

    public function scopecountpendingdata($query,$start,$limit,$order,$dir)
    {
    	$query->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Pending')
		->groupBy('tbl_booking.booking_id')
		->orderBy($order, $dir)
		->limit($limit);
		return $query;

    }

    public function scopegetpendingdatawithsearch($query,$start,$limit,$order,$dir,$search)
    {
    	$query->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Pending')
		->where(function($query) use($search)
			{
				$query->where('tbl_guest_infos.first_name', 'like', "%".$search."%")
				->orWhere('tbl_guest_infos.last_name','like',"%".$search."%")
				->orWhere('tbl_booking.booking_code','like',"%".$search."%")
				->orWhere('tbl_room_number_booking.room_number','like',"%".$search."%")
				->orWhere('tbl_booking.checkin_date','like',"%".$search."%")
				->orWhere('tbl_booking.checkout_date','like',"%".$search."%")
				->orWhere('tbl_booking.total_amount','like',"%".$search."%");
			})
		->offset($start)
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

    public function scopecountpendingdatawithsearch($query,$start,$limit,$order,$dir,$search)
    {
    	$query->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Pending')
		->where(function($query) use($search)
			{
				$query->where('tbl_guest_infos.first_name', 'like', "%".$search."%")
				->orWhere('tbl_guest_infos.last_name','like',"%".$search."%")
				->orWhere('tbl_booking.booking_code','like',"%".$search."%")
				->orWhere('tbl_room_number_booking.room_number','like',"%".$search."%")
				->orWhere('tbl_booking.checkin_date','like',"%".$search."%")
				->orWhere('tbl_booking.checkout_date','like',"%".$search."%")
				->orWhere('tbl_booking.total_amount','like',"%".$search."%");
			})
		->groupBy('tbl_booking.booking_id')
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

     public function scopegetconfirmdata($query,$start,$limit,$order,$dir)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
		->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Confirmed')
		->offset($start)
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

     public function scopecountconfirmdata($query,$start,$limit,$order,$dir)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Confirmed')
		->groupBy('tbl_booking.booking_id')
		->orderBy($order, $dir)
		->limit($limit);
		return $query;

    }

     public function scopegetconfirmdatawithsearch($query,$start,$limit,$order,$dir,$search)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Confirmed')
		->where(function($query) use($search)
			{
				$query->where('tbl_guest_infos.first_name', 'like', "%".$search."%")
				->orWhere('tbl_guest_infos.last_name','like',"%".$search."%")
				->orWhere('tbl_booking.booking_code','like',"%".$search."%")
				->orWhere('tbl_room_number_booking.room_number','like',"%".$search."%")
				->orWhere('tbl_booking.checkin_date','like',"%".$search."%")
				->orWhere('tbl_booking.checkout_date','like',"%".$search."%")
				->orWhere('tbl_booking.total_amount','like',"%".$search."%");
			})
		->offset($start)
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

    public function scopecountconfirmdatawithsearch($query,$start,$limit,$order,$dir,$search)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Confirmed')
		->where(function($query) use($search)
			{
				$query->where('tbl_guest_infos.first_name', 'like', "%".$search."%")
				->orWhere('tbl_guest_infos.last_name','like',"%".$search."%")
				->orWhere('tbl_booking.booking_code','like',"%".$search."%")
				->orWhere('tbl_room_number_booking.room_number','like',"%".$search."%")
				->orWhere('tbl_booking.checkin_date','like',"%".$search."%")
				->orWhere('tbl_booking.checkout_date','like',"%".$search."%")
				->orWhere('tbl_booking.total_amount','like',"%".$search."%");
			})
		->groupBy('tbl_booking.booking_id')
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

    public function scopegetcheckindata($query,$start,$limit,$order,$dir)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
		->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Check In')
		->offset($start)
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

     public function scopecountcheckindata($query,$start,$limit,$order,$dir)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Check In')
		->groupBy('tbl_booking.booking_id')
		->orderBy($order, $dir)
		->limit($limit);
		return $query;

    }

     public function scopegetcheckindatawithsearch($query,$start,$limit,$order,$dir,$search)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Check In')
		->where(function($query) use($search)
			{
				$query->where('tbl_guest_infos.first_name', 'like', "%".$search."%")
				->orWhere('tbl_guest_infos.last_name','like',"%".$search."%")
				->orWhere('tbl_booking.booking_code','like',"%".$search."%")
				->orWhere('tbl_room_number_booking.room_number','like',"%".$search."%")
				->orWhere('tbl_booking.checkin_date','like',"%".$search."%")
				->orWhere('tbl_booking.checkout_date','like',"%".$search."%")
				->orWhere('tbl_booking.total_amount','like',"%".$search."%");
			})
		->offset($start)
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

    public function scopecountcheckindatawithsearch($query,$start,$limit,$order,$dir,$search)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where('tbl_booking.booking_status','Check In')
		->where(function($query) use($search)
			{
				$query->where('tbl_guest_infos.first_name', 'like', "%".$search."%")
				->orWhere('tbl_guest_infos.last_name','like',"%".$search."%")
				->orWhere('tbl_booking.booking_code','like',"%".$search."%")
				->orWhere('tbl_room_number_booking.room_number','like',"%".$search."%")
				->orWhere('tbl_booking.checkin_date','like',"%".$search."%")
				->orWhere('tbl_booking.checkout_date','like',"%".$search."%")
				->orWhere('tbl_booking.total_amount','like',"%".$search."%");
			})
		->groupBy('tbl_booking.booking_id')
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

     public function scopegetalldata($query,$start,$limit,$order,$dir)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
		->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->offset($start)
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

     public function scopecountalldata($query,$start,$limit,$order,$dir)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->groupBy('tbl_booking.booking_id')
		->orderBy($order, $dir)
		->limit($limit);
		return $query;

    }

     public function scopegetalldatawithsearch($query,$start,$limit,$order,$dir,$search)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		
		->where(function($query) use($search)
			{
				$query->where('tbl_guest_infos.first_name', 'like', "%".$search."%")
				->orWhere('tbl_guest_infos.last_name','like',"%".$search."%")
				->orWhere('tbl_booking.booking_code','like',"%".$search."%")
				->orWhere('tbl_room_number_booking.room_number','like',"%".$search."%")
				->orWhere('tbl_booking.checkin_date','like',"%".$search."%")
				->orWhere('tbl_booking.checkout_date','like',"%".$search."%")
				->orWhere('tbl_booking.total_amount','like',"%".$search."%");
			})
		->offset($start)
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }

    public function scopecountalldatawithsearch($query,$start,$limit,$order,$dir,$search)
    {
    	$query->select('*',DB::raw('(tbl_booking.total_amount - tbl_booking.paid_amount) as balance_amount'))
    	->join('tbl_room_number_booking','tbl_room_number_booking.booking_id','=','tbl_booking.booking_id')
		->join('tbl_guest_infos','tbl_guest_infos.guest_id','tbl_booking.guest_id')
		->leftJoin('tbl_bank_deposit_slip','tbl_booking.booking_id','=','tbl_bank_deposit_slip.booking_id')
		->where(function($query) use($search)
			{
				$query->where('tbl_guest_infos.first_name', 'like', "%".$search."%")
				->orWhere('tbl_guest_infos.last_name','like',"%".$search."%")
				->orWhere('tbl_booking.booking_code','like',"%".$search."%")
				->orWhere('tbl_room_number_booking.room_number','like',"%".$search."%")
				->orWhere('tbl_booking.checkin_date','like',"%".$search."%")
				->orWhere('tbl_booking.checkout_date','like',"%".$search."%")
				->orWhere('tbl_booking.total_amount','like',"%".$search."%");
			})
		->groupBy('tbl_booking.booking_id')
		->limit($limit)
		->orderBy($order, $dir);
		return $query;
    }
}
