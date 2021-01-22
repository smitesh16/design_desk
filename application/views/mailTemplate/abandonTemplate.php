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
            
            <p>Thank you so much for your time and interest in our collection. We noticed that you have made certain selection in the Microcotton® virtual showroom.</p>
            
            <p>Selections : </p>
            <table border="2">
                <thead>
                    <tr>
                        <th>Product title</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i=0; $i<count($data['Details']); $i++){
                    ?>
                    <tr>
                        <td><?= $data['Details'][$i]['product_name']; ?></td>
                        <td><img src="<?php echo $this->config->item('file_url').$data['Details'][$i]['product_image']; ?>" height="200" width="150"></td>
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
