var base_url=$("#base_url").val();
var globProductArr = new Array();   //For purchase
var globInvoiceArr = new Array();   //For payment
var globReturnArr = new Array();    //For Return
var globStockArr = '';    //For Current Stock Report

function common(){
    $(".onlynum").keypress(function(event) {
            var character = String.fromCharCode(event.keyCode);
            let Sp_Char = isNotSpecialChar(character);     
            let Char = isNotChar(character);  

            if(Char == true && Sp_Char == true){
                return true;
            } else{
                return false;
            }
        });

        $('.onlynum').bind('paste', function(){
            var self = this;
            setTimeout(function() {
                if(!/^[0-9-+()]+$/.test($(self).val()))
                    $(self).val('');
            }, 0);    
        });
        
        jQuery(document).ready(function($) {
        	 //Set maxlength of all the textarea (call plugin)
        	 $().maxlength();
        });

        ;(function ($) {

            $.fn.maxlength = function(){

                $("textarea[maxlength], input[maxlength]").keypress(function(event){ 
                    var key = event.which;

                    //all keys including return.
                    if(key >= 33 || key == 13 || key == 32) {
                        var maxLength = $(this).attr("maxlength");
                        var length = this.value.length;
                        if(length >= maxLength) {					 
                            event.preventDefault();
                        }
                    }
                });
            }

        })(jQuery);
        
        $('.twoDecimalNumber').keypress(function(event) {
            var $this = $(this);
            if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
               ((event.which < 48 || event.which > 57) &&
               (event.which != 0 && event.which != 8))) {
                   event.preventDefault();
            }

            var text = $(this).val();
            if ((event.which == 46) && (text.indexOf('.') == -1)) {
                setTimeout(function() {
                    if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                        $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                    }
                }, 1);
            }

            if ((text.indexOf('.') != -1) &&
                (text.substring(text.indexOf('.')).length > 2) &&
                (event.which != 0 && event.which != 8) &&
                ($(this)[0].selectionStart >= text.length - 2)) {
                    event.preventDefault();
            }      
        });

        $('.twoDecimalNumber').bind("paste", function(e) {
        var text = e.originalEvent.clipboardData.getData('Text');
        if ($.isNumeric(text)) {
            if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
                e.preventDefault();
                $(this).val(text.substring(0, text.indexOf('.') + 3));
           }
        }
        else {
                e.preventDefault();
             }
        });
}

function product_choose(){
    var id = $("#product").val();
    if(id == '' || id==null || id==0){
        errorSwal('error','Please choose product');
        return;
    }
    if(id in globProductArr){
//        $("#choosing_product").hide();
        $( document ).ready(function() {  errorSwal('error','Already choose this product')});
    } else{
        globProductArr[id] = {product_id:id};
        var product_name = $("#product option:selected").text();
        var content = '<tr id=delete_tr_'+id+'><td>'+product_name+'</td><td><input type="text" class="onlynum form-control" placeholder="Quantity" aria-label="Quantity" id="quantity'+id+'" maxlength="10" value="0" onkeyup="addThisTotal();"></td><td><input type="text" class="noNegetive twoDecimalNumber form-control" placeholder="Price" aria-label="Price"  id="price'+id+'" maxlength="10" value="0" onkeyup="addThisTotal();"></td><td><button type="button" class="btn btn-outline-dark" onclick="product_remove('+id+');">Remove</button></td></tr>';
        $("#choosing_product").show();
        $("#choosing_tbody").append(content);
        addThisTotal();
        common();

    }
}

