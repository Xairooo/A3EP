<?php
require "../Functions/sphubcms.php";
$CMS = new SphubCMS;
eval($CMS->funcDecrypt("==QfK0wOpQUS05WdvN2YBRCKgQXZz5WdJoQD7pQDpIiIg0TPgQUS05WdvN2YBRCKgYWaK0wOyVGbpFWbgcXZuBSPgIXZslWYtRiCNsTKiAHaw5CbpFWbl9CbpFWbF9ycu9Wa0Nmb1Z0Lu4iIoUGZ1x2YulmCNsTKiAHaw5CdjVGblNXZnFWdn5WYs9ycu9Wa0Nmb1Z0Lu4iIoUGZ1x2YulmCNsTKiAHaw5iclxGZuFGau9WazNXZz9ycu9Wa0Nmb1Z0Lu4iIoUmcpVXclJnCNsTKiAHaw5ibvlGdhRWasFmdvMnbvlGdj5WdG9iLuICKlRWdsNmbppQD9pQD7kiIpETOzASRE90QgI1TSJVRoAyTG5USgUkUP1EIS9kRgQlUPBFUVNFIUNUQU50TDBSRTFURMBFIsQURJZUSE9UTgI1TgQkTBByLgQURMxUVOBiTFVkQgMVQIBCTMFEVT5USigSZpRGIgACIK0wOi4jci9CPiAyboNWZgACIgACIgoQD7ISRV5USU50TDBCVP5kTBNEIsI1TSJVRiAyboNWZgACIgoQD7kSKnQnblNHdzFGbngyZulGd0V2U0V2Z+0yczFGbDdmbpRHdlNHJskiIslWYtV2Xn5WavdGd19mIocmbpRHdlNFdldmPtM3chx2Qn5Wa0RXZzRCLpcSeltGbngyZulGd0V2U0V2Z+0yczFGbDdmbpRHdlNHJsISM5MjIo42bpRXYs9Wa25TLn5Wa0J3bwVmUy9mcyVGJgACIgoQD7BSKpUGbpZGZsZHJoMHdzlGel9VZslmZhgCImlmCNszJwhGcu42bpRXYklGbhZ3Lz52bpR3YuVnRv4iLnASPgUGbpZGZsZHJK0wOn5Wa0J3bwVmUy9mcyVGI3Vmbg0DIn5Wa0J3bwVmUy9mcyVGJK0wOzNXYsNkbvl2czlWbyVGcgcXZuBSPgM3chx2QtJXZwRiCNszcn5WYsBydl5GI9Aycn5WYsRiCNszczFGbDJXZzVHI3Vmbg0DIzNXYsNkclNXdkoQD7kyczFGbDdmbpRHdlNHJoM3chx2Q0FGdzBydl5GI9AyczFGbDRXY0NHJK0wOzNXYsN0ZulGd0V2cgcXZuBSPgM3chx2Qn5Wa0RXZzRiCNsTKiAHaw5yclN3chx2YvEmc0hXZv4iLigSZylWdxVmcK0wOpcCcoBnLu9Wbt92YvEmc0hXZv4iLngSZylWdxVmcK0wOi8iLiASPgAXVylGZkoQD7IyLhJHd4V2LuICI9AicpRUYyRHelRiCNsTKoQnchR3cfJ2bK0wOiEjI9UGZ1x2YulGJ"));
?>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>
			<?php echo $settingClass->getServerName();?> Admin</title>
		<!-- Tell the browser to be responsive to screen width -->
		<script src="../library/jquery/dist/jquery.min.js"></script>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="../library/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../library/font-awesome/css/font-awesome.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="../library/admin-css/css/Admin.min.css">
		<link rel="stylesheet" href="../library/admin-css/css/skins/skin-black.min.css">
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<!-- jQuery 3 -->
		<script src="../library/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../library/datatables.net/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="../library/datatables.net/css/dataTables.bootstrap.min.css">
