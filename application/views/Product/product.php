<!-- partial -->
<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            Product
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="card-title">Product Single Add</h4>
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#add_modal"
                        data-whatever="@mdo">Add</button>
                </div>
                <!-- <div class="col-md-8">
                    <h4 class="card-title">CSV file upload &#160;<small><a href="<?php echo base_url();?>assets/csv/product.csv" download="product.csv"><i class="mdi mdi-arrow-down"></i>Demo CSV File</a></small></h4> 
                    <form method="post" enctype="multipart/form-data"
                        action="<?php echo base_url(); ?>Product/csv_upload" multiple>

                        <div class="d-flex">
                           
                                <input type="file" name="product_csv" class="form-control file-upload-info" accept=".csv" required>
                                <div style="width:20px"></div>
                                <button type="submit" class="btn btn-outline-success">Submit</button>
                           
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
                                    <th>Id</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Description</th>
                                    <th>Tags</th>
                                    <th>Category</th>
                                    <th>Fabric</th>
                                    <th>Garment Wash</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($product['stat'] == 200){
                                    foreach($product['all_list'] as $p){
                            ?>
                                <tr>
                                    <td><?php echo $p['product_id']; ?></td>
                                    <td><?php echo $p['product_name']; ?></td>
                                    <td><?php echo $p['part_number']; ?></td>
                                    <td><?php echo $p['description']; ?></td>
                                    <td><?php echo $p['product_tags']; ?></td>
                                    <td><?php echo $p['category']; ?></td>
                                    <td><?php echo $p['fabric']; ?></td>
                                    <td><?php echo $p['garment_wash']; ?></td>
                                    <td><img src="<?php echo $this->config->item('file_url').$p['product_image']; ?>"></td>
                                    <td>
                                        <button class="btn btn-outline-dark"
                                            onclick="GetSingleData(<?php echo $p['product_id']?>,'<?php echo base64_encode('product')?>','view')">View</button>
                                        <button class="btn btn-outline-dark"
                                            onclick="GetSingleData(<?php echo $p['product_id']?>,'<?php echo base64_encode('product')?>','edit')">Edit</button>
                                        <button class="btn btn-outline-dark"
                                            onclick="DeleteData(<?php echo $p['product_id']?>,'<?php echo base64_encode('product')?>')">Delete</button>
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
<!-- content-wrapper ends -->


<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Product Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url(); ?>General/AddData" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Style Number:</label>
                                <input type="text" maxlength="100" class="lengthValidation form-control"
                                    name="part_number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Category:</label>
                                <input type="text" class="form-control" name="category" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Main Pattern:</label>
                                <input type="text" class="form-control" name="product_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fabric:</label>
                                <input type="text" class="form-control" name="fabric" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Garment Wash:</label>
                                <input type="text" class="form-control" name="garment_wash" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Season:</label>
                                <input type="text" class="form-control" name="season" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Purpose Of Garment:</label>
                                <input type="text" class="form-control" name="purpose_garment" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Tags:</label>
                                <select class="form-control select2" multiple name="product_tags[]">
                                <option value="None">None</option>
                                <option value="Solid">Solid</option>
                                <option value="Embroidery">Embroidery</option>
                                <option value="Print">Print</option>
                                <option value="Wash">Wash</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Station Number:</label>
                                <select class="form-control" name="displayNumber">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Description:</label>
                                <textarea maxlength="300" class="form-control ckeditor" name="description" required></textarea>
                            </div>
                        </div>
                         
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Parmalink:</label>
                                <input type="text" maxlength="10" class="form-control" name="parmalink" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Front Image:</label>
                                <input type="file" maxlength="10" class="noNegetive twoDecimalNumber form-control"
                                    name="product_image">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Category Image:</label>
                                <input type="file" maxlength="10" class="noNegetive twoDecimalNumber form-control"
                                    name="category_image">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Other Image:</label>
                                <input type="file" maxlength="10" class="noNegetive twoDecimalNumber form-control"
                                    name="other_images[]" multiple>
                                <span><small>Hint : Press ctrl & choose multiple image</small></span>
                            </div>
                        </div>
                        <!--<div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Default Price:</label>
                                <input type="text" maxlength="10" class="noNegetive twoDecimalNumber form-control"
                                    name="default_price" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Category:</label>
                             <select class="form-control" name="category">
                                <option value="None">None</option>
                                <option value="Nightwear">Nightwear</option>
                                <option value="Topwear">Topwear</option>
                                <option value="Innerwear">Innerwear</option>
                                <option value="Outwear">Outwear</option>
                                <option value="Swimwear">Swimwear</option>
                                <option value="Shirts and Tops">Shirts and Tops</option>
                                <option value="Dresses and Skirts">Dresses and Skirts</option>
                                <option value="Jeans">Jeans</option>
                                <option value="Trousers and Shorts">Trousers and Shorts</option>
                                <option value="Blazers and Waist Coats">Blazers and Waist Coats</option>
                                <option value="Socks and Stockings">Socks and Stockings</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Fabric:</label>
                             <select class="form-control select2" multiple name="fabric[]">
                                <option value="None">None</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Cotton Millange Jersey">Cotton Millange Jersey</option>
                                <option value="Dyed">Dyed</option>
                                <option value="Sweater">Sweater</option>
                                <option value="Denim">Denim</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Garment Wash:</label>
                             <select class="form-control" name="garment_wash">
                                <option value="None">None</option>
                                <option value="Detergent wash">Detergent wash</option>
                                <option value="Stone wash">Stone wash</option>
                                <option value="Pigment wash">Pigment wash</option>
                                <option value="Bleach wash">Bleach wash</option>
                                <option value="Acid wash">Acid wash</option>
                                <option value="Dry wash">Dry wash</option>
                                <option value="Hand scrapping">Hand scrapping</option>
                                <option value=" Destroying"> Destroying</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Season:</label>
                             <select class="form-control" name="season">
                                <option value="None">None</option>
                                <option value="Winter">Winter</option>
                                <option value="Summer">Summer</option>
                                <option value="Spring">Spring</option>
                                <option value="Autumn">Autumn</option>
                                <option value="Late Autumn">Late Autumn</option>
                              </select>
                        </div>
                    </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Tags:</label>
                                <select class="form-control" name="product_tags">
                                <option value="None">None</option>
                                <option value="Solid">Solid</option>
                                <option value="Embroidery">Embroidery</option>
                                <option value="Print">Print</option>
                                <option value="Wash">Wash</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Price Type:</label>
                                 <select class="form-control" name="price_type">
                                    <option value="0">Default Price</option>
                                    <option value="1">Price On Request</option>
                                  </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Stock:</label>
                                <input type="text" maxlength="10" class="noNegetive twoDecimalNumber form-control"
                                    name="current_stock" required>
                            </div>
                        </div> -->
                        
                    </div>
                </div>
                <input type="hidden" name="table_attribute" value="<?php echo base64_encode('product');?>">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success">Submit</button>
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
                                <label for="message-text" class="col-form-label">Style Number:</label>
                                <input type="text" maxlength="100" class="lengthValidation form-control" name="part_number" id="part_number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Category:</label>
                                <input type="text" class="form-control" name="category" id="category" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Main Pattern:</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fabric:</label>
                                <input type="text" class="form-control" name="fabric" id="fabric" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Garment Wash:</label>
                                <input type="text" class="form-control" name="garment_wash" id="garment_wash" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Season:</label>
                                <input type="text" class="form-control" name="season" id="season" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Purpose Of Garment:</label>
                                <input type="text" class="form-control" name="purpose_garment" id="purpose_garment" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Tags:</label>
                                <select class="form-control select2" multiple name="product_tags[]" id="product_tags">
                                <option value="None">None</option>
                                <option value="Solid">Solid</option>
                                <option value="Embroidery">Embroidery</option>
                                <option value="Print">Print</option>
                                <option value="Wash">Wash</option>
                              </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Station Number:</label>
                                <select class="form-control" name="displayNumber" id="displayNumber">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Description:</label>
                                <textarea maxlength="300" class="form-control ckeditor" name="description" id="description" required></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Parmalink:</label>
                                <input type="text" maxlength="10" class="form-control" name="parmalink" id="parmalink" required>
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