  <!DOCTYPE HTML>
  <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Sigayan Bay Beach Resort</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=|Roboto+Sans:400,700|Playfair+Display:400,700">

      <link rel="stylesheet" href="homepage_assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="homepage_assets/css/animate.css">
      <link rel="stylesheet" href="homepage_assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="homepage_assets/css/aos.css">
      <link rel="stylesheet" href="homepage_assets/css/bootstrap-datepicker.css">
      <link rel="stylesheet" href="homepage_assets/css/jquery.timepicker.css">
      <link rel="stylesheet" href="homepage_assets/css/fancybox.min.css">
      
      <link rel="stylesheet" href="homepage_assets/fonts/ionicons/css/ionicons.min.css">
      <link rel="stylesheet" href="homepage_assets/fonts/fontawesome/css/font-awesome.min.css">

      <!-- Theme Style -->
      <link rel="stylesheet" href="homepage_assets/css/style.css">
    </head>
    <body data-spy="scroll" data-target="#templateux-navbar" data-offset="200">

    <nav class="navbar navbar-expand-lg navbar-dark pb_navbar pb_scrolled-light" id="templateux-navbar">
      <div class="container">
        <a class="navbar-brand" href="/"><img src="https://i2.wp.com/sigayanbay.com/wp-content/uploads/2016/08/sigayannew2.png?w=550&ssl=1" height="50" width="200"></a>
        <div class="site-menu-toggle js-site-menu-toggle  ml-auto"  data-aos="fade" data-toggle="collapse" data-target="#templateux-navbar-nav" aria-controls="templateux-navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <!-- END menu-toggle -->

        <div class="collapse navbar-collapse" id="templateux-navbar-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="#section-home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#section-rooms" style="color: #fff;">Rooms</a></li>
            <li class="nav-item"><a class="nav-link" href="#section-vouchers" style="color: #fff;">Vouchers</a></li>
            <li class="nav-item"><a class="nav-link" href="#section-contact" style="color: #fff;">Contact</a></li>
             <li class="nav-item cta-btn ml-xl-2 ml-lg-2 ml-md-0 ml-sm-0 ml-0"><a class="nav-link" href="/guest_login"><span style="border-color: #fff!important; color: #fff!important;"class="pb_rounded-4 px-4 rounded">Log in</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->

      <section class="site-hero overlay" style="background-image: url(https://i2.wp.com/sigayanbay.com/wp-content/uploads/2016/07/Home.jpg?resize=1180%2C610&ssl=1)" data-stellar-background-ratio="0.5" id="section-home">
        <div class="container">
          <div class="row site-hero-inner justify-content-center align-items-center">
            <div class="col-md-10 text-center" data-aos="fade-up">
              <h1 class="heading">Stay With Us &amp; Relax</h1>
            </div>
          </div>
        </div>

        <a class="mouse smoothscroll" href="#next" >
          <div class="mouse-icon">
            <span class="mouse-wheel"></span>
          </div>
        </a>
      </section>
      <!-- END section -->

      <section class="section bg-light pb-0"  >
        <div class="container">
         
          <div class="row check-availabilty" id="next">
            <div class="block-32" data-aos="fade-up" data-aos-offset="-200">

              <form action="/roomavailable" method="post">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <div class="row">
                  <div class="col-md-4 mb-3 mb-lg-0 col-lg-3">
                    <label for="checkin_date" class="font-weight-bold text-black">Check In</label>
                    <div class="field-icon-wrap">
                      <div class="icon"><span class="icon-calendar"></span></div>
                      <input type="text" id="checkin" style="text-align: center; background-color: #fff!important;" name="checkin" value="{{$datetomorrow}}" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3 mb-lg-0 col-lg-3">
                    <label for="checkout" class="font-weight-bold text-black">Check Out</label>
                    <div class="field-icon-wrap">
                      <div class="icon"><span class="icon-calendar"></span></div>
                      <input type="text" id="checkout" style="text-align: center;background-color: #fff!important;" value="{{$dateNexttomorrow}}" name="checkout" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3 mb-lg-0 col-lg-3">
                        <label class="font-weight-bold text-black">Guest</label>
                        <div class="field-icon-wrap">
                          <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                          <select name="guest" class="form-control">
                            @for($i = 1; $i <= 100;$i++)
                              <option value="{{$i}}">{{$i}}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                  <div class="col-md-6 col-lg-3 align-self-end">
                    <button class="btn btn-primary btn-block text-white">Check Availabilty</button>
                  </div>
                </div>
              </form>
            </div>


          </div>
        </div>
      </section>

     @if(count($_roomdata) > 0)
     <section class="section blog-post-entry bg-light" id="section-rooms">
        <div class="container">
          <div class="row justify-content-center text-center mb-5">
            <div class="col-md-7">
              <h2 class="heading" data-aos="fade-up">Rooms</h2>
              <p data-aos="fade-up"></p>
            </div>
          </div>
          <div class="row">
            @foreach($_roomdata as $roomdata)
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 post" data-aos="fade-up" data-aos-delay="100">
              <div class="media media-custom d-block mb-4 h-100">
                <a href="#" class="mb-4 d-block"><img src="homepage_assets/images/img_1.jpg" alt="Image placeholder" class="img-fluid"></a>
                <div class="media-body">
                  
                  <h2 class="mt-0 mb-3"><a>{{$roomdata->room_name}}</a></h2>
                  <p>{{$roomdata->description}}</p>
                  <p>Good for {{$roomdata->capacity}} pax | Max {{($roomdata->capacity + $roomdata->extra_mattress)}} pax</p>
                  <p>&#8369;{{$roomdata->rate}} / night</p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </section>
      @endif

      <section class="section blog-post-entry bg-light" id="section-vouchers">
        <div class="container">
          <div class="row justify-content-center text-center mb-5">
            <div class="col-md-7">
              <h2 class="heading" data-aos="fade-up">Vouchers</h2>
              <p data-aos="fade-up"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 post" data-aos="fade-up" data-aos-delay="100">

              <div class="media media-custom d-block mb-4 h-100">
                <a href="#" class="mb-4 d-block"><img src="homepage_assets/images/img_1.jpg" alt="Image placeholder" class="img-fluid"></a>
                <div class="media-body">
                  <span class="meta-post">February 26, 2018</span>
                  <h2 class="mt-0 mb-3"><a href="#">Travel Hacks to Make Your Flight More Comfortable</a></h2>
                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                </div>
              </div>

            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 post" data-aos="fade-up" data-aos-delay="200">
              <div class="media media-custom d-block mb-4 h-100">
                <a href="#" class="mb-4 d-block"><img src="homepage_assets/images/img_2.jpg" alt="Image placeholder" class="img-fluid"></a>
                <div class="media-body">
                  <span class="meta-post">February 26, 2018</span>
                  <h2 class="mt-0 mb-3"><a href="#">5 Job Types That Aallow You To Earn As You Travel The World</a></h2>
                  <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 post" data-aos="fade-up" data-aos-delay="300">
              <div class="media media-custom d-block mb-4 h-100">
                <a href="#" class="mb-4 d-block"><img src="homepage_assets/images/img_3.jpg" alt="Image placeholder" class="img-fluid"></a>
                <div class="media-body">
                  <span class="meta-post">February 26, 2018</span>
                  <h2 class="mt-0 mb-3"><a href="#">30 Great Ideas On Gifts For Travelers</a></h2>
                  <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. t is a paradisematic country, in which roasted parts of sentences.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="section contact-section" id="section-contact">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-md-7">
              <h2 class="heading" data-aos="fade-up">Contact Us</h2>
              <p data-aos="fade-up">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            </div>
          </div>
        <div class="row">
          <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
            
            <form method="post" class="bg-white p-md-5 p-4 mb-5 border">
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" id="name" class="form-control ">
                </div>
                <div class="col-md-6 form-group">
                  <label for="phone">Phone</label>
                  <input type="text" name="phone" id="phone" class="form-control ">
                </div>
              </div>
          
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control ">
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-md-12 form-group">
                  <label for="message">Write Message</label>
                  <textarea name="message" name="message" id="message" class="form-control " cols="30" rows="8"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="submit" value="Send Message" class="btn btn-primary text-white font-weight-bold">
                  <div class="submitting"></div>
                </div>
              </div>

             
            </form>

            

          </div>
          <div class="col-md-5" data-aos="fade-up" data-aos-delay="200">
            <div class="row">
              <div class="col-md-10 ml-auto contact-info">
                <p><span class="d-block">Address:</span> <span class="text-black"> Brgy. Laiya Aplaya, San Juan Batangas</span></p>
                <p><span class="d-block">Contact Numbers:</span>
                  <span class="text-black"> 
                    @foreach($resort_contact_number as $contact_number)
                      {{$contact_number->contact_number}} <br>
                    @endforeach
                  </span></p>
                <p><span class="d-block">Email:</span> <span class="text-black"> @foreach($resort_email as $email){{$email->email}}@endforeach</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

      <footer class="section footer-section">
        <div class="container">
          <div class="row pt-1">
            <p class="col-md-8 text-left">
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Sigayan Bay Beach Resort
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>

          </div>
        </div>
      </footer>

   
   
      
      <script src="homepage_assets/js/jquery-3.3.1.min.js"></script>
      <script src="homepage_assets/js/jquery-migrate-3.0.1.min.js"></script>
      <script src="homepage_assets/js/popper.min.js"></script>
      <script src="homepage_assets/js/bootstrap.min.js"></script>
      <script src="homepage_assets/js/owl.carousel.min.js"></script>
      <script src="homepage_assets/js/jquery.stellar.min.js"></script>
      <script src="homepage_assets/js/jquery.fancybox.min.js"></script>
      <script src="homepage_assets/js/jquery.easing.1.3.js"></script>
      <script src="homepage_assets/js/aos.js"></script>
      <script src="homepage_assets/js/main.js"></script>
      {{-- Datepicker stuff --}}
      <link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/themes/cupertino/jquery-ui.css">
      <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 
      <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

      @if(count($errors) > 0)
        <script type="text/javascript">
          @foreach($errors->all() as $error)
            toastr['warning']("{{$error}}",'Warning!');
          @endforeach
        </script>
      @endif
       <script type="text/javascript" src="/homepage_assets/js/homepage.js"></script>
    </body>
  </html>