

<div class="modal fade" id="addChargeModal" tabindex="-1" role="dialog" aria-labelledby="addChargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addChargeModalLabel">Add Charge</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            Booking Code: 
          </div>
          <div class="col-lg-6">
            {{$info[0]->booking_code}}
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            Name: 
          </div>
          <div class="col-lg-6 name">
            {{$info[0]->last_name.', '.$info[0]->first_name}}
          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-6">
            Description:
          </div>
        <div class="col-lg-6">
          <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
          <input type="hidden" name="booking_id" id="addcharge_booking_id" value="{{$booking_id}}">
          <select id="addcharge_select" class="form-control">
            <option>Description</option>
            @foreach($addcharge as $add_charge)
              <option value="{{$add_charge->id}}">{{$add_charge->description}} - &#8369;{{$add_charge->rate}}</option>
            @endforeach
          </select>
        </div>
        </div>
         <div class="row">
          <div class="col-lg-6">
            Quantity:
          </div>
          <div class="col-lg-6">
            <input type="number" class="form-control" name="quantity" id="quantity" min="1" placeholder="Quantity">
          </div>
        </div>
      </div>
      <div class="modal-footer">
         <button type="button"  class="btn btn-secondary" data-dismiss="modal" id="close-btn-addcharge">Close</button>
          <button type="button" class="btn btn-primary" id="submit-btn-addcharge" >Submit</button>
      </div>
   
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#submit-btn-addcharge').click(function(){
     swal({
      title:'Are you sure you want to add '+ $('#quantity').val()+' '+ $("#addcharge_select option:selected").text() + ' to '+ $('.name').html(),
      icon:'warning',
      dangerMode:true,
      buttons:true,
    })
    .then(go=>{
      if(go)
      {
        $.ajax({
          headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url:'/addcharge_submit',
          data:{addcharge:$('#addcharge_select').val(),quantity:$('#quantity').val(),booking_id:$('#addcharge_booking_id').val()},
          method:"post",
          success:function(data)
          {
            if(data.message != '')
            {
              toastr[data.type](data.message,'');

            }else if(data.errors != '')
            {
              jQuery.each(data.errors, function(key, value){
               toastr['warning'](value,'Warning!');
              });
            }
            
          },
        });
      }
    })
  });
</script>

