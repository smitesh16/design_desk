<!-- partial -->
<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            Payment
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label for="exampleFormControlSelect2">Client</label>
                            <select class="js-example-basic-single" style="width:100%" id="client" onchange="client_wise_inv(this.value);">
                                <option value="" selected disabled>Select Client</option>
                                <?php
                            if($client['stat'] == 200){
                                foreach($client['all_list'] as $c){
                         ?>
                                <option value="<?php echo $c['client_id']; ?>"><?php echo $c['company_name']; ?>
                                </option>
                                <?php
                                }
                            }
                         ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="exampleFormControlSelect2">Invoice</label>
                            <select class="js-example-basic-single" style="width:100%" id="sell_id">
                                <option value="" selected disabled>Select Invoice</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <button type="button" class="btn btn-outline-dark" onclick="invoice_choose();">Add</button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive" id="choosing_invoice" style="display:none;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Total</th>
                                <th>Outstanding</th>
                                <th>Pay</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="choosing_tbody">
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-hover">
                        <tbody id="totalInvoiceDetails">
                        </tbody>
                    </table>
                    <hr>
                    <button type="button" class="btn btn-outline-success" onclick="payment();">Payment</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->