  <div class="content-wrapper">
      <div class="page-header">
          <h3 class="page-title">
              Analytics List
          </h3>
      </div>
      <div class="card">
          <div class="card-body">
          <!--    <div class="row">
                  <div class="col-md-4">
                      <h4 class="card-title">Analytics List</h4>
                      <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#addModal"
                          data-whatever="@mdo">Add</button>
                  </div>
                   <div class="col-md-8">
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
                  </div> 
              </div>

                <hr>-->

              <div class="row">
                  <div class="col-12">
                      <div class="table-responsivesdsd">
                          <table id="order-listing2" class="table" data-toggle="table" data-sort-name="id" data-sort-order="desc">
                              <thead>
                                  <tr>
                                      <th data-field="id">Analytics Id</th>
                                      <th>IP Address</th>
                                      <th>Location</th>
                                      <th>Register User ?</th>
                                      <th>Date</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php if($analytics_data['stat'] == 200) { 
                                          // foreach($analytics_data['all_list'] as $list) { 
                                      for($i = 0; $i<count($analytics_data['all_list']); $i++){
                                        $list = $analytics_data['all_list'][$i];
                                  ?>
                                  <tr>
                                      <td><?php echo $list['analytics_id'];?> </td>
                                      <td><?php echo $list['ip_address'];?></td>
                                      <td><?php echo $list['location'];?></td>
                                      <td><?php if($list['client_ip_address'] === null || $list['client_ip_address'] == '') echo "-"; else echo $list['user_email']; ?></td>
                                      <td><?php echo date("d-m-Y", strtotime($list['entry_date']));?></td>

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
