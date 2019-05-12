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
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailConfirmation;
use App\Mail\SendEmailModifySuccess;
use Crypt;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ClientSideController extends Controller
{
    private $bank_deposit_photos_path;
 
    public function __construct()
    {
        $this->bank_deposit_photos_path = public_path('/images');
    }
 
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
        else
        {
            return 'UNKNOWN';
        }

        return $result;
    }

    public static function getresortdetails()
    {
        $data['_resort_email']                             = Tbl_email::get();
        $data['_resort_tax']                               = Tbl_tax::get();
        $data['_resort_contact_numbers']                   = Tbl_contact_number::get();
        $data['resort_email']                              = Tbl_email::get();
        $data['resort_contact_number']                     = Tbl_contact_number::get();
        Session::put('resort_email', $data['resort_email']);
        Session::put('resort_contact_number', $data['resort_contact_number']);
         return $data;
    }
    
    public function index()
    {
    	$datenow 		    		              = Carbon::now();
    	$data['dateNexttomorrow']                 = $datenow->addDay(2)->format('m/d/Y');
    	$data['datetomorrow']    	              = $datenow->subDay(1)->format('m/d/Y');
        $data['resort_email']                     = Tbl_email::get();
        $data['resort_contact_number']            = Tbl_contact_number::get();
        $data['_roomdata']                        = Tbl_room::get();
        Session::put('resort_email', $data['resort_email']);
        Session::put('resort_contact_number', $data['resort_contact_number']);
    	return view('home',$data);
    }

    public function roomavailable()
    {
    	
        Request::validate([
            'checkin'  => 'date|required',
            'checkout' => 'date|required',
            'guest'    => 'numeric|required|max:100',
        ]);
       $date1 = new \DateTime(Request::input('checkin'));
       $date2 = new \DateTime(Request::input('checkout'));
       $now   = new \DateTime();
       if($date1 > $now && $date2 > $date1)
       {
            $data                                  = $this->getresortdetails();
            $data['checkindateDisplay']            = $this->dateConverter(Request::input('checkin'),'display');
            $data['checkoutdateDisplay']           = $this->dateConverter(Request::input('checkout'),'display');
            $data['dateDiff']                      = $this->dateConverter($data['checkindateDisplay'],'diff',$data['checkoutdateDisplay']);
            $data['checkindateDb']                 = $this->dateConverter(Request::input('checkin'),'db');
            $data['checkoutdateDb']                = $this->dateConverter(Request::input('checkout'),'db');
            $data['_roomavailable']                = Tbl_room::getavailableroom($data['checkindateDb'],$data['checkoutdateDb'])->get();
            $data['guest']                         = Request::input('guest');
            $data['counter']                       = 0;
            Session::put('reservation_data',$data);
         
        return view('roomavailable',$data);
       }else
       {
        return redirect('/');
       }
           
    }

    public function get_extra_mattress()
    {
        $room_id                                    = Request::input('rid');
        $qnt                                        = Request::input('qnt');
        $result                                     = Tbl_room::getextramattress($room_id,$qnt)->get();
       foreach ($result as  $value) {
           $data['tcp']                             = $value['tcp'];
           $data['cp']                              = $value['cp'];
       }
        return json_encode($data);
    }

    public function form()
    {
        $data                                       = $this->getresortdetails();
        $session                                    = Request::session()->get('reservation_data') ; 
        $_roomdata                                  = Tbl_room::get();
        $post                                       = Request::input();
        if(!isset($post['lastcntr']))
        {
            return redirect('/');
        }else
        {
            
            $index = 0;
            $data['total_amount'] = $post['ep'] * 450;
            foreach ($_roomdata as $roomdata) {
                if(isset($post['selectroom'.$roomdata['room_id']]) && !empty($post['selectroom'.$roomdata['room_id']]))
                {
                    $index++;
                    $data['room_id'][$index]        = $roomdata['room_id'];           
                    $data['room_name'][$index]      = $roomdata['room_name'];           
                    $data['room_qnt'][$index]       = $post['selectroom'.$roomdata['room_id']];           
                    $data['int_rate'][$index]       = $roomdata['rate'];           
                    $data['tot_rate'][$index]       = $roomdata['rate'] * $post['selectroom'.$roomdata['room_id']] * $session['dateDiff'];           
                    $data['total_amount']           += $roomdata['rate'] * $post['selectroom'.$roomdata['room_id']] * $session['dateDiff'];
                    $data['downpayment']            = $data['total_amount'] * .50;
                    $data['extra_person']           = $post['ep'];
                    $data['index']                  = $index;
                    Session::put('room_data',$data);
                }
            }
            $data['tax']                            = Tbl_tax::get();
            Session::put('resort_tax',$data['tax']);
            $data['_reservation_data']              = $session;
            return view('form',$data);
            //dd(Request::session()->get('resort_email')[0]['email']);
        }
    }

    public function insertandemail()
    {
        
       $formdata['first name']                      = Request::input('firstname');
       $formdata['last name']                       = Request::input('lastname');
       $formdata['email']                           = Request::input('email');
       $formdata['contact number']                  = Request::input('contactnumber');
       $formdata['address']                         = Request::input('address');
       $rules['first name']                         = 'required|min:2|regex:/^[\pL\s\-]+$/u';
       $rules['last name']                          = 'required|min:2|regex:/^[\pL\s\-]+$/u';
       $rules['email']                              = 'required|email';
       $rules['contact number']                     = 'required|digits_between:7,12|numeric';
       $rules['address']                            = 'required|min:12';
       $validate = validator::make($formdata, $rules);
       $return_message = array();
       if($validate->fails())
       {
            foreach ($validate->messages()->all() as $key => $message) {
                $return_message[] = $message;
                
            }
            return $return_message;
       }else
       {    $index = 1;
            $checker = 0;
           foreach (Session::get('room_data')['room_id'] as $key => $room_id)
           {
               $checkin                             = Session::get('reservation_data')['checkindateDb'];
               $checkout                            = Session::get('reservation_data')['checkoutdateDb'];
               $roomid                              = Session::get('room_data')['room_id'][$index];
               $roomqnt                             = Session::get('room_data')['room_qnt'][$index];
               $checker                             = $this->check_n_get_et_if_room_still_available('check',$checkin,$checkout,$roomid,$roomqnt);
               $index++;
           }    
           if($checker != 0)
           {
                $return_message[]                   = 'availability';
           }
           if($checker == 0)
           {
                $source = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 
        'B', 'C', 'D', 'E', 'F');
                $insertguestinfo['first_name']      = ucwords(Request::input('firstname'));
                $insertguestinfo['last_name']       = ucwords(Request::input('lastname'));
                $insertguestinfo['contact_number']  = Request::input('contactnumber');
                $insertguestinfo['email']           = Request::input('email');
                $insertguestinfo['address']         = Request::input('address');
                $insertguestinfo['username']        = '';
                $password                           = '';
                for($i = 1; $i <= 8; $i++) 
                {
                    $index = rand(0, 15);
                    $insertguestinfo['username'] = $insertguestinfo['username'] . $source[$index];
                }

                for($i = 1; $i <= 8; $i++) 
                {
                    $index = rand(0, 15);
                    $password = $password . $source[$index];
                }
                date_default_timezone_set('Asia/Manila');
                $insertguestinfo['password']             = Crypt::encryptString($password);
                $insertbooking['guest_id']               = Tbl_guest_infos::insertGetId($insertguestinfo);
                $insertbooking['checkin_date']           = Session::get('reservation_data')['checkindateDb'];
                $insertbooking['checkout_date']          = Session::get('reservation_data')['checkoutdateDb'];
                $insertbooking['booking_date']           = date('Y-m-d H:i:s');
                $insertbooking['total_amount']           = Session::get('room_data')['total_amount'];
                $insertbooking['req_deposit']            = Session::get('room_data')['downpayment'];
                $insertbooking['extra_mattress']         = Session::get('room_data')['extra_person'];
                $insertbooking['extra_mattress_amount']  = Session::get('room_data')['extra_person'] * 450;
                $insertbooking['booking_code']           = 'SBBR-'.date('mdy').rand(1000,9999);
                $insertbooking['no_of_guest']            = Session::get('reservation_data')['guest'];
                $booking_id                              = Tbl_booking::insertGetId($insertbooking);

                $index = 1;
                $insertrnb = new Tbl_room_number_booking;
                $room_number = array();  
                foreach (Session::get('room_data')['room_id'] as $key => $room_id)
               {
                   $checkin                             = Session::get('reservation_data')['checkindateDb'];
                   $checkout                            = Session::get('reservation_data')['checkoutdateDb'];
                   $roomid                              = Session::get('room_data')['room_id'][$index];
                   $roomqnt                             = Session::get('room_data')['room_qnt'][$index];
                   $room_number[]                       = Tbl_room_number::getroomnumber($checkin,$checkout,$roomid,$roomqnt)->get();
                   $index++;
               }

               $index = 0;   
                while (count(Session::get('room_data')['room_id']) > $index) 
                {
                    $index2 = 0;
                    while (count($room_number[$index]) > $index2) {
                        $tbl_room_number                      = Tbl_room_number::select('tbl_room_number.room_id')
                                                            ->where('tbl_room_number.room_number',$room_number[$index][$index2]->room_number)->get();
                        Tbl_room_number_booking::insert([
                            'room_number' => $room_number[$index][$index2]->room_number,
                            'booking_id' => $booking_id,
                            'room_id' => $tbl_room_number[0]->room_id,
                        ]);
                        $index2++;
                    }
                 
                    $index++;
                }
               $emailconfirmationdata = array(
                'firstname'           => ucwords(Request::input('firstname')) , 
                'lastname'            => ucwords(Request::input('lastname')) , 
                'email'               => Request::input('email'), 
                'username'            => $insertguestinfo['username'], 
                'password'            => $password,
                'bookingcode'         => Crypt::encryptString($insertbooking['booking_code']), 
                'link'                => 'http://localhost:1111/confirmreservation/'.Crypt::encryptString($insertbooking['booking_code']),
                'reservationreceipt'  =>  'http://localhost:1111/reservationreceipt/'.Crypt::encryptString($insertbooking['booking_code'])
                );
               
               Mail::to(Request::input('email'))->send(new SendEmailConfirmation($emailconfirmationdata));
               
                    $return_message = 'success';
               
           }
           
       }
       return $return_message;
      
    }

    public function check_n_get_et_if_room_still_available($type,$checkin,$checkout,$roomid,$roomqnt)
    {
        if($type == 'check')
        {
            $checker                                = 0;
            $result['result']                       = Tbl_room_number::getroomnumber($checkin,$checkout,$roomid,$roomqnt)->get();
            if($roomqnt > count($result['result']))
            {
                $checker++;
            }
            return $checker;
        }
       
    }

    public function reserved()
    {
        $data                                  = $this->getresortdetails();
        return view('reserved',$data);
    }

    public function confirmreservation($bookingcode)
    {
        $bookingcode                                = Crypt::decryptString($bookingcode);
       
        $result                                     = Tbl_booking::where('tbl_booking.booking_code',$bookingcode)->update([
            'confirmation_status'   => 'Confirmed'
        ]);

        if($result == 0)
        {
            $data['return_message']                         = 'error';
        }
        else if($result > 0)
        {
            $data['return_message']                         = 'success';
        }
        $data                                               = $this->getresortdetails();
        $data['confirmpage']                                = 'yes';
    
        return view('confirmed',$data);

    }

    public function receipt($bookingcode)
    {
        $bookingcode                                       = Crypt::decryptString($bookingcode); 
        $data['_resort_email']                             = Tbl_email::get();
        $data['_resort_tax']                               = Tbl_tax::get();
        $data['_resort_contact_numbers']                   = Tbl_contact_number::get();
        $data['_bookingdetails']                           = Tbl_room::getbookingdetailsofguest($bookingcode)->get();
        $data['_bookingdetails'][0]['checkin_date']        = $this->dateConverter($data['_bookingdetails'][0]['checkin_date'],'display');
        $data['_bookingdetails'][0]['checkout_date']       = $this->dateConverter($data['_bookingdetails'][0]['checkout_date'],'display');
        $data['_bookingdetails'][0]['total_nights']        = $this->dateConverter($data['_bookingdetails'][0]['checkin_date'],'diff',$data['_bookingdetails'][0]['checkout_date']);

       return view('reservationreceipt',$data);
    }

    public function guest_login_index()
    {
        $data                                               = $this->getresortdetails(); 
        $data['loginpage']                                  = 'yes';
       return view('guest_login',$data);
    }



    public function login_attempt()
    {
        
        $validatedData = Request::validate([
        'username' => 'required',
        'password' => 'required',
        ]);

         $checkusername                                  = Tbl_guest_infos::where('tbl_guest_infos.username',
                                                                Request::input('username'))->get();
        if(count($checkusername) > 0)
        {
            $password                                     = Tbl_guest_infos::where('tbl_guest_infos.username',
                                                            Request::input('username'))
                                                            ->get();
            $password                                     = Crypt::decryptString($password[0]['password']);

            if(Request::input('password') == $password)
            {
                $bookingid                              = Tbl_booking::select('tbl_booking.booking_id')
                                                        ->join('tbl_guest_infos','tbl_booking.guest_id','=','tbl_guest_infos.guest_id')
                                                        ->where('tbl_guest_infos.username',Request::input('username'))
                                                        ->get();
                Session::put('cx_username',Request::input('username'));
                Session::put('cx_password',$password);
                Session::put('cx_booking_id',$bookingid[0]['booking_id']);
                
                return redirect('guest_dashboard');
               
            }
            else
            {
                $return_values['failed_message']        = 'Wrong password';
                $return_values['retain_value']          = Request::input('username');
                return redirect('guest_login')->with('return_values', $return_values);

            }
        }
        else
        {
            $return_values['failed_message']        = 'Wrong password';
            return redirect('guest_login')->with('return_values', $return_values);
        }
    }

    public function guest_dashboard()
    {
        
       if(Session::get('cx_username') == null && Session::get('cx_password') == null )
       {
            Session::flush();
            return redirect('/guest_login');
       }
        
        $bookingcode                                 = Tbl_booking::select('tbl_booking.booking_code')
                                                        ->join('tbl_guest_infos','tbl_booking.guest_id','=','tbl_guest_infos.guest_id')
                                                        ->where('tbl_guest_infos.username',Session::get('cx_username'))
                                                        ->get();
        $data                                        = $this->getresortdetails();
        $data['_bookingdetails']                     = Tbl_room::getbookingdetailsofguest($bookingcode[0]['booking_code'])
                                                        ->get();
        $data['_bookingdetails'][0]['checkin_date']  = $this->dateConverter($data['_bookingdetails'][0]['checkin_date'],'display');
        $data['_bookingdetails'][0]['checkout_date'] = $this->dateConverter($data['_bookingdetails'][0]['checkout_date'],'display');
        $data['room_numbers']                        = Tbl_room_number_booking::getroomnumbers($bookingcode[0]['booking_code'])->get();
        $data['_bank_deposits']                      = Tbl_bank_deposit_slip::where('tbl_bank_deposit_slip.booking_id',Session::get('cx_booking_id'))->get();
        $datenow                                     = Carbon::now();
        $data['dateNexttomorrow']                    = $datenow->addDay(2)->format('m/d/Y');
        $data['datetomorrow']                        = $datenow->subDay(1)->format('m/d/Y');
         return view('cx.cx_dashboard',$data);
    }

    public function upload_deposit_slip()
    {
       

         $photos = Request::file('file');

            if (!is_array($photos)) {
                $photos = [$photos];
            }
     
            if (!is_dir($this->bank_deposit_photos_path)) {
                mkdir($this->bank_deposit_photos_path, 0777);
            }
     
            for ($i = 0; $i < count($photos); $i++) 
            {
                 $filecount                            = Tbl_bank_deposit_slip::where('tbl_bank_deposit_slip.booking_id',Session::get('cx_booking_id'))->get();
        
                    if((count($filecount)+count($photos)) >= 3)
                    {
                        return Response::json(['message' => "You are only allowed to upload 3 images"], 200);
                    }else
                    {
                        $photo = $photos[$i];
                        $name = sha1(date('YmdHis') . str_random(30));
                        $save_name = $name . '.' . $photo->getClientOriginalExtension();
                        $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();
             
                        Image::make($photo)
                            ->resize(250, null, function ($constraints) {
                                $constraints->aspectRatio();
                            })
                            ->save($this->bank_deposit_photos_path . '/' . $resize_name);
             
                        $photo->move($this->bank_deposit_photos_path, $save_name);
             
                        $tbl_bank_deposit_slip                  = new Tbl_bank_deposit_slip();
                        $tbl_bank_deposit_slip->filename        = $save_name;
                        $tbl_bank_deposit_slip->resized_name    = $resize_name;
                        $tbl_bank_deposit_slip->original_name   = basename($photo->getClientOriginalName());
                        $tbl_bank_deposit_slip->booking_id      = Session::get('cx_booking_id');
                        $tbl_bank_deposit_slip->save();
                         return Response::json(['message' => 'Image Saved Successfully'], 200);
                    }
            }
           
        
       
    }


    public function delete_image()
    {
        $id = Request::input('id');
        $uploaded_image = Tbl_bank_deposit_slip::where('id', $id)->where('booking_id',Session::get('cx_booking_id'))->first();
 
        if (empty($uploaded_image)) {
           
        }else
        {
            $file_path = $this->bank_deposit_photos_path . '/' . $uploaded_image->filename;
            $resized_file = $this->bank_deposit_photos_path . '/' . $uploaded_image->resized_name;
     
            if (file_exists($file_path)) {
                unlink($file_path);
            }
     
            if (file_exists($resized_file)) {
                unlink($resized_file);
            }
     
            if (!empty($uploaded_image)) {
                $uploaded_image->delete();
            }
     
            return Response::json(['message' => 'Image Deleted Successfully'], 200);
        }
 
       
    }

    public function cancel_reservation()
    {

        $result                             = Tbl_booking::where('tbl_booking.booking_id',Session::get('cx_booking_id'))->update([
                                                'tbl_booking.cancel_date'    => Carbon::now(),
                                                'Tbl_booking.booking_status' => 'Cancelled',]);
        if($result)
        {
            return Response::json(['message' => 'success'], 200);
        }
    }

    public function modify_available_rooms()
    {
         Request::validate([
            'newCheckIn'  => 'date|required',
            'newCheckOut' => 'date|required',
            'newGuest'    => 'numeric|required|max:100',
        ]);
       $date1 = new \DateTime(Request::input('newCheckIn'));
       $date2 = new \DateTime(Request::input('newCheckOut'));
       $now   = new \DateTime();
       if($date1 > $now && $date2 > $date1)
       {
            $data                                       = $this->getresortdetails();
            $data['newCheckIndateDisplay']              = $this->dateConverter(Request::input('newCheckIn'),'display');
            $data['newCheckOutdateDisplay']             = $this->dateConverter(Request::input('newCheckOut'),'display');
            $data['dateDiff']                           = $this->dateConverter($data['newCheckIndateDisplay'],'diff',$data['newCheckOutdateDisplay']);
            $data['newCheckIndateDb']                   = $this->dateConverter(Request::input('newCheckIn'),'db');
            $data['newCheckOutdateDb']                  = $this->dateConverter(Request::input('newCheckOut'),'db');
            $data['_roomavailable']                     = Tbl_room::getmodifyavailableroom($data['newCheckIndateDb'],$data['newCheckOutdateDb'],Session::get('cx_booking_id'))->get();
            $data['newGuest']                           = Request::input('newGuest');
            $data['counter']                            = 0;
            Session::put('modify_reservation_data',$data);
        return view('cx.modify_roomavailable',$data);
       }else
       {
        return redirect('/guest_dashboard');
       }
    }

    public function modify_submission()
    {
        $data                                       = $this->getresortdetails();
        $session                                    = Session::get('modify_reservation_data') ; 
        $_roomdata                                  = Tbl_room::get();
        $post                                       = Request::input();
        if(!isset($post['lastcntr']))
        {
            return redirect('/');
        }else
        {
            
            $index = 0;
            $data['total_amount'] = $post['ep'] * 450;
            foreach ($_roomdata as $roomdata) {
                if(isset($post['selectroom'.$roomdata['room_id']]) && !empty($post['selectroom'.$roomdata['room_id']]))
                {
                    $index++;
                    $data['room_id'][$index]        = $roomdata['room_id'];           
                    $data['room_name'][$index]      = $roomdata['room_name'];           
                    $data['room_qnt'][$index]       = $post['selectroom'.$roomdata['room_id']];           
                    $data['int_rate'][$index]       = $roomdata['rate'];           
                    $data['tot_rate'][$index]       = $roomdata['rate'] * $post['selectroom'.$roomdata['room_id']] * $session['dateDiff'];           
                    $data['total_amount']           += $roomdata['rate'] * $post['selectroom'.$roomdata['room_id']] * $session['dateDiff'];
                    $data['downpayment']            = $data['total_amount'] * .50;
                    $data['extra_person']           = $post['ep'];
                    $data['index']                  = $index;
                    Session::put('modify_room_data',$data);
                }
            }
            $data['tax']                            = Tbl_tax::get();
            Session::put('resort_tax',$data['tax']);
            $data['_reservation_data']              = $session;

            return view('cx.modify_submission',$data);
            
        }
    }
   
    public function modify_updatebooking()
    {
       
       $return_message = array();
       if((Session::get('modify_room_data') == null || Session::get('modify_room_data') == '') && (Session::get('modify_reservation_data') == null || Session::get('modify_reservation_data') == '') )
       {
                $return_message[] = 'Something Wrong';
                
            
            return $return_message;
       }else
       {    $index = 1;
            $checker = 0;
           foreach (Session::get('modify_room_data')['room_id'] as $key => $room_id)
           {
               $checkin                             = Session::get('modify_reservation_data')['newCheckIndateDb'];
               $checkout                            = Session::get('modify_reservation_data')['newCheckOutdateDb'];
               $roomid                              = Session::get('modify_room_data')['room_id'][$index];
               $roomqnt                             = Session::get('modify_room_data')['room_qnt'][$index];
               $checker                             = $this->check_n_get_et_if_room_still_available('check',$checkin,$checkout,$roomid,$roomqnt);
               $index++;
           }    
           if($checker != 0)
           {
                $return_message[]                   = 'availability';
           }
           if($checker == 0)
           {
                                      
                date_default_timezone_set('Asia/Manila');
                Tbl_booking::where('tbl_booking.booking_id',Session::get('cx_booking_id'))->update([
                    'checkin_date'                  => Session::get('modify_reservation_data')['newCheckIndateDb'],
                    'checkout_date'                 => Session::get('modify_reservation_data')['newCheckOutdateDb'],
                    'prev_checkin'                  => DB::raw('tbl_booking.checkin_date'),
                    'prev_checkout'                 => DB::raw('tbl_booking.checkout_date'),
                    'total_amount'                  =>  Session::get('modify_room_data')['total_amount'],
                    'req_deposit'                   =>  Session::get('modify_room_data')['downpayment'],
                    'extra_mattress'                =>  Session::get('modify_room_data')['extra_person'],
                    'extra_mattress_amount'         =>  Session::get('modify_room_data')['extra_person'] * 450,
                    'no_of_guest'                   =>  Session::get('modify_reservation_data')['newGuest'],
                ]);
              
                Tbl_room_number_booking::where('tbl_room_number_booking.booking_id',Session::get('cx_booking_id'))->delete();
                $index = 1;
                $insertrnb = new Tbl_room_number_booking;
                $room_number = array();  
                foreach (Session::get('modify_room_data')['room_id'] as $key => $room_id)
               {
                   $checkin                             = Session::get('modify_reservation_data')['newCheckIndateDb'];
                   $checkout                            = Session::get('modify_reservation_data')['newCheckOutdateDb'];
                   $roomid                              = Session::get('modify_room_data')['room_id'][$index];
                   $roomqnt                             = Session::get('modify_room_data')['room_qnt'][$index];
                   $room_number[]                       = Tbl_room_number::getroomnumber($checkin,$checkout,$roomid,$roomqnt)->get();
                   $index++;
               }

               $index = 0;   
                while (count(Session::get('modify_room_data')['room_id']) > $index) 
                {
                    $index2 = 0;
                    while (count($room_number[$index]) > $index2) {
                        $tbl_room_number                      = Tbl_room_number::select('tbl_room_number.room_id')
                                                            ->where('tbl_room_number.room_number',$room_number[$index][$index2]->room_number)->get();
                        Tbl_room_number_booking::insert([
                            'room_number' => $room_number[$index][$index2]->room_number,
                            'booking_id' => Session::get('cx_booking_id'),
                            'room_id' => $tbl_room_number[0]->room_id,
                        ]);
                        $index2++;
                    }
                 
                    $index++;
                }
                $resortdetails        = $this->getresortdetails();
                $guest_infos          = Tbl_guest_infos::join('tbl_booking','tbl_booking.guest_id','=','tbl_guest_infos.guest_id')->where('tbl_guest_infos.username',Session::get('cx_username'))->get();
               $emailmodifysuccessdata = array(
                'firstname'           => ucwords($guest_infos[0]['first_name']) , 
                'lastname'            => ucwords($guest_infos[0]['last_name']) , 
                'email'               => $guest_infos[0]['email'],
                'bookingcode'         => $guest_infos[0]['booking_code'], 
                'reservationreceipt'  =>  'http://localhost:1111/reservationreceipt/'.Crypt::encryptString($guest_infos[0]['booking_code'])
                );
               
               Mail::to($guest_infos[0]['email'])->send(new SendEmailModifySuccess($emailmodifysuccessdata));
               
                    $return_message = 'success';
               
           }
           
       }
       return $return_message;
      
    }
    
    public function cx_logout()
    {
        Session::flush();
        return redirect('/');
    }

}


