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
                <div class="col-md-4">
                    <h4 class="card-title">Payment Add</h4>
                    <a class="btn btn-outline-dark" href="<?php echo base_url();?>Payment/Add">Add</a>
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
                                    <th>Voucher Number</th>
                                    <th>Company Name</th>
                                    <th>Invoice Number</th>
                                    <th>Amount Paid</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($payment['stat'] == 200){
                                    foreach($payment['all_list'] as $p){
                            ?>
                                <tr>
                                    <td><?php echo $p['payment_id']; ?></td>
                                    <td><?php echo $p['voucher_number']; ?></td>
                                    <td><?php echo $p['customer_details'][0]['company_name']; ?></td>
                                    <td><?php echo $p['invoice_number']; ?></td>
                                    <td><?php echo $p['amount_paid']; ?></td>
                                    <td><?php echo ($p['payment_type']==1?"Partial Payment":"Full Payment"); ?></td>
                                    <td><?php echo $p['date']; ?></td>
                                    <td>
                                        <button class="btn btn-outline-dark" onclick="GetSinglePayment(<?php echo $p['payment_id']; ?>)">View</button>
                                        <a href='<?php echo base_url();?>Payment/voucher/<?php echo EncryptID($p['payment_id']);?>' target="_blank" ><label class="btn btn-outline-dark">Create Voucher</label></a>
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


  <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Payment Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
             
              <div class="card">
                <div class="card-body">
                                <div class="d-flex justify-content-end">
                                    <span>Invoice No: <b><span id="invoice_number"></span></b></span>
                                    <div style="width:20px"></div>
                                    <span>Voucher No: <b><span id="voucher_number"></span></b></span>
                                    <div style="width:20px"></div>
                                    <span>Payment Amount: <b><span id="amount_paid"></span></b></span><br>
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
                          <h5 class="modal-title" id="ModalLabel">Sell Details</h5>
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th>Sell Amount</th>
                                      <th>Total Discount</th>
                                      <th>Total Tax</th>
                                      <th>Final Amount</th>
                                      <th>Outstanding Amount</th>
                                      <th>Sell Date</th>
                                      <th>Sell Note</th>
                                  </tr>
                              </thead>
                              <tbody id="sale_details">
                              </tbody>
                           </table>
                         </div>
                           <hr>
                        <div class="table-responsive">
                           <h5 class="modal-title" id="ModalLabel">Product Details</h5>
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th>Product Name</th>
                                      <th>Part Number</th>
                                      <th>Price</th>
                                      <th>Discount (%)</th>
                                      <th>Tax (%)</th>
                                      <th>Quantity</th>
                                      <th>Total</th>
                                    
                                  </tr>
                              </thead>
                              <tbody id="product_details">
                              </tbody>
                           </table>
                        </div>
                      
                   
                               
                  </div>     
              </div>
          </div>
      </div>
  </div>