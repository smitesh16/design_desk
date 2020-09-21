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
  var password = $("#loginpassword").val();

  $.ajax({
        type: "POST",
        url: base_url + "Signin/Login",
        data: {user_email:emailofuser,password:password},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            swal("Congratulations, full access has been unlocked. The showroom will now reload")
            .then((value) => {
               parent.redirectToHome();
            });
           
            // location.href = base_url+"Home";
          }else{
            swal("Sorry, Login failed or Your account is not active.");
          }
        },
        error: function(response) {
        }
      });
})

function redirectToHome(){
  location.href = base_url+"Home";
}

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
  if(active_status == 0){
    var accessCode = 0;
  }else{
    var accesscode = active_status;
    active_status = 1;
  }

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
        data: {user_name:user_name,user_email:user_email,contact_number:contact_number,company:company,user_address:user_address,password:password,active_status:active_status,accesscode:accesscode},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
              swal("Thank you for registering with us, Micro Cotton team will verify your account and get in touch within 1-3 business days. We appreciate your patience.")
              .then((value) => {
                 parent.redirectToHome();
              });
          }else{
             swal("Registration Failed. This email is already exist.");
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
            showDiv('registerview',accessCode);
          }else{
            $("#allError").html("This is not a valid code");
          }
        },
        error: function(response) {
        }
      });
}

function forgotPass()
{
  $("#allError").html("");
  var emailofuser = $("#emailofuser").val();
   $.ajax({
        type: "POST",
        url: base_url + "Signin/ForgotPass",
        data: {user_email:emailofuser},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            showDiv('updatepassview');
          }else{
            $("#allError").html("This email id is not register with us.");
          }
        },
        error: function(response) {
        }
      });
}
function resetPass()
{
  $("#allError").html("");
  var otp = $("#otp").val();
  var password = $("#password").val();
  var confpassword = $("#confpassword").val();

  if(otp == 0 || otp.trim() == ""){
    $("#allError").html("OTP cannot be 0 or blank");
    $("#otp").focus();
    return;
  }
  if(password.trim() == ""){
      $("#allError").html("Password cannot be blank");
      $("#password").focus();
      return;
    }

  if(password != confpassword){
    $("#allError").html("Both password not matched");
    return;
  }

   $.ajax({
        type: "POST",
        url: base_url + "Signin/ResetPass",
        data: {otp:otp,password:password},
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
             swal("Your passowrd reset successfully. Please login to continue access your account.")
            .then((value) => {
               showDiv('loginview');
            });
          }else{
            $("#allError").html("This OTP is expired or is not matched.");
          }
        },
        error: function(response) {
        }
      });
}

function SendEnquery(string)
{
   $("#allError").html("");
   var testArr = JSON.parse(string);
   var product_id = testArr.product_id; //$("#product_id").val();
   var message = testArr.message; //$("#message").val();
   var moq = testArr.moq; //$("#moq").val();
   var territory = testArr.territory; //$("#territory").val();

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
            swal("Item added to bag");
            // $("#allError").html("Your enquiry posted successfully.").css("color","green");
          }else{
             swal("This item is already added to bag");
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
      $('.cartView').removeClass("show");
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
  var map = {};
    $('.cartTable').find('.myinput').each(function(){
        map[$(this).attr("name")] = $(this).val();
    });
   $.ajax({
        type: "POST",
        url: base_url + "Enquiry/SendBulkEnquiry",
        data: map,
        success: function(response) {
          console.log(response);
          var res = JSON.parse(response);
          if(res.stat == 200){
            ShowCart();
            $("#cartCount").html("0");
            window.open(base_url+"Thankyou");
            // location.href = base_url+"Thankyou";
          }else{
            swal("No item in your bag.");
          }
        },
        error: function(response) {
        }
      });
}