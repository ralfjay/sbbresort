<<h3>Hello <?php echo e($emailmodifysuccessdata['firstname'].' '.$emailmodifysuccessdata['lastname']); ?>,</h3>
<h4>Your reservation with Booking Code <?php echo e($emailmodifysuccessdata['bookingcode']); ?> is successfully modified.</h4>

<p>Here is your new Reservation Receipt:</p><a href="<?php echo e($emailmodifysuccessdata['reservationreceipt']); ?>">Click here for your new reservation receipt</a>



