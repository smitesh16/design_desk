var base_url = $("#base_url").val();

function showDiv(viewpage,passval=0)
{
  $.ajax({
        type: "POST",
        url: base_url + "Signin/ShowDiv",
        data: {viewpage:viewpage,passval:passval},
        success: function(response) {
          var res = JSON.parse(response);
          $("#loginmainsec").html(res);
          commonfunction();
        },
        error: function(response) {
        }
      });
}

$("#signin").click(function(){
  $("#allError").html("");
  var emailofuser = $("#emailofuser").val();
  var password = $("#password").val();

  $.ajax({
        type: "POST",
        url: base_url + "Signin/Login",
        data: {user_email:emailofuser,password:password},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            location.href = base_url+"Home";
          }else{
            $("#allError").html("Login failed or Your account is not active.");
          }
        },
        error: function(response) {
        }
      });
})

function register(){
  $(".err-msg").html("");
  var user_name = $("#user_name").val();
  var user_email = $("#user_email").val();
  var contact_number = $("#contact_number").val();
  var company = $("#company").val();
  var user_address = $("#user_address").val();
  var password = $("#password").val();
  var conf_password = $("#conf_password").val();
  var active_status = $("#active_status").val();

  if(user_name.trim() == ""){
    $("#user_nameallError").html("Name cannot be blank");
    $("#user_name").focus();
    return;
  }
  if(user_email.trim() == ""){
    $("#user_emailError").html("Email cannot be blank");
    $("#user_email").focus();
    return;
  }
  if(password.trim() == ""){
      $("#passwordallError").html("Password cannot be blank");
      $("#password").focus();
      return;
    }



  if(password != conf_password){
    $("#allError").html("Both password not matched");
    return;
  }

  $.ajax({
        type: "POST",
        url: base_url + "Signin/Register",
        data: {user_name:user_name,user_email:user_email,contact_number:contact_number,company:company,user_address:user_address,password:password,active_status:active_status},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            if(active_status == 1){
              location.href = base_url+"Home";
            }else{
              showDiv('thankyouview');
              return;
            }
          }else{
             $("#allError").html("Registration Failed. This email is already exist.");
             return;
          }
        },
        error: function(response) {
        }
      });
}

function checkAccesscode()
{
  $("#allError").html("");
  var accessCode = $("#accessCode").val();
   $.ajax({
        type: "POST",
        url: base_url + "Signin/CheckAccesscode",
        data: {accesscode:accessCode},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            showDiv('registerview',1);
          }else{
            $("#allError").html("This is not a valid code");
          }
        },
        error: function(response) {
        }
      });
}

function SendEnquery()
{
   $("#allError").html("");
   var product_id = $("#product_id").val();
   var message = $("#message").val();
   var moq = $("#moq").val();
   var territory = $("#territory").val();

   $.ajax({
        type: "POST",
        url: base_url + "Enquiry/SendEnquiry",
        data: {product_id:product_id,message:message,moq:moq,territory:territory},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            // $("#allError").html("Your enquiry posted successfully.").css("color","green");
            swal("Your enquiry posted successfully.");
          }else{
            $("#allError").html("Failed ! Unabel to post your enquery.").css("color","red");
          }
        },
        error: function(response) {
        }
      });
}

function addtobag(string)
{
   $("#allError").html("");
   var testArr = JSON.parse(string);
   console.log("xxxx"+string);
   console.log("dfsdf"+testArr.product_id);
   var product_id = testArr.product_id;//$("#product_id").val();
   $.ajax({
        type: "POST",
        url: base_url + "Enquiry/Addtobag",
        data: {product_id:product_id},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            $("#cartCount").html(res.all_list.length);
            swal("Item added to cart");
            // $("#allError").html("Your enquiry posted successfully.").css("color","green");
          }else{
             swal("This item is already added to cart");
            // $("#allError").html("Failed ! Unabel to post your enquery.").css("color","red");
          }
        },
        error: function(response) {
        }
      });
}

function ShowCart()
{
  $.ajax({
        type: "POST",
        url: base_url + "Enquiry/ShowCart",
        data: {},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          $("#cartview").html(res);
          closeCart();
        },
        error: function(response) {
        }
      });
}

function closeCart(){
  $('.cartClose').on('click', function(event) {
      $('.beg').trigger("click");
      $('.cartBackDrop').hide();
  });
}

function removeCart(cart_id)
{
  $.ajax({
        type: "POST",
        url: base_url + "Enquiry/RemoveCart",
        data: {cart_id:cart_id},
        success: function(response) {
          console.log(response);
          ShowCart();
          $("#cartCount").html(response);
        },
        error: function(response) {
        }
      });
}

function Checkout()
{
   $.ajax({
        type: "POST",
        url: base_url + "Enquiry/SendBulkEnquiry",
        data: {},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            ShowCart();
            $("#cartCount").html("0");
            location.href = base_url+"Thankyou";
          }else{
            swal("No item in your cart.");
          }
        },
        error: function(response) {
        }
      });
}