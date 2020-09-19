  <div class="content-wrapper">
      <div class="page-header">
          <h3 class="page-title">
              Access code List
          </h3>
      </div>
      <div class="card">
          <div class="card-body">
              <div class="row">
                  <div class="col-md-4">
                      <h4 class="card-title">Access Code List</h4>
                      <a href="<?php echo base_url();?>Manage_accesscode/Generate">
                        <button type="button" class="btn btn-outline-dark">Generate Access Code</button>
                      </a>
                  </div>
             <!--      <div class="col-md-8">
                      <h4 class="card-title">CSV Bulk Upload &#160;<small><a href="<?php echo base_url();?>assets/csv/customer.csv" download="customer.csv"><i class="mdi mdi-arrow-down"></i>Demo CSV File</a></small></h4> 
                      <form method="post" enctype="multipart/form-data"
                          action='<?php echo base_url();?>Customer/CSVUpload'>

                          <div class="d-flex">
                              <input type="file" class="form-control file-upload-info" placeholder="Upload Image"
                                  name="csv_file" id="csv_file" accept=".csv" required>
                              <div style="width:20px"></div>
                              <button class="file-upload-browse btn btn-outline-success" type="submit">Upload</button>
                          </div>
                      </form>
                  </div> -->
              </div>

                <hr>

              <div class="row">
                  <div class="col-12">
                      <div class="table-responsive">
                          <table id="order-listing" class="table">
                              <thead>
                                  <tr>
                                      <th>Access code Id</th>
                                      <th>Access Code</th>
                                      <th>Assign To</th>
                                      <th>Date</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php if($accesscode_data['stat'] == 200) { 
                             foreach($accesscode_data['all_list'] as $list) { 

                        ?>
                                  <tr>
                                      <td><?php echo $list['accesscode_id'];?> </td>
                                      <td><?php echo $list['accesscode'];?></td>
                                      <td><?php if($list['assign_to'] != "") echo $list['assign_to']; else { ?><button type="button" class="btn btn-outline-dark" onclick="ShowAssignModal(<?php echo $list['accesscode_id'];?>);">Assign </button> <?php } ?></td>
                                      <td><?php echo date("d-m-Y", strtotime($list['created_at']));?></td>
                                      <td>
                                        <button class="btn btn-outline-dark"
                                            onclick="DeleteData(<?php echo $list['accesscode_id']?>,'<?php echo base64_encode('accesscode')?>')">Delete</button>
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

  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Assign Code</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="<?php echo base_url();?>Manage_accesscode/Update" method='POST'>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Email Address:</label>
                                  <input maxlength="100" type="text" class="form-control onlyemail" name="assign_to" id="assign_to"
                                      required>
                                      <input type=hidden id="accesscode_id" name="accesscode_id">
                                      <input type=hidden id="table_attribute" name="table_attribute" value="<?php echo base64_encode('accesscode');?>">
                                      <span id="assign_toError" style="color: red"></span>
                              </div>
                          </div>
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




  <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title view_name" id="ModalLabel">Customer Edit</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="<?php echo base_url();?>Customer/Edit" method='POST'>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">User Name:</label>
                                  <input maxlength="100" type="text" class="form-control company" name="user_name" id="user_name"
                                      required>
                              </div>
                          </div>
                          
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">User Email:</label>
                                  <input maxlength="100" type="text" class="form-control onlyemail" name="user_email" id="user_email"
                                      required>
                                      <span id="user_emailError" style="color: red"></span>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Contact Number:</label>
                                  <input type="text" class="form-control onlynum" name="contact_number" id="contact_number" maxlength=10 
                                      required>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="message-text" class="col-form-label">User Address:</label>
                                  <textarea maxlength="300" class="form-control" name="user_address" id="user_address"
                                      required></textarea>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">PAN Number:</label>
                                  <input type="text" class="form-control onlynumchar" name="pan_number" id="pan_number" maxlength=10
                                      required>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">GSTIN Number:</label>
                                  <input type="text" class="form-control onlynumchar" name="gstin_number" id="gstin_number" maxlength=15
                                      required>
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Change Status:</label>
                                  <select class="form-control" name="active_status" id="active_status">
                                    <option value="0">Block</option>
                                    <option value="1">Active</option>
                                  </select>
                              </div>
                          </div>
                      <input type=hidden id="client_id" name="client_id">
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-outline-success" id="edit_button">SUBMIT</button>
                      <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                  </div>
              </form>
          </div>
      </div>
  </div>

  <script type="text/javascript">
    function ShowAssignModal(id){
      $("#accesscode_id").val(id);
      $('#addModal').modal('show');
    }
  </script>