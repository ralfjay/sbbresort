<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>
  <meta name="csrf-token" content="{{csrf_token()}}">

  <!-- Custom fonts for this template -->
  <link href="../cx_dashboard_assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../cx_dashboard_assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../cx_dashboard_assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">{{-- 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/basic.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/basic.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" /> --}}
  <link rel="stylesheet" type="text/css" href="./cx_dashboard_assets/css/basic.css">
  <link rel="stylesheet" type="text/css" href="./cx_dashboard_assets/css/dropzone.min.css">

</head>

<body id="page-top" style="
font-family: Arial, Helvetica, sans-serif!important;
  font-size: 16px!important;
  font-style: normal!important;
  font-variant: normal!important;
  font-weight: 200!important;
  letter-spacing: normal!important;
  line-height: 28.8px!important;
  text-decoration: none solid rgb(108, 117, 125)!important;
  text-transform: none!important;
  vertical-align: baseline!important;
  white-space: normal!important;
  word-spacing: 0px!important;">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon">
          <i class="fas fa-address-card"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Guest Dashboard<sup></sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
     {{--  @if($_bookingdetails[0]['booking_status'] != 'Cancelled' || $_bookingdetails[0]['booking_status'] == 'Check Out')
      <li class="nav-item">
        <a class="nav-link deposit_slip" href="#" data-toggle="modal" data-target="#depositSlipModal">
          <i class="fas fa-fw fa-upload"></i>
          <span>Upload Deposit Slip</span></a>
      </li>
      @endif
      @if($_bookingdetails[0]['booking_status'] == 'Pending' | $_bookingdetails[0]['booking_status'] == 'Confirmed')

       <li class="nav-item">
        <a class="nav-link cancel_reservation" href="#">
          <i class="fas fa-fw fa-times"></i>
          <span>Cancel Reservation</span></a>
      </li>
        @if($_bookingdetails[0]['booking_status'] == 'Confirmed')
         <li class="nav-item">
          <a class="nav-link" href="">
            <i class="fas fa-fw fa-pen"></i>
            <span>Modify Reservation</span></a>
        </li>
        @endif
      @endif --}}
    
      
      <li class="nav-item">
        <a class="nav-link deposit_slip" href="#" data-toggle="modal" data-target="#depositSlipModal">
          <i class="fas fa-fw fa-upload"></i>
          <span>Upload Deposit Slip</span></a>
      </li>
      
     

       <li class="nav-item">
        <a class="nav-link cancel_reservation" href="#">
          <i class="fas fa-fw fa-times"></i>
          <span>Cancel Reservation</span></a>
      </li>
       
         <li class="nav-item">
          <a class="nav-link" data-target="#modifyReservationModal" data-toggle="modal">
            <i class="fas fa-fw fa-pen"></i>
            <span>Modify Reservation</span></a>
        </li>
       

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <li class="nav-item">
        <a class="nav-link" href="#" data-target="#logoutModal" data-toggle="modal">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Log out</span></a>
      </li>
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <img src="https://i2.wp.com/sigayanbay.com/wp-content/uploads/2016/08/sigayannew2.png?w=550&ssl=1" height="70" width="200">

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

  

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$_bookingdetails[0]['first_name'].' '.$_bookingdetails[0]['last_name']}}</span>
                @php
                $f_name = strtolower($_bookingdetails[0]['first_name'][0]);
                @endphp
                <img src="{{'https://img.icons8.com/ios/30/4e73df/circled-'.$f_name.'-filled.png'}}">
              </a>
              <!-- Dropdown - User Information -->
             
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

       
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Booking Code</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Room Type(s)</th>
                      <th>Room Number(s)</th>
                      <th>Check in</th>
                      <th>Check out</th>
                      @if(count($_bank_deposits) > 0)
                      <th>Bank Deposit Slip</th>
                      @endif
                      <th>Total Amount</th>
                      <th>Paid Amount</th>
                      <th>Balance Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{$_bookingdetails[0]['booking_code']}}</td>
                      <td>{{$_bookingdetails[0]['last_name'].', '.$_bookingdetails[0]['first_name']}}</td>
                      <td @if($_bookingdetails[0]['booking_status'] == 'Cancelled')style="color:red;" @endif>{{$_bookingdetails[0]['booking_status']}}</td>
                      <td>
                        @foreach($_bookingdetails as $bookingdetails)
                        {{$bookingdetails->roomqnt.' '.$bookingdetails->room_name}}<br>
                        @endforeach
                      </td>
                      <td>
                        @foreach($room_numbers as $room_number)
                        {{$room_number->room_number}}<br>
                        @endforeach
                      </td>
                      <td>{{$_bookingdetails[0]['checkin_date']}}</td>
                      <td>{{$_bookingdetails[0]['checkout_date']}}</td>
                      @if(count($_bank_deposits) > 0)
                      <td>
                        @foreach($_bank_deposits as $bank_deposit)
                          <img data-toggle="modal" data-target="#viewImageModal" onclick="view_image('{{$bank_deposit->filename}}')" src="/images/{{$bank_deposit->filename}}" height="50" width="50"/><button href="#" class="btn btn-danger delete-btn" style="padding: 1px 5px;font-size: 12px;line-height: 1.5;border-radius: 3px;" onclick="delete_image({{$bank_deposit->id}})">Delete</button><br>
                        @endforeach
                      </td>
                      @endif
                      <td>&#x20B1;{{number_format($_bookingdetails[0]['total_amount'],2)}}</td>
                      <td>&#x20B1;{{number_format($_bookingdetails[0]['paid_amount'],2)}}</td>
                      <td>&#x20B1;{{number_format(($_bookingdetails[0]['total_amount']-$_bookingdetails[0]['paid_amount']),2)}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          
            <span>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Sigayan Bay Beach Resort</span>
          
          <div>
            <span>
             @php
            $x = 1;
            $limit = count($_resort_contact_numbers);
            @endphp

            @foreach($_resort_contact_numbers as $contact_number) {{$contact_number->contact_number}} &nbsp; 
                @if($x < $limit) 
                | &nbsp;
                  @php $x++ @endphp
                @endif
            @endforeach</span>&nbsp;
          </div>
          <div>
            <span>E-mail: {{$_resort_email[0]['email']}}</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!--Modals-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Are you sure you want to log out?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="cx_logout">Log out</a>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="depositSlipModal" tabindex="-1" role="dialog" aria-labelledby="depositSlipModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="depositSlipModalLabel">Upload Deposit Slip<span id="counter"></span></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="/upload_deposit_slip" class="dropzone" id="my-dropzone">
          <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        </div>
        </form>
        <div class="modal-footer">
          <small>Note: You are only allowed to upload 3 images including you uploaded before</small>
            <button  class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           <button  class="btn btn-primary" id="submit-all">Upload</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
      <div class="modal-content">
       <img id="viewImage" src="">
      </div>
    </div>
  </div>