<script src="../library/datatables.net/js/jquery.dataTables.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="../library/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Admin App -->
		<script src="../library/admin-css/js/admin.min.js"></script>
		<script src="../library/letteravatar.js"></script>
		<!-- Google Font -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>
	<?php
	 if((!isset($_COOKIE[$defaultConstants['COOKIE_PREFIX'].'sessiontimer'])) && (isset($AccountID)))
	    {
		 if ($defaultConstants['COOKIE_PATH']== NULL)
		{
			$path = "/";
		} else
		{
			$path = $defaultConstants['COOKIE_PATH'];
		}
		if (isset($_COOKIE[$defaultConstants['COOKIE_PREFIX'].'referred']))
		{
			unset($_COOKIE[$defaultConstants['COOKIE_PREFIX'].'referred']);
		} else {
			setcookie($defaultConstants['COOKIE_PREFIX'].'referred', basename($_SERVER['REQUEST_URI']), time() + 60 * 30, $path);
		}
	        header("location: lockscreen.php");
	        exit;
	    }
	    if(!isset($AccountID)){
			header("Location: login.php");
			exit;
		}
		if($userClass->getUserAdminLevel($AccountID) == 0){
			header("Location: ./?page=index");
			exit;
		}
		if ($settingClass->nolicensekey() == true){
  		?>
		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> No License Key Provided</h4>
			Looks like you havent provided a license key.. please provide one now
		</div><?php } ?>
  	<style>
		#acpSearchKeyword {
			border:0;
			width: 60%;
			padding: 12px;
			color: black;
			background-color:rgba(255, 255, 255, 0.15);
			border-style: solid;
			border-radius: 3px;
		}
		#acpSearchKeyword {
			margin-left: 10px;
		}
		#acpSearchKeyword:focus {
		    background: #fff;
		    color: #222;
		}
		.fa-search {
			margin-left: 5px;
		}
		#result {
			position: absolute;
			width: 75%;
			cursor: pointer;
			overflow-y: auto;
			max-height: 400px;
			box-sizing: border-box;
			padding-left:65px;
		}
		@media screen and (max-width:1440px) {
			#acpSearchKeyword {
				border:0;
				width: 50%;
				padding: 12px;
				color: black;
				background-color:rgba(255, 255, 255, 0.15);
				border-style: solid;
				border-radius: 3px;
			}
			#acpSearchKeyword {
				margin-left: 10px;
			}
			#acpSearchKeyword:focus {
			    background: #fff;
			    color: #222;
			}
			#result {
				position: absolute;
				width: 59%;
				cursor: pointer;
				overflow-y: auto;
				max-height: 400px;
				box-sizing: border-box;
				padding-left:35;
			}
			.mobile-hide {
				display: none !important;
			}
		}
		@media screen and (min-width:1439px)
		{
			.desktop-hide {
				display: none !important;
			}
		}
  	</style>
		<body class="hold-transition skin-black sidebar-mini">
			<div class="wrapper">

				<header class="main-header">
					<!-- Logo -->
					<a href="index.php" class="logo">
						<!-- mini logo for sidebar mini 50x50 pixels -->
						<span class="logo-mini"><b>A</b>3</span>
						<!-- logo for regular state and mobile devices -->
						<span class="logo-lg"><b><?php echo $settingClass->getServerName();?></b></span>
					</a>

					<!-- Header Navbar: style can be found in header.less -->
					<nav class="navbar navbar-static-top">
						<!-- Sidebar toggle button-->
						<i class="fa fa-search fa-lg"></i>
						<input type="text" id="acpSearchKeyword" placeholder="Search for settings, etc." autocomplete="off" spellcheck="false" aria-autocomplete="list" aria-haspopup="true">
						<ul class="list-group" id="result"></ul>		<!-- Navbar Right Menu -->
						<div class="navbar-custom-menu">
					        <ul class="nav navbar-nav">
					        	<!-- Hide Side Bar -->
