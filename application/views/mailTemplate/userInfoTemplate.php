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
                A new user has requested access to the virtual showroom</p>
                <p>Please review the details below and approve/deny access.</p>
            <p>User Details</p>
            <table border="2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>company</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $data['user_name'] ?></td>
                        <td><?= $data['user_email'] ?></td>
                        <td><?= $data['contact_number'] ?></td>
                        <td><?= $data['company'] ?></td>
                        <td><?= $data['user_address'] ?></td>
                    </tr>
                </tbody>
            </table>
            <p><a href="<?php echo base_url(); ?>Customer" target="_blank">Click here</a> to go to admin pannel</p>
            <br>
            <p style="margin: 0px;">Best regards,  </p>
            <p style="margin: 0px;"><b>Team <?= Config('company_name');?></b></p>

        </div>

    </body>
</html>
