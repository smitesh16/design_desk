  <div class="content-wrapper">
      <div class="page-header">
          <h3 class="page-title">
              Category List
          </h3>
      </div>
      <div class="card">
          <div class="card-body">
              <div class="row">
                  <div class="col-md-4">
                      <h4 class="card-title">Category List</h4>
                      <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#addModal"
                          data-whatever="@mdo">Add</button>
                  </div>
                  <!-- <div class="col-md-8">
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
                          <table id="order-listing2" class="table">
                              <thead>
                                  <tr>
                                      <th>Category Id</th>
                                      <th>Category Name</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php if($category_data['stat'] == 200) { 
                             foreach($category_data['all_list'] as $list) { 

                        ?>
                                  <tr>
                                      <td><?php echo $list['category_id'];?> </td>
                                      <td><?php echo $list['category'];?></td>
                                      <td>
                                              <button class="btn btn-outline-dark"
                                              onclick="GetSingleData(<?php echo $list['category_id'];?> ,'<?php echo base64_encode('category')?>','edit')">Edit</button>

                                              <button class="btn btn-outline-dark"
                                              onclick="DeleteData(<?php echo $list['category_id'];?> ,'<?php echo base64_encode('category')?>')">Delete</button>


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
                  <h5 class="modal-title" id="ModalLabel">Category Add</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="<?php echo base_url();?>Category/Add" method='POST'>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Category Name:</label>
                                  <input maxlength="100" type="text" class="form-control" name="category"
                                      required>
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
                  <h5 class="modal-title view_name" id="ModalLabel">Category Edit</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="<?php echo base_url();?>Category/Edit" method='POST'>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Category Name:</label>
                                  <input maxlength="100" type="text" class="form-control" name="category" id="category"
                                      required>
                              </div>
                          </div>
                          
                      <input type=hidden id="category_id" name="category_id">
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