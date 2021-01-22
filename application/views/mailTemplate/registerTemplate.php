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
                Thank you for registering with <a href="<?php echo base_url(); ?>" target="_blank"><?= Config('company_name');?> Virtual Showroom.</a> 
            </p>
            <p><?= Config('company_name');?> team will verify your account for full access, and get in touch with you at the earliest.</p>
            <br>
            <p style="margin: 0px;">Best regards,  </p>
            <p style="margin: 0px;"><b>Team <?= Config('company_name');?></b></p>

        </div>

    </body>
</html>
