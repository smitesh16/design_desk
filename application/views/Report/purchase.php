<!-- partial -->
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Purchase
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="card-title">From</h4>
                    <input type="text" class="form-control datepicker" id="from" readonly>
                 </div>
                <div class="col-md-4">
                    <h4 class="card-title">To</h4>
                    <input type="text" class="form-control datepicker" id="to" onclick="fromWiseTo();" readonly>
                 </div>
                <div class="col-md-4">
                    <h4 class="card-title">&#160;</h4>
                    <button type="button" class="btn btn-outline-success" onclick="purchase_filter();">Filter</button>
                </div>
                
           
                <div class="col-md-12 pt-4" style="display:none;" id="details_result">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h4 class="card-title m-0">Purchase Result</h4>
                                <button class="btn btn-inverse-primary btn-rounded btn-icon" id="btnExport" onclick="fnExcelReport();" title="Download">  <i class="mdi mdi-arrow-down" aria-hidden="true"></i></button>
                                <input type="hidden" value="Purchase" id="tableName">
                           </div>
                          <div class="row">
                            <div class="table-sorter-wrapper col-lg-12 table-responsive">
                              <table id="sortable-table-1" class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Part Number</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
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


