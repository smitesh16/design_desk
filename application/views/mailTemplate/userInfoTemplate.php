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
                A new user has requested access to the virtual showroom – Japan</p>
                <p>Please review the details below and approve/deny access.</p>
            <p>User Details</p>
            <table border="2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>company</th>
                        <th>Territory</th>
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
