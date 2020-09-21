<!DOCTYPE html>
<html>
    <head>
        <title><?= Config('pageTitle');?></title>
    </head>
    <body>

        <div>
           <h3>
                Dear <?= $data['Name']; ?>
            </h3>
            
            <p>
                You recently requested to reset your password for your <a href="<?php echo base_url(); ?>" target="_blank">Microcotton Virtual Showroom.</a> account. Please use this bellow OTP to reset your password. 
            </p>
            <p>Your Otp : <b><?= $data['otp']; ?></b></p>
            <p>If you did not request a password reset, please ignore this email or reply on geetha.raj@microcotton.com to let us know.</p>
            <br>
            <p style="margin: 0px;">Best regards,  </p>
            <p style="margin: 0px;"><b>Team Microcotton</b></p>

        </div>

    </body>
</html>