function addThisTotal(){
    var totalQuantity = 0;
    var totalPrice = 0;
    var product = globProductArr.filter(function (el) {
      return el != null;
    });
    $.each(product, function (key, val) {
        var quantity = $("#quantity"+val['product_id']).val();
        var price = $("#price"+val['product_id']).val();
        if(quantity == '' || quantity == null){
            quantity = 0;
        }
        if(price == "."){
            $("#price"+val['product_id']).val("");
            var price = $("#price"+val['product_id']).val();
        }
        if(price == '' || price == null){
            price = 0;
        }
        totalQuantity = parseInt(totalQuantity) + parseInt(quantity);
        totalPrice = parseFloat(totalPrice) + (parseFloat(price) * parseInt(quantity));
    });
    
    var content = '<tr><td>Total Product - '+product.length+'</td><td> Total Quantity - '+totalQuantity+'</td><td>Total Price - '+totalPrice.toFixed(2)+'</td></tr>';
    $("#totalProductDetails").html(content);
}

/*function product_submit(id){
    var arr = new Array();
    var product_name = $("#product option:selected").text();
    var quantity = $("#quantity").val();
    var price = $("#price").val();
    
    if(quantity == '' || price == ''){
        errorSwal('error','Please add quantity and price properly');
        return;
    }
    arr = {product_id:id,quantity:quantity,price:price};
    globProductArr[id] = arr;
    
    var content = '<tr id=delete_tr_'+id+'><td>'+product_name+'</td><td>'+quantity+'</td><td>'+price+'</td><td><button type="button" class="btn btn-danger" onclick="product_remove('+id+');">Remove</button></td></tr>';
    
    $("#choosing_product").hide();
    $("#submit_product").show();
    $("#submit_tbody").append(content);
}*/

function product_remove(id){
    delete globProductArr[id];
    $("#delete_tr_"+id).remove();
    if(Object.keys(globProductArr).length == 0){
        $("#choosing_product").hide();
    }
    addThisTotal();
}

