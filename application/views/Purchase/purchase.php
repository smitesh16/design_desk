<!-- partial -->
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Purchase
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="card-title">Purchase Single Add</h4>
                    <a class="btn btn-outline-dark" href="<?php echo base_url();?>Purchase/Add">Add</a>
                </div>
                <div class="col-md-8">
                    <h4 class="card-title">CSV file upload &#160;<small><a href="<?php echo base_url();?>assets/csv/purchase.csv" download="purchase.csv"><i class="mdi mdi-arrow-down"></i>Demo CSV File</a></small> </h4>
                    <form method="post" enctype="multipart/form-data"
                        action="<?php echo base_url(); ?>Purchase/csv_upload">

                        <div class="d-flex">
                                <input type="file" name="purchase_csv" class="form-control file-upload-info">
                                <div style="width:20px"></div>
                                <button type="submit"  class="file-upload-browse btn btn-outline-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Purchase Number</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Note</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($purchase['stat'] == 200){
                                    foreach($purchase['all_list'] as $p){
                            ?>
                                <tr>
                                    <td><?php echo $p['purchase_id']; ?></td>
                                    <td><?php echo $p['purchase_number']; ?></td>
                                    <td><?php echo $p['total_amount']; ?></td>
                                    <td><?php echo $p['date']; ?></td>
                                    <td><?php echo $p['purchase_note']; ?></td>
                                    <td>
                                        <button class="btn btn-outline-dark"
                                            onclick="GetSinglePurchase(<?php echo $p['purchase_id']?>)">View</button>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                          ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Purchase Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">
                <div class="card-body">

                                <div class="d-flex justify-content-end">
                                    <span>Order No: <b id="purchase_number"></b></span>
                                    <div style="width:20px"></div>
                                    <span>Total Amount: <b id="total_amount"></b></span>
                                </div>

                                <hr> 

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Part Number</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="purchase_details_tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>