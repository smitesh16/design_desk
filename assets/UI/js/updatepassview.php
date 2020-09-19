<div class="authMain">
   <a class="back" href="javascript:void(0);" onclick="showDiv('loginview');"><img width="20px" src="<?php echo base_url(); ?>assets/UI/images/next.png"></a>
   <div class="authContainer">
       <h3>Enter Your Access Code Below</h3>
       <div class="authForm">
         <div class="form-group">
            <input type="text" id="accessCode" class="form-control" placeholder="Access Code">
            <span id="allError" style="color: red;"></span>
          </div>
          <button class="authActon" type="button" onclick="checkAccesscode();">SUBMIT</button>
       </div>

   </div>
</div>