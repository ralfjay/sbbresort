<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;
use Redirect;
use Session;
use Excel;
use DB;
use Response;
use PDF;
use stdClass;
use Input;
use Validator;
use View;
use App\Models\Tbl_guest_infos;
use App\Models\Tbl_booking;
use App\Models\Tbl_room;
use App\Models\Tbl_room_number;
use App\Models\Tbl_room_number_booking;
use App\Models\Tbl_tax;
use App\Models\Tbl_contact_number;
use App\Models\Tbl_email;
use App\Models\Tbl_bank_deposit_slip;
use App\Models\Tbl_account;
use App\Models\Tbl_add_charges;
use App\Models\Tbl_discount_voucher;
use App\Models\Tbl_add_charges_booking;
use App\Models\Tbl_discount_voucher_booking;
use App\Models\Tbl_payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailConfirmation;
use App\Mail\SendEmailModifySuccess;
use Crypt;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AdminSideController extends Controller
{

	 public static function dateConverter($date_1,$type,$date_2 = null)
    {
        if($type == 'display' && ($date_1 != null | $date_1 != ''))
        {
            $date                               = date('y-m-d',strtotime($date_1));
            $date                               = date_create($date);
            $result                             = date_format($date,'M d, Y');
            
        }else if($type == 'diff' && (($date_1 != null | $date_1 != '') &&  ($date_2 != null | $date_2 != '')))
        {
            $date_1_diff                        = new \DateTime(date('y-m-d',strtotime($date_1)));
            $date_2_diff                        = new \DateTime(date('y-m-d',strtotime($date_2)));
            $result                             = $date_1_diff->diff($date_2_diff,true)->days;
        }else if($type == 'db' && ($date_1 != null | $date_1 != ''))
        {
            $date                               = date('y-m-d',strtotime($date_1));
            $date                               = date_create($date);
            $result                             = date_format($date,'Y-m-d');
        }
        else if($type == 'display datetime' && ($date_1 != null | $date_1 != ''))
        {
            $date                               = date('y-m-d',strtotime($date_1));
            $date                               = date_create($date);
            $result                             = date_format($date,'M d, Y h:i A');
        }
        else
        {
            return 'UNKNOWN';
        }

        return $result;
    }

    public static function currencyConverter($value)
    {
    	if($value < 0)
    	{
    		$value = 0;
    	}
    	$result = "₱".number_format(($value),2);
    	return $result;
    }

    public function login_index()
    {

    	return View('admin.resort_admin_login');
    }

    public function admin_login_attempt()
    {
    	Request::validate([
    		'username' => 'required',
    		'password' => 'required',
    	]);

    	$usernamecheck 									= Tbl_account::where('tbl_account.username',Request::input('username'))->get();
    	if(count($usernamecheck) > 0)
    	{
    		$password  									= Crypt::decryptString($usernamecheck[0]['password']);

    		if(Request::input('password') == $password)
    		{
    			Session::put('adx_username',Request::input('username'));
    			Session::put('adx_password',$usernamecheck[0]['password']);
    			Session::put('adx_user_type',$usernamecheck[0]['user_type']);
    			if($usernamecheck[0]['user_type'] == 'admin')
    			{
					return redirect('admin_dashboard');

    			}else if($usernamecheck[0]['user_type'] == 'staff')
    			{
    				return redirect('staff_dashboard');
    			}

    		}
    		else
    		{
    			return redirect('/resort_admin_login')->with('login_failed','Incorrect Log in Details');
    		}

    	}
    	else
    	{
    		return redirect('/resort_admin_login')->with('login_failed','Incorrect Log in Details');
    	}
    }

    public function admin_dashboard()
    {
    	if(Session::get('adx_username') != null | Session::get('adx_password') != null | Session::get('adx_user_type') != null )
    	{
    	return View('admin.admin_dashboard');
    	}else
    	{
    		Session::flush();
    		return redirect('/resort_admin_login');
    	}
    }

    public function get_pending_reservation()
    {
    	$columns  = array(
			0 	 => 'tbl_booking.booking_code',
			1 	 => 'tbl_guest_infos.last_name',
			3 	 => 'tbl_room_number_booking.room_number',
			4	 => 'tbl_booking.checkin_date',
			5 	 => 'tbl_booking.checkout_date',
			6 	 => 'tbl_booking.total_amount',
			7 	 => 'tbl_bank_deposit_slip.filename',
		);
		
		$totalData 										= Tbl_booking::where('tbl_booking.booking_status','Pending')
														->groupBy('tbl_booking.booking_id')
														->count();
		$limit 											= Request::input('length');
		$start 											= Request::input('start');
		$order 											= $columns[Request::input('order.0.column')];
		$dir 											= Request::input('order.0.dir');
		
		if(empty(Request::input('search.value'))){
		 $pendingbook_data 								= Tbl_booking::getpendingdata($start,$limit,$order,$dir)->get();
		 $totalFiltered 								= Tbl_booking::countpendingdata($start,$limit,$order,$dir)->get();
		 $totalFiltered 								= count($totalFiltered);
		}
		else
		{
			
			$pendingbook_data  							= Tbl_booking::getpendingdatawithsearch($start,$limit,$order,$dir,
															Request::input('search.value'))->get();
			$totalFiltered 								= Tbl_booking::countpendingdatawithsearch($start,$limit,$order,$dir,
															Request::input('search.value'))->get();
			$totalFiltered 								= count($totalFiltered);
		}		
					
		
		$data 											= array();
		$pendingindex 									= 0;
		$rn_index 										= 0;
		$prev_bc 										= '';
		$prev_room 										= '';
		$prev_slip 										= '';
		$array_room 									= array();
		$array_slip 									= array();
		if($pendingbook_data){
			$i 											= 0;
			for (; $i < count($pendingbook_data);) 
			{ 
				unset($array_room);
				unset($array_slip);
				$current_bid 							= Crypt::encryptString($pendingbook_data[$i]['booking_id']);
				$current_guest 							= $pendingbook_data[$i]['last_name']. ', '.$pendingbook_data[$i]['first_name'];
				$prev_bc 								= $pendingbook_data[$i]['booking_code'];
				$nestdata['booking_code'] 				= $pendingbook_data[$i]['booking_code'];
				$nestdata['name'] 						= $pendingbook_data[$i]['last_name']. ', '.$pendingbook_data[$i]['first_name'];
				$nestdata['checkin_date'] 				= $this->dateConverter($pendingbook_data[$i]['checkin_date'],'display');
				$nestdata['checkout_date'] 				= $this->dateConverter($pendingbook_data[$i]['checkout_date'],'display');
				$nestdata['contact_number'] 			= $pendingbook_data[$i]['contact_number'];
				$nestdata['total_amount'] 				= $this->currencyConverter($pendingbook_data[$i]['total_amount']);
				
				$array_room = array();
				$array_slip = array();

				for (;$i < count($pendingbook_data) && $pendingbook_data[$i]['booking_code'] == $prev_bc;) { 
					
					if( in_array($pendingbook_data[$i]['room_number'], $array_room)  == false)
					{
						$array_room[] = $pendingbook_data[$i]['room_number'];
					}
					
					if( in_array('images/'.$pendingbook_data[$i]['filename'], $array_slip) == false && $pendingbook_data[$i]['filename'] != null)
					{
						$array_slip[] = 'images/'.$pendingbook_data[$i]['filename'];
					}
					
					$prev_bc = $pendingbook_data[$i]['booking_code'];
					$i++;
				}

				$nestdata['room_number']  					= '';
				$nestdata['deposit_slip'] 					= '';
				foreach ($array_room as $room_number) 
				{
					$nestdata['room_number']				= $nestdata['room_number'].$room_number.'<br>';
				}
				foreach ($array_slip as $filename) 
				{
					$nestdata['deposit_slip'] 			= $nestdata['deposit_slip']."<a href=\"#\" onclick=\"imgModal('../".$filename."')\"><img src=\"".$filename."\" height\"50\" width=\"50\"></a>".'<br>';
				}
				
				
				
				$nestdata['action'] 						= "<div class=\"dropdown mb-4\">
											                    <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
											                      Actions
											                    </button>
											                    <div class=\"dropdown-menu animated--fade-in\" aria-labelledby=\"dropdownMenuButton\">
											                      <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"paymentModal\" onclick=\"paymentBook('".$current_bid."')\"><span class=\"fa fa-dollar-sign\"><span>&nbsp; Payment</a>
											                      <a class=\"dropdown-item\" href=\"#\"  data-toggle=\"modal\" data-target=\"addChargeModal\" onclick=\"addChargeBook('".$current_bid."')\"><span class=\"fa fa-plus\"><span>&nbsp; Addt&apos;l Charge</a>
											                      <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"discountModal\" onclick=\"discountBook('".$current_bid."')\"><span class=\"fa fa-percent\">&nbsp; Discount/Voucher</span>&nbsp;</a>
											                      <a class=\"dropdown-item\" href=\"#\" onclick=\"clientInfoBook('".$current_bid."')\"><span class=\"fa fa-info\"><span>&nbsp; Client Info</a>
											                      <a class=\"dropdown-item\" href=\"#\"  data-toggle=\"modal\" data-target=\"modifyModal\" onclick=\"modifyBook('".$current_bid."')\"><span class=\"fa fa-pencil-alt\"><span>&nbsp; Modify</a>
											                      <a class=\"dropdown-item\" href=\"#\"  onclick=\"cancelBook('".$current_bid."','".$current_guest."')\"><span class=\"fa fa-times\"><span>&nbsp; Cancel</a>
											                    </div>
											                  </div>";
				$data[] 									= $nestdata;

			}

		}
		
		$json_data 											= array
															(
			
																"draw"				=> intval(Request::input('draw')),
																"recordsTotal"		=> intval($totalData),
																"recordsFiltered"   => intval($totalFiltered),
																"data"				=> $data

															);
		
		return json_encode($json_data);

    }

    public function get_confirm_reservation()
    {
    	$columns  = array(
			0 	 => 'tbl_booking.booking_code',
			1 	 => 'tbl_guest_infos.last_name',
			3 	 => 'tbl_room_number_booking.room_number',
			4	 => 'tbl_booking.checkin_date',
			5 	 => 'tbl_booking.checkout_date',
			6 	 => 'tbl_booking.total_amount',
			7 	 => 'tbl_booking.paid_amount',
			8 	 => 'balance_amount',
			9 	 => 'tbl_bank_deposit_slip.filename',
		);
		
		$totalData 										= Tbl_booking::where('tbl_booking.payment_status','Confirmed')
														->orWhere('tbl_booking.booking_status','Confirmed')
														->groupBy('tbl_booking.booking_id')
														->count();
		$limit 											= Request::input('length');
		$start 											= Request::input('start');
		$order 											= $columns[Request::input('order.0.column')];
		$dir 											= Request::input('order.0.dir');
		
		if(empty(Request::input('search.value'))){
		 $confirmbook_data 								= Tbl_booking::getconfirmdata($start,$limit,$order,$dir)->get();
		 $totalFiltered 								= Tbl_booking::countconfirmdata($start,$limit,$order,$dir)->get();
		 $totalFiltered 								= count($totalFiltered);
		}
		else
		{
			
			$confirmbook_data  							= Tbl_booking::getconfirmdatawithsearch($start,$limit,$order,$dir,
															Request::input('search.value'))->get();
			$totalFiltered 								= Tbl_booking::countconfirmdatawithsearch($start,$limit,$order,$dir,
															Request::input('search.value'))->get();
			$totalFiltered 								= count($totalFiltered);
		}		
					
		
		$data 											= array();
		$confirmindex 									= 0;
		$rn_index 										= 0;
		$prev_bc 										= '';
		$prev_room 										= '';
		$prev_slip 										= '';
		$array_room 									= array();
		$array_slip 									= array();
		if($confirmbook_data){
			$i 											= 0;
			for (; $i < count($confirmbook_data);) 
			{ 
				unset($array_room);
				unset($array_slip);
				$current_bid 							= Crypt::encryptString($confirmbook_data[$i]['booking_id']);
				$current_guest 							= $confirmbook_data[$i]['last_name']. ', '.$confirmbook_data[$i]['first_name'];
				$alreadyPaid 							= $confirmbook_data[$i]['paid_amount'] >= 
														  $confirmbook_data[$i]['req_deposit'];
				$current_checkin 					    = $confirmbook_data[$i]['checkin_date'];
				$prev_bc 								= $confirmbook_data[$i]['booking_code'];
				$nestdata['booking_code'] 				= $confirmbook_data[$i]['booking_code'];
				$nestdata['name'] 						= $confirmbook_data[$i]['last_name']. ', '.$confirmbook_data[$i]['first_name'];
				$nestdata['checkin_date'] 				= $this->dateConverter($confirmbook_data[$i]['checkin_date'],'display');
				$nestdata['checkout_date'] 				= $this->dateConverter($confirmbook_data[$i]['checkout_date'],'display');
				$nestdata['guest'] 						= $confirmbook_data[$i]['no_of_guest'];
				$nestdata['total_amount'] 				= $this->currencyConverter($confirmbook_data[$i]['total_amount']);
				$nestdata['paid_amount'] 				= $this->currencyConverter($confirmbook_data[$i]['paid_amount']);
				$nestdata['balance_amount'] 			= $this->currencyConverter($confirmbook_data[$i]['total_amount'] - $confirmbook_data[$i]['paid_amount']);
				
				$array_room = array();
				$array_slip = array();

				for (;$i < count($confirmbook_data) && $confirmbook_data[$i]['booking_code'] == $prev_bc;) { 
					
					if( in_array($confirmbook_data[$i]['room_number'], $array_room)  == false)
					{
						$array_room[] = $confirmbook_data[$i]['room_number'];
					}
					
					if( in_array('images/'.$confirmbook_data[$i]['filename'], $array_slip) == false && $confirmbook_data[$i]['filename'] != null)
					{
						$array_slip[] = 'images/'.$confirmbook_data[$i]['filename'];
					}
					
					$prev_bc = $confirmbook_data[$i]['booking_code'];
					$i++;
				}

				$nestdata['room_number']  					= '';
				$nestdata['deposit_slip'] 					= '';
				foreach ($array_room as $room_number) 
				{
					$nestdata['room_number']				= $nestdata['room_number'].$room_number.'<br>';
											
				}
				foreach ($array_slip as $filename) 
				{
					$nestdata['deposit_slip'] 				= $nestdata['deposit_slip']."<a href=\"#\" onclick=\"imgModal('../".$filename."')\"><img src=\"".$filename."\" height\"50\" width=\"50\"></a>".'<br>';

				}
				
				$nestdata['action'] 						= "<div class=\"dropdown mb-4\">
											                    <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
											                      Actions
											                    </button>
											                    <div class=\"dropdown-menu animated--fade-in\" aria-labelledby=\"dropdownMenuButton\">";
				if($alreadyPaid | $current_checkin == date('Y-m-d'))
				{
				$nestdata['action'] 						.= "<a class=\"dropdown-item\" href=\"#\" 
																 onclick=\"checkinBook('".$current_bid."','".$current_guest."')\"><span class=\"fa fa-arrow-down\"><span>&nbsp; Check In</a>";
				}
			    $nestdata['action'] 						.= "<a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" 																		data-target=\"paymentModal\" onclick=\"paymentBook('".$current_bid."')\">
			    													<span class=\"fa fa-dollar-sign\"><span>&nbsp; Payment</a>
											                      <a class=\"dropdown-item\" href=\"#\"  data-toggle=\"modal\" data-target=\"addChargeModal\" onclick=\"addChargeBook('".$current_bid."')\"><span class=\"fa fa-plus\"><span>&nbsp; Addt&apos;l Charge</a>
											                      <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"discountModal\" onclick=\"discountBook('".$current_bid."')\"><span class=\"fa fa-percent\">&nbsp; Discount/Voucher</span>&nbsp;</a>
											                      <a class=\"dropdown-item\" href=\"#\" onclick=\"clientInfoBook('".$current_bid."')\"><span class=\"fa fa-info\"><span>&nbsp; Client Info</a>
											                      <a class=\"dropdown-item\" href=\"#\"  data-toggle=\"modal\" data-target=\"modifyModal\" onclick=\"modifyBook('".$current_bid."')\"><span class=\"fa fa-pencil-alt\"><span>&nbsp; Modify</a>
											                      <a class=\"dropdown-item\" href=\"#\"  onclick=\"cancelBook('".$current_bid."','".$current_guest."')\"><span class=\"fa fa-times\"><span>&nbsp; Cancel</a>
											                    </div>
											                  </div>";
				$data[] 									= $nestdata;

			}

		}
		
		$json_data 											= array
															(
			
																"draw"				=> intval(Request::input('draw')),
																"recordsTotal"		=> intval($totalData),
																"recordsFiltered"   => intval($totalFiltered),
																"data"				=> $data

															);
		
		return json_encode($json_data);

    }

    public function get_checkin_reservation()
    {
    	$columns  = array(
			0 	 => 'tbl_booking.booking_code',
			1 	 => 'tbl_guest_infos.last_name',
			3 	 => 'tbl_room_number_booking.room_number',
			4	 => 'tbl_booking.checkin_date',
			5 	 => 'tbl_booking.checkout_date',
			6 	 => 'tbl_booking.total_amount',
			7 	 => 'tbl_booking.paid_amount',
			8 	 => 'balance_amount',
		);
		
		$totalData 										= Tbl_booking::where('tbl_booking.payment_status','Check In')
														->orWhere('tbl_booking.booking_status','Check In')
														->groupBy('tbl_booking.booking_id')
														->count();
		$limit 											= Request::input('length');
		$start 											= Request::input('start');
		$order 											= $columns[Request::input('order.0.column')];
		$dir 											= Request::input('order.0.dir');
		
		if(empty(Request::input('search.value'))){
		 $checkinbook_data 								= Tbl_booking::getcheckindata($start,$limit,$order,$dir)->get();
		 $totalFiltered 								= Tbl_booking::countcheckindata($start,$limit,$order,$dir)->get();
		 $totalFiltered 								= count($totalFiltered);
		}
		else
		{
			
			$checkinbook_data  							= Tbl_booking::getcheckindatawithsearch($start,$limit,$order,$dir,
															Request::input('search.value'))->get();
			$totalFiltered 								= Tbl_booking::countcheckindatawithsearch($start,$limit,$order,$dir,
															Request::input('search.value'))->get();
			$totalFiltered 								= count($totalFiltered);
		}		
					
		
		$data 											= array();
		$checkinindex 									= 0;
		$rn_index 										= 0;
		$prev_bc 										= '';
		$prev_room 										= '';
		$prev_slip 										= '';
		$array_room 									= array();
		$array_slip 									= array();
		if($checkinbook_data){
			$i 											= 0;
			for (; $i < count($checkinbook_data);) 
			{ 
				unset($array_room);
				unset($array_slip);
				$current_bid 							= Crypt::encryptString($checkinbook_data[$i]['booking_id']);
				$current_guest 							= $checkinbook_data[$i]['last_name']. ', '.$checkinbook_data[$i]['first_name'];
				$current_checkin 					    = $checkinbook_data[$i]['checkin_date'];
				$canCheckout					    	= $checkinbook_data[$i]['total_amount'] <= $checkinbook_data[$i]['paid_amount'];
				$prev_bc 								= $checkinbook_data[$i]['booking_code'];
				$nestdata['booking_code'] 				= $checkinbook_data[$i]['booking_code'];
				$nestdata['name'] 						= $checkinbook_data[$i]['last_name']. ', '.$checkinbook_data[$i]['first_name'];
				$nestdata['checkin_date'] 				= $this->dateConverter($checkinbook_data[$i]['checkin_date'],'display');
				$nestdata['checkout_date'] 				= $this->dateConverter($checkinbook_data[$i]['checkout_date'],'display');
				$nestdata['contact_number'] 			= $checkinbook_data[$i]['contact_number'];
				$nestdata['total_amount'] 				= $this->currencyConverter($checkinbook_data[$i]['total_amount']);
				$nestdata['paid_amount'] 				= $this->currencyConverter($checkinbook_data[$i]['paid_amount']);
				$nestdata['balance_amount'] 			= $this->currencyConverter($checkinbook_data[$i]['total_amount'] - $checkinbook_data[$i]['paid_amount']);
				
				$array_room = array();
				$array_slip = array();

				for (;$i < count($checkinbook_data) && $checkinbook_data[$i]['booking_code'] == $prev_bc;) { 
					
					if( in_array($checkinbook_data[$i]['room_number'], $array_room)  == false)
					{
						$array_room[] = $checkinbook_data[$i]['room_number'];
					}
					
					if( in_array('images/'.$checkinbook_data[$i]['filename'], $array_slip) == false && $checkinbook_data[$i]['filename'] != null)
					{
						$array_slip[] = 'images/'.$checkinbook_data[$i]['filename'];
					}
					
					$prev_bc = $checkinbook_data[$i]['booking_code'];
					$i++;
				}

				$nestdata['room_number']  					= '';
				$nestdata['deposit_slip'] 					= '';
				foreach ($array_room as $room_number) 
				{
					$nestdata['room_number']				= $nestdata['room_number'].$room_number.'<br>';
				}
				foreach ($array_slip as $filename) 
				{
					$nestdata['deposit_slip'] 				= $nestdata['deposit_slip']."<a href=\"#\" onclick=\"imgModal('../".$filename."')\"><img src=\"".$filename."\" height\"50\" width=\"50\"></a>".'<br>';
				}
				
				$nestdata['action'] 						= "<div class=\"dropdown mb-4\">
											                    <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
											                      Actions
											                    </button>
											                    <div class=\"dropdown-menu animated--fade-in\" aria-labelledby=\"dropdownMenuButton\">";
				if($canCheckout)
				{
				$nestdata['action'] 						.= "<a class=\"dropdown-item\" href=\"#\" 
																 onclick=\"checkoutBook('".$current_bid."','".$current_guest."')\"><span class=\"fa fa-arrow-up\"><span>&nbsp; Check Out</a>";
				}
			    $nestdata['action'] 						.= "<a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" 																		data-target=\"paymentModal\" onclick=\"paymentBook('".$current_bid."')\">
			    													<span class=\"fa fa-dollar-sign\"><span>&nbsp; Payment</a>
											                      <a class=\"dropdown-item\" href=\"#\"  data-toggle=\"modal\" data-target=\"addChargeModal\" onclick=\"addChargeBook('".$current_bid."')\"><span class=\"fa fa-plus\"><span>&nbsp; Addt&apos;l Charge</a>
											                      <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"discountModal\" onclick=\"discountBook('".$current_bid."')\"><span class=\"fa fa-percent\">&nbsp; Discount/Voucher</span>&nbsp;</a>
											                      <a class=\"dropdown-item\" href=\"#\" onclick=\"clientInfoBook('".$current_bid."')\"><span class=\"fa fa-info\"><span>&nbsp; Client Info</a>
											                    </div>
											                  </div>";
				$data[] 									= $nestdata;

			}

		}
		
		$json_data 											= array
															(
			
																"draw"				=> intval(Request::input('draw')),
																"recordsTotal"		=> intval($totalData),
																"recordsFiltered"   => intval($totalFiltered),
																"data"				=> $data

															);
		
		return json_encode($json_data);

    }

     public function get_all_reservation()
    {
    	$columns  = array(
			0 	 => 'tbl_booking.booking_code',
			1 	 => 'tbl_guest_infos.last_name',
			2 	 => 'tbl_booking.booking_status',
			3 	 => 'tbl_room_number_booking.room_number',
			4	 => 'tbl_booking.checkin_date',
			5 	 => 'tbl_booking.checkout_date',
			6 	 => 'tbl_booking.total_amount',
			7 	 => 'tbl_booking.paid_amount',
		);
		
		$totalData 										= Tbl_booking::where('tbl_booking.payment_status','Check In')
														->orWhere('tbl_booking.booking_status','Check In')
														->groupBy('tbl_booking.booking_id')
														->count();
		$limit 											= Request::input('length');
		$start 											= Request::input('start');
		$order 											= $columns[Request::input('order.0.column')];
		$dir 											= Request::input('order.0.dir');
		
		if(empty(Request::input('search.value'))){
		 $allbook_data 								    = Tbl_booking::getalldata($start,$limit,$order,$dir)->get();
		 $totalFiltered 								= Tbl_booking::countalldata($start,$limit,$order,$dir)->get();
		 $totalFiltered 								= count($totalFiltered);
		}
		else
		{
			
			$allbook_data  							    = Tbl_booking::getalldatawithsearch($start,$limit,$order,$dir,
															Request::input('search.value'))->get();
			$totalFiltered 								= Tbl_booking::countalldatawithsearch($start,$limit,$order,$dir,
															Request::input('search.value'))->get();
			$totalFiltered 								= count($totalFiltered);
		}		
					
		
		$data 											= array();
		$allindex 									    = 0;
		$rn_index 										= 0;
		$prev_bc 										= '';
		$prev_room 										= '';
		$prev_slip 										= '';
		$array_room 									= array();
		$array_slip 									= array();
		if($allbook_data){
			$i 											= 0;
			for (; $i < count($allbook_data);) 
			{ 
				unset($array_room);
				unset($array_slip);
				$current_bid 							= Crypt::encryptString($allbook_data[$i]['booking_id']);
				$current_guest 							= $allbook_data[$i]['last_name']. ', '.$allbook_data[$i]['first_name'];
				$prev_bc 								= $allbook_data[$i]['booking_code'];
				$nestdata['booking_code'] 				= $allbook_data[$i]['booking_code'];
				$nestdata['status'] 					= $allbook_data[$i]['booking_status'];
				$nestdata['name'] 						= $allbook_data[$i]['last_name']. ', '.$allbook_data[$i]['first_name'];
				$nestdata['checkin_date'] 				= $this->dateConverter($allbook_data[$i]['checkin_date'],'display');
				$nestdata['checkout_date'] 				= $this->dateConverter($allbook_data[$i]['checkout_date'],'display');
				$nestdata['total_amount'] 				= $this->currencyConverter($allbook_data[$i]['total_amount']);
				$nestdata['paid_amount'] 				= $this->currencyConverter($allbook_data[$i]['paid_amount']);
				$nestdata['balance_amount'] 			= $this->currencyConverter($allbook_data[$i]['total_amount'] - $allbook_data[$i]['paid_amount']);
				
				$array_room = array();
				$array_slip = array();

				for (;$i < count($allbook_data) && $allbook_data[$i]['booking_code'] == $prev_bc;) { 
					
					if( in_array($allbook_data[$i]['room_number'], $array_room)  == false)
					{
						$array_room[] = $allbook_data[$i]['room_number'];
					}
					
					if( in_array('images/'.$allbook_data[$i]['filename'], $array_slip) == false && $allbook_data[$i]['filename'] != null)
					{
						$array_slip[] = 'images/'.$allbook_data[$i]['filename'];
					}
					
					$prev_bc = $allbook_data[$i]['booking_code'];
					$i++;
				}


				$nestdata['room_number']  					= '';
				$nestdata['deposit_slip'] 					= '';
				foreach ($array_room as $room_number) 
				{
					$nestdata['room_number']				= $nestdata['room_number'].$room_number.'<br>';
				}
				foreach ($array_slip as $filename) 
				{
					$nestdata['deposit_slip'] 				= $nestdata['deposit_slip']."<a href=\"#\" 
					onclick=\"imgModal('../".$filename."')\"><img src=\"".$filename."\" height\"50\" width=\"50\"></a>".'<br>';
				}
				
				$nestdata['action'] 						= "<button class=\"btn btn-info\" onclick=\"clientInfoBook('".$current_bid."')\"><span class=\"fa fa-info\"></span> Client Info</button>";
				$data[] 									= $nestdata;

			}

		}
		
		$json_data 											= array
															(
			
																"draw"				=> intval(Request::input('draw')),
																"recordsTotal"		=> intval($totalData),
																"recordsFiltered"   => intval($totalFiltered),
																"data"				=> $data

															);
		
		return json_encode($json_data);

    }

    public function view_payment()
    {
    	$data['info'] 										= Tbl_booking::join('tbl_guest_infos','tbl_booking.guest_id','=',
    															'tbl_guest_infos.guest_id')->where('tbl_booking.booking_id',Crypt::decryptString(Request::input('booking_id')))->get();
    	$data['booking_id']						            = Request::input('booking_id');
    	$view = view('admin.modals.modal_payment_book_view',$data)->render();
    	return response()->json(['html'=>$view]);
    }

    public function payment_submit()
    {
       	$input['booking id'] 								 = Request::input('booking_id');
       	$input['amount'] 			    					 = Request::input('amount');
       	$rules['amount']									 = 'required|numeric|min:1'; 				
       	$rules['booking id']								 = 'required'; 
       	$validate 											 = validator::make($input,$rules);				
        if($validate->fails())
        {
        	return response()->json(['errors'=>$validate->errors()->all(),'message2'=>'','message'=>'']);
        	
        }else
        {
        	$booking_id 									 = Crypt::decryptString(Request::input('booking_id'));
        	
		    $query 											 = Tbl_booking::where('tbl_booking.booking_id',
		    													$booking_id)
		       													 ->update(['paid_amount' => DB::raw('paid_amount + '. Request::input('amount'))
		       												   ]);
		    $tbl_payment 									= new Tbl_payment();
		    $tbl_payment->booking_id 						= $booking_id;
		    $tbl_payment->amount 							= Request::input('amount');
		    $query3  										= $tbl_payment->save();					
		       	if($query && $query3)
		       	{
		       		$query 									= Tbl_booking::join('tbl_guest_infos','tbl_booking.guest_id','=',
       														'tbl_guest_infos.guest_id')
       													  	->where('tbl_booking.booking_id',$booking_id)
       													  	->where('tbl_booking.paid_amount','>=','tbl_booking.req_deposit')
       													  	->where('tbl_booking.booking_status','Pending')
       													  	->get();
		       		if(count($query) > 0)
		       		{
		       			$query2 							= Tbl_booking::where('tbl_booking.booking_id',$booking_id)
		       											    ->update(['tbl_booking.booking_status'=>'Confirmed','tbl_booking.payment_status'=>'Confirmed']);
		       			if($query2)
		       			{
		       		 	return response()->json(['message2'=>"Reservation of ".$query[0]->first_name.' '.$query[0]->last_name.' is now Confirmed.','message' => 'Payment successfully added' ]);
		       			}
		       		}else
		       		{
		       				return response()->json(['message'=>'Payment successfully added','message2'=>'']);
		       		}
		       
		       	}
		    
        }
        
    }

    public function checkin_guest()
    {
    	$booking_id											= Crypt::decryptString(Request::input('booking_id'));
    	$query 											    = Tbl_booking::join('tbl_guest_infos','tbl_guest_infos.guest_id','=',
    														  'tbl_booking.guest_id')
    														 ->where('tbl_booking.booking_status','Confirmed')
    														 ->where('tbl_booking.booking_id',$booking_id)
    														 ->where('tbl_booking.paid_amount','>=','tbl_booking.req_deposit')
    											 			 ->get();
    	if(count($query) > 0)
    	{
    		$query2 										= Tbl_booking::where('tbl_booking.booking_id',
    														  $booking_id)
    														 ->update(['booking_status' => 'Check In']);
    		if($query2)
    		{
    			return response()->json(['errors'=>'','message'=>'Check In Success','message2'=>Request::input('name').' is now check in']);
    		}
    		
    	}
    	else
    	{
    		$return_message                                 = 'The reservation is not yet confirm, kindly settle the 50% of total amount.';

    		return  response()->json(['errors'=>$return_message,'message'=>'','message2'=>'']);
    	} 

    }

    public function checkout_guest()
    {
    	$booking_id											= Crypt::decryptString(Request::input('booking_id'));
    	$query 											    = Tbl_booking::where('tbl_booking.booking_status','Check In')
    														 ->where('tbl_booking.booking_id',$booking_id)
    														 ->where('tbl_booking.paid_amount','>=','tbl_booking.total_amount')
    														 ->get();
    	if(count($query) > 0)
    	{
    		$query2 										= Tbl_booking::where('tbl_booking.booking_id',$booking_id)
    														 ->update(['booking_status' => 'Check Out']);
    		if($query2)
    		{
    			return response()->json(['errors'=>'','message'=>'Check Out Success','message2'=>Request::input('name').' is now check out']);
    		}
    	
    	}
    	else
    	{
    		$return_message                                  = 'The guest still have a balance amount.';

    		return  response()->json(['errors'=>$return_message,'message'=>'','message2'=>'']);
    	} 

    }

    public function view_addcharge()
    {
    	$data['info'] 										= Tbl_booking::join('tbl_guest_infos','tbl_booking.guest_id','=',
    															'tbl_guest_infos.guest_id')->where('tbl_booking.booking_id',Crypt::decryptString(Request::input('booking_id')))->get();
    	$data['addcharge']									= Tbl_add_charges::get();
    	$data['booking_id'] 								= Request::input('booking_id');
    	$view 												= view('admin.modals.modal_add_charge_view',$data)->render();
    	return response()->json(['html'=>$view]);

    }

    public function addcharge_submit()
    {
    	$input['quantity']									= Request::input('quantity');
    	$input['description']   							= Request::input('addcharge');
    	$input['booking id']   								= Crypt::decryptString(Request::input('booking_id'));
    	$rules['quantity'] 									= 'required|min:1|numeric';
    	$rules['description'] 								= 'required|numeric';
    	$rules['booking id'] 								= 'required|numeric';
    	$validate 											= validator::make($input,$rules);
    	if($validate->fails())
    	{
    		return response()->json(['errors'=>$validate->errors()->all(),'message2'=>'','message'=>'']);
    	}else
    	{
    		$tbl_add_charges 								= Tbl_add_charges::where('id',Request::input('addcharge'))->get();
    		if(count($tbl_add_charges) > 0)
    		{
    			$tbl_add_charges_booking 					= new Tbl_add_charges_booking();
    			$tbl_add_charges_booking->description       = $tbl_add_charges[0]->description;
    			$tbl_add_charges_booking->quantity       	= Request::input('quantity');
    			$tbl_add_charges_booking->rate       		= $tbl_add_charges[0]->rate;
    			$tbl_add_charges_booking->amount       		= $tbl_add_charges[0]->rate * Request::input('quantity');
    			$query 									    = $tbl_add_charges_booking->save();
    			if($query)
    			{
    				$query 									= Tbl_booking::where('tbl_booking.booking_id',
    														   $input['booking id'])
    														   ->update([
    														  'tbl_booking.total_amount' => DB::raw('tbl_booking.total_amount +'.($tbl_add_charges[0]->rate * Request::input('quantity')))]);
    				if($query)
    				{
    					return response()->json(['errors'=>'','type'=>'success','message'=>'Additional Charge Successfully Added']);
    				}
    				else
    				{
    					return response()->json(['errors'=>'','type'=>'warning','message'=>'Something is wrong!']);
    				}
    			}
    			else
    			{
    				return response()->json(['errors'=>'','type'=>'warning','message'=>'Something is wrong!']);
    			}
    		}
    		else
    		{
    			return response()->json(['errors'=>'Description does not exist','type'=>'','message'=>'']);
    		}
    	}
    }

    public function view_discount_voucher()
    {
    	$data['info'] 										= Tbl_booking::join('tbl_guest_infos','tbl_booking.guest_id','=',
    														 'tbl_booking.guest_id')
    														->where('tbl_booking.booking_id',Crypt::decryptString(Request::input('booking_id')))
    														->get();
    	$data['discountVoucher'] 							= Tbl_discount_voucher::get();
    	$data['booking_id']									= Request::input('booking_id');
    	$view 												= view('admin.modals.modal_discount_voucher_view',$data)->render();
    	return response()->json(['html'=> $view]);
    }

    public function discountvoucher_submit()
    {
    	$input['booking id'] 							  	= Crypt::decryptString(Request::input('booking_id'));
    	$input['description'] 								= Request::input('discountvoucher');
    	$rules['booking id'] 								= 'required|numeric';
    	$rules['description'] 								= 'required|numeric';
    	$validate 											= Validator::make($input,$rules);
    	if($validate->fails())
    	{
    		return response()->json(['errors'=>$validate->errors()->all(),'message'=>'','type'=>'']);
    	}
    	else
    	{
    		$query 											= Tbl_discount_voucher_booking::where('booking_id',												$input['booking id'])
    														->get();
    		if(count($query) <= 0)
    		{
    			$query 										= Tbl_discount_voucher::where('id',
    														$input['description'])
    														->get();
    			$bookingquery 								= Tbl_booking::where('booking_id',
    														$input['booking id'])
    														->get();
    			if(count($query) > 0)
    			{
    				$tbl_discount_voucher_booking 			   = new Tbl_discount_voucher_booking();
    				$tbl_discount_voucher_booking->booking_id  = $input['booking id'];
    				$tbl_discount_voucher_booking->percentage  = $query[0]->percentage;
    				$tbl_discount_voucher_booking->description = $query[0]->description;
    				$discount_amount 						   = $bookingquery[0]->total_amount 
    															 * ($query[0]->percentage / 100);
    				$tbl_discount_voucher_booking->amount 	   = $discount_amount;

    				$result 								   = $tbl_discount_voucher_booking->save();
    				if($result)
    				{
    					$result 							   = Tbl_booking::where('booking_id',
    															$input['booking id'])
    															->update(['total_amount'=> DB::raw('total_amount - '.$discount_amount),
    																'discount_amount' => $discount_amount
    														]);
    					if($result)
    					{
    						return response()->json(['errors'=>'','type'=>'success','message'=>'Discount/Voucher Success!']);
    					}
    					else
    					{
    						return response()->json(['errors'=>'','type'=>'warning','message'=>'Something is wrong!']);
    					}
    				}
    				else
    				{
    					return response()->json(['errors'=>'','type'=>'warning','message'=>'Something is wrong!']);
    				} 	

    			}
    			else
    			{
    				return response()->json(['errors'=>'','message'=>'Discount/Voucher Description does not exist.','type'=>'warning']);
    			}
    		}
    		else
    		{
    			return response()->json(['errors'=>'','message'=>'The clients is already discounted.','type'=>'warning']);
    		}
    	}
    }

    public function view_client_info()
    {
    	$booking_id 									= Crypt::decryptString(Request::input('booking_id'));
    	$data['personalInfo'] 							= Tbl_booking::join('Tbl_guest_infos','tbl_booking.guest_id','='
    													,'tbl_booking.guest_id')
    													->where('booking_id',
    													  $booking_id)
    													  ->get();
    	$data['bookingDetails']                         = Tbl_booking::join('tbl_room_number_booking',
    													'tbl_room_number_booking.booking_id','=',
    													'tbl_booking.booking_id')
    													->where('tbl_booking.booking_id',$booking_id)
    													->get();
    	$data['bookingDetails'][0]->checkin_date 		= $this->dateConverter($data['bookingDetails'][0]->checkin_date,'display');
    	$data['bookingDetails'][0]->checkout_date 		= $this->dateConverter($data['bookingDetails'][0]->checkout_date,'display');
    	$data['bookingDetails'][0]->booking_date 		= $this->dateConverter($data['bookingDetails'][0]->booking_date,'display datetime');
    	$data['bookingDetails'][0]->balance_amount 		= $this->currencyConverter(($data['bookingDetails'][0]->total_amount - 
    														$data['bookingDetails'][0]->paid_amount));
    	$data['bookingDetails'][0]->total_amount 		= $this->currencyConverter($data['bookingDetails'][0]->total_amount);
    	$data['bookingDetails'][0]->paid_amount 		= $this->currencyConverter($data['bookingDetails'][0]->paid_amount);
    	$data['paymentDetails'] 						= Tbl_payment::where('booking_id'
    													  ,$booking_id)->get();
    	$data['discountDetails'] 						= Tbl_discount_voucher_booking::where('booking_id'
    													 ,$booking_id)->get();
    	$data['depositSlip']							= Tbl_bank_deposit_slip::where('booking_id',$booking_id)->get();
    	$view 											= view('admin.modals.modal_client_info_view',$data)
    													  ->render();
    	return response()->json(['html'=>$view]);	

    }

    public function booking_panel_counter()
    {
    	$pending 										= Tbl_booking::where('booking_status','Pending')->get();
    	$confirm 										= Tbl_booking::where('booking_status','Confirmed')->get();
    	$checkin 										= Tbl_booking::where('booking_status','Check In')->get();
    	$all 										    = Tbl_booking::get();
    	return response()->json(['pending'=>count($pending),'confirm'=>count($confirm),'checkin'=>count($checkin),'all'=>count($all)]);
    }

    public function edit_payment()
    {
    	$input['booking id'] 							= Crypt::decryptString(Request::input('booking_id'));
    	$input['payment id'] 							= Crypt::decryptString(Request::input('id'));
    	$input['amount'] 								= Request::input('amount');
    	$rules['booking id'] 							= 'required|numeric';
    	$rules['payment id'] 							= 'required|numeric';
    	$rules['amount'] 								= 'required|numeric|min:0';
    	$validate 										= Validator($input,$rules);
    	if($validate->fails())
    	{
    		return response()->json(['errors'=>$validate->errors()->all(),'message'=>'','type'=>'']);
    	}
    	else
    	{
    		$payment 									= Tbl_payment::where('tbl_payment.id',$input['payment id'])
    													  ->where('tbl_payment.booking_id',$input['booking id'])->get();
    		$query 										= Tbl_booking::where('tbl_booking.booking_id',$input['booking id'])
    													  ->update(['paid_amount'=>DB::raw('paid_amount - '.$payment[0]->amount)]);
    		if($query)
    		{
				$query 									= Tbl_booking::where('tbl_booking.booking_id',$input['booking id'])
    													  ->update(['paid_amount'=>DB::raw('paid_amount + '.$input['amount'])]);
    			if($query)
    			{
					$query 								= Tbl_payment::where('tbl_payment.booking_id',$input['booking id'])
    													->where('tbl_payment.id',$input['payment id'])
    													->update(['amount'=>$input['amount']]);
    				if($query)
    				{
    					return response()->json(['errors'=>'','message'=>'Payment Updated Successfully','type'=>'success']);
    				}
    			}
    		}
    		
    	}
    }
}
