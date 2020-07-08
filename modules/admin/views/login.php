<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="utf-8" />
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

		<meta name="description" content="login system">
		<meta name="keyword" content="">
		<meta name="author" content="screative">
		<title><?=$app_title?></title>
		<link rel="stylesheet" type="text/css" href="<?=base_url('bismillah/bootstrap/css/bootstrap.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/icon/css/font-awesome.min.css')?>">
		<link rel="stylesheet" href="<?=base_url('bismillah/icon/css/ionicons.min.css')?>">
		<style type="text/css">
			body#b-login{
				width: 100%;
				height: 100%;
				overflow: hidden;
				position: relative;
				background-color: #282931 ;
			}
			#b-login .wrappic{
				width: 100% ;
				height: 100% ;
				position: absolute;
				overflow: hidden;
			}
				#b-login .wrappic .caption{
					position: absolute;
					bottom: 0 ;
					left: 0 ;
					padding: 2em ;
					color: #FFF ;
				}
				#b-login .b-pic{
					opacity: .6 ;
					height: 100% ;
					background: #b69e25 url(<?=$app_login_image."?time=".time()?>) no-repeat;
					background-size: cover;
				}
			#b-login .wraplogin{
				display: block;
				position: relative;
				background-color: #FFF ;
				float: right;
				width: 500px ;
				height: 100% ;
				border-left: 1px solid #eaeaea ;
				padding: 5em 2em 2em ;
			}
				#b-login .wraplogin form{}
			#b-login .wraplogin .error{
				border-left: .5em solid red ;
     			border-right: .5em solid red ;
     			font-size:12px ;
     			text-align: center ;
     			display: none ;
     			margin-bottom: 1em ;
			}
			.logo{
				padding-bottom: 2em ;
			}
			.logo img{max-height: 100px ; margin: 0 auto ; }

			.left-inner-addon {
			    position: relative;
			}
			.left-inner-addon input {
			    padding-left: 30px;
			}
			.left-inner-addon i {
			    position: absolute;
			    padding: 10px 12px;
			    pointer-events: none;
			}

			.right-inner-addon {
			    position: relative;
			}
			.right-inner-addon input {
			    padding-right: 30px;
			}
			.right-inner-addon i {
			    position: absolute;
			    right: 0px;
			    padding: 10px 12px;
			    pointer-events: none;
			}
		</style>
	</head>
	<body id="b-login">
		<div class="wrappic">
			<div class="b-pic"></div>
			<div class="caption">
				<h1 style="margin-bottom:10px"><?=$app_title?></h1>
				<p>
					Copyright &copy; <?=date("Y")?> BIMA OSKAB
				</p>
			</div>
		</div>

		<div class="wraplogin">
			<div class="logo" style="text-align: center;">
				<img src="<?=$app_logo."?time=".time()?>" class="img-responsive" alt="<?=$app_title?>" title="<?=$app_title?>">
				<br>
				<b><h3>Login</h3></b>
			</div>
			<form>
				<div class="error"></div>
				<div class="left-inner-addon">
					<!-- <label>Username</label> -->
					<i class="fa fa-user fa-fw"></i>
					<input type="text" name="cusername" id="cusername"  
					class="form-control" placeholder="Nama Pengguna" required >
				</div>
				<br />
				<div class="left-inner-addon">
					<!-- <label>Password</label> -->
					<i class="fa fa-key fa-fw"></i>
					<input type="password" name="cpassword" id="cpassword"
					class="form-control" placeholder="Kata Sandi" required >
				</div>
				<br />
				<button type="submit" class="btn btn-primary pull-right" name="cmdlogin" id="cmdlogin"><i class="fa fa-sign-in fa-fw"></i> Masuk</button>
			</form>
		</div>

		<script type="text/javascript" src="<?=base_url('bismillah/jQuery/jquery-2.2.3.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('bismillah/bootstrap/js/bootstrap.min.js')?>"></script>
		<script type="text/javascript">
		<?php
			echo 'var base_url = "'.base_url().'" ;' ;
		?>
		</script>
		<script type="text/javascript" src="<?=base_url('bismillah/core.js')?>"></script>
		<script type="text/javascript">
			$(function(){
				$("#cusername").focus() ;
				bjs.initenter($("form")) ;
				$("form").on("submit", function(e){
					e.preventDefault() ;
					if(bjs.isvalidform(this)){
						bjs.ajax("admin/login/checklogin", bjs.getdataform(this), $('#cmdlogin')) ;
					}
				}) ;
			}) ;
		</script>
	</body>
</html>
