  <style>
.ajax-file-upload-container:empty {
    display: none;
}

.ajax-upload-dragdrop {
    width: 100% !important;
}
  </style>

  <div class="content-wrapper">
      <div class="page-header">
          <h3 class="page-title">
              Quotation Edit
          </h3>
          <?php if($quotation_list['stat'] == 200){ 
                 $q_note =  $quotation_list['all_list'][$id]['quotation_note'];
            ?>

           <!-- <input type="hidden" id="quotation_id" value="<?php echo $quotation_list['all_list'][$id]['quotation_id']; ?>">
           <input type="hidden" id="q_num" value="<?php echo $quotation_list['all_list'][$id]['quotation_number']; ?>"> -->
           <textarea id="ids" style="display:none"><?php echo json_encode($quotation_list['all_list'][$id]);?></textarea>

         <?php }  ?>

      </div>
      <div class="card">
          <div class="card-body">
              <div class="row">
                  <div class="col-md-3">
                      <h4 class="card-title">Client Name</h4>
                   
                      <select class="js-example-basic-single" style="width:100%" id="client">
                          <option selected disabled value=0>Select an Option</option>
                          <?php if($client_list['stat'] == 200)
                          {
                            foreach($client_list['all_list'] as $list)
                            { 

                              if($quotation_list['all_list'][$id]['client_id'] == $list['client_id']){
                                
                           ?>
                          <option value="<?php echo $list['client_id'];?>" selected ><?php echo $list['company_name'];?></option>
                          <?php } } } ?>
                      </select>
                     
                  </div>
                 
                  <div class="col-md-4">
                      <h4 class="card-title">Product List</h4>

                      <select class="js-example-basic-single" style="width:100%" id="product">
                          <option selected disabled value=0>Select an Option</option>
                          <?php if($product_list['stat'] == 200)
                          {
                            foreach($product_list['all_list'] as $list){ 
                              if($list['current_stock']) { ?>
                          <option value="<?php echo $list['product_id'];?>"><?php echo $list['part_number'];?></option>
                          <?php } } } ?>
                      </select>
                      <span id="message"></span>
                  </div>
                  <div class="col-md-2 text-right">
                  <h4 class="card-title">&#160;</h4>
                      <button type="button"  class="btn btn-outline-dark add" onclick="show()">Add</button>
                  </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12" >
                  <h4 class="card-title">Quotation Note</h4>
                  <textarea class="form-control ckeditor" id="sale_note" ><?php echo $q_note;?></textarea>
                   
                </div>
              </div>
              <br>

              <div class="row" id="product_list">
                  <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">
                              <h4 class="card-title">Product List</h4>

                              <div class="table-responsive">
                                  <table class="table">
                                      <thead>
                                          <tr>
                                              <th>Product Name</th>
                                              <th>Part Number</th>
                                              <th>Default Price</th>
                                              <th>Price</th>
                                              <th>Discount(%)</th>
                                              <th>Tax(%)</th>
                                              <th>Qty Remaining</th>
                                              <th>Qty</th>
                                              <th>Amount</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody id="list">
                                        <?php if($quotation_list['stat'] == 200){ 
                                               foreach($quotation_list['all_list'][$id]['details'] as $list) { 
                                                $name = $list['product_name'];
                                                
                                                   ?>
                                                 <tr id='product_list_<?php echo $list['product_id'];?>'>
                                                     <td><?php echo $list['product_name'];?></td>
                                                     <td><?php echo $list['part_number'];?></td>
                                                     <td><?php echo $list['default_price'];?></td>
                                                     <td><input type="text" class="twoDecimalNumber form-control" id="price_<?php echo $list['product_id'];?>" onkeyup="product_sell()" maxlength=10 required value="<?php echo $list['price'];?>"><span id="msg1_<?php echo $list['product_id'];?>"></span></td>
                                                     <td><input type="text" class="percent twoDecimalNumber form-control" id="discount_<?php echo $list['product_id'];?>" onkeyup="product_sell()" value="<?php echo $list['discount'];?>"><span id="msg2_<?php echo $list['product_id'];?>"></span></td>
                                                     <td><input type="text" class="percent twoDecimalNumber form-control" id="tax_<?php echo $list['product_id'];?>" value="<?php echo $list['tax'];?>" onkeyup="product_sell()"><span id="msg3_<?php echo $list['product_id'];?>"></span></td>
                                                     <td><?php echo $list['current_stock'];?></td>
                                                     <td><input type="text" class="onlynum lengthValidation form-control " id="quantity_<?php echo $list['product_id'];?>" maxlength=10 onkeyup="product_sell()" value="<?php echo $list['quantity'];?>"><br><span id="message1_<?php echo $list['product_id'];?>"></span></td>
                                                     <td><span id="amt_<?php echo $list['product_id'];?>"></span></td>
                                                     <td><button type="button"  class="btn btn-outline-dark btn-sm" onclick="remove_product(<?php echo $list['product_id'];?>)">Remove</button><input type="hidden" id="stock_<?php echo $list['product_id'];?>" value="<?php echo $list['current_stock'];?>"><input type="hidden" id="name_<?php echo $list['product_id'];?>" value="<?php echo $name; ?>"><input type="hidden" id="part_num_<?php echo $list['product_id'];?>" value="<?php echo $list['part_number']; ?>"></td>
                                                </tr>
                                          <?php       
                                               } ?>
                                              
                                         <?php   }
                                         ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

            


              <div class="row" id="result_list" >
                  <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">

                               <h4 class="card-title">Total List</h4>
                              <div class="table-responsive">
                                      <table class="table table-striped" id="resultTable">
                                          <thead>
                                              <tr>
                                                  <th>Items</th>
                                                  <th>Total Price</th>
                                                  <th>Total discount</th>
                                                  <th>Total tax</th>
                                                  <th>Total Quantity</th>
                                                  <th>Grand Total</th>
                                                  
                                              </tr>
                                          </thead>

                                          <tbody id="r_list">
                                              <tr>
                                                <td>1</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0</td>
                                                <td>0.00</td>
                                              </tr>


                                          </tbody>
                                      </table>
                                      <hr>
                                     <button type="button"  class="btn btn-outline-dark btn-sm"
                                          onclick="submit_product()">Submit</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </div>
   