<?php
if($_POST["test"]=="1")
{?>
<form name="myForm" id="1232" action="license.php" method="POST">
  <input name="status" value="license" type="hidden"/>
	<input type="submit" value="Submit" type="hidden" />
</form>

<script>
	document.getElementById("1232").submit();
	document.getElementById("1232").click();
			//window.location.replace("systemcheck.php");
</script>
<?php
}
else{
if($_POST["status"]!="systemcheck")
{?>
<script>
			window.location.replace("index.php");
</script>
<?php
}
else{

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>A3EP System Check</title>
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
	<body class='App App_installer'>

		<div id='elInstaller_wrap'>
			<div id='Layout_header' class='Clearfix' role='banner'>
				<header>
					<a href='/' id='elSiteTitle'><span id='elLogo'><img src='img/logo.png' alt=''></span>Install A3 Exile Portal</a>

				</header>
			</div>
			<main id='elInstaller_body'>

					<div class='Pad AreaBackground_light'>
						<h1 class='Type_pageTitle'>
							Step: System Check
						</h1>
					</div>
					<div class='Columns Pad'>
						<div class='Column Column_wide Pad' id='elInstaller_stepsWrap'>
							<ul id='elInstaller_steps'>

									<li class=''>
										<i class='fa fa-circle'></i>&nbsp;&nbsp;System Check
									</li>

									<li class=''>
										<i class='fa fa-circle-o'></i>&nbsp;&nbsp;License
									</li>


									<li class=''>
										<i class='fa fa-circle-o'></i>&nbsp;&nbsp;Server Details
									</li>
								<li class=''>
                <i class='fa fa-circle-o'></i>&nbsp;&nbsp;Portal Settings
              </li>
									<li class=''>
										<i class='fa fa-circle-o'></i>&nbsp;&nbsp;Admin
									</li>

									<li class=''>
										<i class='fa fa-circle-o'></i>&nbsp;&nbsp;Install
									</li>

							</ul>
						</div>
						<div class='Column Column_fluid'>
							<div class='Pad'>


<section>
				<style>a.phpinfo {
				float: right;
				color: #868686;
				font-size: 11px;
			}</style>
		<h2 class="Type_sectionHead">PHP Requirements</h2>
	<?php if ( isset( $_GET['phpinfo'] ) ) { phpinfo(); exit; } ?>
		<ul class="Pad Type_large List_checks">

<?php $success = TRUE; ?>
				<a href="?phpinfo" class="phpinfo">phpinfo</a>
<?php if ( version_compare( PHP_VERSION, '5.6.0' ) >= 0 ): ?>
					<li class="success">PHP version <?php echo PHP_VERSION; ?>.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You are not running a compatible version of PHP. You need PHP 5.6.0 or above (7.0.0 or above recommended). You should contact your hosting provider or system administrator to ask for an upgrade.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'curl' ) and $version = curl_version() and version_compare( $version['version'], '7.36', '>=' ) ): ?>
					<li class="success">cURL extension loaded</li>
<?php elseif ( ini_get('allow_url_fopen') ): ?>
					<li class="advisory">You do not have the cURL PHP extension loaded or it is running a version less than 7.36.(You have <?php echo  $version['version'];?>) While this is not required, it is recommend to make calls to external API services faster. You may wish to contact your hosting provider or system administrator to ask for it to be installed.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the cURL PHP extension loaded (or it is running a version less than 7.36)(You Have<?php echo  $version['version'];?>) and the allow_url_fopen PHP setting is disabled. You should contact your hosting provider or system administrator to ask either for cURL version 7.36 or greater to be installed, to be installed or the allow_url_fopen setting enabled. cURL is recommended.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'dom' ) ): ?>
					<li class="success">DOM extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the DOM PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be enabled.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'gd' ) ): ?>
					<li class="success">GD extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the GD PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be enabled.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'mbstring' ) ): ?>
<?php if ( function_exists( 'mb_eregi' ) ): ?>
					<li class="success">Multibyte String extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">The Multibyte String extension has been configured with the --disable-mbregex option. You should contact your hosting provider or system administrator to ask for it to be reconfigured without that option.</li>
<?php if( ini_get('mbstring.func_overload') AND ini_get('mbstring.func_overload') > 0 ): $success = FALSE; ?>
					<li class="fail">The PHP configuration has mbstring.func_overload set with a value higher than 0. You should contact your hosting provider or system administrator to disable Multibyte function overloading.</li>
<?php endif; ?>
<?php endif; ?>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the Multibyte String PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be installed.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'pdo' ) ): ?>
					<li class="success">PDO extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the PDO PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be installed.</li>
<?php endif; ?>
<!--Not Added Yet
<?php if ( extension_loaded( 'openssl' ) ): ?>
					<li class="success">OpenSSL extension loaded.</li>
