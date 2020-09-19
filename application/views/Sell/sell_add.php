  <style>
.ajax-file-upload-container:empty {
    display: none;
}

.ajax-upload-dragdrop {
    width: 100% !important;
}

/*input[type="text"], textarea {

  background-color : lightgrey; 
  border-color:black;

}*/
  </style>

  <div class="content-wrapper">
      <div class="page-header">
          <h3 class="page-title">
              Sale Add
          </h3>
          <!-- <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data table</li>
              </ol>
              
            </nav> -->
      </div>
      <div class="card">
          <div class="card-body">
              <div class="row">
                  <div class="col-md-3">
                      <h4 class="card-title">Client List</h4>

                      <select class="js-example-basic-single" style="width:100%" id="client">
                          <option selected disabled value=0>Select an Option</option>
                          <?php if($client_list['stat'] == 200)
                          {
                            foreach($client_list['all_list'] as $list){ ?>
                          <option value="<?php echo $list['client_id'];?>"><?php echo $list['company_name'];?></option>
                          <?php } } ?>
                      </select>
                     
                  </div>
                  <div class="col-md-2 text-right">
                    <h4 class="card-title">Add Customer</h4>
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#addModal"
                          data-whatever="@mdo" ><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </div>
                  <div class="col-md-4">
                      <h4 class="card-title">Product List</h4>

                      <select class="js-example-basic-single" style="width:100%" id="product">
                          <option selected disabled value=0>Select an Option</option>
                          <?php if($product_list['stat'] == 200)
                          {
                            foreach($product_list['all_list'] as $list){ 
                              if($list['current_stock'] > 0) { ?>
                          <option value="<?php echo $list['product_id'];?>"><?php echo $list['part_number'];?></option>
                          <?php } } } ?>
                      </select>
                      <span id="message"></span>
                  </div>
                  <div class="col-md-2 text-right">
                  <h4 class="card-title">&#160;</h4>
                      <button type="button" class="btn btn-outline-dark" onclick="show()">Add</button>
                  </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12" >
                  <h4 class="card-title">Sale Note</h4>
                  <textarea class="form-control ckeditor" id="sale_note"></textarea>
                   
                </div>
              </div>
              <br>

              <div class="row" style="display:none" id="product_list">
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

                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

             <!--  <div class="row" id="client_sell_list" style="display:none">
                  <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">


                              <div class="table-responsive">
                                
                                      <table class="table" id="myTable">
                                          <thead>
                                              <tr>
                                                  <th>Product Id</th>
                                                  <th>Product Name</th>
                                                  <th>Original Price</th>
                                                  <th>Discount</th>
                                                  <th>Tax</th>
                                                  <th>Selling Price</th>
                                                  <th>Qty</th>
                                                  <th>Sub Total</th>
                                                  <th>Action</th>
                                              </tr>
                                          </thead>

                                          <tbody id="p_list">



                                          </tbody>
                                      </table>
                                      
                                  
                              </div>
                          </div>
                      </div>
                  </div>
              </div> -->


              <div class="row" id="result_list" style="display:none">
                  <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">

                               <h4 class="card-title">Total List</h4>
                              <div class="table-responsive">
                                  <!--  <form action="<?php echo base_url();?>Sell/Add_product" method="POST">  -->
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
                                     <button type="button" class="btn btn-outline-success btn-sm"
                                          onclick="submit_product(1)">Submit</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Customer Add</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="<?php echo base_url();?>Customer/Add" method='POST'>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Company Name:</label>
                                  <input maxlength="100" type="text" class="form-control company" name="company_name"
                                      required>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="message-text" class="col-form-label">Company Address:</label>
                                  <textarea maxlength="300" class="form-control" name="company_address"
                                      required></textarea>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Contact Person:</label>
                                  <input maxlength="100" type="text" class="form-control onlyChar" name="contact_person"
                                      required>
                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Contact Number:</label>
                                  <input type="text" class="form-control onlynum" name="contact_number" maxlength=10
                                      required>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">PAN Number:</label>
                                  <input type="text" class="form-control onlynumchar" name="pan_number" maxlength=10
                                      required>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">GSTIN Number:</label>
                                  <input type="text" class="form-control onlynumchar" name="gstin_number" maxlength=15
                                      required>
                              </div>
                          </div>
                          <input type="hidden" name=type value='sell_1'>
                      </div>

                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-outline-success">SUBMIT</button>
                      <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                  </div>
              </form>
          </div>
      </div>
  </div>