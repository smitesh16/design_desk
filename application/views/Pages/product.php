 <?= View("template/uiheader"); 
   $p = $product['all_list'][0];
 ?>
 <style type="text/css">
   /*header{
    display: none;
   }*/
   .BotPenguin-chat{
    display: none !important;
   }
 </style>
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
    <div class="container-fluid">
      <div class="navArrow">
         <?php $prevp = getprevprod($p['product_id'],$p['category_id']); if($prevp != ""){ ?>
            <a class="navArrowLeft" href="<?php echo base_url(); ?>Product/Get/<?= $prevp['parmalink']; ?>"><span><?= $prevp['cp']; ?></span><img width="20px" src="<?php echo base_url(); ?>assets/UI/images/next.png"></a>
         <?php } ?>
        <?php $nextp = getnextprod($p['product_id'],$p['category_id']);  if($nextp != ""){  ?>
         <a class="navArrowRight" href="<?php echo base_url(); ?>Product/Get/<?= $nextp['parmalink']; ?>"><span style="transform: rotate(180deg);"><?= $nextp['cp']; ?></span><img width="20px" src="<?php echo base_url(); ?>assets/UI/images/next.png"></a>
        <?php } ?>
      </div>
      <div class="row">
      <div class="col-md-5 productHolder">
       
        <div class="productItem">
           <div class="bCum">
              <ul>
                <li><a href="">Shop </a></li>
                <li><a href="<?= base_url();?>Product/GetAll/<?=$p['category_id']?>"> /  <?= $p['category']; ?> / </a></li>
                <li> <?= $p['part_number']; ?></li>
                <input type="hidden" id="product_id" value="<?= $p['product_id']; ?>">
              </ul> 
            </div>

          <!-- <figure class="zoom" onmousemove="zoom(event)" style="background-image:url(<?= base_url(); ?>assets/UI/images/product.png)">
            <img src="<?= base_url(); ?>assets/UI/images/product.png" />
          </figure> -->

            <div class="imgSlider">

                <div id="demo" class="carousel slide" data-ride="carousel">
                    <!-- The slideshow -->
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="<?php echo $this->config->item('file_url').$p['product_image']; ?>" class="img-fluid">
                      </div>

                      <?php
                      $content = "";
                          if($p['other_images'] != ""){
                            $otherImgArr = explode(",", $p['other_images']);
                            $content = "";
                            for($i=0; $i<count($otherImgArr); $i++){
                              $j = $i+1;
                              $content .= '<li data-target="#demo" data-slide-to="'.$j.'"><img src="'.$this->config->item("file_url").$otherImgArr[$i].'" ></li>';
                      ?>

                      <div class="carousel-item">
                        <img src="<?php echo $this->config->item('file_url').$otherImgArr[$i]; ?>" class="img-fluid">
                      </div>
                    <?php }} ?>
                    </div>
                    <!-- img thumbnails -->
                     <ul class="carousel-indicators">
                      <li data-target="#demo" data-slide-to="0" class="active"><img src="<?php echo $this->config->item('file_url').$p['product_image']; ?>" ></li>
                      <?= $content; ?>
                      <!-- <li data-target="#demo" data-slide-to="1"><img src="<?php echo $this->config->item('file_url').$p['product_image']; ?>" ></li>
                      <li data-target="#demo" data-slide-to="2"><img src="<?php echo $this->config->item('file_url').$p['product_image']; ?>" ></li>
                      <li data-target="#demo" data-slide-to="3"><img src="<?php echo $this->config->item('file_url').$p['product_image']; ?>" ></li> -->
                    </ul>

                  </div>

              </div>
            </div>
      </div>
      <div class="col-md-5 py-5 mt-4">

              <h3><?= $p['product_name']; ?></h3>
              <div class="pDes">
                <p><small><?= $p['parmalink']; ?></small></p>
              </div>
              <div class="pDes">
                <?= $p['description']; ?>
              </div>

              <a class="addBag authActon" href="javascript:void();" onclick="frameaddtobag();">ADD TO BAG</a>

      </div>
    </a>
    </div>
     <script type="text/javascript">
        function frameaddtobag()
        {
          var product_id = $("#product_id").val();
          var testArr = {product_id: product_id};
          var testArrString = JSON.stringify(testArr);
          parent.addtobag(testArrString);
        }

        function frameSendEnquery()
        {
          var product_id = $("#product_id").val();
          var message = $("#message").val();
          var moq = $("#moq").val();
          var territory = $("#territory").val();
          var testArr = {product_id: product_id,message:message,moq:moq,territory:territory};
          var testArrString = JSON.stringify(testArr);
          parent.SendEnquery(testArrString);
        }
      </script>
    <?= View("template/uifooter"); ?>