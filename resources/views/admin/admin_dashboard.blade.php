@extends('admin.admin_layout')
@section('panel')
<div class="col-xl-3 col-md-6 mb-4">
  <a href="#" id="view-pending" style="text-decoration: none;">
  <div class="card border-left-info shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-lg font-weight-bold text-info text-uppercase mb-1">Pending Reservation <i class="badge badge-danger badge-lg pending-badge"></i></div>
        </div>
        <div class="col-auto">
          <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
  </a>
</div>
<div class="col-xl-3 col-md-6 mb-4">
 <a href="#" id="view-confirmed" style="text-decoration: none;">
  <div class="card border-left-warning shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">Confirm Reservation <i class="badge badge-danger badge-lg confirm-badge"></i></div>
        </div>
        <div class="col-auto">
          <i class="fas fa-check fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
 </a>
</div>
<div class="col-xl-3 col-md-6 mb-4">
 <a href="#" id="view-check-in" style="text-decoration: none;">
  <div class="card border-left-success shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-lg font-weight-bold text-success text-uppercase mb-1">Check In <i class="badge badge-danger badge-lg checkin-badge"></i></div>
        </div>
        <div class="col-auto">
          <i class="fas fa-check-double fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
 </a>
</div>
<div class="col-xl-3 col-md-6 mb-4">
<a href="#" id="view-all" style="text-decoration: none;">
  <div class="card border-left-danger shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">All <i class="badge badge-danger badge-lg all-badge"></i></div>
        </div>
        <div class="col-auto">
          <i class="fas fa-book fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
 </a>
</div>
@endsection
@section('content')

<div class="col-lg-12 pendingTable-div" style="display: none;">
    <div class="panel panel-default">
        <div class="panel-heading">
            PENDING RESERVATION
        </div>
        <div class="panel-body">
            <div class="table-responsive">
             <table class="table table-bordered " id="pendingTable"  cellspacing="0" >
				<thead>
				<tr>
				<th>Booking Code</th>
				<th>Name</th>
				<th>Contact Number</th>
				<th>Room Number</th>
				<th>Check In</th>
				<th>Check Out</th>
				<th>Total Amount</th>
				<th>Deposit Slip</th>
				<th>Actions</th>
				</tr>
				</thead>
				<tfoot>
				 <tr>
				<th>Booking Code</th>
				<th>Name</th>
				<th>Contact Number</th>
				<th>Room Number</th>
				<th>Check In</th>
				<th>Check Out</th>
				<th>Total Amount</th>
				<th>Deposit Slip</th>
				<th>Actions</th>
				</tr>
				</tfoot>
			</table>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 confirmTable-div" style="display: none;">
    <div class="panel panel-default">
        <div class="panel-heading">
            CONFIRM RESERVATION
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="confirmTable"  cellspacing="0">
				  <thead>
				    <tr>
				      <th>Booking Code</th>
				      <th>Name</th>
				      <th>No. of Guest</th>
				      <th>Room Number</th>
				      <th>Check In</th>
				      <th>Check Out</th>
				      <th>Total Amount</th>
				      <th>Paid Amount</th>
				      <th>Balance Amount</th>
				      <th>Deposit Slip</th>
				      <th>Actions</th>
				    </tr>
				  </thead>
				  <tfoot>
				  	 <tr>
				      <th>Booking Code</th>
				      <th>Name</th>
				      <th>No. of Guest</th>
				      <th>Room Number</th>
				      <th>Check In</th>
				      <th>Check Out</th>
				      <th>Total Amount</th>
				      <th>Paid Amount</th>
				      <th>Balance Amount</th>
				      <th>Deposit Slip</th>
				      <th>Actions</th>
				    </tr>
			  	  </tfoot>
				</table>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 checkinTable-div" style="display: none;">
    <div class="panel panel-default">
        <div class="panel-heading">
            CHECK IN
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="checkinTable"  cellspacing="0">
				  <thead>
				    <tr>
				      <th>Booking Code</th>
				      <th>Name</th>
				      <th>Contact Number</th>
				      <th>Room Number</th>
				      <th>Check In</th>
				      <th>Check Out</th>
				      <th>Total Amount</th>
				      <th>Paid Amount</th>
				      <th>Balance Amount</th>
				      <th>Deposit Slip</th>
				      <th>Actions</th>
				    </tr>
				  </thead>
				  <tfoot>
				  	 <tr>
				      <th>Booking Code</th>
				      <th>Name</th>
				      <th>Contact Number</th>
				      <th>Room Number</th>
				      <th>Check In</th>
				      <th>Check Out</th>
				      <th>Total Amount</th>
				      <th>Paid Amount</th>
				      <th>Balance Amount</th>
				      <th>Deposit Slip</th>
				      <th>Actions</th>
				    </tr>
			  	  </tfoot>
				</table>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 allTable-div" style="display: none;">
    <div class="panel panel-default">
        <div class="panel-heading">
            ALL
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="allTable">
   				   <thead>
				<tr>
				  <th>Booking Code</th>
				  <th>Name</th>
				  <th>Status</th>
				  <th>Room Number</th>
				  <th>Check In</th>
				  <th>Check Out</th>
				  <th>Total Amount</th>
				  <th>Paid Amount</th>
				  <th>Deposit Slip</th>
				  <th>Actions</th>
				</tr>
				</thead>
				<tfoot>
					 <tr>
					  <th>Booking Code</th>
					  <th>Name</th>
					  <th>Status</th>
					  <th>Room Number</th>
					  <th>Check In</th>
					  <th>Check Out</th>
					  <th>Total Amount</th>
					  <th>Paid Amount</th>
					  <th>Deposit Slip</th>
					  <th>Actions</th>
					</tr>
				  </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">

