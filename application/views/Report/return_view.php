<!-- partial -->
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Return Report
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h4 class="card-title">From</h4>
                    <input type="text" class="form-control datepicker" id="from" readonly >
                 </div>
                <div class="col-md-3">
                    <h4 class="card-title">To</h4>
                    <input type="text" class="form-control datepicker" id="to" onclick="fromWiseTo();" readonly >
                 </div>
                 <div class="col-md-3">
                      <h4 class="card-title">Client List</h4>

                      <select class="js-example-basic-single" style="width:100%" id="client">
                          <option selected value=0>Select an Option</option>
                          <?php if($client_list['stat'] == 200)
                          {
                            foreach($client_list['all_list'] as $list){ ?>
                          <option value="<?php echo $list['client_id'];?>"><?php echo $list['company_name'];?></option>
                          <?php } } ?>
                      </select>
                     
                  </div>
                <div class="col-md-3">
                    <h4 class="card-title">&#160;</h4>
                    <button type="button" class="btn btn-outline-success" onclick="return_filter();">Filter</button>
                </div>
                
           
                <div class="col-md-12 pt-4" style="display:none;" id="sell_details">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h4 class="card-title m-0">Return Result</h4>
                                <button class="btn btn-inverse-primary btn-rounded btn-icon" id="btnExport" onclick="fnExcelReport();" title="Download">  <i class="mdi mdi-arrow-down" aria-hidden="true"></i></button>
                                <input type="hidden" value="Return" id="tableName">
                            </div>
                          <div class="row">
                            <div class="table-sorter-wrapper col-lg-12 table-responsive">
                              <table id="sortable-table-1" class="table">
                                <thead>
                                  <tr>
                                    <th >#</th>
                                    <th >Customer</th>
                                    <th >Invoice No.</th>
                                    <th >Price</th>
                                    <th >Discount (%)</th>
                                    <th >Tax (%)</th>
                                    <th >Return Quantity</th>
                                    <th >Return Amount</th>   
                                    <th >Date</th>
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






