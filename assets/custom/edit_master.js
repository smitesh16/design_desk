 var glob_prod = new Array();
 var q_id ='';
 var q_num =''; 

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


$( document ).ready(function() {
                             

                              
    var arr=JSON.parse($('#ids').val());
     q_id   = arr['quotation_id'];
     q_num   = arr['quotation_number'];
     for(x in arr['details'])
      { 

         glob_prod[arr['details'][x]['product_id']] = {product_id:arr['details'][x]['product_id']};
          
         


      }
    
     product_sell();
     
});

// -------------------Adding the product in list-----------------------
function show()
{   
    var client = $('#client').val();
   
    var id = $('#product').val();
    
    
   
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
                           console.log(res);
                           con +='<tr id="product_list_'+res.all_list[0].product_id+'"><td>'+res.all_list[0].product_name+'</td><td>'+res.all_list[0].part_number+'</td><td>'+res.all_list[0].default_price+'</td><td><input type="text" class="twoDecimalNumber form-control" id="price_'+res.all_list[0].product_id+'" onkeyup="product_sell()" maxlength=10 required ><span id="msg1_'+res.all_list[0].product_id+'"></span></td><td><input type="text" class="percent twoDecimalNumber form-control" id="discount_'+res.all_list[0].product_id+'" onkeyup="product_sell()"><span id="msg2_'+res.all_list[0].product_id+'"></span></td><td><input type="text" class="percent twoDecimalNumber form-control" id="tax_'+res.all_list[0].product_id+'"  value="'+res.all_list[0].igst+'" onkeyup="product_sell()"><span id="msg3_'+res.all_list[0].product_id+'"></span></td></td><td>'+res.all_list[0].current_stock+'</td><td><input type="text" class="onlynum lengthValidation form-control " id="quantity_'+res.all_list[0].product_id+'" maxlength=10 onkeyup="product_sell()"><br><span id="message1_'+res.all_list[0].product_id+'"></span></td><td><span id="amt_'+res.all_list[0].product_id+'"></span></td><td><button type="button" class="btn btn-outline-dark btn-sm" onclick="remove_product('+res.all_list[0].product_id+')">Remove</button><input type="hidden" id="stock_'+res.all_list[0].product_id+'" value='+res.all_list[0].current_stock+'><input type="hidden" id="name_'+res.all_list[0].product_id+'" value=\''+res.all_list[0].product_name+'\'><input type="hidden" id="part_num_'+res.all_list[0].product_id+'" value=\''+res.all_list[0].part_number+'\'></td></tr>';


                            
                           
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
           
           

            var con ="";

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
                $('#quantity_'+id).val('');      
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
             
             total_sum   = total_amt.toFixed(2);
             //console.log(total_amt);

             sell_price = sell_price.toFixed(2);
             amount = amount.toFixed(2);

             var list_content='<td class="py-1">'+count+'</td><td class="py-1">'+total_price+'</td><td class="py-1">'+total_dis+'</td><td class="py-1">'+total_tax+'</td><td class="py-1">'+ total_qty +'</td><td class="py-1">'+total_sum+'</td>';

         
              $('#client').prop('disabled', 'disabled');
              $('#amt_'+id).html(amount);
                        
              $('#r_list').html(list_content);
              $('#result_list').show();
                       
    }
   
} 


function remove_product(id)
{   
   //console.log(glob_prod);
    
    delete glob_prod[id];
    $('#product_list_'+id).remove();
    
   
    if(Object.keys(glob_prod).length == 0){
       $('#product_list').hide();
       $('#result_list').hide();
       $('#client').prop('disabled', false);
    }
   product_sell();

}

function submit_product()
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


             /* dis = dis.toFixed(2);
              tax = tax.toFixed(2);*/
              sell_price = sell_price.toFixed(2);
              amount = amount.toFixed(2);

            
              product_list[id] ={quotation_id:q_id,quotation_num:q_num,product_id:id,client_id:client,quantity:qt,stock:stock,price:price,discount:dis,per_discount:discount,per_tax:tax1,tax:tax,sell_price:sell_price,amount:amount,sale_note:sale_note,name:name};
            
            
          } 

            product_list = product_list.filter(function (el) {
                return el != null;
              });
    }
   


     $.ajax({
        type: "POST",
        url: base_url + "Quotation/Edit_product",
        data: {s_list:product_list},
        success: function(response) {
           console.log(response);
            var res = JSON.parse(response);
            if(res.stat == 200)
            {
                successSwal('new_msg',res.msg);
                window.location = base_url+'Quotation';
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

















