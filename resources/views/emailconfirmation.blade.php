<h3>Hello {{$emailconfirmationdata['firstname'].' '.$emailconfirmationdata['lastname'] }},</h3>
<h4>Thank you for giving us opportunity to serve you!</h4>
<p>Please take note of your account username and password, you can use your account to upload the picture of your bank deposit slip, and modify or cancel your reservation. Kindly click the confirmation link below to confirm your reservation.</p><br>
<strong>Username: {{$emailconfirmationdata['username']}}</strong>
<strong>Password: {{$emailconfirmationdata['password']}}</strong><br>

<a href={{$emailconfirmationdata['link'] }}>Click Here to Confirm your reservation</a><br>

<p>And here is your Reservation Receipt:</p><a href="{{$emailconfirmationdata['reservationreceipt']}}">Click here for your reservation receipt</a>



