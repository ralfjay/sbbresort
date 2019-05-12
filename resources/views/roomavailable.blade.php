<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Room Available - Sigayan Bay Beach Resort</title>

    <!-- Bootstrap core CSS -->
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


  </head>

  <body>

    <!-- Navigation -->
    @include('navbar')

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
          @if(count($_roomavailable) > 0)
          <h1 class="my-4">Available Rooms</h1>
          @else
          <h1 class="my-4">No Available Room</h1>
          <div><div style="margin-bottom: 50%;"></div></div>
          @endif
          <!-- Blog Post -->
          <form method="post">
          <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
          @foreach($_roomavailable as $roomavailable)
            @if($roomavailable->availableroom > 0)
           @php
            $max = $roomavailable->capacity + $roomavailable->extra_mattress;
            $counter++;
           @endphp
           
            <div class="card mb-4">
              <img class="card-img-top" src="{{$roomavailable->imgpath }}" height="300" width="750" alt="Card image cap">
              <div class="card-body">
                <h2 class="card-title">{{$roomavailable->room_name }}</h2>
                <p class="card-text">{{$roomavailable->description }}</p>
                <p><strong>Good for {{$roomavailable->capacity}} pax per room | Max : {{$max}} pax per room (with extra charges)</strong></p>
                <p><strong>&#8369;{{number_format($roomavailable->rate) }} per night</strong></p>
              </div>
              <div class="card-footer text-muted">
                <div class="row">
                  <div class="col-lg-2">
                    <select class="form-control" id="selectroom{{$counter}}" name="selectroom{{$roomavailable->room_id}}">
                      @for($i = 0;$i <= $roomavailable->availableroom;$i++)
                        <option value="{{$i}}">{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                  <div class="col-lg-2">
                    <input type="hidden" id="sltr{{$counter}}" value="{{$roomavailable->room_id }}">
                    <a>{{$roomavailable->availableroom }} Available Room(s)</a>
                  </div>
                </div>
              </div>
            </div>

            @endif
          @endforeach
         <input type="hidden" id="lastcntr" name="lastcntr" value="{{$counter}}" >

         

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

         

          <!-- Reservation Details Widget -->
          <div class="card my-4">
            <h5 class="card-header">Reservation Details</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <strong>Check In</strong>
                    </li>
                    <li>
                      <a>{{$checkindateDisplay}}</a>
                      <input type="hidden" name="ckin">
                    </li>
                    <li>
                      <strong>Check Out</strong>
                    </li>
                    <li>
                      <a>{{$checkoutdateDisplay}}</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <strong>Day(s)</strong>
                    </li>
                    <li>
                      <a>{{$dateDiff}}</a>
                    </li>
                    <li>
                      <strong>Guest(s)</strong>
                    </li>
                    <li>
                      <a>{{$guest}}</a>
                      <input type="hidden" id="ep" name="ep" value="0">
                      <input type="hidden" id="em" name="em" value="0">
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- Side Widget -->
          
            
            <div class="card-body submit-card" style="display: none;">
              <div class="row">
                <div class="col-lg-12">
                  <button class="btn btn-primary form-control" name="btn-submit" id="btn-submit">Next</button>
                </div>
              </div>
            </div>
         

        </div>

      </div>
      <!-- /.row -->

    </div>
    
    <!-- /.container -->

    {{-- footer --}}
    @include('footer')

    <!-- Bootstrap core JavaScript -->
    <script src="cx_assets/vendor/jquery/jquery.min.js"></script>
    <script src="cx_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
      var a = 0;
      var cp = 0;
      var tcp = 0;
      function addCommas(nStr)
      {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
      } 


      $('select').change(function() {
        a     = 0;
        tcp   = 0;
        cp    = 0;
        
        for (var i = 1; i <= {{$counter}}; i++) 
        {
          if($('#selectroom'+i).val() > 0)
          {
            a++;

            
          }
        }
        if(a > 0)
        {
          $('.submit-card').css('display','block');
        }else
        {
          $('.submit-card').css('display','none');
        }
      });

      $('#btn-submit').click(function()
      {
       
       
        
        var i = 1;
        var b = 0;
      function getTheCap()
      {
        for (;i <= {{$counter}};i++) 
        {
          if($('#selectroom'+i).val() > 0)
          {
           
             
                $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'/get_extra_mattress',
                data:{rid:$('#sltr'+i).val(),qnt:$('#selectroom'+i).val()},
                method:"POST",
                success:function(data)
                {
                  data = JSON.parse(data);
                  cp  = parseInt(cp) + parseInt(data.cp);
                  tcp = parseInt(tcp) + parseInt(data.tcp);
                  b+=1;
                  declaringTheCap(cp,tcp,b);

                  
                }
              });
            
          }
        }
      }
      getTheCap();

      function declaringTheCap(cp,tcp,b)
      {
         if(parseInt({{$guest}}) > parseInt(cp) && parseInt({{$guest}}) <= parseInt(tcp) && b == a )
          {
            $('#btn-submit').attr('disabled','true');
            swal({
              title: "Are you sure?",
              text: "You will have an extra charge of Php" + (({{$guest}} - cp ) * 450) +"\n"+
              "("+({{$guest}} - cp)+" extra person x 450)",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willProceed) => {
              if (willProceed) {
                $('#ep').val(({{$guest}} - cp));
                $('form').attr('action','/form');
                $('form').submit();
              }else
              {
                $('#btn-submit').removeAttr('disabled');
              }
            });
          }else if(parseInt({{$guest}}) > parseInt(tcp))
          {
            swal('Room Capacity Validation',"We can't accommodate the given number of guests even with the inclusion of "+(tcp - cp)+" mattresses to all room selected. "+({{$guest}} - tcp)+" excess guests.",'info')
            .then(willBack => {
              if(willBack)
              {
                window.location.href="/";
              }
            });
          }else
          {
            $('form').attr('action','/form');
            $('form').submit();
          }
      }
      });


    </script>

  </body>

</html>