$('#view-pending').click(function(){
	$('#pendingTable').DataTable({
		"destroy"	: true,
		"bInfo"     : true,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			"url":"/get_pending_reservation",
			"dataType":"json",
			"type":"POST",
			"data":{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
		},
		"columns":[
			{"data":"booking_code"},
			{"data":"name"},
			{"data":"contact_number","orderable":false,"sortable":false},
			{"data":"room_number"},
			{"data":"checkin_date"},
			{"data":"checkout_date"},
			{"data":"total_amount","searchable":false},
			{"data":"deposit_slip","searchable":false,},
			{"data":"action","searchable":false,"orderable":false,"sortable":false}
		]
	});
	$('.pendingTable-div').css('display','block');
	$('.confirmTable-div').css('display','none');
	$('.checkinTable-div').css('display','none');
	$('.allTable-div').css('display','none');
});


$('#view-confirmed').click(function(){
	$('#confirmTable').DataTable({
		"destroy"	: true,
		"bInfo"     : true,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			"url":"/get_confirm_reservation",
			"dataType":"json",
			"type":"POST",
			"data":{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
		},
		"columns":[
			{"data":"booking_code"},
			{"data":"name"},
			{"data":"guest","orderable":false,"sortable":false},
			{"data":"room_number"},
			{"data":"checkin_date"},
			{"data":"checkout_date"},
			{"data":"total_amount","searchable":false},
			{"data":"paid_amount","searchable":false},
			{"data":"balance_amount","searchable":false},
			{"data":"deposit_slip","searchable":false,},
			{"data":"action","searchable":false,"orderable":false,"sortable":false}
		]
	});
		
	$('.confirmTable-div').css('display','block');
	$('.pendingTable-div').css('display','none');
	$('.checkinTable-div').css('display','none');
	$('#allTable-div').css('display','none');
});

$('#view-check-in').click(function(){
	$('#checkinTable').DataTable({
		"destroy"	: true,
		"bInfo"     : true,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			"url":"/get_checkin_reservation",
			"dataType":"json",
			"type":"POST",
			"data":{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
		},
		"columns":[
			{"data":"booking_code"},
			{"data":"name"},
			{"data":"contact_number","orderable":false,"sortable":false},
			{"data":"room_number"},
			{"data":"checkin_date"},
			{"data":"checkout_date"},
			{"data":"total_amount","searchable":false},
			{"data":"paid_amount","searchable":false},
			{"data":"balance_amount","searchable":false},
			{"data":"deposit_slip","searchable":false,},
			{"data":"action","searchable":false,"orderable":false,"sortable":false}
		]
	});
	$('.checkinTable-div').css('display','block');
	$('.pendingTable-div').css('display','none');
	$('.confirmTable-div').css('display','none');
	$('.allTable-div').css('display','none');
});

