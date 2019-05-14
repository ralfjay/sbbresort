<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>Reservation Form - Sigayan Bay Beach Resort</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link href="../cx_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<link href="../cx_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->

      <link href="../cx_assets/css/blog-home.css" rel="stylesheet">
    <link href="../cx_assets/css/mod_style.css" rel="stylesheet">
    <link rel="stylesheet" href="../homepage_assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="../homepage_assets/css/animate.css">
      <link rel="stylesheet" href="../homepage_assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="../homepage_assets/css/aos.css">
      <link rel="stylesheet" href="../homepage_assets/css/bootstrap-datepicker.css">
      <link rel="stylesheet" href="../homepage_assets/css/jquery.timepicker.css">
      <link rel="stylesheet" href="../homepage_assets/css/fancybox.min.css">
      <link rel="stylesheet" href="../homepage_assets/css/style.css">
      <link rel="stylesheet" href="../homepage_assets/fonts/ionicons/css/ionicons.min.css">
      <link rel="stylesheet" href="../homepage_assets/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../cx_assets/css/login-style.css">
    <script src="../cx_assets/vendor/jquery/jquery.min.js"></script>
    <script src="../cx_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">



</head>
<body>
   <div>
     <a href="/guest_dashboard" ><button class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back To Dashboard</button></a>
   </div>
<div class="container">
<div class="row">
        <div class="col-lg-8">
          <!-- Booking Details Widget -->
          <div class="card my-4">
            <h5 class="card-header">New Booking Details</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <strong>Check In</strong>
                    </li>
                    <li>
                      <a><?php echo e($_reservation_data['newCheckIndateDisplay']); ?></a>
                    </li>
                    <li>
                     <strong>Check Out</strong>
                    </li>
                     <li>
                      <a><?php echo e($_reservation_data['newCheckOutdateDisplay']); ?></a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <strong>Day(s)</strong>
                    </li>
                    <li>
                      <a><?php echo e($_reservation_data['dateDiff']); ?></a >
                    </li>
                    <li>
                      <strong>Guest(s)</strong>
                    </li>
                     <li>
                      <a><?php echo e($_reservation_data['newGuest']); ?></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
             <h5 class="card-header">Quotation</h5>
              <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <ul class="list-unstyled mb-0">
                  <?php for($i = 1;$i <= $index; $i++): ?>
                    <li><?php echo e($room_qnt[$i].'  '.$room_name[$i]); ?> &mdash; &#x20B1;<?php echo e(number_format($tot_rate[$i],2)); ?></li>
                  <?php endfor; ?>
                  <?php if($extra_person > 0): ?>
                    <li><?php echo e($extra_person); ?> Extra Mattress &mdash; &#x20B1;<?php echo e(number_format(($extra_person*450),2)); ?></li>
                  <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
            <h5 class="card-header">Payment</h5>
             <div class="card-body">
              <div class="row">
                <div class="col-md-12 text-center">
                  <ul class="list-unstyled mb-0">
                    <li>VATable Amount  &mdash; &#x20B1;<?php echo e(number_format( ($total_amount - (($total_amount / ( 1 + ($tax[0]->tax / 100))) * ($tax[0]->tax / 100))) ,2)); ?>

                    </li>
                    <li>
                      <span>VAT(<?php echo e($tax[0]->tax); ?>%) &mdash; &#x20B1;<?php echo e(number_format( (($total_amount / ( 1 + ($tax[0]->tax / 100))) * ($tax[0]->tax / 100)),2 )); ?></span>
                    </li>
                  </ul>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12 text-center">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <h3>Total Amount</h3>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <h4>&#x20B1; <?php echo e(number_format($total_amount,2)); ?></h4>
                    </li>
                  </ul>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12 text-center">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <h4>50% Down Payment</h4>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <h4>&#x20B1; <?php echo e(number_format($downpayment,2)); ?></h4>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
        
          </div>

          <button class="btn btn-primary btn-lg" id="btn-submit" style="margin-bottom: 2%;">Submit<div class="spinner-border" style="display: none;">
              <i class="fa fa-spinner fa-spin" style="font-size:30px"></i>
            </div></button>

        </div>
</div>

</div>

 <!-- Footer -->
      <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <script type="text/javascript">
    $('#btn-submit').click(function(){
        $('.spinner-border').css("display","block");
        $('#btn-submit').attr('disabled','true');
     
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/modify_updatebooking',
        method:"POST",
        success:function(data)
        {
          if(data == 'success')
          {

            $('.spinner-border').css("display","none");
            swal('Success!','Reservation successfully added','success')
            .then(val=>{
              window.location.href="/guest_dashboard";
            });
          }else if(data == 'availability')
          {
            $('.spinner-border').css("display","none");
            swal('',"Oops..the room(s) that you select is not available.Kindly select other rooms or change the reservation dates",'info')
            .then(val=>{
              window.location.href='/guest_dashboard';
            });
          }else
          {
            $('#btn-submit').removeAttr('disabled');
            $('.spinner-border').css("display","none");
            for (var i = 0; i < data.length; i++) {
              toastr['warning'](data[i],'Warning');
            }
          }
            
          
        },
        error:function (data) {
          $('#btn-submit').removeAttr('disabled');
          $('.spinner-border').css("display","none");
          toastr['error']('Something is wrong','Error!');
        },
      });
      
    });

  </script>

    
</body>
</html>                                                               