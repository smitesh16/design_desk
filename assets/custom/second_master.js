
var glob_prod = new Array();


// -------------------Adding the product in list-----------------------
function show()
{   
    var client = $('#client').val();
   
    var id = $('#product').val();
    
    if(client == '' || client == 0 || client == null)
   {
      $( document ).ready(function() {  errorSwal('error','Please choose a client')});
      return false;
   }

   
     if(id in glob_prod){

        $( document ).ready(function() {  errorSwal('error','Already chosen this product')});
    } 
    else{
        glob_prod[id] = {product_id:id};
       var tableAttribute = 'product';
       var data = {};
       data[tableAttribute] = {};
       data[tableAttribute][tableAttribute+'_id'] = id;
              

        if(id == '' || id == null )
        {
            $( document ).ready(function() {  errorSwal('error','Please choose a product')});
            return false;
        }
               
               var con ="";


                 $.ajax({
                        type: "POST",
                        url: base_url + "General/GetSingleData",
                        data: data,
                        success: function(response) {
                            

                           var res = JSON.parse(response);
                           //console.log(res);
                           con +='<tr id="product_list_'+res.all_list[0].product_id+'"><td>'+res.all_list[0].product_name+'</td><td>'+res.all_list[0].part_number+'</td><td>'+res.all_list[0].default_price+'</td><td><input type="text" class="twoDecimalNumber form-control" id="price_'+res.all_list[0].product_id+'" onkeyup="product_sell()" maxlength=10 required ></td><td><input type="text" class="percent twoDecimalNumber form-control" id="discount_'+res.all_list[0].product_id+'" onkeyup="product_sell()"></td><td><input type="text" class="percent twoDecimalNumber form-control" id="tax_'+res.all_list[0].product_id+'" value="'+res.all_list[0].igst+'" onkeyup="product_sell()"><span id="msg3_'+res.all_list[0].product_id+'"></span></td></td><td>'+res.all_list[0].current_stock+'</td><td><input type="text" class="onlynum lengthValidation form-control " id="quantity_'+res.all_list[0].product_id+'" maxlength=10 onkeyup="product_sell()"></td><td><span id="amt_'+res.all_list[0].product_id+'"></span></td><td><button type="button" class="btn btn-outline-dark btn-sm" onclick="remove_product('+res.all_list[0].product_id+')">Remove</button><input type="hidden" id="stock_'+res.all_list[0].product_id+'" value='+res.all_list[0].current_stock+'><input type="hidden" id="name_'+res.all_list[0].product_id+'" value=\''+res.all_list[0].product_name+'\'><input type="hidden" id="part_num_'+res.all_list[0].product_id+'" value=\''+res.all_list[0].part_number+'\'></td></tr>';


                            
                           
                            $('#product_list').show();
                            $('html, body').animate({
                            scrollTop: $("#product_list").offset().top
                          }, 1000);
                           $('#list').append(con);
                           $('#result_list').show();

                             product_sell();


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
                                    if(/^([1-9]\d*)$/.test($(self).val()))
                                        $(self).val('');
                                }, 0);
                                product_sell();    
                            });

                            jQuery('.percent').keyup(function () {  
                               
                                    var val = parseFloat(this.value);
                                    if(val > 100 || val <= 0 )
                                    {
                                        
                                        this.value ='';        
                                    }
                                    product_sell();
                               
                            });

                             jQuery('#quantity_'+id).keyup(function () {  
                                    
                                     if(this.value == '')
                                     {
                                       var val  = 0;
                                     }
                                     else
                                     {
                                        var val   =  parseInt(this.value);
                                     }
                                   
                                    var stock = parseInt($('#stock_'+id).val());
                                    
                               
                                    if(val > stock || val <= 0 )
                                    {
                                        
                                        this.value ='';        
                                    }
                                    product_sell();
                               
                            });



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
                        },
                        error: function(response) {
                           
                            $( document ).ready(function() {  errorSwal('error','Something went wrong. Reload & try again.')});
                        }
                });
             
        }
}


// -------------------Calculating the total amount-----------------------

