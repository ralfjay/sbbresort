<!DOCTYPE html>
<html>
<head>
	<title>Log in Admin</title>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
	<link rel="stylesheet" type="text/css" href="../admin_assets/css/admin_login.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
</head>
<body>
	<script type="text/javascript">
	@if(count($errors) > 0)
		@foreach($errors->all() as $error)
			toastr['warning']($error,'Warning!');
		@endforeach
	@endif
	@if(session('login_failed') != '')
		toastr['warning']("{{session('login_failed')}}",'Warning!');
	@endif
	</script>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Log In</h5>
            <form class="form-signin" action="/admin_login_attempt" method="post">
            	<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
              <div class="form-label-group">
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
                <label for="username">Username</label>
              </div>
              <div class="form-label-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <label for="password">Password</label>
              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Log in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>