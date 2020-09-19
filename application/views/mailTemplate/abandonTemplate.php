<!DOCTYPE html>
<html>
    <head>
        <title><?= Config('pageTitle');?></title>
    </head>
    <body>

        <div>
           <h3>
                Dear <?= $data['user_name']?>
            </h3>
            
            <p>Thanks for your time and interest in our collection.</p>
            <p>We noticed that you have made certain selections in the <a href="<?php echo base_url(); ?>" target="_blank">Cheer Sagar Virtual Showroom.</a></p>
            <p>You can find the details of your selections below.</p>
            
            <br>
            <p>Please <a href="<?php echo base_url(); ?>" target="_blank">click here</a> to complete your enquiry so that our team can work on it and get back to you with the detailed inputs on designing, sampling, pricing etc. For any questions, you can email us on enquiry@cheersagar.com</p>
            <p>We can develop different styles and designs as per your inputs and specifications as well.  Hope to develop long term business relationship. </p>
            
            <p>Selections : </p>
            <table border="2">
                <thead>
                    <tr>
                        <th>Style Number</th>
                        <th>Product title</th>
                        <th>Image</th>
                        <th>Fabric</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i=0; $i<count($data['Details']); $i++){
                    ?>
                    <tr>
                        <td><?= $data['Details'][$i]['part_number']; ?></td>
                        <td><?= $data['Details'][$i]['product_name']; ?></td>
                        <td><img src="<?php echo $this->config->item('file_url').$data['Details'][$i]['product_image']; ?>" height="200" width="150"></td>
                        <td><?= $data['Details'][$i]['fabric']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
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