function product_sell()
{   
      
    var total_tax   = 0.00;
    var total_dis   = 0.00;
    var total_price = 0.00;
    var total_qty   = 0;
    var total_amt   = 0.00;
    
    

    var s_list = glob_prod.filter(function (el) {
      return el != null;
    });
   
     var count = s_list.length;
      var total_sum ='';

       for(var key in s_list) {
            var id = s_list[key]['product_id'];
           
           
            var qt     = $('#quantity_'+id).val();
            var stock  = $('#stock_'+id).val();
            var name  = $('#name_'+id).val();
            var part_num  = $('#part_num_'+id).val();



            var price    = $('#price_'+id).val();
            var discount = $('#discount_'+id).val();
            var tax1      = $('#tax_'+id).val();
            var tax_val     = 0;
            var dis_val     = 0;
            var price_val   = 0;

            var con ="";
            
             if(price == '' || price == 0 || price == '.' || price == '0.')
            {  
                
                price = 0.00;
            }
            
             if(tax1 == '' || tax1 == '.0' ||  tax1 == '.00' || tax1 == '.')
            {
               tax1 =0.00;
                
            }
            
             if(qt == '' || (parseInt(qt) > parseInt(stock)) || (parseInt(qt) == 0))
            { 
                qt = 0;
                      
            }
            
            if(discount == '.' || discount == '' || discount =='.0' || discount == '.00')
            {
                discount=0.00;
            }
           
           
             qt       = parseInt(qt);
             stock    = parseInt(stock);
             price    = parseFloat(price);
             discount = parseFloat(discount);
             tax1     = parseFloat(tax1);
            

           

            var dis        = parseFloat(price * discount)/100;
            var new_price  = parseFloat(price - dis);
            var tax        = parseFloat(new_price * tax1)/100;
            var sell_price = parseFloat(new_price)  + parseFloat(tax);
            var amount     = parseFloat(sell_price * qt);

            
            
            if(qt =='' || qt ==0 || qt== null)
            {
               tax_val  = tax;
               dis_val  = dis;
               price_val= price;
            }
            else
            {
             tax_val   = parseFloat(tax * qt);
             dis_val   = parseFloat(dis * qt);
             price_val   = parseFloat(price * qt);
            }
           
            
             total_tax   = parseFloat(total_tax) +  parseFloat(tax_val);
             total_tax   = total_tax.toFixed(2);
             total_dis   = parseFloat(total_dis) +  parseFloat(dis_val);
             total_dis   = total_dis.toFixed(2);
             total_price = parseFloat(total_price) +  parseFloat(price_val);
             total_price = total_price.toFixed(2);
             total_qty   = parseInt(total_qty) + parseInt(qt);
             total_amt   = parseFloat(total_amt) +  parseFloat(amount);
             //total_amt   = total_amt.toFixed(2);
           
              total_sum   = total_amt.toFixed(2);

              sell_price = sell_price.toFixed(2);
              amount = amount.toFixed(2);
            

             var list_content='<td class="py-1">'+count+'</td><td class="py-1">'+total_price+'</td><td class="py-1">'+total_dis+'</td><td class="py-1">'+total_tax+'</td><td class="py-1">'+ total_qty +'</td><td class="py-1">'+total_sum+'</td>';

         
              $('#client').prop('disabled', 'disabled');
              $('#amt_'+id).html(amount);
                        
              $('#r_list').html(list_content);
              $('#result_list').show();
                       
    }
   
} 

// -------------------Removing a product from list-----------------------

function remove_product(id)
{   

    
    delete glob_prod[id];
    $('#product_list_'+id).remove();
    
   
   

    if(Object.keys(glob_prod).length == 0){
       $('#product_list').hide();
       glob_ids = '';
       $('#result_list').hide();
       $('#client').prop('disabled', false);
    }
   product_sell();

}

// -------------------Submit Product (Both Sell and Quotation)-----------------------

