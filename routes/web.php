<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Client Side Routes
Route::any('/', "ClientSideController@index");
Route::any('/roomavailable', "ClientSideController@roomavailable");
Route::any('/form', "ClientSideController@form");
Route::any('/get_extra_mattress', "ClientSideController@get_extra_mattress");
Route::any('/insertandemail', "ClientSideController@insertandemail");
Route::any('/reserved', "ClientSideController@reserved");
Route::any('/confirmreservation/{bookingcode}', "ClientSideController@confirmreservation");
Route::any('/reservationreceipt/{bookingcode}', "ClientSideController@receipt");
Route::any('/guest_login', "ClientSideController@guest_login_index");
Route::any('/login_attempt', "ClientSideController@login_attempt");
Route::any('/guest_dashboard', "ClientSideController@guest_dashboard");
Route::any('/deposit_slip', "ClientSideController@deposit_slip");
Route::any('/upload_deposit_slip', "ClientSideController@upload_deposit_slip");
Route::any('/delete_image', "ClientSideController@delete_image");
Route::any('/cancel_reservation', "ClientSideController@cancel_reservation");
Route::any('/modify_available_rooms', "ClientSideController@modify_available_rooms");
Route::any('/modify_submission', "ClientSideController@modify_submission");
Route::any('/modify_updatebooking', "ClientSideController@modify_updatebooking");
Route::any('/cx_logout', "ClientSideController@cx_logout");



// Admin Side Routes
Route::any('/resort_admin_login','AdminSideController@login_index');
Route::any('/admin_login_attempt','AdminSideController@admin_login_attempt');
Route::any('/admin_dashboard','AdminSideController@admin_dashboard');
Route::any('/get_pending_reservation','AdminSideController@get_pending_reservation');
Route::any('/get_confirm_reservation','AdminSideController@get_confirm_reservation');
Route::any('/get_checkin_reservation','AdminSideController@get_checkin_reservation');
Route::any('/get_all_reservation','AdminSideController@get_all_reservation');
Route::any('/view_payment','AdminSideController@view_payment');
Route::any('/payment_submit','AdminSideController@payment_submit');
Route::any('/checkin_guest','AdminSideController@checkin_guest');
Route::any('/checkout_guest','AdminSideController@checkout_guest');
Route::any('/view_addcharge','AdminSideController@view_addcharge');
Route::any('/addcharge_submit','AdminSideController@addcharge_submit');
Route::any('/view_discount_voucher','AdminSideController@view_discount_voucher');
Route::any('/discountvoucher_submit','AdminSideController@discountvoucher_submit');
Route::any('/view_client_info','AdminSideController@view_client_info');
Route::any('/booking_panel_counter','AdminSideController@booking_panel_counter');
Route::any('/edit_payment','AdminSideController@edit_payment');

