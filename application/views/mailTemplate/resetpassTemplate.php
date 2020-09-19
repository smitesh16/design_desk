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
                You recently requested to reset your password for your <a href="<?php echo base_url(); ?>" target="_blank">Cheer Sagar Virtual Showroom.</a> account. Please use this bellow OTP to reset your password. 
            </p>
            <p>Your Otp : <b><?= $data['otp']; ?></b></p>
            <p>If you did not request a password reset, please ignore this email or reply on enquiry@cheersagar.com to let us know.</p>
            <br>
            <p style="margin: 0px;">Best regards,  </p>
            <p style="margin: 0px;"><b>Cheer Sagar</b></p>
            <p style="margin: 0px;"><small>(A Government Recognised Star Export House)</small></p>
            <p style="margin: 0px;"><small>(AN ISO 9001 : 2015, BSCI, SMETA AND WRAP CERTIFIED COMPANY )</small></p>
            <p style="margin: 0px;">E-194 Industrial Area, Mansarover, Jaipur-302020, INDIA.</p>
            <p style="margin: 0px;">Ph. : +91 141 4441111</p>
            <p style="margin: 0px;">E-mail : enquiry@cheersagar.com</p>
            <p style="margin: 0px;">Visit us on <a href="<?php echo base_url(); ?>" target="_blank">http://www.cheersagar.com</a> </p>

        </div>

    </body>
</html>
