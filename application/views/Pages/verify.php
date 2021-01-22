<?php
    $Expiry = $expiry['expiry'];
    $Email = $email['email'];
    $Userid = $clientid['clientid'];
    $Username = $name['name'];
    $Currentdate = date('Y-m-d h:i:s');
    $expconverted = strtotime($Expiry);  //expiry conversion
    $curconverted = strtotime($Currentdate);   //current conversion
    $avgtime = abs($curconverted - $expconverted)/(60*60);
    var_dump($Expiry,$Currentdate,$avgtime);
    if(($verified['stat'] == 200) && ($avgtime <= 1) )
        { 
          $userveri = 1;
        }
      else if(($verified['stat'] == 300) && ($avgtime <= 1))
        { 
            $userveri = 0;
        }
      else if(($verified['stat'] == 400) && ($avgtime >1))
        { 
            $userveri = "expired";
        }
      else
        {
          $userveri = "error";
        }
        
        // <body onload="checkVerification()">
        
    ?>

    <html>
    <head>
    <!-- <script src="jquery-3.3.1.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    </head>
    <body onload="checkVerification()">
    <!-- <p id="demo"></p> -->
    
<script>
    
function checkVerification() {
  var verify = "<?php echo $userveri?>";
  var email = "<?php echo $Email?>";
  var userid = "<?php echo $Userid?>";
  var username = "<?php echo $Username?>";

  if (verify == 1) {
    text1 = text1 = swal("Sucesfully Verified. Please Login.")
          .then(function()
           {
              window.location = "../";
           });
  } 
  else if (verify == 0)
  {
    text1 = swal("Already Verified. Please Login.")
          .then(function()
           {
              window.location = "../";
           });
  }
  else
  {
    // text1 = swal("Link Expired!!");
          text1 = swal({
        title: "Link Expired!!",
        text: "Resend Verification Link?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willresend) => {
        if (willresend) {
          swal("Verification Link send, Please Verify.", 
          {
            icon: "success",
          })
          .then(function() 
           {
              // window.location.href="ResendEmailVerication?email="+email;
              window.location.href="ResendEmailVerication?email="+email+"&userid="+userid+"&name="+username;
           });
        }
         else 
         {
          swal("Verification Link is not send")
          .then(function()
           {
              window.location = "../";
           });
        }
      });
        }
  // document.getElementById("demo").innerHTML = text1;
}
</script>
</body>
    </html>

