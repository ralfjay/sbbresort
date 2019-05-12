    <nav  class="navbar navbar-expand-lg navbar-dark pb_navbar pb_scrolled-light" id="templateux-navbar">
      <div class="container">
        <a class="navbar-brand" href="/"><img src="https://i2.wp.com/sigayanbay.com/wp-content/uploads/2016/08/sigayannew2.png?w=550&ssl=1" height="50" width="200"></a>
        <div style="color: #00c141 !important;" class="site-menu-toggle js-site-menu-toggle  ml-auto"  data-aos="fade" data-toggle="collapse" data-target="#templateux-navbar-nav" aria-controls="templateux-navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <!-- END menu-toggle -->

        <div class="collapse navbar-collapse" id="templateux-navbar-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link home-nav" href="/" style="color:white!important;background-color: #00c141 !important;">Home</a></li>
            @if(isset($loginpage) == false)
             <li class="nav-item cta-btn ml-xl-2 ml-lg-2 ml-md-0 ml-sm-0 ml-0"><a  style="color: white!important;background-color: #00c141 !important;"class="nav-link" href="/guest_login"><span  style="border:1px solid;padding-top: inherit;padding-bottom: inherit;" class="pb_rounded-4 px-4 rounded">Log in</span></a></li>
             @endif
          </ul>
        </div>
      </div>
    </nav>