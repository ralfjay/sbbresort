

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Payment</h5>
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
            <?php echo e($info[0]->booking_code); ?>

          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            Name: 
          </div>
          <div class="col-lg-6">
            <?php echo e($info[0]->last_name.', '.$info[0]->first_name); ?>

          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            Total Amount: 
          </div>
          <div class="col-lg-6">
            &#8369;<?php echo e(number_format($info[0]->total_amount,2)); ?>

          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            Balance Amount: 
          </div>
          <div class="col-lg-6">
            <?php
            $balance = $info[0]->total_amount - $info[0]->paid_amount;
            if($balance < 0)
            {
              $balance = 0;
            }
            ?>
            &#8369;<?php echo e(number_format($balance,2)); ?>

          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-6">
            Amount:
          </div>
        <div class="col-lg-6">
           <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
          <input type="hidden" name="booking_id" id="payment_booking_id" value="<?php echo e($booking_id); ?>">
          <input type="number" name="amount" id="payment_amount" class="form-control" min="1" required>
        </div>
         
        </div>
      </div>
      <div class="modal-footer">
         <button type="button"  class="btn btn-secondary" data-dismiss="modal" id="close-btn-payment">Close</button>
          <button type="button" class="btn btn-primary" id="submit-btn-payment" >Submit</button>
      </div>
   
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#submit-btn-payment').click(function(){
    $.ajax({
      headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url:'/payment_submit',
      data:{amount:$('#payment_amount').val(),booking_id:$('#payment_booking_id').val()},
      method:"post",
      success:function(data)
      {
        if(data.message != '')
        {
          swal(data.message,data.message2 != '' ? data.message2:'','success')
          .then(val=>{
            location.reload();
          });

        }else if(data.error != '')
        {
          jQuery.each(data.errors, function(key, value){
           toastr['warning'](value,'Warning!');
          });
        }
        
      },
    });
  });
</script>