function place_order(){
    var product_details = new Array();
    var purchase_number = $("#purchase_number").val();
    var purchase_note = CKEDITOR.instances.purchase_note.getData();
    var Pflag = 0;
    var Qflag = 0;
    if(purchase_number == ''){
        errorSwal('error','Please add purchase number');
        return;
    }
    var product = globProductArr.filter(function (el) {
      return el != null;
    });
    $.each(product, function (key, val) {
        var quantity = $("#quantity"+val['product_id']).val();
        var price = $("#price"+val['product_id']).val();

        if(quantity == 0 || quantity == '' || quantity == null){
            Qflag = 1;
            errorSwal('error','Please add some quantity');
            return;
        }
        if(price == '' || price == null){
            Pflag = 1;
            errorSwal('error','Please add some price');
            return;
        }
        
        product_details[key] = {product_id:val['product_id'],quantity:quantity,price:price};
        
    });
    
    if(Qflag == 1){
        errorSwal('error','Please add some quantity');
        return;
    }
    if(Pflag == 1){
        errorSwal('error','Please add some price');
        return;
    }
   $("#loader").removeClass('d-none');
    
    $.ajax({
        type: "POST",
        url: base_url + "Purchase/place_order",
        data: {purchase_number:purchase_number,purchase_note:purchase_note,product:product_details},
        success: function(response) {
           $("#loader").addClass('d-none');
            var res = JSON.parse(response);
            if(res.stat == 200){
              showSwal('auto_msg');
              window.location = base_url+"Purchase";
            } else if(res.stat == 201){
                errorSwal('error',res.msg);
            } else{
                errorSwal('error',res.msg);
            }
            
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function GetSinglePurchase(id){
    $.ajax({
        type: "POST",
        url: base_url + "Purchase/single_purchase",
        data: {purchase_id:id},
        success: function(response) {
            var res = JSON.parse(response);
            if(res.stat == 200){
              var purchase = res.all_list;
              var content = '';
                for (var key in purchase) {
                    $("#purchase_number").html(purchase[key]['purchase_number']);
                    $("#total_amount").html(purchase[key]['total_amount']);
                    var purchase_details = purchase[key].details;
                    for(var key1 in purchase_details){
                      var total = purchase_details[key1].quantity * purchase_details[key1].price;
                      content += '<tr><td>'+purchase_details[key1].part_number+'</td><td>'+purchase_details[key1].quantity+'</td><td>'+purchase_details[key1].price+'</td><td>'+total.toFixed(2)+'</td></tr>';
                    }
                }
              $("#purchase_details_tbody").html(content);
              $("#edit_modal").modal('show');
            } else{
                errorSwal('error',res.msg);
            }
            
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function client_wise_inv(id){
    $.ajax({
        type: "POST",
        url: base_url + "Payment/client_wise_inv",
        data: {client_id:id},
        success: function(response) {
            var res = JSON.parse(response);
            var content = '<option value="" selected disabled>Select Invoice</option>';
            if(res.stat == 200){
                for(var i=0; i<res.list_count; i++){
                    content += '<option value="'+res.all_list[i].sell_id+'" data-total='+res.all_list[i].final_amount+' data-outstanding='+res.all_list[i].outstanding_amount+'>'+res.all_list[i].invoice_number+'</option>';
                }
            } else{
                errorSwal('error','No invoice found for this client');
            }
            $("#sell_id").html(content);
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function invoice_choose(){
    var client = $("#client").val();
    var sell_id = $("#sell_id").val();
    
    if(client == null){
        errorSwal('error','Please choose client');
        return;
    }
    if(sell_id == null){
        errorSwal('error','Please choose invoice');
        return;
    }
    var total = $("#sell_id option:selected").attr('data-total');
    var outstanding = $("#sell_id option:selected").attr('data-outstanding');
    
    if(sell_id in globInvoiceArr){
        $( document ).ready(function() {  errorSwal('error','Already choose this invoice')});
    } else{
        $("#client").prop("disabled",true);
        globInvoiceArr[sell_id] = {sell_id:sell_id};
        var sell_name = $("#sell_id option:selected").text();
        var content = '<tr id=delete_tr_'+sell_id+'><td>'+sell_name+'</td><td><input type="text" class="onlynum form-control" aria-label="Amount" id="final_amount'+sell_id+'" value="'+total+'" readonly></td><td><input type="text" class="form-control" placeholder="Price" aria-label="Price"  id="outstanding_amount'+sell_id+'" value="'+outstanding+'" readonly></td><td><input type="text" class="noNegetive twoDecimalNumber form-control" placeholder="Payment" aria-label="Payment"  id="amount_paid'+sell_id+'" maxlength="10" onkeyup="addThisInvTotal();"></td><td><textarea class="form-control" maxlength="100" id="remarks'+sell_id+'"></textarea></td><td><button type="button" class="btn btn-outline-dark" onclick="invoice_remove('+sell_id+');">Remove</button></td></tr>';
        $("#choosing_invoice").show();
        $("#choosing_tbody").append(content);
        addThisInvTotal();
        common();

    }
}

function addThisInvTotal(){
    var totalAmount = 0;
    var totalOutstanding = 0;
    var totalPay = 0;
    var invoice = globInvoiceArr.filter(function (el) {
      return el != null;
    });
    $.each(invoice, function (key, val) {
        var final_amount = $("#final_amount"+val['sell_id']).val();
        var outstanding_amount = $("#outstanding_amount"+val['sell_id']).val();
        var amount_paid = $("#amount_paid"+val['sell_id']).val();
        
        if(amount_paid == "."){
            $("#amount_paid"+val['sell_id']).val("");
            var amount_paid = $("#amount_paid"+val['sell_id']).val();
        }
        if(amount_paid == '' || amount_paid == null){
            amount_paid = 0;
        }
        
        if(parseFloat(outstanding_amount)<parseFloat(amount_paid)){
            $("#amount_paid"+val['sell_id']).val(outstanding_amount);
            var amount_paid = $("#amount_paid"+val['sell_id']).val();
        }
        totalAmount = parseFloat(totalAmount) + parseFloat(final_amount);
        totalOutstanding = parseFloat(totalOutstanding) + (parseFloat(outstanding_amount) - parseFloat(amount_paid));
        totalPay = parseFloat(totalPay) + parseFloat(amount_paid);
    });
    
    var content = '<tr><td>Total Invoice - '+invoice.length+'</td><td> Total Amount - '+totalAmount.toFixed(2)+'</td><td>Total Outstanding - '+totalOutstanding.toFixed(2)+'</td><td>Total Pay - '+totalPay.toFixed(2)+'</td><td></td><td></td></tr>';
    $("#totalInvoiceDetails").html(content);
}

function invoice_remove(id){
    delete globInvoiceArr[id];
    $("#delete_tr_"+id).remove();
    if(Object.keys(globInvoiceArr).length == 0){
        $("#client").prop("disabled",false);
        $("#choosing_invoice").hide();
    }
    addThisInvTotal();
}

/*Add payment for chossing invoice client wise*/
function payment(){
    var invoice_details = new Array();
    var client = $("#client").val();
    var Pflag = 0;
    if(client == ''){
        errorSwal('error','Please choose client');
        return;
    }
    var invoice = globInvoiceArr.filter(function (el) {
      return el != null;
    });
    $.each(invoice, function (key, val) {
        var final_amount = $("#final_amount"+val['sell_id']).val();
        var outstanding_amount = $("#outstanding_amount"+val['sell_id']).val();
        var amount_paid = $("#amount_paid"+val['sell_id']).val();
        var remarks = $("#remarks"+val['sell_id']).val();

        if(amount_paid == 0 || amount_paid == '' || amount_paid == null){
            Pflag = 1;
            errorSwal('error','Please add some price');
            return;
        }
        
        invoice_details[key] = {sell_id:val['sell_id'],final_amount:final_amount,outstanding_amount:outstanding_amount,amount_paid:amount_paid,remarks:remarks};
        
    });
    
    if(Pflag == 1){
        errorSwal('error','Please add some price');
        return;
    }
   $("#loader").removeClass('d-none');
    
    $.ajax({
        type: "POST",
        url: base_url + "Payment/place_payment",
        data: {client:client,invoice:invoice_details},
        success: function(response) {
           $("#loader").addClass('d-none');
            var res = JSON.parse(response);
            if(res.stat == 200){
              showSwal('auto_msg');
              window.location = base_url+"Payment";
            } else{
                errorSwal('error','Something wrong please try after sometime');
            }
            
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function GetSinglePayment(id){
    $.ajax({
        type: "POST",
        url: base_url + "Payment/single_payment",
        data: {payment_id:id},
        success: function(response) {
            var res = JSON.parse(response);
            if(res.stat == 200){
              var invoice = res.all_list;
              var client_content = '';
              var sell_content = '';
              var product_content = '';
                for (var key in invoice) {
                    $("#invoice_number").html(invoice[key]['invoice_number']);
                    $("#voucher_number").html(invoice[key]['voucher_number']);
                    $("#amount_paid").html(invoice[key]['amount_paid']);
                    
                    var customer_details = invoice[key]['customer_details'][0];
                    
                    client_content += '<tr><td>'+customer_details['company_name']+'</td><td>'+customer_details['company_address']+'</td><td>'+customer_details['contact_person']+'</td><td>'+customer_details['contact_number']+'</td><td>'+customer_details['pan_number']+'</td><td>'+customer_details['gstin_number']+'</td></tr>';
                    
                    var sale_details = invoice[key]['sale_details'][0];
                    sell_content += '<tr><td>'+sale_details['sell_amount']+'</td><td>'+sale_details['total_discount']+'</td><td>'+sale_details['total_tax']+'</td><td>'+sale_details['final_amount']+'</td><td>'+sale_details['outstanding_amount']+'</td><td>'+sale_details['sell_date']+'</td><td>'+sale_details['sale_note']+'</td></tr>';
                    
                    
                    var product_details = invoice[key].product_details;
                    for(var key1 in product_details){
                      var discount_amount = parseFloat(product_details[key1].price) * parseFloat(parseFloat(product_details[key1].discount)/100);
                     
                      var after_discount_amount = parseFloat(product_details[key1].price) - parseFloat(discount_amount);
                      
                      var tax_amount = parseFloat(after_discount_amount) * parseFloat(parseFloat(product_details[key1].tax)/100);
                     
                      var sell_price = parseFloat(after_discount_amount) + parseFloat(tax_amount);
                      
                      var final_amount = product_details[key1].quantity * sell_price;
                      
                      final_amount = final_amount.toFixed(2);
                      discount_amount = discount_amount.toFixed(2);
                      after_discount_amount = after_discount_amount.toFixed(2);
                      tax_amount = tax_amount.toFixed(2);
                      sell_price = sell_price.toFixed(2);
                        
                      product_content += '<tr><td>'+product_details[key1].product_name+'</td><td>'+product_details[key1].part_number+'</td><td>'+product_details[key1].price+'</td><td>'+product_details[key1].discount+'</td><td>'+product_details[key1].tax+'</td><td>'+product_details[key1].quantity+'</td><td>'+final_amount+'</td></tr>';
                    }
                }
              $("#customer_details").html(client_content);
              $("#sale_details").html(sell_content);
              $("#product_details").html(product_content);
              $("#paymentModal").modal('show');
            } else{
                errorSwal('error',res.msg);
            }
            
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function sell_wise_product(id){
    $.ajax({
        type: "POST",
        url: base_url + "ReturnProduct/sell_wise_product",
        data: {sell_id:id},
        success: function(response) {
            var res = JSON.parse(response);

            var content = '<option value="" selected disabled>Select Product</option>';
            if(res.stat == 200){

                for(var i=0; i<res.all_list.length; i++){
                    var quantity = parseInt(res.all_list[i].quantity) - parseInt(res.all_list[i].return_quantity);

                    if(quantity>0){
                        content += '<option value="'+res.all_list[i].product_id+'" data-quantity='+quantity+' >'+res.all_list[i].part_number+'</option>';
                    }
                }
            } else{
                errorSwal('error',res.msg);
            }
          
            $("#product_id").html(content);
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function return_product_choose(){
    var sell_id = $("#sell_id").val();
    var product_id = $("#product_id").val();
    
    if(sell_id == null){
        errorSwal('error','Please choose invoice');
        return;
    }
    if(product_id == null){
        errorSwal('error','Please choose product');
        return;
    }
    var quantity = $("#product_id option:selected").attr('data-quantity');
    
    if(product_id in globReturnArr){
        $( document ).ready(function() {  errorSwal('error','Already choose this product')});
    } else{
        $("#sell_id").prop("disabled",true);
        globReturnArr[product_id] = {product_id:product_id};
        var product_name = $("#product_id option:selected").text();
        var content = '<tr id=delete_tr_'+product_id+'><td>'+product_name+'</td><td><input type="text" class="onlynum form-control" aria-label="Quantity" id="product_quantity'+product_id+'" value="'+quantity+'" readonly></td><td><input type="text" class="noNegetive onlynum form-control" placeholder="Return Quantity" aria-label="Return Quantity"  id="return_quantity'+product_id+'" maxlength="10" onkeyup="addThisReturnTotal();"></td><td><button type="button" class="btn btn-outline-dark" onclick="return_remove('+product_id+');">Remove</button></td></tr>';
        $("#choosing_return_product").show();
        $("#choosing_tbody").append(content);
        addThisReturnTotal();
        common();

    }
}

function addThisReturnTotal(){
    var totalProductQuantity = 0;
    var totalReturnQuantity = 0;
    var product = globReturnArr.filter(function (el) {
      return el != null;
    });
    $.each(product, function (key, val) {
        var product_quantity = $("#product_quantity"+val['product_id']).val();
        var return_quantity = $("#return_quantity"+val['product_id']).val();
        
        if(return_quantity == '' || return_quantity == null){
            return_quantity = 0;
        }
        if(parseFloat(product_quantity)<parseFloat(return_quantity)){
            $("#return_quantity"+val['product_id']).val(product_quantity);
            var return_quantity = $("#return_quantity"+val['product_id']).val();
        }
        totalProductQuantity = parseInt(totalProductQuantity) + parseInt(product_quantity);
        totalReturnQuantity = parseInt(totalReturnQuantity) + parseInt(return_quantity);
    });
    
    var content = '<tr><td>Total Product - '+product.length+'</td><td> Total Product Qunatity - '+totalProductQuantity+'</td><td>Total Return Quantity - '+totalReturnQuantity+'</td><td></td></tr>';
    $("#totalReturnDetails").html(content);
}

function return_remove(id){
    delete globReturnArr[id];
    $("#delete_tr_"+id).remove();
    if(Object.keys(globReturnArr).length == 0){
        $("#sell_id").prop("disabled",false);
        $("#choosing_return_product").hide();
    }
    addThisReturnTotal();
}

function return_submit(){
    var return_details = new Array();
    var sell_id = $("#sell_id").val();
    var Qflag = 0;
    if(sell_id == ''){
        errorSwal('error','Please choose invoice');
        return;
    }
    var product = globReturnArr.filter(function (el) {
      return el != null;
    });
    $.each(product, function (key, val) {
        var return_quantity = $("#return_quantity"+val['product_id']).val();
        if(return_quantity == 0 || return_quantity == '' || return_quantity == null){
            Qflag = 1;
            errorSwal('error','Please add some quantity');
            return;
        }
        
        return_details[key] = {product_id:val['product_id'],return_quantity:return_quantity};
        
    });
    
    if(Qflag == 1){
        errorSwal('error','Please add some quantity');
        return;
    }
   $("#loader").removeClass('d-none');
    
    $.ajax({
        type: "POST",
        url: base_url + "ReturnProduct/return_submit",
        data: {sell_id:sell_id,return_details:return_details},
        success: function(response) {
           $("#loader").addClass('d-none');
            console.log(response);
            var res = JSON.parse(response);

            if(res.stat == 200){
              showSwal('auto_msg');
              window.location = base_url+"ReturnProduct";
            } else{
                errorSwal('error','Cannot return Product');
            }
            
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function GetSingleReturn(id){
    $.ajax({
        type: "POST",
        url: base_url + "ReturnProduct/single_return",
        data: {return_no:id},
        success: function(response) {
            var res = JSON.parse(response);
            if(res.stat == 200){
              var return_details = res.all_list;
              var total_return_amount = 0;
              var client_content = '';
              var product_content = '';
                for (var key in return_details) {
                    $("#invoice_number").html(return_details[key]['sale_details'][0]['invoice_number']);
                    
                    var customer_details = return_details[key]['customer_details'][0];
                    
                    client_content += '<tr><td>'+customer_details['company_name']+'</td><td>'+customer_details['company_address']+'</td><td>'+customer_details['contact_person']+'</td><td>'+customer_details['contact_number']+'</td><td>'+customer_details['pan_number']+'</td><td>'+customer_details['gstin_number']+'</td></tr>';
                    
                    var product_details = return_details[key].product_details;
                    var i=0;
                    for(var key1 in product_details){
                        i=i+1;
                        total_return_amount = parseFloat(total_return_amount) + parseFloat(return_details[key]['product_details'][key1]['return_amount']);
                        
                      product_content += '<tr><td>'+i+'</td><td>'+product_details[key1].product_name+'</td><td>'+product_details[key1].part_number+'</td><td>'+product_details[key1].price+'</td><td>'+product_details[key1].discount+'</td><td>'+product_details[key1].tax+'</td><td>'+product_details[key1].return_quantity+'</td><td>'+product_details[key1].return_amount+'</td></tr>';
                    }
                    $("#return_amount").html(total_return_amount.toFixed(2));
                }
                
              $("#customer_details").html(client_content);
              $("#product_details").html(product_content);
              $("#returnModal").modal('show');
            } else{
                errorSwal('error',res.msg);
            }
            
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}



function purchase_filter(){
    var from = $("#from").val();
    var to = $("#to").val();
    
    if(from == '' || to == ''){
        errorSwal('error','Please choose date');
        return;
    }
    
    var f=YMD(from);
    var t=YMD(to);
    
   $("#loader").removeClass('d-none');
    
    $.ajax({
        type: "POST",
        url: base_url + "Report/purchase_filter",
        data: {from:f,to:t},
        success: function(response) {
           $("#loader").addClass('d-none');
            var res = JSON.parse(response);
            var content = '';
            var total = 0;
            var i=0;
            if(res.stat == 200){
              showSwal('auto_msg');
                for(var key in res.all_list){
                    var details = res.all_list[key].details;
                    var date = DMY(res.all_list[key].date);
                    for(var key1 in details){
                        i = i+1;
                        var single_total = details[key1]['quantity'] * details[key1]['price'];
                        total = parseFloat(total) + parseFloat(single_total);
                       content += '<tr><td>'+i+'</td><td>'+details[key1]['part_number']+'</td><td>'+details[key1]['quantity']+'</td><td>'+details[key1]['price']+'</td><td>'+single_total+'</td><td>'+date+'</td></tr>'; 
                    }
                }
                content += '<tr><td></td><td></td><td></td><td><b>Total (Quantity * Price)</b></td><td><b>'+total+'</b></td><td></td></tr>'; 
                $("#details_result").show();
            } else{
                errorSwal('error','No data found');
                $("#details_result").hide();
            }
            $("#filter_data").html(content);
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function current_stock_filter(){
    var stock_type = $("#stock_type").val();
   $("#loader").removeClass('d-none');
    
    $.ajax({
        type: "POST",
        url: base_url + "Report/current_stock_filter",
        data: {stock_type:stock_type},
        success: function(response) {
           $("#loader").addClass('d-none');
            var res = JSON.parse(response);
            var content = '';
            var totalStock = 0;
            var i=0;
            globStockArr = res;
            if(res.stat == 200){
              showSwal('auto_msg');
                for(var key in res.all_list){
                    if(stock_type == 1){
                        if(res.all_list[key]['current_stock'] == 0){
                            continue;
                        }
                    }
                        i = i+1;
                        totalStock = parseInt(totalStock) + parseInt(res.all_list[key]['current_stock']);
                       content += '<tr><td>'+i+'</td><td>'+res.all_list[key]['part_number']+'</td><td>'+res.all_list[key]['product_name']+'</td><td>'+res.all_list[key]['current_stock']+'</td></tr>'; 
                }
                content += '<tr><td></td><td></td><td><b>Total Current Stock</b></td><td><b>'+totalStock+'</b></td></tr>'; 
                $("#details_result").show();
            } else{
                errorSwal('error','No data found');
                $("#details_result").hide();
            }
            $("#filter_data").html(content);
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function stock_wise_filter(stock_type){
    if(globStockArr != ''){
        var res = globStockArr;
        var content = '';
        var totalStock = 0;
        var i=0;
        if(res.stat == 200){
          showSwal('auto_msg');
            for(var key in res.all_list){
                if(stock_type == 1){
                    if(res.all_list[key]['current_stock'] == 0){
                        continue;
                    }
                }
                    i = i+1;
                    totalStock = parseInt(totalStock) + parseInt(res.all_list[key]['current_stock']);
                   content += '<tr><td>'+i+'</td><td>'+res.all_list[key]['part_number']+'</td><td>'+res.all_list[key]['product_name']+'</td><td>'+res.all_list[key]['current_stock']+'</td></tr>'; 
            }
            content += '<tr><td></td><td></td><td><b>Total Current Stock</b></td><td><b>'+totalStock+'</b></td></tr>'; 
            $("#details_result").show();
        } else{
            errorSwal('error','No data found');
            $("#details_result").hide();
        }
        $("#filter_data").html(content);
    }
}

function stock_in_out_filter(){
    var product_id = $("#product_id").val();
    var from = $("#from").val();
    var to = $("#to").val();
    
    if(from == '' || to == ''){
        errorSwal('error','Please choose date');
        return;
    }
    
    var f=YMD(from);
    var t=YMD(to);
    
   $("#loader").removeClass('d-none');
    
    $.ajax({
        type: "POST",
        url: base_url + "Report/stock_in_out_filter",
        data: {product_id:product_id,from:f,to:t},
        success: function(response) {
           $("#loader").addClass('d-none');
            var res = JSON.parse(response);
            var content = '';
            var i=0;
            if(res.stat == 200){
              showSwal('auto_msg');
                for(var key in res.all_list){
                    var date = DMY(res.all_list[key].date);
                        i = i+1;
                       content += '<tr><td>'+i+'</td><td>'+res.all_list[key]['part_number']+'</td><td>'+res.all_list[key]['previous_quantity']+'</td><td>'+res.all_list[key]['total_purchase']+'</td><td>'+res.all_list[key]['total_sell']+'</td><td>'+res.all_list[key]['total_return']+'</td><td>'+res.all_list[key]['final_stock']+'</td><td>'+date+'</td></tr>'; 
                }
                $("#details_result").show();
            } else{
                errorSwal('error','No data found');
                $("#details_result").hide();
            }
            $("#filter_data").html(content);
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}

function profit_loss_filter(){
    var client_id = $("#client_id").val();
    var product_id = $("#product_id").val();
    var from = $("#from").val();
    var to = $("#to").val();
    
    if(from == '' || to == ''){
        errorSwal('error','Please choose date');
        return;
    }
    
    var f=YMD(from);
    var t=YMD(to);
    
   $("#loader").removeClass('d-none');
    
    $.ajax({
        type: "POST",
        url: base_url + "Report/profit_loss_filter",
        data: {client_id:client_id,product_id:product_id,from:f,to:t},
        success: function(response) {
           $("#loader").addClass('d-none');
            var res = JSON.parse(response);
            var content = '';
            var i=0;
            var totalProductAmount = 0;
            var totalSellAmount = 0;
            if(res.stat == 200){
              showSwal('auto_msg');
                for(var key in res.all_list){
                    var date = DMY(res.all_list[key].sell_date);
                        i = i+1;
                        totalProductAmount = parseFloat(totalProductAmount) + parseFloat(res.all_list[key]['product_amount']);
                        totalSellAmount = parseFloat(totalSellAmount) + parseFloat(res.all_list[key]['sell_amout']);
                       content += '<tr><td>'+i+'</td><td>'+res.all_list[key]['company_name']+'</td><td>'+res.all_list[key]['part_number']+'</td><td>'+res.all_list[key]['default_price']+'</td><td>'+res.all_list[key]['igst']+'</td><td>'+res.all_list[key]['price']+'</td><td>'+res.all_list[key]['discount']+'</td><td>'+res.all_list[key]['tax']+'</td><td>'+res.all_list[key]['quantity']+'</td><td>'+res.all_list[key]['product_amount']+'</td><td>'+res.all_list[key]['sell_amout']+'</td><td>'+date+'</td></tr>'; 
                }
                content += '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total</b></td><td><b>'+totalProductAmount.toFixed(2)+'</b></td><td><b>'+totalSellAmount.toFixed(2)+'</b></td><td></td></tr>';
                $("#details_result").show();
            } else{
                errorSwal('error','No data found');
                $("#details_result").hide();
            }
            $("#filter_data").html(content);
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}


