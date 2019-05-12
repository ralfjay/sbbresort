<footer @if(isset($confirmpage)) class="section footer-section" @else class="section-3 footer-section"  @endif>
    <div class="container">
      <div class="row pt-1">
        <p class="col-md-8 text-left" style="color: white!important;">
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Sigayan Bay Beach Resort
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </p>
        <div>
          <span style="color: white;"><span class="fa fa-phone" style="color: white;"></span> Contact Us: 
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
          <span style="color: white;">
            <span style="color: white;" class="fa fa-envelope"></span> 
            E-mail: {{$_resort_email[0]['email']}}
          </span>
        </div>
      </div>
    </div>
</footer>