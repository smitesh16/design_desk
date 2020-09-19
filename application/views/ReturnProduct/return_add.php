<!-- partial -->
<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            Return
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label for="exampleFormControlSelect2">Invoice</label>
                            <select class="js-example-basic-single" style="width:100%" id="sell_id" onchange="sell_wise_product(this.value);">
                                <option value="" selected disabled>Select Invoice</option>
                                <?php
                            if($sell['stat'] == 200){
                                foreach($sell['all_list'] as $s){
                         ?>
                                <option value="<?php echo $s['sell_id']; ?>"><?php echo $s['invoice_number']; ?>
                                </option>
                                <?php
                                }
                            }
                         ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="exampleFormControlSelect2">Product</label>
                            <select class="js-example-basic-single" style="width:100%" id="product_id">
                                <option value="" selected disabled>Select Product</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <button type="button" class="btn btn-outline-dark" onclick="return_product_choose();">Add</button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive" id="choosing_return_product" style="display:none;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Product Quantity</th>
                                <th>Return Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="choosing_tbody">
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-hover">
                        <tbody id="totalReturnDetails">
                        </tbody>
                    </table>
                    <hr>
                    <button type="button" class="btn btn-outline-success" onclick="return_submit();">Return</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->