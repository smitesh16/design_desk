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
                Thank you for registering with <a href="<?php echo base_url(); ?>" target="_blank">Microcotton Virtual Showroom.</a> 
            </p>
            <p>Microcotton team will verify your account for full access, and get in touch with you at the earliest.</p>
            <br>
            <p style="margin: 0px;">Best regards,  </p>
            <p style="margin: 0px;"><b>Team Microcotton</b></p>

        </div>

    </body>
</html>
