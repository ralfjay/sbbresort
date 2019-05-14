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
<link href="cx_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<link href="cx_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->

      <link href="cx_assets/css/blog-home.css" rel="stylesheet">
    <link href="cx_assets/css/mod_style.css" rel="stylesheet">
    <link rel="stylesheet" href="homepage_assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="homepage_assets/css/animate.css">
      <link rel="stylesheet" href="homepage_assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="homepage_assets/css/aos.css">
      <link rel="stylesheet" href="homepage_assets/css/bootstrap-datepicker.css">
      <link rel="stylesheet" href="homepage_assets/css/jquery.timepicker.css">
      <link rel="stylesheet" href="homepage_assets/css/fancybox.min.css">
      <link rel="stylesheet" href="homepage_assets/css/style.css">
      <link rel="stylesheet" href="homepage_assets/fonts/ionicons/css/ionicons.min.css">
      <link rel="stylesheet" href="homepage_assets/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="cx_assets/css/login-style.css">
    <script src="cx_assets/vendor/jquery/jquery.min.js"></script>
    <script src="cx_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">




</head>
<body>
<?php echo $__env->make('navbar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
<div class="row">
<div class="login-form col-md-8">    
    <form>
    <div class="avatar"><i class="material-icons">&#xe5ca;</i></div>
      <center>
        <h2 class="modal-title">Thank You!</h2>
        <div>
          <p>We've sent you a confirmation message, please kindly check your email. </p>
          <p>Failure to confirm your reservation within 1 day will result of cancellation.</p>
        </div>
      </center>
      
</div>
 
       </form>
</div>
</div>     
    <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>                                                               

                                                