$('#view-all').click(function(){
	$('#allTable').DataTable({
		"destroy"	: true,
		"bInfo"     : true,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			"url":"/get_all_reservation",
			"dataType":"json",
			"type":"POST",
			"data":{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
		},
		"columns":[
			{"data":"booking_code"},
			{"data":"name"},
			{"data":"status"},
			{"data":"room_number"},
			{"data":"checkin_date"},
			{"data":"checkout_date"},
			{"data":"total_amount","searchable":false},
			{"data":"paid_amount","searchable":false},
			{"data":"deposit_slip","searchable":false,},
			{"data":"action","searchable":false,"orderable":false,"sortable":false}
		]
	});
	$('.allTable-div').css('display','block');
	$('.pendingTable-div').css('display','none');
	$('.confirmTable-div').css('display','none');
	$('.checkinTable-div').css('display','none');
});

function paymentBook(booking_id)
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/view_payment',
        data:{booking_id:booking_id},
        method:"POST",
        success:function(data)
        {
        	$('.global-modal-container').html(data.html);
        	$('#paymentModal').modal('show');
        }
	});
}

function checkinBook(booking_id,name)
{
	swal({
	 title:'Are you sure you want to check in '+ name + '?',
	 icon: 'warning',
	 dangerMode:true,
	 buttons:true,
	})
	.then(checkin=>{
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url:'/checkin_guest',
			data:{booking_id:booking_id,name:name},
			method:"post",
			success:function(data) {
				if(data.message != '')
		        {
		          swal(data.message,data.message2 != '' ? data.message2:'','success')
		          .then(val=>{
		            location.reload();
		          });

		        }else if(data.errors != '')
		        {
		          
		           toastr['warning'](data.errors,'Warning!');
		          
		        }
			}
		});
	});
}

function checkoutBook(booking_id,name)
{
	swal({
	 title:'Are you sure you want to check out '+ name + '?',
	 icon: 'warning',
	 dangerMode:true,
	 buttons:true,
	})
	.then(checkin=>{
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url:'/checkout_guest',
			data:{booking_id:booking_id,name:name},
			method:"post",
			success:function(data) {
				if(data.message != '')
		        {
		          swal(data.message,data.message2 != '' ? data.message2:'','success')
		          .then(val=>{
		            location.reload();
		          });

		        }else if(data.error != '')
		        {
		          
		           toastr['warning'](data.error,'Warning!');
		          
		        }
			}
		});
	});
}

function addChargeBook(booking_id) {
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/view_addcharge',
        data:{booking_id:booking_id},
        method:"POST",
        success:function(data)
        {
        	$('.global-modal-container').html(data.html);
        	$('#addChargeModal').modal('show');
        }
	});
}

function discountBook(booking_id) {
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/view_discount_voucher',
        data:{booking_id:booking_id},
        method:"POST",
        success:function(data)
        {
        	$('.global-modal-container').html(data.html);
        	$('#discountVoucherModal').modal('show');
        }
	});
}

function clientInfoBook(booking_id) {
	$.ajax({
		headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
		url:'/view_client_info',
		data:{booking_id:booking_id},
		method:"POST",
		success:function(data)
		{
			$('.global-modal-container').html(data.html);
			$('#clientInfoModal').modal('show');
		}
	});
}

setInterval(function(){
	$.ajax({
		headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
		url:'/booking_panel_counter',
		success:function (data) {
			$('.pending-badge').html(data.pending);
			$('.confirm-badge').html(data.confirm);
			$('.checkin-badge').html(data.checkin);
			$('.all-badge').html(data.all);
		},
		error:function (argument) {
			alert('Network error.');
			location.reload();
		}
	});
},2000000);
</script>
@endsection