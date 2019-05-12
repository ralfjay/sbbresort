 $('.submit-btn').click(function(){
        $('.spinner-border').css("display","block");
        $('.submit-btn').attr('disabled','true');
      var formData = new FormData();
      formData.append('firstname',$('#firstname').val());
      formData.append('lastname',$('#lastname').val());
      formData.append('email',$('#email').val());
      formData.append('contactnumber',$('#contactnumber').val());
      formData.append('address',$('#address').val());
      formData.append('_token',$('meta[name="csrf-token"]').attr('content'));
      
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/insertandemail',
        data:formData,
        method:"POST",
        success:function(data)
        {
          if(data == 'success')
          {

            $('.spinner-border').css("display","none");
            swal('Success!','Reservation successfully added','success')
            .then(val=>{
              window.location.href="/reserved";
            });
          }else if(data == 'availability')
          {
            $('.spinner-border').css("display","none");
            swal('',"Oops..the room(s) that you select is not available.Kindly select other rooms or change the reservation dates",'info')
            .then(val=>{
              window.location.href='/';
            });
          }else
          {
            $('.submit-btn').removeAttr('disabled');
            $('.spinner-border').css("display","none");
            for (var i = 0; i < data.length; i++) {
              toastr['warning'](data[i],'Warning');
            }
          }
            
          
        },
        error:function (data) {
          $('.submit-btn').removeAttr('disabled');
          $('.spinner-border').css("display","none");
          toastr['error']('Something is wrong','Error!');
        },
        cache:false,
        processData:false,
        contentType:false
      });
      
    });
