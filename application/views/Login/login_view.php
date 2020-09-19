<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset=utf-8>
	<meta http-equiv=X-UA-Compatible content="IE=edge">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name=description content=admin />
	<meta name=robots content=noodp />
	<meta name=keywords content=admin>
	<title>Virtual Shop Admin</title>
	<style>
		.mainLoader {
			position: fixed;
			width: 100%;
			height: 100vh;
			background-color: #222;
			z-index: 99999;
		}
	</style>
	<div class="mainLoader bg-gradient-dark">
		<div class="square-box-loader">
			<div class="square-box-loader-container">
				<div class="square-box-loader-corner-top"></div>
				<div class="square-box-loader-corner-bottom"></div>
			</div>
			<div class="square-box-loader-square"></div>
		</div>
	</div>
	<!-- endinject -->
	<!-- <link rel="shortcut icon" href="images/favicon.png" /> -->
	<!-- plugins:css -->
	<!-- <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css"> -->
	<!-- <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css"> -->
	<!-- <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css"> -->
	<!-- endinject -->
	<!-- plugin css for this page -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<link rel="preload" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">

	<noscript>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
	</noscript>


</head>

<body>
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper bg-dark d-flex align-items-stretch auth auth-img-bg">
				<div class="row flex-grow">
					<div class="col-lg-6 d-flex align-items-center justify-content-center">
						<div class="auth-form-transparent text-left p-3">
							<div class="brand-logo">
								<img src="<?php echo base_url(); ?>assets/images/vlogo.png" alt="logo">
							</div>
							<h4 class="text-light">Welcome back!</h4>
							<h6 class="font-weight-light text-light">Happy to see you again!</h6>
							<form class="pt-3" action="<?php echo base_url(); ?>Login/admin_login" method="post">
								<div class="form-group text-light">
									<label for="exampleInputEmail">Username</label>
									<div class="input-group">
										<div class="input-group-prepend bg-transparent">
											<span class="input-group-text bg-transparent border-right-0">
												<i class="mdi mdi-account-outline  "></i>
											</span>
										</div>
										<input type="text" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Username" name="user_name" required>
									</div>
								</div>
								<div class="form-group text-light">
									<label for="exampleInputPassword">Password</label>
									<div class="input-group">
										<div class="input-group-prepend bg-transparent">
											<span class="input-group-text bg-transparent border-right-0">
												<i class="mdi mdi-lock-outline "></i>
											</span>
										</div>
										<input type="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Password" name="password" required>
									</div>
								</div>
								<!--<div class="my-2 d-flex justify-content-between align-items-center">
									<div class="form-check">
										<label class="form-check-label text-muted">
											<input type="checkbox" class="form-check-input" name="remember">
											Remember me
										</label>
									</div>
								</div>-->
								<div class="my-3">
									<button type="submit" class="btn btn-block bg-light btn-lg font-weight-bold  auth-form-btn">LOGIN</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-lg-6 login-half-bg d-flex flex-row">
						<p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2018 All rights reserved.</p>
					</div>
				</div>
			</div>
			<!-- content-wrapper ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->
	<!-- plugins:js -->
	<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/master.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/master.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/common.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/second_master.js"></script>

	<?php
	$message = $this->session->flashdata('alert');
	?>

	<?php
	$message = $this->session->flashdata('alert');
	?>

	<?php if ($message['class'] == 'success') { ?>
		<script language=javascript>
			$(document).ready(function() {
				showSwal('success-message')
			});
		</script>
	<?php } else if ($message['class'] == 'auto') {  ?>
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

	<?php } else if ($message['class'] == 'error') {
		echo "<script language=javascript>$( document ).ready(function() {  errorSwal('error','" . $message['message'] . "')});</script>";
	} ?>



	<script>
		$(window).on("load", function() {
			// executes when complete page is fully loaded, including all frames, objects and images
			$(".mainLoader").fadeOut(300);
		});
	</script>
</body>

</html>