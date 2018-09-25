





<?php require '../../extra/config.php';
\file_put_contents( '../../extra/config.php', "<?php\n\n" . '$INFO = ' . var_export( array(
			'sql_host'	 		=> $INFO['sql_host'],
			'sql_database'		=> $INFO['sql_database'],
			'sql_user'			=> $INFO['sql_user'],
			'sql_pass'			=> $INFO['sql_pass'],
			'sql_port'			=> $INFO['sql_port'],
			'sql_tbl_prefix'	=> $INFO['sql_tbl_prefix'],
			'portal_start'		=> time(),
			'installed'			=> TRUE,
			'base_url'			=> $INFO['base_url']
			), TRUE ) . ';' );



?>
<html><head>
		<meta charset="utf-8">
		<title>Installation Complete!</title>
	<link rel='stylesheet' href='css/reset.css' media='all'>
	<link rel='stylesheet' href='css/fonts.css' media='all'>
	<link rel='stylesheet' href='css/global.css' media='all'>
	<link rel='stylesheet' href='css/layout.css' media='all'>
	<link rel='stylesheet' href='css/messages.css' media='all'>
	<link rel='stylesheet' href='css/misc.css' media='all'>
	<link rel='stylesheet' href='css/forms.css' media='all'>
	<link rel='stylesheet' href='css/typography.css' media='all'>
	<link rel='stylesheet' href='css/buttons.css' media='all'>
	<link rel='stylesheet' href='css/installer.css' media='all'>

	<!-- FAVICON SECTION -->

	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
	<link rel="manifest" href="favicon/manifest.json">
	<link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">

	<!-- FAVICON SECTION END -->
		<script type="text/javascript">
			var a3_TIMEOUT = 30;
		</script>
		<script src="js/jquery.min.js"></script>
		<script src="js/multipleRedirect.js"></script>
	</head>
	<body class="App App_installer">

		<div id="elInstaller_wrap">
			<div id="Layout_header" class="Clearfix" role="banner">
				<header>
					<a href="/" id="elSiteTitle"><span id="elLogo"><img src="img/logo.png" alt=""></span> Install A3 Exile Portal</a>

				</header>
			</div>
			<main id="elInstaller_body">

					<div class="Pad_double Type_center">
						<h1 class="Type_pageTitle" id="elInstaller_welcome">Your A3 Exile Portal is Ready!</h1>
						<p class="Type_normal Type_light">
							The installation process is now complete and yourA3 Exile Portal is now ready!
						</p>
						<br><br>
						<a href="<?php echo $INFO['base_url'];?>admin" class="Button Button_large Button_primary">Go to the AdminCP</a>

						<br><br>
					</div>

			</main>
		</div>

</body></html>
