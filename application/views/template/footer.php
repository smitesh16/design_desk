<!--Loader-->

<div class="" id="loader">
	<div class="loader-demo-box">
		<div class="square-box-loader">
			<div class="square-box-loader-container">
				<div class="square-box-loader-corner-top"></div>
				<div class="square-box-loader-corner-bottom"></div>
			</div>
			<div class="square-box-loader-square"></div>
		</div>
	</div>
</div>

<!-- partial:partials/_footer.html -->
<footer class="footer">
	<div class="d-sm-flex justify-content-center justify-content-sm-between">
		<span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="https://japan.cheersagar.com/" rel="noreferrer" target="_blank">Virtulab</a>. All rights
			reserved.</span>
		<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
			with <i class="mdi mdi-heart text-danger"></i></span>
	</div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/master.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script> -->
<script src="<?php echo base_url('assets/ckeditor/'); ?>ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/common.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/master.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ckeditor.js"></script>
<?php if($this->uri->segment(2) == 'edit_view')
 { 
?>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/edit_master.js"></script>
<?php } else { ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/second_master.js"></script>
<?php } ?>


<?php
if(null !== $this->session->flashdata('alert')){
$message = $this->session->flashdata('alert');
?>

<?php if ($message['class'] == 'success') { ?>
	<script language=javascript>
		$(document).ready(function() {
			showSwal('success-message')
		});
	</script>
<?php } else if ($message['class'] == 'success_msg_new') {

	echo "<script language=javascript>$( document ).ready(function() {  successSwal('new_msg','" . $message['message'] . "')});</script>";
} else if ($message['class'] == 'auto') {  ?>


	<script language=javascript>
		$(document).ready(function() {
			showSwal('auto-close')
		});
	</script>

<?php } else if ($message['class'] == 'delete') {  ?>
	<script language=javascript>
		$(document).ready(function() {
			showSwal('warning-message-and-cancel')
		});
	</script>
<?php } else if ($message['class'] == 'csv_error') {

	echo "<script language=javascript>$( document ).ready(function() {  errorcsvSwal('csv_error','" . $message['message1'] . "','" . $message['message2'] . "')});</script>";
} else if ($message['class'] == 'csv_success') {

	echo "<script language=javascript>$( document ).ready(function() {  successcsvSwal('csv_success','" . $message['message1'] . "','" . $message['message2'] . "')});</script>";
} else if ($message['class'] == 'auto_msg') {

	echo "<script language=javascript>$( document ).ready(function() {  autoSwal('auto_msg','" . $message['message'] . "')});</script>";
} else if ($message['class'] == 'error') {
	echo "<script language=javascript>$( document ).ready(function() {  errorSwal('error','" . $message['message'] . "')});</script>";
}} ?>

<script type="text/javascript" async defer>
    $(document).ready(function() {
	    !function(e){"use strict";e(function(){e("#order-listing2").DataTable({"order": [[ 0, "desc" ]],aLengthMenu:[[5,10,15,-1],[5,10,15,"All"]],iDisplayLength:10,language:{search:""}}),e("#order-listing2").each(function(){var a=e(this),t=a.closest(".dataTables_wrapper").find("div[id$=_filter] input");t.attr("placeholder","Search"),t.removeClass("form-control-sm"),a.closest(".dataTables_wrapper").find("div[id$=_length] select").removeClass("form-control-sm")})})}(jQuery);
	} );
  </script>
<script>
	$(window).on("load", function() {
		// executes when complete page is fully loaded, including all frames, objects and images
		$(".mainLoader").fadeOut(300);
		$("#loader").addClass('d-none');
		$(".masterPanel").removeClass('d-none').fadeIn(300);
	});
	$(".select2").select2({
	  allowClear:true
	});
</script>
<style>
	.datepicker-days .table-condensed .disabled{
		color:#d9dde3 !important;
	}
	.select2-container{
		padding: 0px !important;
	}
</style>
</body>

</html>