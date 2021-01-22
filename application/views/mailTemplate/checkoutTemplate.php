<!DOCTYPE html>
<html>
    <head>
        <title><?= Config('pageTitle');?></title>
    </head>
    <body>

        <div>
           <h3>
                Dear <?= $data['Name']?>
            </h3>
            <?php
                if($data['user_name'] == ""){
            ?>
            <p>Thank you so much for your time and interest in our collection. We have received your selection from <?= Config('company_name');?>® virtual showroom.
Our team will work on your enquiry and get back to you
In case of any other questions you can email us on geetha.raj@microcotton.com or call us on +91-7667244400. </p>
            <?php }else{ ?>
                <p>The below selection has been checked out by the client . </p>
            <?php
            }
                if($data['user_name'] != ""){
            ?>
            <p>User Details : </p>
            <table border="2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Territory</th>
                        <th>MOQ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $data['user_name']; ?></td>
                        <td><?= $data['user_email']; ?></td>
                        <td><?= $data['company']; ?></td>
                        <td><?= $data['user_address']; ?></td>
                        <td><?= $data['moq']; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php } ?>
            <p>Selections : </p>
            <table border="2">
                <thead>
                    <tr>
                        <th>Product title</th>
                        <th>Image</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i=0; $i<count($data['pdetails']); $i++){
                    ?>
                    <tr>
                        <td><?= $data['pdetails'][$i]['product_name']; ?></td>
                        <td><img src="<?php echo $this->config->item('file_url').$data['pdetails'][$i]['product_image']; ?>" height="200" width="150"></td>
                        <td><?= $data['pdetails'][$i]['message']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <br>
            <p style="margin: 0px;">Best regards,  </p>
            <p style="margin: 0px;"><b>Team <?= Config('company_name');?></b></p>

            
        </div>

    </body>
</html>
