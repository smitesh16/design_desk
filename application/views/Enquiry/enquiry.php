  <div class="content-wrapper">
      <div class="page-header">
          <h3 class="page-title">
              Enquiry List
          </h3>
      </div>
      <div class="card">
          <div class="card-body">
             <!--  <div class="row">
                 <div class="col-md-4">
                      <h4 class="card-title">Enquiry List</h4>
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
                      <div class="table-responsive">
                          <table id="order-listing2" class="table">
                              <thead>
                                  <tr>
                                      <th>Enquiry Id</th>
                                      <th>Enquiry By</th>
                                      <th>Enquiry For</th>
                                      <th>Enquiry Date</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php if($enquiry_data['stat'] == 200) { 
                                          foreach($enquiry_data['data'] as $list) { 

                        ?>
                                              <tr>
                                                  <td><?= $list['enquiry_id']; ?></td>
                                                  <td><p>Name : <?php echo $list['user_name'];?></p><p>Email : <?php echo $list['user_email'];?></p><p>Phone : <?php echo $list['contact_number'];?></p><p>Address : <?php echo $list['user_address'];?></p> </td>
                                                  <td>
                                                    <?php
                                                        foreach ($list['Details'] as $details) {
                                                      ?>
                                                          <p><?= $details['product_name']."(".$details['part_number'].")"." (".$details['product_quantity']."pcs)" ?>
                                                          <span onclick="GetSingleData(<?php echo $details['product_id']?>,'<?php echo base64_encode('product')?>','view')" title="View Product"><i class="fa fa-eye"></i></span><br><?php echo $details['comment']?></p>
                                                      <?php
                                                        }
                                                      ?>
                                                      
                                                  </td>
                                                  <td><?php echo date("d-m-Y", strtotime($list['enquiry_date']));?></td>

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

  <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title view_name" id="ModalLabel">Product Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url(); ?>General/EditData" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Product Name:</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Product Code:</label>
                                <input type="text" maxlength="100" class="lengthValidation form-control" name="part_number" id="part_number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Category:</label>
                                <select class="form-control categorySelect" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <?php
                                        for($i = 0; $i<count($category['all_list']); $i++){
                                    ?>
                                        <option value="<?=$category['all_list'][$i]['category']?>" data-val="<?=$category['all_list'][$i]['category_id']?>"><?=$category['all_list'][$i]['category']?></option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" class="form-control category_id" id="category_id" name="category_id" required>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Description:</label>
                                <textarea maxlength="300" class="form-control ckeditor" name="description" id="description" required></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Short Description:</label>
                                <input type="text" maxlength="100" class="form-control" name="parmalink" id="parmalink" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" id="product_image_div">
                                <label for="message-text" class="col-form-label">Product Image:</label>
                                <input type="file" maxlength="10" class="noNegetive twoDecimalNumber form-control"
                                    name="product_image">
                            </div>
                            <input type="hidden" id="product_image" name="prev_product_img">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" id="category_image_div">
                                <label for="message-text" class="col-form-label">Category Image:</label>
                                <input type="file" maxlength="10" class="noNegetive twoDecimalNumber form-control"
                                    name="category_image">
                            </div>
                            <input type="hidden" id="category_image" name="prev_category_img">
                        </div>                        
                        <div class="col-md-12">
                            <div class="form-group" id="other_image_div">
                                <label for="message-text" class="col-form-label">Other Images:</label>
                                <input type="file" class="noNegetive twoDecimalNumber form-control"
                                    name="other_images[]" multiple>
                                <span><small>Hint : Press ctrl & choose multiple image</small></span>
                            </div>
                        </div>
                        
                    </div>
                    <input type="hidden" id="product_id" name="product_id">
                    <input type="hidden" name="table_attribute" value="<?php echo base64_encode('product');?>">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success" id="edit_button">Submit</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>