function submit_product(type)
{   
    var client = $('#client').val();
    var sale_note = CKEDITOR.instances.sale_note.getData();
    var product_list= new Array();

    var s_list = glob_prod.filter(function (el) {
      return el != null;
    });

   
    if(s_list == '' || s_list == null)
     {
        $( document ).ready(function() {  errorSwal('error','Please enter details')});
        return false;
     }
    else
    {
      for (var key in s_list) 
      {     
            
            var id        = s_list[key]['product_id'];
            var qt        = $('#quantity_'+id).val();
            var price     = $('#price_'+id).val();
            var discount  = $('#discount_'+id).val();
            var stock     = $('#stock_'+id).val();
            var tax1      = $('#tax_'+id).val();
            var name      = $('#name_'+id).val();
            var part_num  = $('#part_num_'+id).val();

             if(price == '' || price == 0)
            {  
                
               $( document ).ready(function() {  errorSwal('error','Please enter  \''+part_num+'\'  price')});
               return false;
            }
           
             if(tax1 == '' || tax1 == '.0' ||  tax1 == '.00')
            {
               
                $( document ).ready(function() {  errorSwal('error','Please enter  \''+part_num+'\'  tax')});
                return false;
            }
             if(qt == '' || (parseInt(qt) > parseInt(stock)) || (parseInt(qt) == 0))
            {
               
                $( document ).ready(function() {  errorSwal('error','Please enter  \''+part_num+'\'  quantity')});
                return false;
            }

             if(discount == '.' || discount == '' || discount =='.0' || discount == '.00')
            {
                discount=0.00;
            }

               qt       = parseInt(qt);
               stock    = parseInt(stock);
               price    = parseFloat(price);
               discount = parseFloat(discount);
               tax1     = parseFloat(tax1);
              

             

              var dis        = parseFloat(price * discount)/100;
              var new_price       = parseFloat(price) - parseFloat(dis);
              var tax        = parseFloat(new_price * tax1)/100;
              var sell_price = parseFloat(new_price)  + parseFloat(tax);
              var amount = parseFloat(sell_price * qt);


           
              sell_price = sell_price.toFixed(2);
              amount = amount.toFixed(2);

            
              product_list[id] ={product_id:id,client_id:client,quantity:qt,stock:stock,price:price,discount:dis,per_discount:discount,per_tax:tax1,tax:tax,sell_price:sell_price,amount:amount,sale_note:sale_note,name:name};
            
            
          } 

            product_list = product_list.filter(function (el) {
                return el != null;
              });
    }
   
 

if(type ==  1)
{
    var link     = base_url + "Sell/Add_product";
    var redirect = base_url+"Sell" ;
}
else if(type ==  2)
{
    var link = base_url + "Quotation/Add_product";
    var redirect = base_url+"Quotation" ;
}

$("#loader").removeClass('d-none');

     $.ajax({
        type: "POST",
        url: link,
        data: {s_list:product_list},
        success: function(response) {
        $("#loader").addClass('d-none');
           console.log(response);
            var res = JSON.parse(response);
            if(res.stat == 200)
            {
                successSwal('new_msg',res.msg);
                window.location = redirect;
                //glob_prod = '';
            }
            else if(res.stat == 400)
            {
                errorSwal('error',res.msg);
            }
            
        },
        error: function(response) {
             errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}


// ---------------- Get single Sell or Quotation---------------

function GetSingleSell(id,type)
{     

    if(type ==  1)
    {
        var link     = base_url + "Sell/get_sell";
        
    }
    else if(type ==  2)
    {
        var link = base_url + "Quotation/get_quotation";
       
    }

      $.ajax({
        type: "POST",
        url: link,
        data: {id:id},
        success: function(response) {
            console.log(response);
            var res = JSON.parse(response);
            console.log(res);
            var arr = res['all_list'];
            var x;
            var y;
            var content = '';
            var total_dis = 0.00;
            var total_tax = 0.00;
            var total_price = 0.00;
            var total_qty = 0.00;
            var content = '';
            var con = '';
          
            for(x in arr)
            {  
                var final_amt   = arr[x]['final_amount'];
                if(type ==  1)
                {
                    var invoice = arr[x]['invoice_number'];
                    
                }
                else if(type ==  2)
                {
                   var invoice = arr[x]['quotation_number'];
                   
                }
                
                var comp_name = arr[x]['company_name'];
                var address = arr[x]['company_address'];
                var person = arr[x]['contact_person'];
                var contact_no = arr[x]['contact_number'];
                var pan_no = arr[x]['pan_number'];
                var gst_no = arr[x]['gstin_number'];
                var details = arr[x]['details'];
                var tax_val = 0;
                var dis_val = 0;
                var price_val = 0;
                for(y in details)
                {   
                    var dis     = parseFloat(details[y]['price'] * details[y]['discount'])/100;
                    var n_price = parseFloat(details[y]['price']) - parseFloat(dis);
                    var tax     = parseFloat(n_price * details[y]['tax'])/100;
                   
                    
                    
                    var subtotal= parseFloat(details[y]['quantity'] * (n_price + tax));
                    subtotal    = subtotal.toFixed(2);

                    
                  
                     tax_val   = parseFloat(tax * details[y]['quantity']);
                     dis_val   = parseFloat(dis * details[y]['quantity']);
                     price_val   = parseFloat(details[y]['price'] * details[y]['quantity']);
                   
                     total_tax   = parseFloat(total_tax) +  parseFloat(tax_val);
                     total_tax   = total_tax.toFixed(2);
                     total_dis   = parseFloat(total_dis) +  parseFloat(dis_val);
                     total_dis   = total_dis.toFixed(2);
                     total_price = parseFloat(total_price) + parseFloat(price_val);
                     total_price = total_price.toFixed(2);
                     total_qty   = parseInt(total_qty) + parseInt(details[y]['quantity']);
          
                     var per_dis = parseFloat(details[y]['discount']).toFixed(2);
                     var per_tax = parseFloat(details[y]['tax']).toFixed(2);
                    
                    content+='<tr><td>'+details[y]['product_name']+'</td><td>'+details[y]['part_number']+'</td><td>'+details[y]['price']+'</td><td>'+per_dis+'</td><td>'+per_tax+'</td><td>'+details[y]['quantity']+'</td><td>'+subtotal+'</td></tr>';

                }
               

            }
           

            content +='<tr><td colspan=2><b>Total</b></td><td>'+total_price+'</td><td>'+total_dis+'</td><td>'+total_tax+'</td><td>'+total_qty+'</td><td>'+final_amt+'</td></tr>';
            con+='<tr><td>'+comp_name+'</td><td>'+address+'</td><td>'+person+'</td><td>'+contact_no+'</td><td>'+pan_no+'</td><td>'+gst_no+'</td></tr>';
            $('#com_list').html(con);
            
            $('#pro_list').html(content);
            $('#inv').html(invoice);
            $('#amt').html(final_amt);
          
            $('#sellModal').modal('show');
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}


// ------------------ Sell a product from quotation -----------------------

function add_quotation_sell(id)
{
    
     var product_list= new Array();
      $.ajax({
        type: "POST",
        url: base_url + "Quotation/get_quotation",
        data: {id:id},
        success: function(response) {
            console.log(response);
            var res = JSON.parse(response);
        
            var arr = res['all_list'];
            var x;
            var y;
            var content = '';
            var total_dis = 0.00;
            var total_tax = 0.00;
            var total_price = 0.00;
            var total_qty = 0.00;
            var content = '';
            var con = '';
          
            for(x in arr)
            {  
                var final_amt   = arr[x]['final_amount'];
                var invoice = arr[x]['quotation_number'];
                var comp_name = arr[x]['company_name'];
                var address = arr[x]['company_address'];
                var person = arr[x]['contact_person'];
                var contact_no = arr[x]['contact_number'];
                var pan_no = arr[x]['pan_number'];
                var gst_no = arr[x]['gstin_number'];
                var details = arr[x]['details'];
                var client  = arr[x]['client_id'];
                

                for(y in details)
                {   
                   
                    
                    var dis     = parseFloat(details[y]['price'] * details[y]['discount'])/100;
                    var n_price = parseFloat(details[y]['price']) - parseFloat(dis);
                    var tax     = parseFloat(n_price * details[y]['tax'])/100;
            
                    
                    var sell_price = parseFloat(n_price) + parseFloat(tax);
                    var subtotal   = parseFloat(details[y]['quantity'] * (n_price + tax));
                    subtotal    = subtotal.toFixed(2);

        
                     var id          = details[y]['product_id'];
                    
                     var qt          = details[y]['quantity'];
                     var stock       = details[y]['current_stock'];
                     var price       = details[y]['price'];
                     var discount    = details[y]['discount'];
                     var tax1        = details[y]['tax'];
                     var sale_note   = '';
                     var name        = details[y]['product_name'];

                     
                      product_list[id] ={product_id:id,client_id:client,quantity:qt,stock:stock,price:price,discount:dis,per_discount:discount,per_tax:tax1,tax:tax,sell_price:sell_price,amount:subtotal,sale_note:sale_note,name:name};
                   
                }
                
            }

            product_list = product_list.filter(function (el) {
                return el != null;
              });

           $.ajax({
                type: "POST",
                url: base_url + "Sell/Add_product",
                data: {s_list:product_list},
                success: function(response) {
                   console.log(response);
                    var res = JSON.parse(response);
                    if(res.stat == 200)
                    {
                        successSwal('new_msg',res.msg);
                        window.location = base_url + "Sell";
                    }
                    else if(res.stat == 400)
                    {
                        errorSwal('error',res.msg);
                    }
                    else if(res.stat == 500)
                    {
                        errorSwal('error',res.msg);
                    }
                    
                },
                error: function(response) {
                     errorSwal('error','Something went wrong. Reload & try again.');
                    return;
                }
            });





         
        },
        error: function(response) {
            errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}


// ---------------- Delete a quotation ---------------------------

function delete_quotation(id)
{

     swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3f51b5',
        cancelButtonColor: '#ff4081',
        confirmButtonText: 'Great ',
        buttons: {
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-outline-dark",
            closeModal: true,
          },
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-outline-success",
            closeModal: true
          }
        }
      }).then((willDelete) => {
      if (willDelete) {
         $.ajax({
                    type: "POST",
                    url: base_url + "Quotation/delete",
                    data: {id:id},
                    success: function(response) {
                       console.log(response);
                        var res = JSON.parse(response);
                        if(res.stat == 200)
                        {
                            successSwal('new_msg',res.msg);
                            window.location = base_url + "Quotation";
                        }
                        else if(res.stat == 400)
                        {
                            errorSwal('error',res.msg);
                        }
                        
                    },
                    error: function(response) {
                         errorSwal('error','Something went wrong. Reload & try again.');
                        return;
                    }
                });
      } else {
        swal("Your Data is not deleted!");
      }
    });


}


// ---------------- all sell report filtered data------------------



function sell_filter()
{
   
   var client   = $('#client').val();
   var from_date= $('#from').val();
   var to_date  = $('#to').val();


   if(from_date == '')
   {
     errorSwal('error','Please enter from date');
     return false;
   }
   if(to_date == '')
  {
     errorSwal('error','Please enter to date');
     return false;
   }
   

    var from =YMD(from_date);
    var to  =YMD(to_date);
    $("#loader").removeClass('d-none');

     $.ajax({
        type: "POST",
        url: base_url + 'Report/sell_filter',
        data: {client:client,from:from,to:to},
        success: function(response) {
             
            $("#loader").addClass('d-none');
            var res = JSON.parse(response);
           
            var arr = res['all_list'];
            var x;
            var y;
           
            var total_dis   = 0.00;
            var total_tax   = 0.00;
            var total_price = 0.00;
            var total_qty   = 0.00;
            var con         = '';
            var c
            var grand_total   =0.00;
            var i =0;
            if(res.stat == 200)
            {
               for(x in arr)
               {  
                
                var final_amt   = arr[x]['final_amount'];
                var invoice = arr[x]['invoice_number'];
                var comp_name = arr[x]['company_name'];
                var address = arr[x]['company_address'];
                var person = arr[x]['contact_person'];
                var contact_no = arr[x]['contact_number'];
                var pan_no = arr[x]['pan_number'];
                var gst_no = arr[x]['gstin_number'];
                var details = arr[x]['details'];
                var date = DMY(arr[x]['sell_date']);
               
                var tax_val = 0;
                var dis_val = 0;
                var price_val = 0;
                
                
                for(y in details)
                {   
                    i =i + 1;
                    var dis     = parseFloat(details[y]['price'] * details[y]['discount'])/100;
                    var n_price = parseFloat(details[y]['price']) - parseFloat(dis);
                    var tax     = parseFloat(n_price * details[y]['tax'])/100;
                   
                    
                    var subtotal= parseFloat(details[y]['quantity'] * (n_price + tax));
                    grand_total = parseFloat(grand_total) + parseFloat(subtotal);
                    subtotal    = subtotal.toFixed(2);
                
                    price_val = parseFloat(details[y]['price']).toFixed(2);
                    
                    con +='<tr><td>'+i+'</td><td>'+invoice+'</td><td>'+comp_name+'</td><td>'+details[y]['part_number']+'</td><td>'+price_val+'</td><td>'+details[y]['discount']+'</td><td>'+details[y]['tax']+'</td><td>'+details[y]['quantity']+'</td><td>'+subtotal+'</td><td>'+date+'</td></tr>';

                 }
               
               }
               
               grand_total  = grand_total.toFixed(2);
               con +='<tr><td colspan=7></td><td><b>Total</b></td><td><b>'+grand_total+'</b></td><td></td></tr>';

                $('#filter_data').html(con);
                $('#sell_details').show();
            }
            else if(res.stat == 500)
            {  
               $('#filter_data').html('');
               $('#sell_details').hide(); 
               errorSwal('error','No Data');
               return false;
            }

           
            
        },
        error: function(response) {
             errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });

}

// ---------------- all payment report filtered data------------------


function cash_filter()
{
   
  
   var from_date= $('#from').val();
   var to_date  = $('#to').val();


   if(from_date == '')
   {
     errorSwal('error','Please enter from date');
     return false;
   }

   if(to_date == '')
   {
     errorSwal('error','Please enter to date');
     return false;
   }

    var from =YMD(from_date);
    var to  =YMD(to_date);

     $("#loader").removeClass('d-none');

     $.ajax({
        type: "POST",
        url: base_url + 'Report/cash_filter',
        data: {from:from,to:to},
        success: function(response) {
             $("#loader").addClass('d-none');
            
            var res = JSON.parse(response);
            var con='';
            var total =0;
            if(res.stat == 200)
            {  
                if(res.all_list.payment_details !=0)
                {

                    for(var i=0;i<res.all_list.payment_details.length;i++)
                    {   
                        j=i+1;
                        total = parseFloat(total) + parseFloat(res.all_list.payment_details[i].amount_paid);
                       
                        var date = DMY(res.all_list.payment_details[i].date);
                        con +='<tr><td>'+j+'</td><td>'+res.all_list.payment_details[i].invoice_number+'</td><td>'+res.all_list.payment_details[i].voucher_number+'</td><td>'+res.all_list.payment_details[i].company_name+'</td><td>'+res.all_list.payment_details[i].remarks+'</td><td>'+res.all_list.payment_details[i].amount_paid+'</td><td>'+date+'</td></tr>';

                    }

                     con +='<tr ><td colspan=4></td><td><b>Total</b></td><td ><b>'+total+'</b></td><td></td></tr>';
                     $('#filter_data').html(con);
                     $('#payment_details').show();

                   
                 }
                 else
                 {
                    $('#filter_data').html('');
                    $('#payment_details').hide(); 
                    errorSwal('error','No Data');
                    return false;
                    
                 }
          
                      
            }
            else
            {
               $('#filter_data').html('');
               $('#payment_details').hide(); 
               errorSwal('error','No Data');
               return false;
            }
           
            
        },
        error: function(response) {
             errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });

}

// ---------------- all customer report filtered data------------------


function customer_filter()
{
   var client   = $('#client').val();
   var from_date= $('#from_date').val();
   var to_date  = $('#to_date').val();


   if(client == '' || client == null)
   {
     errorSwal('error','Please choose a Client');
     return false;
   }

   if(from_date)
   {
     var from =YMD(from_date);
   }
   else
   {
     var from ='';
   }
   if(to_date)
   {
     var to  =YMD(to_date);
   }
   else
   {
     var to ='';
   }
    
    $("#loader").removeClass('d-none');

     $.ajax({
        type: "POST",
        url: base_url + 'Report/customer_filter',
        data: {client:client,from:from,to:to},
        success: function(response) {
            $("#loader").addClass('d-none');
           
            var res = JSON.parse(response);
          
            var arr = res['all_list'];
            var x;
            var con         = '';
            
            var grand_total_pay   =0.00;
            var grand_total_return   =0.00;
            var grand_total_out   =0.00;
            var grand_total_sell   =0.00;
            var i =0;
            if(res.stat == 200)
            {
                for(x in arr)
                {   
                    i =i + 1;
                    grand_total_pay = parseFloat(grand_total_pay) + parseFloat(arr[x]['payment_amount']); 
                    grand_total_return = parseFloat(grand_total_return) + parseFloat(arr[x]['return_amount']); 
                    grand_total_out= parseFloat(grand_total_out) + parseFloat(arr[x]['outstanding_amount']); 
                    grand_total_sell= parseFloat(grand_total_sell) + parseFloat(arr[x]['final_amount']); 
                    con +='<tr><td>'+i+'</td><td>'+arr[x]['company_name']+'</td><td>'+arr[x]['invoice_number']+'</td><td>'+arr[x]['final_amount']+'</td><td>'+arr[x]['outstanding_amount']+'</td><td>'+arr[x]['payment_amount']+'</td><td>'+arr[x]['return_amount']+'</td><td>'+arr[x]['sell_date']+'</td></tr>';

                 }
               
               
               
               grand_total_pay  = grand_total_pay.toFixed(2);
               grand_total_return  = grand_total_return.toFixed(2);
               grand_total_out  = grand_total_out.toFixed(2);
               grand_total_sell  = grand_total_sell.toFixed(2);
               con +='<tr><td colspan=2></td><td><b>Total</b></td><td><b>'+grand_total_sell+'</b></td><td><b>'+grand_total_out+'</b></td><td><b>'+grand_total_pay+'</b></td><td><b>'+grand_total_return+'</b></td><td></td></tr>';

                $('#filter_data').html(con);
                $('#details').show();
            }
            else if(res.stat == 500)
            {  
               $('#filter_data').html('');
               $('#details').hide(); 
               errorSwal('error','No Data');
               return false;
            }

           
            
        },
        error: function(response) {
             errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });
}


// ---------------- all return report filtered data------------------

function return_filter()
{
   
   var client   = $('#client').val();
   var from_date= $('#from').val();
   var to_date  = $('#to').val();


   if(from_date == '')
   {
     errorSwal('error','Please enter from date');
     return false;
   }

   if(to_date == '')
   {
     errorSwal('error','Please enter to date');
     return false;
   }
   

    var from =YMD(from_date);
    var to  =YMD(to_date);
    $("#loader").removeClass('d-none');

     $.ajax({
        type: "POST",
        url: base_url + 'Report/return_filter',
        data: {client:client,from:from,to:to},
        success: function(response) {
             
             $("#loader").addClass('d-none');

            var res = JSON.parse(response);
            console.log(res);
            var arr = res['all_list'];
            var con         = '';
            var grand_total   =0.00;
            var i =0;
            if(res.stat == 200)
            {
               for(var x in arr)
               {  
                
               
                var date = DMY(arr[x]['date']);
                var customer = arr[x]['customer_details'][0]['company_name'];
                var invoice = arr[x]['sale_details'][0]['invoice_number'];
                var final_amt = arr[x]['sale_details'][0]['final_amount'];
                var details = res['all_list'][x]['product_details'];
                
                for(y in details)
                {   
                    i =i + 1;
                   
                    grand_total = parseFloat(grand_total) + parseFloat(details[y]['return_amount']);
                    con +='<tr><td>'+i+'</td><td>'+customer+'</td><td>'+invoice+'</td><td>'+details[y]['price']+'</td><td>'+details[y]['discount']+'</td><td>'+details[y]['tax']+'</td><td>'+details[y]['return_quantity']+'</td><td>'+details[y]['return_amount']+'</td><td>'+date+'</td></tr>';

                 }
               
               }
               
               grand_total  = grand_total.toFixed(2);
               con +='<tr><td colspan=6></td><td><b>Total</b></td><td ><b>'+grand_total+'</b></td><td></td></tr>';

                $('#filter_data').html(con);
                $('#sell_details').show();
            }
            else if(res.stat == 500)
            {  
               $('#filter_data').html('');
               $('#sell_details').hide(); 
               errorSwal('error','No Data');
               return false;
            }


           
            
        },
        error: function(response) {
             errorSwal('error','Something went wrong. Reload & try again.');
            return;
        }
    });

}

















