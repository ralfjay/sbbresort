<h3>Hello <?php echo e($emailconfirmationdata['firstname'].' '.$emailconfirmationdata['lastname']); ?>,</h3>
<h4>Thank you for giving us opportunity to serve you!</h4>
<p>Please take note of your account username and password, you can use your account to upload the picture of your bank deposit slip, and modify or cancel your reservation. Kindly click the confirmation link below to confirm your reservation.</p><br>
<strong>Username: <?php echo e($emailconfirmationdata['username']); ?></strong>
<strong>Password: <?php echo e($emailconfirmationdata['password']); ?></strong><br>

<a href=<?php echo e($emailconfirmationdata['link']); ?>>Click Here to Confirm your reservation</a><br>

<p>And here is your Reservation Receipt:</p><a href="<?php echo e($emailconfirmationdata['reservationreceipt']); ?>">Click here for your reservation receipt</a>



