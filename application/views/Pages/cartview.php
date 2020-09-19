<?php
	$cartlist = Cartdata();
	// pr($cartlist);
?>
<!-- <div class="cartView"> -->
      <a class="cartClose" href="javascript:void(0)">
        <img src="<?php echo base_url()?>assets/UI/images/close.svg" width="15px">
      </a>
        <h3>Cart</h3>

        <!-- <div class="cartList"> -->
          <div class="table-responsive cartTable cartList">
          <table class="table-responsive border-1 w-100">
            <thead>
              <tr>              
                <th>Style Number</th>
                <th>Product Title</th>
                <th>Image </th>
                <th>Fabric</th>
                <th>Comment</th>
                <th>Remove</th>
              </tr>
            </thead>
            <tbody>
        <?php
        	if($cartlist['stat'] == 200){
        		for($i = 0; $i<count($cartlist['all_list']); $i++){
        ?>
              <tr>
                <td><?= $cartlist['all_list'][$i]['part_number']?></td>
                <td><?= $cartlist['all_list'][$i]['product_name']?></td>
                <td class="cartImg"><img src="<?php echo $this->config->item('file_url').$cartlist['all_list'][$i]['product_image']; ?>"></td>
                <td><?= $cartlist['all_list'][$i]['fabric']?></td>
                <td><textarea class="form-control myinput" placeholder="Add your Comment" rows="2" name="cartComment<?= $cartlist['all_list'][$i]['product_id']?>"></textarea></td>
                <td ><a href="javascript:void(0);" onclick="removeCart(<?= $cartlist['all_list'][$i]['cart_id']; ?>);"><img width="10px" src="<?php echo base_url()?>assets/UI/images/close2.svg"></a></td>
              </tr> 
              <?php }}else{ ?>
                <tr><td colspan="7">Your cart is empty.</td></tr>
               <?php } ?>
            </tbody>
          </table>
        </div>

        <div class="checkoutBtn">
          <a class="addBag authActon" href="javascript:void(0);" onclick="Checkout();">Checkout</a>
        </div>
<!-- </div> -->