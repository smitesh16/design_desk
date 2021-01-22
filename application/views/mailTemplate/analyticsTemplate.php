<!DOCTYPE html>
<html>
    <head>
        <title><?= Config('pageTitle');?></title>
    </head>
    <body>

        <div>
           <h3>
                Dear team <?= Config('company_name');?>,
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
            <p style="margin: 0px;"><b>Team <?= Config('company_name');?></b></p>

        </div>

    </body>
</html>
