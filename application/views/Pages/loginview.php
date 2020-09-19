<div class="authContainer">
    <h3>Login for Full Access</h3>
    <div class="authForm">
       <div class="form-group">
         <input type="email" id="emailofuser" class="form-control onlyemail" placeholder="Email" autocomplete="off">
         <span id="emailofuserError" style="color: red"></span> 
       </div>
       <div class="form-group">
         <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
         <span id="allError" style="color: red;"></span>
       </div>
       <button class="authActon" type="button" id="signin">SUBMIT</button>
    </div>

    <div class="authFooter">
      <p>Have an access code? <a href="javascript:void(0);" onclick="showDiv('accesscodeview');">Login here</a></p>
      <p>Sign up as a new user? <a href="javascript:void(0);" onclick="showDiv('registerview');"> Click Here</a></p>
      <p>Forgot password? <a href="javascript:void(0);" onclick="showDiv('forgotpassview');"> Click Here</a></p>
    </div>
</div>