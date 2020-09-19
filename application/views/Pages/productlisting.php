<?= View("template/uiheader"); ?>
   <body class="remove_loader">

    <header>
       <div class="container">
        <div class="row align-items-center">
          <div class="col-12 text-right">
            <a href="#" class="beg" onclick="ShowCart();">
              BAG (<span id="cartCount"><?= Cartcount();?></span>)
            </a>
            <a href="#" class="actionBtn">
              Login
            </a>
          </div>
        </div>
       </div>
    </header><!-- /header -->


    <div class="cartView" id="cartview">
      <?= View("Pages/cartview"); ?>  
    </div>
        <!-- <div class="sub">
          <h5><b>Subtotal:</b> 36,000</h5>
        </div> -->

        <!-- <div class="checkoutBtn">
          <a class="addBag authActon" href="#">Checkout</a>
        </div> -->
    </div>
    <div class="cartBackDrop" style="display: none"></div>



    <!-- body part -->
      <div class="container">
        <div class="row">
          <div class="listHeading col-12 text-center">
            <h3><?=$product['all_list'][0]['category']; ?></h3>
          </div>
          <?php
            for($i=0; $i<count($product['all_list']); $i++){
          ?>
          <div class="col-sm-4 mb-4">
            <div class="pList">
              <img src="<?php if($product['all_list'][$i]['category_image'] != '') echo $this->config->item('file_url').$product['all_list'][$i]['category_image']; else echo $this->config->item('file_url')."default.jpg" ?>" class="img-fluid">
              <div class="pListDes">
                <p><?=$product['all_list'][$i]['product_name']; ?></p>
                <a href="<?php echo base_url();?>Product/Get/<?=$product['all_list'][$i]['parmalink']; ?>">Learn more <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
      <?= View("template/uifooter"); ?>
    