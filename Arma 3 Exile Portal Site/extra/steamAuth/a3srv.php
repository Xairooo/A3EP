<?php
if ($_GET["ret"] == "1")
{
    $urs = $_GET['openid_claimed_id'];
    preg_match("#^http://steamcommunity.com/openid/id/([0-9]{17,25})#", $_GET['openid_claimed_id'], $matches);
    $steamID64 = is_numeric($matches[1]) ? $matches[1] : 0;
  
    header ("location: url.php?steamid=$steamID64");
    exit();
}
else
{
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$decoded_url = rawurldecode($actual_link);
header ("location: $decoded_url &ret=1");
  exit();
}
?>