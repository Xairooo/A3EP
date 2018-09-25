<?php
if(file_exists("../../extra/config.php")) {
	require('../../extra/config.php');
if($INFO['installed'] == true){
	die("installer locked");
}
}

if($_POST["test"]=="1")
{?>
<form name="myForm" id="1232" action="systemcheck.php" method="POST">
  <input name="status" value="systemcheck" type="hidden"/>
	<input type="submit" value="Submit" type="hidden" />
</form>

<script>
	document.getElementById("1232").click();
		document.getElementById("1232").submit();
			//window.location.replace("systemcheck.php");
</script>
<?php
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>A3 Portal Installer</title>
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
		<link rel="stylesheet" media="screen" href="css/style.css">

		<!-- FAVICON SECTION -->

<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/manifest.json">
<link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">

<!-- FAVICON SECTION END -->

		<script type="text/javascript">
			var A3_TIMEOUT = 30;
		</script>
		<script src="js/jquery.min.js"></script>
		<script src="js/multipleRedirect.js"></script>
	</head>
	<body class='App App_installer'>

		<div id='elInstaller_wrap'>
			<div id='Layout_header' class='Clearfix' role='banner'>
				<header>
				<a href='/' id='elSiteTitle'><span id='elLogo'><img src='img/logo.png' alt=''></span>Install A3 Exile Portal</a>

				</header>
			</div>
			<main id='elInstaller_body'>

					<div class='Pad_double Type_center'>
						<h1 class='Type_pageTitle' id='elInstaller_welcome'>Welcome to A3 Exile Portal Installer</h1>
						<p class='Type_normal Type_light'>

								This process will install your software for you. Be sure you have your license key and MySQL database details to hand.

						</p>

							<br><br>
						<form action="index.php" method="POST">
							<input name="test" value="1" type="hidden"/>
							<button type="submit" name="submit" class='Button Button_large Button_primary'>Start Installation</button>
						</form>


						<br><br>

					</div>

			</main>
		</div>
	</body>
</html>