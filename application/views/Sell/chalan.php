<!DOCTYPE html>
<html>
<head>
    <title>IMAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body style="font-family: Arial, sans-serif">

<?php if($sell_list['stat'] == 200){ 

        $chalan_no      = $sell_list['all_list'][$id]['chalan_number'];
        $date           = $sell_list['all_list'][$id]['chalan_date'];
        $s_date           = $sell_list['all_list'][$id]['sell_date'];
        $old_date_timestamp = strtotime($s_date);
        $s_date        = date('d/m/Y', $old_date_timestamp);   
        $company_name   = $sell_list['all_list'][$id]['company_name'];
        $contact_person = $sell_list['all_list'][$id]['contact_person'];
        $contact_number = $sell_list['all_list'][$id]['contact_number'];
        $pan_number     = $sell_list['all_list'][$id]['pan_number'];
        $gstin_number   = $sell_list['all_list'][$id]['gstin_number'];
    }
    ?> 
    <div id="page-wrap" class="proforma_section" style="width: 750px;margin: 0 auto;border: 1px solid #222;box-shadow: 0 0 10px rgba(0, 0, 0, 0.52)">

		<div class="proforma_head">
            <div class="new_name" style="height: 25px;display: -webkit-flex;display: flex;-webkit-align-items: center;align-items: center;-webkit-justify-content: center;justify-content: center;margin: 10px 0;padding-bottom: 10px;border-bottom: 1px solid #222;margin-bottom: 0;">
                <div class="p_name">
                    <h5 style="font-size: 30px;font-weight: normal;text-transform: capitalize;">CHALAN</h5>
                </div>
            </div>
            <div class="top_head" style="padding: 10px;width: 97.6%;border-bottom: 1px solid #222;">
                <div class="company_stamp" style="width: 50%;margin: 0 auto;">
                    <!-- <img src="logo.png" style="width: 50%;max-width: 100%;display: block;margin: 0 auto;"> -->
                    <h5 style="font-size: 22px;font-weight: normal;text-transform: capitalize;text-align:center;margin:0px">Inventory Management</h5>
                </div>
            </div>
            <div class="middle" style="overflow: auto;">
                <div class="buyer_address" style="width: 45%;float: left;padding: 12px;">
                    <!-- <div style="padding: 0px 12px;border-bottom: 1px "> -->
                        <p style="margin-bottom: 10px;font-size: 14px;">Inventory Management and Sales Team</p>
                        <p style="margin-bottom: 10px;font-size: 14px;">Address:&nbsp;&nbsp;&nbsp;<span>Kolkata</span>
                        </p>
                       <!--  <p style="margin-bottom: 10px;font-size: 14px;">GSTIN-&nbsp;&nbsp;&nbsp;<span>19AADCH4384E1ZI</span></p> -->
                    <!-- </div> -->
                    <!-- <div style="padding: 0px 12px;">
                        <p style="margin-bottom: 10px;font-size: 14px;">KOTAK MAHINDRA BANK,BALLY HIGH BRANCH</p>
                        <p style="margin-bottom: 10px;font-size: 14px;">A/c no.&nbsp;&nbsp;&nbsp;<span>3012013723</span></p>
                        <p style="font-size: 14px;">IFSC CODE:&nbsp;&nbsp;&nbsp;<span>KKBK0000325</span></p>
                    </div> -->
                </div>
                <div class="buyer_address" style="width: 45%;float: left;padding: 12px;border-left: 1px solid #222;">
                    <p style="margin-bottom: 10px;font-size: 14px;">Chalan No :&nbsp;&nbsp;&nbsp;<span><?php echo $chalan_no; ?></span></p>
                    <p style="margin-bottom: 10px;font-size: 14px;">Chalan Date : <?php echo $date;?><span></span></p>
                    <p style="margin-bottom: 10px;font-size: 14px;">Sale Date : <?php echo $s_date;?><span></span></p>
                   <!--  <p style="margin-bottom: 10px;font-size: 14px;">Terms:&nbsp;&nbsp;&nbsp;<span>50% advance</span></p>
                    <p style="font-size: 14px;">Due Date:&nbsp;&nbsp;&nbsp;<span>15 days from date of issuance</span></p> -->
                </div>
            </div>
            <div class="middle_2" style="overflow: auto;">
                <div class="payments_info" style="padding: 5px 10px;border-bottom: 1px solid #222;border-top: 1px solid #222;overflow: auto;">
                    <div class="customerpart" style="width: 50%;float: left;">
                        <p><i>Company Name :</i>&nbsp;&nbsp;&nbsp;<span > <?php echo $company_name; ?></span></p>
                        <p><i>Contact Person  :</i>&nbsp;&nbsp;&nbsp;<span> <?php echo $contact_person; ?></span></p>
                        <p><i>PAN Number :</i>&nbsp;&nbsp;&nbsp;<span class="name_customer"> <?php echo $pan_number; ?></span></p>
                        <p><i>GSTIN Number :</i>&nbsp;&nbsp;&nbsp;<span> <?php echo $gstin_number; ?></span></p>
                    </div>
                    <!-- <div class="customerpart" style="width: 50%;float: left;">
                        <p style="margin: 0;">Contact Person  :&nbsp;&nbsp;&nbsp;<span> <?php echo $contact_person; ?></span></p>
                    </div> -->
                </div>
            </div>
            <div class="buttom_head" style="height: 45px;">
                <div class="e_order" style="padding: 5px 10px;width: 97.5%;">
                    <div class="customerpart" style="width: 50%;float: left;">
                        <p style="margin-left: 10px;"><span class="name_customer" style="width: 245px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;height: 14px;"> <b><i>Product Details :- </i></b></span></p>
                    </div>
                    <!-- <div class="customerpart" style="width: 50%;float: left;">
                        <p style="margin: 0;">GSTIN Number :&nbsp;&nbsp;&nbsp;<span> <?php echo $gstin_number; ?></span></p>
                    </div> -->
                </div>
            </div>
        </div>
        
        <table class="item_table" style="font-size:80%;width: 100%;text-align: center;margin-top: 15px;border-collapse: collapse;">
            <thead style="background: #eee;">
                <tr>
                    <th style="padding: 8px 5px;border-width: 1px 1px 1px 0px;border-color: #222;border-style: solid;">Sl No.</th>
                    <th style="border-width: 1px 1px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;">Product Name</th>
                    <th style="border-width: 1px 1px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;">Part Number </th>
                    <th style="border-width: 1px 1px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;">Description</th>
                    <th style="border-width: 1px 0px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                      $total = 0;
                      $i     = 0;
                      foreach($sell_list['all_list'][$id]['details'] as $list){ 
                        $total  = $total + $list['quantity'];
                        $i      = $i+1;
                ?>
                <tr>
                    <td style="border-width: 1px 1px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;"><?php echo $i;?></td>
                    <td style="border-width: 1px 1px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;"><?php echo $list['product_name'];?></td>
                    <td style="border-width: 1px 1px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;"><?php echo $list['part_number'];?></td>
                    <td style="border-width: 1px 1px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;"><?php echo $list['description'];?></td>
                    <td style="border-width: 1px 0px 1px 0px;border-color: #222;border-style: solid;padding: 8px 5px;"><?php echo $list['quantity'];?></td>
                </tr>
               <?php } ?>
            </tbody>
      
            <tfoot class="note_and">
              
                <tr>
                    <td colspan=4 style="border-width: 1px 1px 0px 0px;border-color: #222;border-style: solid;padding: 8px 5px;text-align: right;"><b>Total Quantity</b></td>
                    <td style="border-width: 1px 0px 0px 1px;border-color: #222;border-style: solid;padding: 8px 5px;"><?php echo $total; ?></td>
                </tr>
            </tfoot>
        </table>

	</div>

</body>
</html>