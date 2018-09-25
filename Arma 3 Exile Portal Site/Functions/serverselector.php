<?php
if ($defaultConstants['COOKIE_PATH']== NULL)
{
  $path = "/";
} else
{
  $path = $defaultConstants['COOKIE_PATH'];
}
if(isset($_GET["SERVERCHANGE"])) {
    $var = $_GET["SERVERCHANGE"];
    setcookie($defaultConstants['COOKIE_PREFIX'].'lid', $var, time() + (10 * 365 * 24 * 60 * 60), $path);
    header("location: ?page=".$_GET["page"]);
}
if(!isset($_COOKIE[$defaultConstants['COOKIE_PREFIX'].'lid'])) {
    setcookie($defaultConstants['COOKIE_PREFIX'].'lid', '0', time() + (10 * 365 * 24 * 60 * 60), $path);

}
/*
if($_COOKIE[$defaultConstants['COOKIE_PREFIX'].'lid'] > $keylimit)
{
    setcookie($defaultConstants['COOKIE_PREFIX'].'lid', '0', time() + (10 * 365 * 24 * 60 * 60), $path);
}
*/
$LINKID = $_COOKIE[$defaultConstants['COOKIE_PREFIX'].'lid'];
if(!isset($LINKID) || $LINKID == '')
{
    $LINKID = '0';
}
$dbhost = explode(",",$settingClass->getSetting('db_host'))[$LINKID];
$dbschema = explode(",",$settingClass->getSetting('db_schema'))[$LINKID];
$dbusername = explode(",",$settingClass->getSetting('db_user'))[$LINKID];
$dbpassword = explode(",",$settingClass->getSetting('db_pass'))[$LINKID];
try
{
    $dbo = new PDO("mysql:dbname={$dbschema};host={$dbhost};charset=utf8", $dbusername, $dbpassword);
}
catch(PDOException $exa)
{
    $message= "Unable to Connect to Exile Server";
    include("error.php");
    die();
}
$dbo->exec("USE {$dbschema}");
$dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$dbo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$a_host= explode(",",$settingClass->getSetting('addon_ip'))[$LINKID];
$a_port= explode(",",$settingClass->getSetting('addon_port'))[$LINKID];
$a_user= explode(",",$settingClass->getSetting('addon_username'))[$LINKID];
$a_pass= explode(",",$settingClass->getSetting('addon_pass'))[$LINKID];
$query = "SELECT `status` FROM ".$tblpre."settings WHERE `name` = 'link_ids' ";
try
{
	$stmt = $db->prepare($query);
	$result = $stmt->execute();
}
catch(PDOException $ex)
{
    die("Failed to run query: " . $ex->getMessage());
}
$SERVERNAMES = $stmt->fetch();
$compilnam = "";
$SERVERNAMES = explode(",",$SERVERNAMES["status"]);
foreach($SERVERNAMES as $SNAM)
{
    $SNAM = explode(":",$SNAM);
    $compilnam .= $SNAM[2].",";
}
$compilnam = rtrim($compilnam,',');
$SERVERNAMES =explode(",",$compilnam);
$CURRENTSERVERNAME = $SERVERNAMES[$LINKID];
?>