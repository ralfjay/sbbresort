

<div class="modal fade" id="discountVoucherModal" tabindex="-1" role="dialog" aria-labelledby="discountVoucherModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="discountVoucherModalLabel">Discount/Voucher</h5>
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
          <div class="col-lg-6 name">
            <?php echo e($info[0]->last_name.', '.$info[0]->first_name); ?>

          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-6">
            Description:
          </div>
        <div class="col-lg-6">
          <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
          <input type="hidden" name="booking_id" id="discountVoucher_booking_id" value="<?php echo e($booking_id); ?>">
          <select id="discountVoucher_select" class="form-control">
            <option>------</option>
            <?php $__currentLoopData = $discountVoucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount_voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($discount_voucher->id); ?>"><?php echo e($discount_voucher->description); ?> - <?php echo e($discount_voucher->percentage.'%'); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        </div>
      </div>
      <div class="modal-footer">
         <button type="button"  class="btn btn-secondary" data-dismiss="modal" id="close-btn-discountVoucher">Close</button>
          <button type="button" class="btn btn-primary" id="submit-btn-discountVoucher" >Submit</button>
      </div>
   
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#submit-btn-discountVoucher').click(function(){
    swal({
      title:'Are you sure you want to give '+ $("#discountVoucher_select option:selected").text() + ' to '+ $('.name').html(),
      icon:'warning',
      dangerMode:true,
      buttons:true,
    })
    .then(go=>{
      if(go)
      {
          $.ajax({
          headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url:'/discountvoucher_submit',
          data:{discountvoucher:$('#discountVoucher_select').val(),booking_id:$('#discountVoucher_booking_id').val()},
          method:"post",
          success:function(data)
          {
            if(data.message != '')
            {
              toastr[data.type](data.message,'');

            }else if(data.error != '')
            {
              jQuery.each(data.errors, function(key, value){
               toastr['warning'](value,'Warning!');
              });
            }
            
          },
        });
      }
    });
  });
</script>

