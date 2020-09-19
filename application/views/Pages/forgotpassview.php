<div class="authMain">
   <a class="back" href="javascript:void(0);" onclick="showDiv('loginview');"><img width="20px" src="<?php echo base_url(); ?>assets/UI/images/next.png"></a>
   <div class="authContainer">
       <h3>Enter Your Register Email Id Below</h3>
       <small>An OTP will be send to this email id</small>
       <div class="authForm">
         <div class="form-group">
            <input type="text" id="emailofuser" class="form-control onlyemail" placeholder="Email Address">
            <span id="emailofuserError" style="color: red"></span> 
            <span id="allError" style="color: red;"></span>
          </div>
          <button class="authActon" type="button" onclick="forgotPass();">SUBMIT</button>
       </div>
       <div class="authFooter">
        <p>Already have an OTP? <a href="javascript:void(0);" onclick="showDiv('updatepassview');">Click here</a></p>
      </div>
   </div>
</div>