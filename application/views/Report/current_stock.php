<!-- partial -->
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Current Stock
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6" class="form-control">
                    <h4 class="card-title">Stock Type</h4>
                    <select class="form-control" id="stock_type" onchange="stock_wise_filter(this.value);">
                        <option value="0">All</option>
                        <option value="1">In Stock</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <h4 class="card-title">&#160;</h4>
                    <button type="button" class="btn btn-outline-success" onclick="current_stock_filter();">Filter</button>
                </div>
                
           
                <div class="col-md-12 pt-4" style="display:none;" id="details_result">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h4 class="card-title m-0">Current Stock Result</h4>
                                <button class="btn btn-inverse-primary btn-rounded btn-icon" id="btnExport" onclick="fnExcelReport();" title="Download">  <i class="mdi mdi-arrow-down" aria-hidden="true"></i></button>
                                <input type="hidden" value="Current Stock" id="tableName">
                            </div>
                          <div class="row">
                            <div class="table-sorter-wrapper col-lg-12 table-responsive">
                              <table id="sortable-table-1" class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Part Number</th>
                                    <th>Product Name</th>
                                    <th>Current Stock</th>
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


