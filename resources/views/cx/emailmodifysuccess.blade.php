<<h3>Hello {{$emailmodifysuccessdata['firstname'].' '.$emailmodifysuccessdata['lastname'] }},</h3>
<h4>Your reservation with Booking Code {{$emailmodifysuccessdata['bookingcode'] }} is successfully modified.</h4>

<p>Here is your new Reservation Receipt:</p><a href="{{$emailmodifysuccessdata['reservationreceipt']}}">Click here for your new reservation receipt</a>