<div class="modal fade" id="modifyReservationModal" tabindex="-1" role="dialog" aria-labelledby="modifyReservationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modifyReservationLabel">Modify Reservation<span id="counter"></span></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="/modify_available_rooms" method="post">
           <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
         <div class="row">
           <div class="col-lg-6">
             <label>New Check In Date</label>
           </div>
           <div class="col-lg-6">
             <input type="text" class="form-control text-center" name="newCheckIn" id="newCheckIn" value="{{$datetomorrow}}">
            
           </div>
         </div>
         <div class="row">
           <div class="col-lg-6">
             <label>New Check Out Date</label>
           </div>
           <div class="col-lg-6">
              <input type="text" class="form-control text-center" name="newCheckOut" id="newCheckOut" value="{{$dateNexttomorrow}}">
           </div>
         </div>
         <div class="row">
           <div class="col-lg-6">
             <label>Number of Guest(s)</label>
           </div>
           <div class="col-lg-6">
              <select name="newGuest" class="form-control text-center">
                @for($i = 1; $i <= 100;$i++)
                  <option value="{{$i}}">{{$i}}</option>
                @endfor
              </select>
           </div>
         </div>
        </div>
        <div class="modal-footer">
           <button  class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           <input type="submit"  class="btn btn-primary" name="btn-submit-modify" value="Submit">
        </div>
        </form>
      </div>
    </div>
  </div>



  
    
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../cx_dashboard_assets/vendor/jquery/jquery.min.js"></script>
  <script src="../cx_dashboard_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../cx_dashboard_assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../cx_dashboard_assets/js/sb-admin-2.min.js"></script>

  <link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/themes/cupertino/jquery-ui.css">
  <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- Page level plugins -->
  <script src="../cx_dashboard_assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../cx_dashboard_assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="../cx_dashboard_assets/js/dropzone.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function() {
  $('table').DataTable({
    "bSort":false,
    "bFilter":false,
    "bLengthChange":false,
    "bInfo":false,
    "bPaginate":false,
  });

});

