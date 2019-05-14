

<div class="modal fade" id="clientInfoModal" tabindex="-1" role="dialog" aria-labelledby="clientInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="clientInfoModalLabel">Client Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <div class="modal-body">
             <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-personal-tab" data-toggle="tab" href="#nav-personal" role="tab" aria-controls="nav-personal" aria-selected="false">Personal Info</a>
                <a class="nav-item nav-link" id="nav-booking-info-tab" data-toggle="tab" href="#nav-booking-info" role="tab" aria-controls="nav-booking-info" aria-selected="true">Booking Info</a>
                <a class="nav-item nav-link" id="nav-payment-tab" data-toggle="tab" href="#nav-payment" role="tab" aria-controls="nav-payment" aria-selected="false">Payment History</a>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-personal" role="tabpanel" aria-labelledby="nav-personal-tab">
                <div class="row">
                  <div class="col-lg-6">
                    <small class="client-name">Name:</small>
                    <p><?php echo e($personalInfo[0]->last_name.', '.$personalInfo[0]->first_name); ?></p>
                  </div>
                  <div class="col-lg-6">
                   <small>Contact Number:</small>
                   <p><?php echo e($personalInfo[0]->contact_number); ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <small>Email:</small>
                    <p><?php echo e($personalInfo[0]->email); ?></p>
                  </div>
                  <div class="col-lg-6">
                    <small>Address:</small>
                    <p><?php echo e($personalInfo[0]->address); ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-2">
                    <button class="btn btn-primary btn-sm"><span class="fa fa-envelope"></span> Resend Account Information (not yet working)</button>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="nav-booking-info" role="tabpanel" aria-labelledby="nav-booking-info-tab">
                <div class="row">
                  <div class="col-lg-3">
                    <small>Booking Code:</small>
                    <p><?php echo e($bookingDetails[0]->booking_code); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Booking Date:</small>
                    <p><?php echo e($bookingDetails[0]->booking_date); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Check In Date:</small>
                    <p><?php echo e($bookingDetails[0]->checkin_date); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Check Out Date:</small>
                    <p><?php echo e($bookingDetails[0]->checkout_date); ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-3">
                    <small>Status:</small>
                    <p><?php echo e($bookingDetails[0]->booking_status); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>No. of Guest(s):</small>
                    <p><?php echo e($bookingDetails[0]->no_of_guest); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Extra Mattress:</small>
                    <p><?php echo e($bookingDetails[0]->extra_mattress); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Room Number(s):</small>
                    <p>
                      <?php $__currentLoopData = $bookingDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($booking_details->room_number); ?><br>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-3">
                    <small>Total Amount:</small>
                    <p><?php echo e($bookingDetails[0]->total_amount); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Paid Amount:</small>
                    <p><?php echo e($bookingDetails[0]->paid_amount); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Balance Amount:</small>
                    <p><?php echo e($bookingDetails[0]->balance_amount); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Deposit Slip:</small><br>
                    <?php $__currentLoopData = $depositSlip; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit_slip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <img src="../images/<?php echo e($deposit_slip->resized_name); ?>" onclick="imgClientInfoModal('../images/<?php echo e($deposit_slip->filename); ?>')" height="50" width="50">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                </div>
                <?php if(count($discountDetails) > 0): ?>
                <div class="row">
                  <div class="col-lg-3">
                    <small>Discount/Voucher:</small>
                    <p><?php echo e($discountDetails[0]->description); ?></p>
                  </div>
                  <div class="col-lg-3">
                    <small>Discount Amount:</small>
                    <p><?php echo e($discountDetails[0]->amount); ?></p>
                  </div>
                </div>
                <?php endif; ?>
              </div>
             
              <div class="tab-pane fade" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                <div class="row">
                  <div class="col-lg-3">
                    <small>Date Received</small>
                  </div>
                   <div class="col-lg-3">
                    <small>Date Updated</small>
                  </div>
                  <div class="col-lg-3">
                    <small>Amount</small>
                  </div>
                  <div class="col-lg-3">
                    <small>Action</small>
                  </div>
                </div>
                <br>
                <?php $__currentLoopData = $paymentDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="row">
                    <div class="col-lg-3">
                      <p><?php echo e(date('M d, Y h:i A',strtotime($payment_details->created_at))); ?></p>
                    </div>
                     <div class="col-lg-3">
                      <p><?php echo e(date('M d, Y h:i A',strtotime($payment_details->updated_at))); ?></p>
                    </div>
                     <div class="col-lg-3">
                      <p><?php echo e('₱'.number_format($payment_details->amount,2)); ?></p>
                    </div>
                     <div class="col-lg-3">
                      <button class="btn btn-warning" onclick="editPayment('<?php echo e(Crypt::encryptString($payment_details->booking_id)); ?>','<?php echo e(Crypt::encryptString($payment_details->id)); ?>','<?php echo e(number_format($payment_details->amount,2)); ?>','<?php echo e(date('M d, Y h:i A',strtotime($payment_details->created_at))); ?>','<?php echo e(date('M d, Y h:i A',strtotime($payment_details->updated_at))); ?>')" style="color: white;"><span class="fa fa-pen"></span> Edit</button>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="imgClientInfoModal" tabindex="-1" role="dialog" aria-labelledby="imgClientInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
          <img class="imgsrc" src="">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editPaymentModal" tabindex="-1" role="dialog" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="booking_id" >
        <input type="hidden" id="pid" >
        <div class="row">
          <div class="col-lg-4">
            Date Received:
          </div>
          <div class="col-lg-4">
            Date Updated:
          </div>
          <div class="col-lg-4">
            Amount:
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 edit-payment-received">
          </div>
          <div class="col-lg-4 edit-payment-updated">
          </div>
          <div class="col-lg-4 edit-payment-amount">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-6">
            New Amount:
          </div>
          <div class="col-lg-6">
            <input type="number" name="new_amount" id="new_amount" class="form-control" min="0" placeholder="New Amount">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary edit-payment-submit">Submit</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function imgClientInfoModal(link) {
    $('.imgsrc').attr('src',link);
    $('#imgClientInfoModal').modal('show');
  }

  function editPayment(booking_id,id,amount,created_at,updated_at) {
    $('#booking_id').val(booking_id);
    $('#pid').val(id);
    $('.edit-payment-received').html(created_at);
    $('.edit-payment-updated').html(updated_at);
    $('.edit-payment-amount').html('₱'+amount);
    $('#editPaymentModal').modal('show');
  }

  $('.edit-payment-submit').click(function() {
    if($('.edit-payment-amount').html() != '₱'+$('#new_amount').val()+'.00' )
    {
      swal({
            title:'Are you sure you want to edit the payment of '+$('.client-name').html()+' worth '+$('.edit-payment-amount').html()+' to ₱'+$('#new_amount').val(), 
            buttons:true,
            dangerMode:true,
            icon:'warning'
          })
          .then(next=>{
            $.ajax({
              headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
              url:'/edit_payment',
              method:"post",
              data:{booking_id:$('#booking_id').val(),id:$('#pid').val(),amount:$('#new_amount').val()},
              success:function(data)
              {
                if(data.message != '')
                {
                  swal(data.message,'','success')
                  .then(val=>{
                    location.reload();
                  });

                }else if(data.errors != '')
                {
                  jQuery.each(data.errors, function(key, value){
                   toastr['warning'](value,'Warning!');
                  });
                }
              }
            });
          });
    }
    else
    {
      swal('You input the same amount.','');
    }
  });
    

</script>