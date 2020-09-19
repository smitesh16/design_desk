<div class="authMain">
   <a class="back" href="javascript:void(0);" onclick="showDiv('forgotpassview');"><img width="20px" src="<?php echo base_url(); ?>assets/UI/images/next.png"></a>
   <div class="authContainer">
       <h3>Reset your password</h3>
       <div class="authForm">
         <div class="form-group">
         <input type="text" id="otp" class="form-control" placeholder="OTP" autocomplete="off">
       </div>
       <div class="form-group">
         <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
       </div>
       <div class="form-group">
         <input type="password" id="confpassword" class="form-control" placeholder="Confirm Password" autocomplete="off">
         <span id="allError" style="color: red;"></span>
       </div>
          <button class="authActon" type="button" onclick="resetPass();">SUBMIT</button>
       </div>
   </div>
</div>