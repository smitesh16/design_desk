<body class="remove_loader">
<!-- <div id="chatsec"><script id="Ym90cGVuZ3VpbkFwaQ" src="https://cdn.botpenguin.com/bot.js?apiKey=Gch%3Fa%28-%3E%29VsCVCWo%7ED6X%3EI" async></script></div> -->
    <header>
       <div class="container">
        <div class="row align-items-center">
          <div class="col-6">
            <!-- <a href="#" class="logoHolder">
              <img width="200px" src="<?php echo base_url(); ?>assets/UI/images/logo.png" class="img-fluid">
            </a> -->
          </div>
          <div class="col-6 text-right">
            <a href="javascript:void(0);" onclick="ShowCart();" class="beg">
              BAG (<span id="cartCount"><?= Cartcount();?></span>)
            </a>
            <a href="<?php echo base_url(); ?>Signout" class="actionBtn">
              Logout
            </a>
            <!-- <p>Hello ! <?= Userdata('user_name'); ?></p> -->
          </div>
        </div>
       </div>
    </header><!-- /header -->
    <div id="cartview" class="cartView">
    	<?= View("Pages/cartview"); ?>
	</div>
    <div class="cartBackDrop" style="display: none"></div>