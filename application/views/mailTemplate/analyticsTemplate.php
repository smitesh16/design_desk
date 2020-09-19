<!DOCTYPE html>
<html>
    <head>
        <title><?= Config('pageTitle');?></title>
    </head>
    <body>

        <div>
           <h3>
                Dear team Cheer Sagar,
            </h3>
            
            <p>
                We generate the list of todays analytics report of new visitor.
            </p>
            <p>Visitor Details</p>
            <table border="2">
                <thead>
                    <tr>
                        <th>Ip Address</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            for($i = 0; $i<count($data); $i++){
                        ?>
                        <tr>
                            <td><?= $data[$i]['ip_address'] ?></td>
                            <td><?= $data[$i]['location'] ?></td>
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
