$( function() {
 
      $( "#checkin" ).datepicker( "option", "showAnim", "slideDown" );
  

     $('#checkin').datepicker({
            dateFormat: "mm/dd/yy",
            minDate:1,
            maxDate:365,
            onSelect: function (date) {
                var date2 = $('#checkin').datepicker('getDate');
                date2.setDate(date2.getDate() + 1);
                $('#checkout').datepicker('setDate', date2);
                //sets minDate to CheckInDate date + 1
                $('#checkout').datepicker('option', 'minDate', date2);
            }
        });
        $('#checkout').datepicker({
           dateFormat: "mm/dd/yy",
           minDate:2,
           maxDate:365,
            onClose: function () {
                var checkin = $('#checkin').datepicker('getDate');
                console.log(checkin);
                var checkout = $('#checkout').datepicker('getDate');
                if (checkout <= checkin) {
                    var minDate = $('#checkout').datepicker('option', 'minDate');
                    $('#checkout').datepicker('setDate', minDate);
                }
            }
        });
  } );