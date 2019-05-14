<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
<body style="
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
  <?php echo $__env->make('navbar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <script type="text/javascript">
  <?php if(count($errors) > 0): ?>

  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  	toastr['warning']("<?php echo e($error); ?>",'Warning!');
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(session('return_values')['failed_message']): ?>
  	toastr['warning']("<?php echo e(session('return_values')['failed_message']); ?>",'Warning!');
 <?php endif; ?>
</script>
<div class="login-form">    
    <form id="login-form" action="/login_attempt" method="post">
    <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
    <div class="avatar"><i class="material-icons">&#xE7FF;</i></div>
      <h4 class="modal-title">Login to Your Account</h4>
        <div class="form-group">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" >
        </div>
        <input type="submit" class="btn btn-submit btn-primary btn-block btn-lg" value="Login">              
    </form>     
   
</div>

 <!-- Footer -->
   <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>

</html>                                                               