<?php else: ?>
					<li class="advisory">You do not have the OpenSSL PHP extension loaded. You can install A3 Exile Portal without it, but it is required to use external login services (Facebook, Google, LinkedIn, Microsoft and Twitter), some share services (Facebook and Twitter), Gravatar, and, if using Commerce some gateways and MaxMind integration. You may wish to contact your hosting provider or system administrator to ask for it to be installed.</li>
<?php endif; ?>-->
<?php if ( extension_loaded( 'session' ) ): ?>
					<li class="success">Session extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the Session PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be enabled.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'simplexml' ) ): ?>
					<li class="success">SimpleXML extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the SimpleXML PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be enabled.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'xml' ) ): ?>
					<li class="success">XML Parser extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the XML Parser PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be enabled.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'xmlreader' ) ): ?>
					<li class="success">XMLReader extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the XMLReader PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be enabled.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'xmlwriter' ) ): ?>
					<li class="success">XMLWriter extension loaded.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">You do not have the XMLWriter PHP extension loaded which is required. You should contact your hosting provider or system administrator to ask for it to be enabled.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'zip' ) ): ?>
					<li class="success">Zip extension loaded.</li>
<?php else: ?>
					<li class="advisory">You do not have the Zip PHP extension loaded. While this is not required, it is recommend. You may wish to contact your hosting provider or system administrator to ask for it to be installed.</li>
<?php endif; ?>
<?php
	$_memoryLimit = @ini_get('memory_limit');
	$memoryLimit = $_memoryLimit;
	preg_match( "#^(\d+)(\w+)$#", strtolower($memoryLimit), $match );
	if( $match[2] == 'g' )
	{
		$memoryLimit = intval( $memoryLimit ) * 1024 * 1024 * 1024;
	}
	else if ( $match[2] == 'm' )
	{
		$memoryLimit = intval( $memoryLimit ) * 1024 * 1024;
	}
	else if ( $match[2] == 'k' )
	{
		$memoryLimit = intval( $memoryLimit ) * 1024;
	}
	else
	{
		$memoryLimit = intval( $memoryLimit );
	}
?>
<?php if ( $memoryLimit >= 128 * 1024 * 1024 ): ?>
					<li class="success"><?php echo $_memoryLimit; ?> memory limit.</li>
<?php else: $success = FALSE; ?>
					<li class="fail">Your PHP memory limit is too low. It needs to be set to 128M or more. You should contact your hosting provider or system administrator to ask for this to be changed.</li>
<?php endif; ?>
<?php if ( extension_loaded( 'suhosin' ) ): ?>
<?php if ( ini_get( 'suhosin.max_vars' ) >= 4096 ): ?>
					<li class="success">suhosin.max_vars <?php echo ini_get( 'suhosin.max_vars' ) ?></li>
<?php else: ?>
					<li class="advisory">PHP setting suhosin.max_vars is set to <?php echo ini_get( 'suhosin.max_vars' ) ?>. This can cause problems in some areas. We recommended a value of 4096 or above. You should contact your hosting provider or system administrator to ask for this to be changed.</li>
<?php endif ?>
<?php if ( ini_get( 'suhosin.request.max_vars' ) >= 4096 ): ?>
					<li class="success">suhosin.request.max_vars <?php echo ini_get( 'suhosin.request.max_vars' ) ?></li>
<?php else: ?>
					<li class="advisory">PHP setting suhosin.request.max_vars is set to <?php echo ini_get( 'suhosin.request.max_vars' ) ?>. This can cause problems in some areas. We recommended a value of 4096 or above. You should contact your hosting provider or system administrator to ask for this to be changed.</li>
<?php endif ?>
<?php if ( ini_get( 'suhosin.get.max_value_length' ) >= 2000 ): ?>
					<li class="success">suhosin.get.max_value_length <?php echo ini_get( 'suhosin.get.max_value_length' ) ?></li>
<?php else: ?>
					<li class="advisory">PHP setting suhosin.get.max_value_length is set to <?php echo ini_get( 'suhosin.get.max_value_length' ) ?>. This can cause problems in some areas. We recommended a value of 2000 or above. You should contact your hosting provider or system administrator to ask for this to be changed.</li>
<?php endif ?>
<?php if ( ini_get( 'suhosin.post.max_value_length' ) >= 10000 ): ?>
					<li class="success">suhosin.post.max_value_length <?php echo ini_get( 'suhosin.post.max_value_length' ) ?></li>
<?php else: ?>
					<li class="advisory">PHP setting suhosin.post.max_value_length is set to <?php echo ini_get( 'suhosin.post.max_value_length' ) ?>. This can cause problems in some areas. We recommended a value of 10000 or above. You should contact your hosting provider or system administrator to ask for this to be changed.</li>