Dropzone.options.myDropzone = {

  // Prevents Dropzone from uploading dropped files immediately
  autoProcessQueue: false,
  processingmultiple:true,
  maxFiles:3,
  renameFile: function(file) {
      var dt = new Date();
      var time = dt.getTime();
     return time+file.name;
  },
  acceptedFiles: ".jpeg,.jpg,.png,.gif",

  init: function() {
    var submitButton = document.querySelector("#submit-all")
        myDropzone = this; // closure

    submitButton.addEventListener("click", function() {
      myDropzone.processQueue(); // Tell Dropzone to process all queued files.
    });

    myDropzone.on("complete", function(file) {
      myDropzone.removeFile(file);
    });
  },
  success: function (file, done) {
     if(done.message == 'Image Saved Successfully')
     {
        toastr['success'](done.message,'Success!');
     }else
     {
      toastr['warning'](done.message,'Warning!');
     }
  }
};


$('#depositSlipModal').on('hidden.bs.modal', function () {
  location.reload();
});


function delete_image(id){
  swal({
    title:'Are you sure?',
    text: "Once deleted, you will not be able to recover this image!",
    icon: "warning",
    buttons: true,
    dangerMode:true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/delete_image',
        data:{id:id},
        success:function(data)
        {
          if(data.message == 'Image Deleted Successfully')
          {
            swal('Success!',data.message,'success')
            .then(val=>{
              location.reload();
            });
          }
          
        },
      });
      
    }
  });
}


function view_image(link)
{
  $('#viewImage').attr('src','images/'+link);
}

$('.cancel_reservation').click(function(){
  swal({
    title:'Are you sure you want to cancel your reservation',
    icon:'warning',
    dangerMode:true,
    buttons:true,
  })
  .then(cancelled=>{
    if(cancelled)
    {
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/cancel_reservation',
        success:function(data)
        {
          if(data.message == 'success')
          {
            swal('Your reservation is now cancelled','','success')
            .then(confirmed=>{
              location.reload();
            });
          }
        }
      });
      
    }
  });
});

$( function() {
 
      $( "#newCheckIn" ).datepicker( "option", "showAnim", "slideDown" );
  

     $('#newCheckIn').datepicker({
            dateFormat: "mm/dd/yy",
            minDate:1,
            maxDate:365,
            onSelect: function (date) {
                var date2 = $('#newCheckIn').datepicker('getDate');
                date2.setDate(date2.getDate() + 1);
                $('#newCheckOut').datepicker('setDate', date2);
                //sets minDate to newCheckInDate date + 1
                $('#newCheckOut').datepicker('option', 'minDate', date2);
            }
        });
        $('#newCheckOut').datepicker({
           dateFormat: "mm/dd/yy",
           minDate:2,
           maxDate:365,
            onClose: function () {
                var newCheckIn = $('#newCheckIn').datepicker('getDate');
                console.log(newCheckIn);
                var newCheckOut = $('#newCheckOut').datepicker('getDate');
                if (newCheckOut <= newCheckIn) {
                    var minDate = $('#newCheckOut').datepicker('option', 'minDate');
                    $('#newCheckOut').datepicker('setDate', minDate);
                }
            }
        });
  } );

  </script>

</body>

</html>
