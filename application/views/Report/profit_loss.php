<!-- partial -->
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Profit & Loss
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3" class="form-control">
                    <h4 class="card-title">Client</h4>
                    <select class="form-control" id="client_id">
                        <option value="0" selected >Select Client</option>
                        <?php
                            if($client['stat'] == 200){
                                foreach($client['all_list'] as $c){
                        ?>
                                    <option value="<?php echo $c['client_id']; ?>"><?php echo $c['company_name']; ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-3" class="form-control">
                    <h4 class="card-title">Product</h4>
                    <select class="form-control" id="product_id">
                        <option value="0" selected >Select Product</option>
                        <?php
                            if($product['stat'] == 200){
                                foreach($product['all_list'] as $p){
                        ?>
                                    <option value="<?php echo $p['product_id']; ?>"><?php echo $p['part_number']; ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <h4 class="card-title">From</h4>
                    <input type="text" class="form-control datepicker" id="from" readonly>
                 </div>
                <div class="col-md-2">
                    <h4 class="card-title">To</h4>
                    <input type="text" class="form-control datepicker" id="to" onclick="fromWiseTo();" readonly>
                 </div>
                <div class="col-md-2">
                    <h4 class="card-title">&#160;</h4>
                    <button type="button" class="btn btn-outline-success" onclick="profit_loss_filter();">Filter</button>
                </div>
           
                <div class="col-md-12 pt-4" style="display:none;" id="details_result">
                    <div class="card">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between mb-4">
                            <h4 class="card-title m-0">Profit & Loss Result</h4>
                            <button class="btn btn-inverse-primary btn-rounded btn-icon" id="btnExport" onclick="fnExcelReport();" title="Download">  <i class="mdi mdi-arrow-down" aria-hidden="true"></i></button>
                            <input type="hidden" value="Profit Loss" id="tableName">
                          </div>
                          <div class="row">
                            <div class="table-sorter-wrapper col-lg-12 table-responsive">
                              <table id="sortable-table-1" class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Part Number</th>
                                    <th>Product Price</th>
                                    <th>Product IGST (%)</th>
                                    <th>Sale Price</th>
                                    <th>Sale Discount (%)</th>
                                    <th>Sale Tax (%)</th>
                                    <th>Quantity</th>
                                    <th>Product Amount</th>
                                    <th>Sale Amount</th>
                                    <th>Date</th>
                                  </tr>
                                </thead>
                                <tbody id="filter_data">
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            <hr>
        </div>
    </div>
</div>


