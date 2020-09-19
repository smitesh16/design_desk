<!DOCTYPE html>
<html>
<head>
    <title>IMAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body style="font-family: Arial, sans-serif">

<?php 
   // print_r($payment);die;
    if($payment['stat'] == 200){ 
        foreach($payment['all_list'] as $pay){

    ?> 
    <div id="page-wrap" class="proforma_section" style="width: 750px;margin: 0 auto;border: 1px solid #222;box-shadow: 0 0 10px rgba(0, 0, 0, 0.52)">

		<div class="proforma_head">
            <div class="new_name" style="height: 25px;display: -webkit-flex;display: flex;-webkit-align-items: center;align-items: center;-webkit-justify-content: center;justify-content: center;margin: 10px 0;padding-bottom: 10px;border-bottom: 1px solid #222;margin-bottom: 0;">
                <div class="p_name">
                    <h5 style="font-size: 30px;font-weight: normal;text-transform: capitalize;">VOUCHER</h5>
                </div>
            </div>
            <div class="top_head" style="padding: 10px;width: 97.6%;border-bottom: 1px solid #222;">
                <div class="company_stamp" style="width: 50%;margin: 0 auto;">
                    <h5 style="font-size: 22px;font-weight: normal;text-transform: capitalize;text-align:center;margin:0px">Inventory Management</h5>
                </div>
            </div>
            <div class="middle" style="overflow: auto;">
                <div class="buyer_address" style="width: 45%;float: left;padding: 12px;">
                    <p><i>Company Name :</i>&nbsp;&nbsp;&nbsp;<span > <?php echo $pay['customer_details'][0]['company_name']; ?></span></p>
                        <p><i>Contact Person  :</i>&nbsp;&nbsp;&nbsp;<span> <?php echo $pay['customer_details'][0]['contact_person']; ?></span></p>
                        <p><i>PAN Number :</i>&nbsp;&nbsp;&nbsp;<span class="name_customer"> <?php echo $pay['customer_details'][0]['pan_number']; ?></span></p>
                        <p><i>GSTIN Number :</i>&nbsp;&nbsp;&nbsp;<span> <?php echo $pay['customer_details'][0]['gstin_number']; ?></span></p>
                        <p><i>Company Address :</i>&nbsp;&nbsp;&nbsp;<span> <?php echo $pay['customer_details'][0]['company_address']; ?></span></p>
                </div>
                <div class="buyer_address" style="width: 45%;float: left;padding: 12px;border-left: 1px solid #222;">
                    <p style="margin-bottom: 10px;font-size: 14px;">Voucher Number :&nbsp;&nbsp;&nbsp;<span><?php echo $pay['voucher_number']; ?></span></p>
                    <p style="margin-bottom: 10px;font-size: 14px;">Date : <?php echo $pay['date'];?><span></span></p>
                    <p style="margin-bottom: 10px;font-size: 14px;">Bill Number : <?php echo $pay['invoice_number'];?><span></span></p>
                    <p style="margin-bottom: 10px;font-size: 14px;">Bill Date : <?php echo $pay['sale_details'][0]['sell_date'];?><span></span></p>
                </div>
            </div>
            <div class="middle_2" style="overflow: auto;">
                <div class="payments_info" style="padding: 5px 10px;border-bottom: 1px solid #222;border-top: 1px solid #222;overflow: auto;">
                    <div class="customerpart" style="width: 50%;float: left;">
<!--
                        <p><i>Total Bill :</i>&nbsp;&nbsp;&nbsp;<span > <?php echo $pay['sale_details'][0]['final_amount']; ?></span></p>
                        <p><i>Outstanding Amount  :</i>&nbsp;&nbsp;&nbsp;<span> <?php echo $pay['sale_details'][0]['final_amount'] - $pay['total_paid']; ?></span></p>
-->
                        <p><i>Amount Paid  :</i>&nbsp;&nbsp;&nbsp;<span> <?php echo $pay['amount_paid']; ?></span></p>
                        <p><i>Due :</i>&nbsp;&nbsp;&nbsp;<span class="name_customer"> <?php echo $pay['sale_details'][0]['outstanding_amount']; ?></span></p>
                    </div>
                </div>
            </div>
            <div class="middle_2" style="overflow: auto;">
                <div class="payments_info" style="padding: 5px 10px;border-bottom: 1px solid #222;border-top: 1px solid #222;overflow: auto;">
                    <div class="customerpart" style="width: 50%;float: left;">
                        <p><i>Remarks :</i>&nbsp;&nbsp;&nbsp;<span > <?php echo $pay['remarks']; ?></span></p>
                    </div>
                </div>
            </div>
            <div class="buttom_head" style="height: 45px;">
                <div class="e_order" style="padding: 5px 10px;width: 97.5%;">
                    <div class="customerpart" style="width: 50%;float: left;">
                        <p style="margin-left: 10px;"><span class="name_customer" style="display: inline-block;width: 245px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;height: 14px;"> <b><i>Signature </i></b></span></p>
                    </div>
                </div>
            </div>
        </div>
	</div>

    <?php
         }
    }
    ?>
</body>
</html>