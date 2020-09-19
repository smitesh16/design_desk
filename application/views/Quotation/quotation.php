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
              Quotation List
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
                  <div class="col-md-4">
                      <h4 class="card-title"> Quotation List</h4>
                      <a href="<?php echo base_url().'Quotation/Add_view';?>"><button type="button" class="btn btn-outline-dark"
                              data-whatever="@mdo">Add</button></a>
                      
                  </div>
                 
                    
              </div>

                <hr>

              <div class="row">
                  <div class="col-12">
                      <div class="table-responsive">
                          <table id="order-listing" class="table">
                              <thead>
                                  <tr>
                                      <th>Quotation Id</th>
                                      <th>Client Name</th>
                                      <th>Final Amount</th>
                                      <th>Quotation Date</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php if($quotation_list['stat'] == 200){ 
                                        foreach ($quotation_list['all_list'] as $list) { ?>
                                         <tr>
                                             <td><?php echo $list['quotation_id']; ?></td>         
                                             <td><?php echo $list['company_name']; ?></td>         
                                             <td><?php echo $list['final_amount']; ?></td>            
                                             <td><?php echo $list['quotation_date']; ?></td>
                                             <td class="">
                                                <button class="btn btn-outline-dark"
                                                    onclick="GetSingleSell(<?php echo $list['quotation_id'];?>,2)">View</button>

                                                <a href='<?php echo base_url();?>Quotation/invoice/<?php echo EncryptID($list['quotation_id']);?>' target='_blank'><button class="btn btn-outline-dark">Quotation Invoice</button></a>
                                                
                                                <a href='javascript:void(0)' onclick="add_quotation_sell(<?php echo $list['quotation_id']; ?>)"><button class="btn btn-outline-dark">Sell</button></a>
                                                 
                                                <a href='<?php echo base_url();?>Quotation/edit_view/<?php echo EncryptID($list['quotation_id']);?>'><button class="btn btn-outline-dark">Edit</button></a>

                                                <a href='javascript:void(0)' onclick="delete_quotation(<?php echo $list['quotation_id']; ?>)"><button class="btn btn-outline-dark">Delete</button></a>


                                             

                                            </td>
                                           
                                         </tr>           
                                <?php } } ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>


  <div class="modal fade" id="sellModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Quotation Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
             
              <div class="card">
                 <div class="card-body">
                              
                                <div class="d-flex justify-content-end">
                                    <span>Quotation No: <b><span id="inv"></span></b></span>
                                    <div style="width:20px"></div>
                                    <span>Total Amount: <b><span id="amt"></span></b></span><br>
                                  
                                </div>
                            
                                <hr> 
                         <div class="table-responsive">
                          <h5 class="modal-title" id="ModalLabel">Company Details</h5>
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
                              <tbody id="com_list">
                              </tbody>
                           </table>
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
                              <tbody id="pro_list">
                              </tbody>
                           </table>
                          
                        
                        </div>
                      </div>
                   
                               
                  </div>     
              </div>
          </div>
      </div>
  </div>

