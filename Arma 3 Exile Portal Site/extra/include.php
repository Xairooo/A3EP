<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
if(!file_exists("./extra/config.php")) {
		header("Location: admin/install/");
		exit;
	}
	if(file_exists("./install")) {
		echo '<title>A3 Exile Portal</title>';
		echo "The installation files still exist. Please delete the /install directory before using A3 Exile Portal.";
		exit;
	}


require('./extra/common.php');
require("./extra/classes.php");
include "./Functions/Mobile_Detect.php";

//BEGIN SECURITY CHECK (THIS IS THE BASIC FORMAT.. )

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
/*
if(isset($_COOKIE['sphub_sessionid'])){
  if (($_COOKIE['sphub_sessionid']) != $ip)
  {
        setcookie( 'sphub_sessionid', '', -1, '/' );
        die("ERROR: IPCHANGE, Connection Terminated. You have been signed out. Please Refresh the page...");
  }
} else {
	unset($_SESSION['userid']);
  setcookie('sphub_sessionid', $ip, time() + 60 * 30, '/');
}
*/
//END

define('LICENSE', 'Sphub Authority Limited Licensing Service. Copyright Sphub Networks 2009-2017');
?>
