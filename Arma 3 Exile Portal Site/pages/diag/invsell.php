<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
$class = $_POST["item"];
$value = $_POST["value"];
$col = $_POST["col"];
$desc = addslashes((filter_var($_POST['desc'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS)));;
$steamid = $userClass->getusersteamid($AccountID);
$seller = $AccountID;
$serverid=$LINKID;
$singlearray = ["backpack","goggles","handgun_weapon","headgear","binocular","primary_weapon","secondary_weapon","uniform","vest"];
$simplearray = ["assigned_items"];
$fuckyouexilearray = ["backpack_items","handgun_items","primary_weapon_items","secondary_weapon_items","backpack_magazines","backpack_weapons","loaded_magazines","uniform_items","uniform_magazines","uniform_weapons","vest_items","vest_magazines","vest_weapons"];
$query = "INSERT INTO ".$tblpre."marketplace (`class`,`price`,`seller`,`server`,`type`,`description`) VALUES ('$class','$value','$seller','$serverid','$col','$desc')";
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch(PDOException $ex)
{
    error_log("Failed to run query: " . $ex->getMessage(),0);
}
$query = "SELECT ".$col." FROM player WHERE account_uid =".$steamid;

try
{
    $stmt = $dbo->prepare($query);
    $result = $stmt->execute();
}
catch(PDOException $ex)
{
    error_log("Failed to run query: " . $ex->getMessage());
}
$ply = $stmt->fetch();
if(in_array($col,$singlearray))//SINGLE
{
$query = "UPDATE player SET ".$col."=NULL WHERE account_uid ='".$steamid."';";
}
if(in_array($col,$simplearray))//SIMPLE
{
$a = substr($ply[$col], 1 ,-1);
$a = str_replace('"','', $a);
$a= explode(",", $a);
$string = "";
$limiter = 0;
foreach($a as $b)
{
    if ($limiter == 0)
    {
        if($b == $class)
        {
            $limiter = 1;
        }
        else
        {

            $string = '"'.$b.'"' . "," . $string;
        }
    }
    else
    {
        $string = '"'.$b.'"' . "," . $string;
    }
}
$string = str_replace('"",','', $string);
$string = substr($string, 0 ,-1);
$h = "[".$string."]";
$query = "UPDATE player SET ".$col."='".$h."' WHERE account_uid ='".$steamid."';";
}
if(in_array($col,$fuckyouexilearray))//HARD...
{
$a = substr($ply[$col], 1 ,-1);
$a = str_replace('],',']:', $a);
$b = explode(":", $a);
$e = "";
$limiter = 0;
foreach($b as $c)
{
    $d = [];
    $d = explode(",", $c);
    $r = substr($d[0], 2 ,-1);
    if ($limiter == 0)
    {
    if($r == $class)
    {
        $limiter = 1;
    }
    else
    {
        if ($e == "")
        {
            $e = $c;
        }
        else
        {
            $e = $c . ",". $e;
        }
    }
    }
    else
    {
        if ($e == "")
        {
            $e = $c;
        }
        else
        {
            $e = $c . ",". $e;
        }
    }
}
$h = "[".$e."]";
$query = "UPDATE player SET ".$col."='".$h."' WHERE account_uid ='".$steamid."';";
}
try
{
    $stmt = $dbo->prepare($query);
    $result = $stmt->execute();
}
catch(PDOException $ex)
{
    error_log("Failed to run query: " . $ex->getMessage());
}
$pstat = $settingClass->isOnline($userClass->getusersteamid($AccountID) ,$a_host, $a_port, $a_user, $a_pass);
if($pstat == "true")
{
$settingClass->RemoveItem($userClass->getusersteamid($AccountID), $class, "1" ,$a_host, $a_port, $a_user, $a_pass);
}
?>