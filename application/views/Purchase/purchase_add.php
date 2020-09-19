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
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label for="exampleFormControlSelect2">Purchase Number</label>
                            <input type="text" maxlength="100" class="lengthValidation form-control"
                                id="purchase_number">
                        </div>
                        <div class="col-md-5">
                            <label for="exampleFormControlSelect2">Part Number</label>
                            <select class="js-example-basic-single" style="width:100%" id="product">
                                <option value="" selected disabled>Select Product</option>
                                <?php
                            if($product['stat'] == 200){
                                foreach($product['all_list'] as $p){
                         ?>
                                <option value="<?php echo $p['product_id']; ?>"><?php echo $p['part_number']; ?>
                                </option>
                                <?php
                                }
                            }
                         ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <button type="button" class="btn btn-outline-dark" onclick="product_choose();">Add</button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group row">
                    <div class="col-md-12" >
                      <h4 class="card-title">Purchase Note</h4>
                      <textarea class="form-control ckeditor" id="purchase_note"></textarea>
                    </div>
                  </div>
                </div>
                
                <div class="table-responsive" id="choosing_product" style="display:none;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="choosing_tbody">
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-hover">
                        <tbody id="totalProductDetails">
                        </tbody>
                    </table>
                    <hr>
                    <button type="button" class="btn btn-outline-success" onclick="place_order();">Place Order</button>
                </div>
                <!--<div class="table-responsive" id="submit_product" style="display:none;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="submit_tbody">
                        </tbody>
                   
                    </table>
                    <hr>
                    <button type="button" class="btn btn-success" onclick="place_order();">Place Order</button>
                </div>-->
                
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->