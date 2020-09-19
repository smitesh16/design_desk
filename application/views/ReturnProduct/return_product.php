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
                <div class="col-md-4">
                    <h4 class="card-title">Return Add</h4>
                    <a class="btn btn-outline-dark" href="<?php echo base_url();?>ReturnProduct/Add">Add</a>
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
                                    <th>Invoice Number</th>
                                    <th>Company Name</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($return['stat'] == 200){
                                    foreach($return['all_list'] as $r){
                            ?>
                                <tr>
                                    <td><?php echo $r['return_no']; ?></td>
                                    <td><?php echo $r['sale_details'][0]['invoice_number']; ?></td>
                                    <td><?php echo $r['customer_details'][0]['company_name']; ?></td>
                                    <td><?php echo $r['date']; ?></td>
                                    <td>
                                        <button class="btn btn-outline-dark" onclick="GetSingleReturn(<?php echo $r['return_no']; ?>)">View</button>
                                        <a href='<?php echo base_url();?>ReturnProduct/credit_note/<?php echo EncryptID($r['return_no']);?>' target="_blank" ><label class="btn btn-outline-dark">Create Credit Note</label></a>
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


  <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Return Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
             
              <div class="card">
                <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <span>Invoice No: <b><span id="invoice_number"></span></b></span>
                            <div style="width:20px"></div>
                            <span>Total Amount: <b><span id="return_amount"></span></b></span><br>
                        </div>
                        <hr> 
                         <div class="table-responsive">
                          <h5 class="modal-title" id="ModalLabel">Customer Details</h5>
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th>Company Name</th>
                                      <th>Company Address</th>
                                      <th>Contact Person</th>
                                      <th>Contact Number</th>
                                      <th>GSTIN Number</th>
                                      <th>PAN Number</th>
                                  </tr>
                              </thead>
                              <tbody id="customer_details">
                              </tbody>
                           </table>
                         </div>
                           <hr>
                        <div class="table-responsive">
                          <h5 class="modal-title" id="ModalLabel">Product Details</h5>
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th>Sl No.</th>
                                      <th>Product Name</th>
                                      <th>Part Number</th>
                                      <th>Price</th>
                                      <th>Discount (%)</th>
                                      <th>Tax (%)</th>
                                      <th>Returned Quantity</th>
                                      <th>Return Amount</th>
                                  </tr>
                              </thead>
                              <tbody id="product_details">
                              </tbody>
                           </table>
                         </div>
                           <hr>       
                  </div>     
              </div>
          </div>
      </div>
  </div>