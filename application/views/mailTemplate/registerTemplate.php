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
                Thank you for registering with <a href="<?php echo base_url(); ?>" target="_blank">Cheer Sagar Virtual Showroom.</a> 
            </p>
            <p>Cheer Sagar team will verify your account for full access, and get in touch within 1-3 business days. We appreciate your patience.</p>
            <p>
                Meanwhile you can browse the <a href="<?php echo base_url(); ?>" target="_blank">Cheer Sagar Virtual store</a> or get in touch on enquiry@cheersagar.com.</a>
            </p>
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