<?php endif ?>
<?php if ( ini_get( 'suhosin.request.max_value_length' ) >= 10000 ): ?>
					<li class="success">suhosin.request.max_value_length <?php echo ini_get( 'suhosin.request.max_value_length' ) ?></li>
<?php else: ?>
					<li class="advisory">PHP setting suhosin.request.max_value_length is set to <?php echo ini_get( 'suhosin.request.max_value_length' ) ?>. This can cause problems in some areas. We recommended a value of 10000 or above. You should contact your hosting provider or system administrator to ask for this to be changed.</li>
<?php endif ?>
<?php if ( ini_get( 'suhosin.request.max_varname_length' ) >= 350 ): ?>
					<li class="success">suhosin.request.max_varname_length <?php echo ini_get( 'suhosin.request.max_varname_length' ) ?></li>
<?php else: ?>
					<li class="advisory">PHP setting suhosin.request.max_varname_length is set to <?php echo ini_get( 'suhosin.request.max_varname_length' ) ?>. This can cause problems in some areas. We recommended a value of 350 or above. You should contact your hosting provider or system administrator to ask for this to be changed.</li>
<?php endif ?>
<?php else: ?>
					<li class="success">No Suhosin restrictions.</li>
<?php endif; ?>
	</ul>
		<h2 class="Type_sectionHead">Port Requirements</h2>
		<ul class="Pad Type_large List_checks">

			<?php
			$local = 'localhost';
    $outgoing = 'restinhellgamers.com';

    if ($socket = @fsockopen($local, '3306', $errno, $errstr, 3)) { ?>
       <li class="success">Local 3306 is open</li>
       <?php } else {
    ?>
            <li class="fail">Local 3306 is not open</li>
			<?php }
 if ($socket = @fsockopen($outgoing, '3306', $errno, $errstr, 3)) { ?>
       <li class="success">Outgoing 3306 is open</li>
       <?php } else {
     ?>
            <li class="fail">Outgoing 3306 is not open</li>
			<?php }
 if ($socket = @fsockopen($outgoing, '80', $errno, $errstr, 3)) { ?>
       <li class="success">Outgoing 80 is open</li>
       <?php } else {
       ?>
            <li class="fail">Outgoing 80 is not open</li>
			<?php }
 if ($socket = @fsockopen($outgoing, '2087', $errno, $errstr, 3)) { ?>
       <li class="success">Outgoing 2087 is open</li>
       <?php } else {
     ?>
            <li class="fail">Outgoing 2087 is not open</li>
			<?php }
?>
		</ul>
		<h2 class="Type_sectionHead">File System Requirements</h2>
		<ul class="Pad Type_large List_checks">

			<?php

    if (is_dir(dirname(__dir__,2) . "/images/uploads")){
    	if(is_writable(dirname(__dir__,2) . "/images/uploads")){ ?>
           <li class="success"><?php echo dirname(__dir__,2) . "/images/uploads";?> is writable</li> <?php }
           else
           { $success = FALSE; ?>
            <li class="fail"><?php echo dirname(__dir__,2) . "/images/uploads";?> is not writable</li>
			<?php }
    }
	if (is_dir(dirname(__dir__,2) . "/extra")){
    	if(is_writable(dirname(__dir__,2) . "/extra")){ ?>
           <li class="success"><?php echo dirname(__dir__,2) . "/extra";?> is writable</li> <?php }
           else
           { $success = FALSE; ?>
            <li class="fail"><?php echo dirname(__dir__,2) . "/extra";?> is not writable</li>
			<?php }
    }
	 if (is_dir(dirname(__dir__) . "/language")){
    	if(is_writable(dirname(__dir__) . "/language")){ ?>
           <li class="success"><?php echo dirname(__dir__) . "/language";?> is writable</li> <?php }
           else
           { $success = FALSE; ?>
            <li class="fail"><?php echo dirname(__dir__) . "/language";?> is not writable</li>
			<?php }
    }
?>
		</ul>


</section>
<div class='Pad_double Type_center'>
	<?php if ( $success === true ): ?>


							<form action="systemcheck.php" method="POST">
							<input name="test" value="1" type="hidden"/>
							<button type="submit" name="submit" class='Button Button_large Button_primary'>Continue</button>
						</form>


	<?php else: ?>
				<p class="fail">You are not ready to install A3EP yet. See the information above for instructions how to fix or <a href="https://a3exileportal.com/clientarea " target="_blank">contact technical support</a> for further assistance.</p>
<?php endif; ?>

</div>
							</div>
						</div>
					</div>

			</main>
		</div>
	</body>
</html>
<?php } }?>