<li>
                                    <a href="#" class="desktop-hide" data-toggle="push-menu" role="button" style="position: relative; padding:15px;"><i class="fa fa-bars"></i></a>
                                    <a href="#" class="mobile-hide" data-toggle="push-menu" role="button"><i class="fa fa-bars"></i> <?php echo $langs->word($dlang,'toggle_navigation');?></a>
                                </li>
					    		<li><a href="../" class="mobile-hide" target="_blank"><i class="fa fa-home"></i><span> <?php echo $langs->word($dlang,'back_to_site');?></span></a></li>
					            <li><a href="logout.php" class="mobile-hide"><i class="fa fa-sign-out"></i> <?php echo $langs->word($dlang,'navbar_logout');?></a></li>

					            <li><a href="../" class="desktop-hide" target="_blank"><i class="fa fa-home"></i></span></a></li>
					            <li><a href="logout.php" class="desktop-hide"><i class="fa fa-sign-out"></i></a></li>
					        </ul>
      					</div>
					</nav>
				</header>
				<!-- Left side column. contains the logo and sidebar -->
				<aside class="main-sidebar">
					<section class="sidebar">
						<script>
						$(document).ready(function(){
							$.ajaxSetup({ cache: false });
							$('#acpSearchKeyword').keyup(function(){
								$('#result').html('');
								$('#state').val('');
								var searchField = $('#acpSearchKeyword').val();
								var expression = new RegExp(searchField, "i");
								$.getJSON('data.json', function(data) {
									$.each(data, function(key, value){
										if (value.name.search(expression) != -1)
										{
										$('#result').append('<li class="list-group-item link-class"><a href="'+value.url+'"> ['+value.module+'] '+value.name+'</a></li>');
										}
									});
								});
							});

							$('#result').on('click', 'li', function() {
							var click_text = $(this).text().split('|');
							$('#acpSearchKeyword').val($.trim(click_text[0]));
							$("#result").html('');
							});
						});
						</script>

						<script>
							jQuery(document).ready(function($) {
								// Get current path and find target link
								var path = window.location.pathname.split("/").pop();

								// Account for home page with empty path
								if (path == '') {
									path = 'index.php';
								}

								var target = $('li a[href="' + path + '"]');
								// Add active class to target link
								target.closest('.treeview').addClass('active menu-open');
								target.parent().addClass('active');
							});
						</script>
						<!-- sidebar menu: : style can be found in sidebar.less -->
						<ul class="sidebar-menu" data-widget="tree">
							<li class="header"><?php echo $langs->word($dlang,'main_navigation');?></li>
							<li class="treeview">
								<a href="#">
						            <i class="fa fa-cogs"></i> <span><?php echo $langs->word($dlang,'overview');?></span>
						        </a>
								<ul class="treeview-menu">
									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'overview');?></b></li>
									<li><a href="index.php"> <?php echo $langs->word($dlang,'dashboard');?></a></li>

									<?php if(!$permClass->checkUserPerms("view_security_center", $AccountID)){}else {?>
									<li><a href="security.php"> <?php echo $langs->word($dlang,'security_center');?></a></li><br><?php } ?>

									<?php if(!$permClass->checkUserPerms("view_enhancements", $AccountID)){}else {?>
									<li><b style="color:white; align:center"> <?php echo $langs->word($dlang,'portal_features');?></b></li><?php } ?>

									<?php if(!$permClass->checkUserPerms("view_enhancements", $AccountID)){}else {?>
									<li><a href="enhancements.php"> <?php echo $langs->word($dlang,'enhancements');?></a></li><br><?php } ?>

									<?php if(!$permClass->checkUserPerms("view_general_config", $AccountID) and !$permClass->checkUserPerms("view_lkey", $AccountID)){}else {?>
									<li><b style="color:white; align:center"> <?php echo $langs->word($dlang,'settings');?></b></li><?php } ?>

									<?php if(!$permClass->checkUserPerms("view_general_config", $AccountID)){}else {?>
									<li><a href="generalconfiguration.php"> <?php echo $langs->word($dlang,'general_config');?></a></li><?php } ?>

									<?php if(!$permClass->checkUserPerms("view_lkey", $AccountID)){}else {?>
									<li><a href="licensekey.php"> <?php echo $langs->word($dlang,'lkey');?></a></li><?php } ?>

									<?php if(!$permClass->checkUserPerms("view_lkey", $AccountID)){}else {?>
									<li><a href="updater.php"> <?php echo $langs->word($dlang,'updater');?></a></li><?php } ?>

									<?php if(!$permClass->checkUserPerms("view_general_config", $AccountID)){}else {?>
									<li><a href="emailsettings.php"> <?php echo $langs->word($dlang,'email_settings');?></a></li><?php } ?>

									<?php if(!$permClass->checkUserPerms("view_login_handlers", $AccountID)){}else {?>
									<li><a href="loginhandlers.php"> <?php echo $langs->word($dlang,'login_handlers');?></a></li><?php } ?>
									<?php if(!$permClass->checkUserPerms("support", $AccountID)){}else {?>
								<li><b style="color:white; align:center"> <?php echo $langs->word($dlang,'support');?></b></li>
								<li><a href="support.php"> <?php echo $langs->word($dlang,'support');?></a></li>

									<?php } ?>

								</ul>
							</li>
							<?php
							if(!$permClass->checkUserPerms("manage_blog", $AccountID) and
								 !$permClass->checkUserPerms("manage_garage", $AccountID) and
								 !$permClass->checkUserPerms("manage_inventory", $AccountID) and
								 !$permClass->checkUserPerms("manage_announcement", $AccountID) and
								 !$permClass->checkUserPerms("manage_territory", $AccountID)){}else {?>
								<li class="treeview">
								<a href="#">
						            <i class="fa fa-comments"></i> <span><?php echo $langs->word($dlang,'portal');?></span>

						        </a>
								<ul class="treeview-menu">
									<?php if(!$permClass->checkUserPerms("manage_garage", $AccountID)){}else {?>
									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'page_manager');?></b></li>
									<li><a href="pagemanager.php"> <?php echo $langs->word($dlang,'settings');?></a></li>
									<br><?php } ?>

									<?php if(!$permClass->checkUserPerms("manage_announcement", $AccountID)){}else {?>
									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'announcements');?></b></li>
									<li><a href="manageannouncements.php"> <?php echo $langs->word($dlang,'manage_announcements');?></a></li>
									<br><?php } ?>

									<?php if(!$permClass->checkUserPerms("manage_blog", $AccountID)){}else {?>
									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'blog');?></b></li>
									<li><a href="blogposts.php"> <?php echo $langs->word($dlang,'manage_blog');?></a></li>
									<br><?php } ?>
								</ul>
							</li><?php } ?>
							<li class="treeview">
								<a href="#">
						            <i class="fa fa-users"></i> <span><?php echo $langs->word($dlang,'members');?></span>

						        </a>
								<ul class="treeview-menu">
									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'members');?></b></li>
									<li><a href="members.php"> <?php echo $langs->word($dlang,'manage_members');?></a></li>
									<?php if(!$permClass->checkUserPerms("registration_settings", $AccountID) and !$permClass->checkUserPerms("spam_settings", $AccountID)){}else {?>
									<br>
									<li><b style="color:white; align:center"> <?php echo $langs->word($dlang,'member_settings');?></b></li>

									<?php if(!$permClass->checkUserPerms("registration_settings", $AccountID)){}else {?>
									<li class=""><a href="registrationsettings.php"> <?php echo $langs->word($dlang,'registration_settings');?></a></li><?php } ?>

									<?php if(!$permClass->checkUserPerms("spam_settings", $AccountID)){}else {?>
									<li><a href="spamprevention.php"> <?php echo $langs->word($dlang,'spam_prevention');?></a></li>
									<?php }  }?>
								</ul>
							</li>
							<?php if(!$permClass->checkUserPerms("addon_settings", $AccountID) and !$permClass->checkUserPerms("addon_console", $AccountID)){}else {?>
							<li class="treeview">
								<a href="#">
						            <i class="fa fa-server"></i> <span> <?php echo $langs->word($dlang,'exile_server');?></span>

						        </a>
          						<ul class="treeview-menu">
          								<?php if(!$permClass->checkUserPerms("addon_settings", $AccountID)){}else {?>
									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'server');?></b></li>
									<li><a href="servermanager.php"> <?php echo $langs->word($dlang,'general_config');?></a></li>

									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'server_addon');?></b></li>

									<li><a href="addonconfiguration.php"> <?php echo $langs->word($dlang,'addon_config');?></a></li><?php } ?>
									<?php if(!$permClass->checkUserPerms("addon_console", $AccountID)){}else {?>

									<li><a href="addonconsole.php"> <?php echo $langs->word($dlang,'addon_console');?></a></li><?php }?>

									<?php if(!$permClass->checkUserPerms("addon_settings", $AccountID)){}else {?>
									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'db_main');?></b></li>
									<li><a href="dbmanager.php"> <?php echo $langs->word($dlang,'db_config');?></a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>

							<li class="treeview">
								<a href="#">
						            <i class="fa fa-paint-brush"></i> <span><?php echo $langs->word($dlang,'customization');?></span>

						        </a>
								<ul class="treeview-menu">
									<li><b style="color:white; align:center;"> <?php echo $langs->word($dlang,'appearance');?></b></li>
									<li><a href="servergallery.php"> <?php echo $langs->word($dlang,'manage_server_images');?></a></li>
									<br>
									<li><b style="color:white; align:center"> <?php echo $langs->word($dlang,'page_management');?></b></li>
									<li class=""><a href="pages.php"> <?php echo $langs->word($dlang,'page_manager');?></a></li>
									<br>
									<li><b style="color:white; align:center"> <?php echo $langs->word($dlang,'localization');?></b></li>
									<li class=""><a href="lang.php"> <?php echo $langs->word($dlang,'languages');?></a></li>
								</ul>
							</li>
						</ul>
					</section>
					<!-- /.sidebar -->
				</aside>