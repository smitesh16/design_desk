<?php login(); ?>
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
	<link rel="preload" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	
	<!-- <noscript>
		<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">
	</noscript> -->
	<style>
		body.modal-open {
			height: 100vh;
			overflow-y: hidden !important;
		}
	</style>
</head>

<body class="sidebar-dark">


	<div class="container-scroller">
		<!-- partial:partials/_navbar.html -->
		<nav class="navbar default-layout-navbar bg-gradient-dark col-lg-12 col-12 p-0 fixed-top d-flex flex-row ">
			<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
				<a class="navbar-brand brand-logo" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/vlogo.png" alt="logo" /></a>
				<a class="navbar-brand brand-logo-mini" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/logo-mini.png" alt="logo" /></a>
			</div>
			<div class="navbar-menu-wrapper d-flex align-items-center">
				<button class="navbar-toggler navbar-toggler align-self-center" data-toggle="minimize">
					<span class="mdi mdi-menu"></span>
				</button>
				<span class="d-none d-md-inline">Admin Dashboard</span>
				<ul class="navbar-nav navbar-nav-right">

					<li class="nav-item nav-logout d-none d-lg-block">
						<a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#resetpass_modal">
							Reset Password
							<i class="mdi mdi-settings"></i>
						</a>
					</li>
					<li class="nav-item nav-logout d-none d-lg-block">
						<a class="nav-link" href="<?php echo base_url(); ?>Logout">
							Logout
							<i class="mdi mdi-power"></i>
						</a>
					</li>
				</ul>
				<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
					<span class="mdi mdi-menu"></span>
				</button>
			</div>
		</nav>
		<!-- partial -->
		<div class="container-fluid page-body-wrapper">
			<!-- partial:partials/_settings-panel.html -->

			<!-- partial -->
			<!-- partial:partials/_sidebar.html -->
			<nav class="sidebar sidebar-offcanvas bg-dark text-light" id="sidebar">
				<ul class="nav">
					<li class="nav-item nav-profile">
						<span class="nav-link">

							<span class="nav-profile-text text-light">Admin</span>

						</span>
					</li>
					<?php 
                        $module_list = module();
                        foreach ($module_list as $list) {
                            if(array_key_exists('submenu',$list)){
                    ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#page-layouts<?php echo $list['module_id']; ?>" aria-expanded="false"
                                    aria-controls="page-layouts<?php echo $list['module_id']; ?>">
                                    <?php echo $list['fav_icon']; ?>
								    <span class="menu-title"><?php echo $list['module_name']; ?></span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse " id="page-layouts<?php echo $list['module_id']; ?>">
                                    <ul class="nav flex-column sub-menu">
                                        <?php
                                            foreach($list['submenu'] as $submenu){
                                        ?>
                                            <li class="nav-item"> <a class="nav-link"
                                                    href="<?php echo base_url().$submenu['controller_name']."/".$submenu['function_name']; ?>">
                                                    <?php echo $submenu['fav_icon']; ?>
                                                    <?php echo $submenu['module_name']; ?>
                                                </a>
                                            </li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </li>
                    <?php      
                            } else{
                    ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url() . $list['controller_name']; ?>">
                                    <?php echo $list['fav_icon']; ?>
								    <span class="menu-title"><?php echo $list['module_name']; ?></span>
                                </a>
                            </li>
                    <?php
                            }
                        }
                    ?>
				</ul>
			</nav>
			<div class="main-panel masterPanel d-none">
<div class="modal fade" id="resetpass_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title view_name" id="ModalLabel">Reset Password</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="<?php echo base_url();?>Customer/ResetPass" method='POST'>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Password:</label>
                                  <input maxlength="100" type="password" class="form-control" name="password" id="password"
                                      required>
                              </div>
                          </div>
                          
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Confirm Password:</label>
                                  <input maxlength="100" type="password" class="form-control" name="conf_password" id="conf_password"
                                      required>
                                      <span id="passwordError" style="color: red"></span>
                              </div>
                          </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-outline-success" id="reset_button">SUBMIT</button>
                      <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                  </div>
              </form>
          </div>
      </div>
  </div>