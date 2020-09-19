<?php
    if($dashboard['stat'] == 200){
?>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                Dashboard

            </h3>

        </div>
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger border-0 text-white p-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <i class="mdi mdi-cards-outline mdi-48px"></i>
                            <div class="ml-4">
                                <h2 class="mb-2"><?php echo ($dashboard['all_list']['total'][0]['total_purchase'] == '' || $dashboard['all_list']['total'][0]['total_purchase'] == null)?0:$dashboard['all_list']['total'][0]['total_purchase']; ?></h2>
                                <h4 class="mb-0">Total Product</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info border-0 text-white p-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <i class="mdi mdi-chart-line mdi-48px"></i>
                            <div class="ml-4">
                                <h2 class="mb-2"><?php echo ($dashboard['all_list']['total'][0]['total_sell'] == '' || $dashboard['all_list']['total'][0]['total_sell'] == null)?0:$dashboard['all_list']['total'][0]['total_sell']; ?></h2>
                                <h4 class="mb-0">Total Enquiry</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success border-0 text-white p-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <i class="mdi mdi-currency-usd mdi-48px"></i>
                            <div class="ml-4">
                                <h2 class="mb-2"><?php echo ($dashboard['all_list']['total'][0]['total_payment'] == '' || $dashboard['all_list']['total'][0]['total_payment'] == null)?0:$dashboard['all_list']['total'][0]['total_payment']; ?></h2>
                                <h4 class="mb-0">Total Viewers</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 d-flex align-items-stretch">
                <div class="row flex-grow-1 w-100">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 style="float:left" class="card-title">Products (Minimum Stock)</h4>
                                <a style="float:right" class="btn  btn-outline-success btn-sm" href=<?php echo base_url();?>Product>View</a>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Part Number
                                                </th>
                                                <th>
                                                    Igst
                                                </th>
                                                <th>
                                                    Default Price
                                                </th>
                                                <th>
                                                    Current Stock
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                               if(!empty($dashboard['all_list']['top_product'])) { 
                                                foreach($dashboard['all_list']['top_product'] as $top_product){
                                            ?>
                                            <tr>
                                                <td><?php echo $top_product['product_name']; ?></td>
                                                <td><?php echo $top_product['part_number']; ?></td>
                                                <td><?php echo $top_product['igst']; ?></td>
                                                <td><?php echo $top_product['default_price']; ?></td>
                                                <td><?php echo $top_product['current_stock']; ?></td>
                                            </tr>
                                            <?php } } else { ?>
                                            <tr>
                                                <td colspan=5 style="text-align:center"> No Data </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


        </div>
     </div>

 </div>
</div>

<?php } ?>


