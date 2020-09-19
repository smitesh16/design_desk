 <input type="hidden" id="base_url" value="<?= base_url(); ?>">
   </body>
   <!-- All link are here -->
   <script src="<?= base_url(); ?>assets/UI/js/popper.min.js" ></script>
   <script src="<?= base_url(); ?>assets/UI/js/bootstrap.min.js" ></script>
   <script src="<?= base_url(); ?>assets/UI/js/global.js" type="text/javascript"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/common.js"></script>
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/UI/js/all.js"></script>
   <script type="text/javascript">
    function openModal(modalId){
      $("#"+modalId).click();
      $("#authModal").modal('show');
    }
    function zoom(e){
        var zoomer = e.currentTarget;
        e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
        e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
        x = offsetX/zoomer.offsetWidth*100
        y = offsetY/zoomer.offsetHeight*100
        zoomer.style.backgroundPosition = x + '% ' + y + '%';
      }
   </script>
</html>


