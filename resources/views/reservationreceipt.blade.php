<!DOCTYPE html>
<html>
<head>
	<title>Reservation Receipt</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;width: 100%;}
.tg td{font-family:Arial, sans-serif;font-size:20px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:20px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-rvo4{font-weight:bold;background-color:#000000;border-color:#ffffff;text-align:center;vertical-align:top}
.tg .tg-oczp{border-color:#ffffff;text-align:left;vertical-align:top;font-size: 20px;}
</style>
</head>
<body>



<center>
	<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1>Sigayan Bay Beach Resort</h1>
				</div>
			</div>
			<div class="row justify-content-center">
				<h4>Brgy. Laiya-Aplaya , Batangas, San Juan, 4226 Batangas</h4>
			</div>
			<div class="row justify-content-center">
				<strong>
				@php
		          $x = 1;
		          $limit = count($_resort_contact_numbers);
		          @endphp

		          @foreach($_resort_contact_numbers as $contact_number) {{$contact_number->contact_number}} &nbsp; 
		              @if($x < $limit) 
		              | &nbsp;
		                @php $x++ @endphp
		              @endif
		          @endforeach
		         </strong>
			</div>
			<div class="row justify-content-center">
				<strong>
					@foreach($_resort_email as $resort_email)
						{{$resort_email->email}}
					@endforeach
				</strong>
			</div>

	</div>
	<h2 style="margin-top: 5%;">Reservation Receipt</h2>
<table class="tg" style="margin-top: 5%">
  <tr>
    <td class="tg-oczp">Booking Code: {{$_bookingdetails[0]->booking_code}}</td>
     <td class="tg-oczp">Check in: {{$_bookingdetails[0]->checkin_date}}</td>
  </tr>
  <tr>
  	<td class="tg-oczp">Name: {{$_bookingdetails[0]->last_name.', '.$_bookingdetails[0]->first_name}}</td>
  	<td class="tg-oczp">Check out: {{$_bookingdetails[0]->checkout_date}}</td>
  </tr>
  <tr>
  	 <td class="tg-oczp">Guest(s): {{$_bookingdetails[0]->no_of_guest}}</td>
  	 <td class="tg-oczp">Night(s): {{$_bookingdetails[0]->total_nights}}</td>
  </tr>
</table>



	<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-ai0l{font-weight:bold;font-size:12px;text-align:center;vertical-align:top;font-size: 20px;}
.tg .tg-ir4y{font-weight:bold;font-size:12px;text-align:center;vertical-align:top}
.tg .tg-rg0h{font-size:12px;text-align:center;vertical-align:top;font-size: 20px;}
.tg-rg0h{font-size:12px;text-align:center;vertical-align:top;font-size: 20px;}
.tg-rg0hb{font-size:12px;text-align:center;vertical-align:top;font-size: 20px;font-weight: bold;}
</style>

<table class="tg" style="margin-top: 5%;">
  <tr>
    <th class="tg-ai0l">Quantity</th>
    <th class="tg-ai0l">Description</th>
    <th class="tg-ai0l">Amount</th>
  </tr>
  @foreach($_bookingdetails as $bookingdetails)
  <tr>
    <td class="tg-rg0h">{{$bookingdetails->roomqnt}}</td>
    <td class="tg-rg0h">{{$bookingdetails->room_name}}</td>
    <td class="tg-rg0h">&#x20B1;{{number_format(($bookingdetails->rate * $bookingdetails->roomqnt * $_bookingdetails[0]->total_nights),2)}}</td>
  </tr>
  @endforeach
  @if($_bookingdetails[0]->extra_mattress != 0)
  	<tr>
	  	<td class="tg-rg0h">{{$_bookingdetails[0]->extra_mattress}}</td>
	    <td class="tg-rg0h">Extra Mattress</td>
	    <td class="tg-rg0h">&#x20B1;{{number_format(($_bookingdetails[0]->extra_mattress_amount),2)}}</td>
  	</tr>
  @endif
</table>
</center>
@php
$total_amount = ($_bookingdetails[0]->req_deposit * 2);
$vat          = (($total_amount / 1 + ($_resort_tax[0]->tax / 100)) * ($_resort_tax[0]->tax / 100));
$vatable 	  = ($total_amount - $vat);
@endphp
<table  style="margin-top: 2%;">
  <tr>
  	<td class="tg-rg0h">VAT: </td>
  	<td class="tg-rg0h">&nbsp;&nbsp;&nbsp;&nbsp;&#x20B1;{{number_format($vat,2)}}</td>
  </tr>
   <tr>
    <td class="tg-rg0h">VATable Amount: </td>
    <td class="tg-rg0h">&nbsp;&nbsp;&nbsp;&nbsp;&#x20B1;{{number_format($vatable,2)}}</td>
  </tr>
  <tr>
  	<td class="tg-rg0hb">Total Amount: </td>
  	<td class="tg-rg0hb">&nbsp;&nbsp;&nbsp;&nbsp;&#x20B1;{{number_format($total_amount,2)}}</td>
  </tr>
</table>

<script type="text/javascript">
	 javascript:window.print();
var mediaQueryList = window.matchMedia('print');
mediaQueryList.addListener(function(mql) {
    if (mql.matches) {
        
    } else {
        window.top.close();
    }
});
</script>
</body>
</html>