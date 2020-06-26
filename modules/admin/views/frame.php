<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?=$app_title?></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" type="text/css" href="<?=base_url('bismillah/bootstrap/css/bootstrap.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/icon/css/font-awesome.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/icon/css/ionicons.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/select2/css/select2.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/datepicker/bootstrap-datetimepicker.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/timepicker/bootstrap-timepicker.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/w2/w2ui-1.5.rc1.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/adminlte/css/AdminLTE.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/adminlte/css/skins/skin-black.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/core.mobile.css')?>">
		<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
		<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2AgQpLx4g1Xb5MEK7BW_5FG0_f0Kg69Q&libraries=places"></script> -->
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.notif-title-perihal{
				word-break: break-all; 
				word-wrap: break-word;
			}
		</style>
	</head>
	<body class="hold-transition skin-black sidebar-mini">
		<div class="wrapper">
			<!-- Main Header -->
			<header class="main-header">
				<!-- Logo -->
				<a href="<?=site_url()?>" class="logo">
					<span class="logo-mini"><img src="./uploads/bank_indonesia.png" style="width: 36px; height: 36px;" alt="App Logo"></span>
					<span class="logo-lg"><img src="./uploads/bank_indonesia.png" style="width: 36px; height: 36px;" alt="App Logo">&nbsp;<?=$app_title?></span>
				</a>
				<!-- Header Navbar -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- Messages: style can be found in dropdown.less-->
							<li class="dropdown messages-menu list-notif-suratmasuk">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" alt="Surat Masuk">
									<i class="fa fa-envelope-o" alt="Surat Masuk"></i>
									<span class="label label-success"><?= sizeof(listNotifSuratMasuk()) ?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="header"></li>
										<li>
											<!-- inner menu: contains the actual data -->
											<?php
												$nJumlahNotif = sizeof(listNotifSuratMasuk()) ;
												$cFooterDescription = "" ;
												if($nJumlahNotif > 0){
													?>
														<ul class="menu">
															<?php

																foreach(listNotifSuratMasuk() as $key=>$val){
																	?>
																		<li><!-- start message -->
																			<a href="#">
																				<div class="notif-title-perihal">
																					<p>
																						<h5>
																							<?=$val['Perihal']?>
																						</h5>
																					</p>
																				</div>
																				<p><small><i class="fa fa-clock-o"></i> <?=$val['DTDisposisi']?></small></p>
																				<p>From : <?=$val['Dari']?></p>
																			</a>
																		</li>
																	<?php
																}

															?>
														</ul>
													<?php
												}else{
													$cFooterDescription = "Tidak Ada Data" ;
												}
											?>
											
										</li>
									<li class="footer"><a href="#"><?=$cFooterDescription?></a></li>
								</ul>
							</li>
							
							<!-- User Account Menu -->
							<li class="dropdown user user-menu">
								<!-- Menu Toggle Button -->
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<span class="hidden-xs"><i class="fa fa-user fa-fw"></i> <?=$fullname?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- The user image in the menu -->
									<li class="user-header">
										<img src="<?=$data_var['ava']."?time=".time()?>" class="img-circle" alt="User Image" />
										<p><?=$fullname?></p>
									</li>
									<!-- Menu Footer-->
									<li class="user-footer">
										<!-- <div class="pull-left">
											<a href="#" class="btn btn-default btn-flat">Profile</a>
										</div> -->
										<div class="pull-right">
											<a href="#" onclick="bjs.ajax('admin/frame/logout')" class="btn btn-danger"><i class="fa fa-sign-out fa-fw"></i> Log Out</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					<div class="user-panel">
				        <div class="pull-left image">
				          <img src="<?=$data_var['ava']."?time=".time()?>" class="img-responsive" alt="<?=$fullname?>">
				        </div>
				        <div class="pull-left info">
				          <p><i class="fa fa-user fa-fw"></i> <?=$username?></p>
				          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				        </div>
				    </div>
					<!-- Sidebar Menu -->
					<ul class="sidebar-menu"><?=$menu_html?></ul>
				</section>
			</aside>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper bwrapper">
				<section class="content-header">
					<h1>Loading, Please Wait</h1>
					<ol class="breadcrumb">
				        <li><a href="#"><i class="fa fa-dashboard"></i> System</a></li>
				        <li class="active">Loading</li>
					</ol>
				</section>
				<section class="content">
                </section>
			</div>

			<!-- Main Footer -->
			<footer class="main-footer">
				<!-- To the right -->
				<div class="pull-right hidden-xs"><strong>Version</strong> <?=BISMILLAH_APP_VERSION?></div>
				Copyright &copy; <?=date("Y")?> BIMA OSKAB.
			</footer>

		</div>

		<script type="text/javascript" src="<?=base_url('bismillah/jQuery/jquery-2.2.3.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/bootstrap/js/bootstrap.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/adminlte/app.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/select2/js/select2.full.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/w2/w2ui-1.5.rc1.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/datepicker/moment.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/datepicker/bootstrap-datetimepicker.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/timepicker/bootstrap-timepicker.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/jQuery/jquery.number.js')?>"></script>
        <script type="text/javascript" src="<?=base_url('bismillah/chart/Chart-2.4.0.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/tinymce/js/tinymce/tinymce.min.js')?>"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>


		<script type="text/javascript">
		<?php
		echo 'var base_url = "'.base_url().'" ;' ;
		?>
		</script>
		<script type="text/javascript" src="<?=base_url('bismillah/core.js')?>"></script>
		<script type="text/javascript">
		<?php
		echo 'bjs.form('.json_encode($oinit).') ; ' ;
		?>
			function form_mobile(par){
				$(".sidebar-menu").find("li.active").removeClass("active") ;
				$(".sidebar-menu").find("li#" + par.md5).addClass("active") ;
				bjs.form(par) ;
			}
		</script>
		<script>
			// Enable pusher logging - don't include this in production
			Pusher.logToConsole = true;

			var pusher = new Pusher('1d87ad16eb0bd12a181f', {
			cluster: 'ap1'
			});

			var channel = pusher.subscribe('my-channel');
			channel.bind('my-event', function(data) {
				// alert(JSON.stringify(data));
				xhr = $.ajax({
					method 		: "POST",
					url 		: "<?php echo base_url('/admin/frame/notifikasiSuratMasuk') ; ?>" ,
					success 	: function(response){
									$('.list-notif-suratmasuk').html(response) ;
								  }
				});
			});
		</script>
		<?php require_once 'frame.rpt.php' ?>
	</body>
</html>
