<?php
class errorReporting {
    function violation($error,$key,$outemail,$lsent){
                    $pageURL = 'http';
if(isset($_SERVER["HTTPS"]))
if ($_SERVER["HTTPS"] == "on") {
$pageURL .= "s";
}
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
$pageURL .= $_SERVER["SERVER_NAME"];
} else {
$pageURL .= $_SERVER["SERVER_NAME"];
}
$message = "A key Violation ". $error ." has occured on the url:". $pageURL . "";
$req = 'https://a3exileportal.com/api/nexus/supportrequests';
$req .= "?key=482a838c87ff443d4ea8df38a56e201e";
$req .= "&department=4";
$req .= '&email='.$outemail;
$req .= '&message='.urlencode($message);
$req .= '&lkey='.$key;
$req .= '&title=KEYVIOLATION';

if(isset($lsent))
{
    if((date(Gis)-$lsent) > 1)
    {
    	global $db;
    	global $tblpre;
    	$query = "UPDATE `".$tblpre."settings` SET `status` = :value WHERE name = :setting";
        $query_params = array(
    		':value' => date('Hms'),
    		':setting' => "lastsent"
        );
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
        $curl = curl_init($req);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $curl );
    }
}
else
{

    global $db;
    global $tblpre;
    $query = "UPDATE `".$tblpre."settings` SET `status` = :value WHERE name = :setting";
    $query_params = array(
    	':value' => date('Hms'),
    	':setting' => "lastsent"
    );
    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

        $curl = curl_init($req);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $curl );
}

}
}
class langs {
    function word($s_lang, $word){
        global $db; global $tblpre;
        $query = "
            SELECT
                *
            FROM ".$tblpre."lang_words
            WHERE lang_id=:s_lang AND word_key=:word
            ";
        $query_params = array(
            ':s_lang' => $s_lang,
            ':word' => $word
				);

        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $word_value = $stmt->fetch();
        $result = $stmt->rowcount();
			if($result == 0){
				return "__".$word."__";
			} else {
				 if($word_value['word_custom'] == NULL or $word_value['word_custom'] == '')
        {
            return $word_value['word_default'];
        } else {
            return $word_value['word_custom'];
        }
			}


    }
    function words($s_lang, $word, $index){
        global $db; global $tblpre;
        $query = "
            SELECT
                *
            FROM ".$tblpre."lang_words
            WHERE lang_id=:s_lang AND word_key=:word
            ";
        $query_params = array(
            ':s_lang' => $s_lang,
            ':word' => $word
				);

        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $word_value = $stmt->fetch();
        $result = $stmt->rowcount();
			if($result == 0){
				return "__".$word."__";
			} else {
				  if($word_value['word_custom'] == NULL or $word_value['word_custom'] == '')
        {

             $str = explode(",",$word_value['word_default']);
            return $str[$index];
        } else {
            $str = explode(",",$word_value['word_custom']);
            return $str[$index];
        }
			}


    }
}
class settingClass {
    function getdefaultlang(){
        global $db;
        global $tblpre;
        $query = "
            SELECT
               *
            FROM `".$tblpre."lang`
            WHERE lang_default=:default
            ";

          $query_params = array(
            ':default' => '1'
				);

        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $defaultlang = $stmt->fetch();
        return $defaultlang['lang_short'];
    }
    function nolicensekey(){

             global $db;
             global $tblpre;
        $query        = "
            SELECT
                status
            FROM ".$tblpre."settings
            WHERE name=:name
            ";
        $query_params = array(
            ':name' => 'lkey'
				);

        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $setting = $stmt->fetch();
            if($setting['status'] == null OR $setting['status'] == ''){
                return true;
            } else return false;
        }
    function getA3EPVersion(){
					$xml = new SimpleXMLElement(file_get_contents(__DIR__.'/version.xml'));
					$result = $xml->xpath('//entry_ver');
					usort($result,'strcmp');
					$maxdate = end($result);
					foreach ($xml->entry as $item)
					{

							return $item->entry_title;

					}
			}
			    function getA3EPVersionLong(){
					$xml = new SimpleXMLElement(file_get_contents(__DIR__.'/version.xml'));
					$result = $xml->xpath('//entry_ver');
					usort($result,'strcmp');
					$maxdate = end($result);
					foreach ($xml->entry as $item)
					{

							return $item->entry_ver;

					}
			}
    function getSetting($settingname){
        global $db;
        global $tblpre;
        $query = "
            SELECT
                status
            FROM ".$tblpre."settings
            WHERE name=:name
            ";
        $query_params = array(
            ':name' => $settingname
				);

        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $settingvalue = $stmt->fetch();
        return $settingvalue['status'];
    }
    function getSteamapi(){
        global $db;
        global $tblpre;
        $query = "
            SELECT
                status
            FROM ".$tblpre."settings
            WHERE name=:name
            ";
        $query_params = array(
            ':name' => 'steamapi'
        );

        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $apikey = $stmt->fetch();
        return $apikey['status'];
    }
    function getItemName($class, $host, $port, $user, $pass){
		$scripta = '"'.$class .'" call ExileClient_util_gear_getConfigNameByClassName;';
$query = http_build_query([
 'script' => $scripta
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$typea = curl_exec($curl);
$type = substr($typea, 1, -1);
$script = 'getText(configFile >> "'.$type.'" >> "'.$class.'" >> "displayName");';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
return $result;
}

   function getServerUpTime($host, $port, $user, $pass){
		$script = 'serverTime;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$minutes = $result / 60;

$hours = floor($result / 3600);
$mins = floor($result / 60 % 60);
$secs = floor($result % 60);

$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
return $timeFormat;
}
   function getOnlinePlayers($host, $port, $user, $pass){
		$script = '_name = "";{_name =  (name _x) + "," + _name;}forEach( allPlayers - entities "HeadlessClient_F");  _name;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -2);

return $result;
}
   function isOnline($id,$host, $port, $user, $pass){
		$script = '_name = "";{_name =  (getPlayerUID _x) + "," + _name;}forEach( allPlayers - entities "HeadlessClient_F");  _name;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -2);
if (strpos($result, $id) !== false) {
    $result = 'true';
}
else
{
    $result = "false";
}

return $result;
}

    function getTerritoryLife(){
        global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
$script = ' getNumber(configFile >> "CfgSettings" >> "GarbageCollector" >> "Database" >> "territoryLifeTime");';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$a_host.'?user='.$a_user.'&pass='.$a_pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $a_port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $a_port);
$result = curl_exec($curl);
$result = str_replace (' ', '', $result);
$result = str_replace ('//', '', $result);
$result = str_replace (' ', '', $result);
//$result = substr($result, 1);
return $result;
}
    function getTerritoryCost(){
        global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
$script = ' getNumber (missionConfigFile >> "CfgTerritories" >> "popTabAmountPerObject");';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$a_host.'?user='.$a_user.'&pass='.$a_pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $a_port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $a_port);
$result = curl_exec($curl);
$result = str_replace (' ', '', $result);
$result = str_replace ('//', '', $result);
$result = str_replace (' ', '', $result);
//$result = substr($result, 1);
return $result;
}

    function VehiclePin($pin, $class, $loc, $host, $port, $user, $pass){

$script = '["'.$class.'",['.$loc.'],'.$pin.'] call a3ep_vehiclepin;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
return $result;
}
    function VehicleLock( $class, $loc, $host, $port, $user, $pass){

$script = '["'.$class.'",['.$loc.']] call a3ep_lock;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
return $result;
}
    function AddItems( $id, $class, $count, $host, $port, $user, $pass){
$script = '["'.$id.'","'.$class.'",'.$count.'] call a3ep_additem;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_TIMEOUT_MS, 50);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
$result = curl_exec($curl);

return $result;
}
function CheckItems( $id, $host, $port, $user, $pass){

$script = '["'.$id.'","'.$class.'"] call a3ep_checkinv;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_TIMEOUT_MS, 50);
$result = curl_exec($curl);
return $result;
}

    function Tabs( $id, $value, $host, $port, $user, $pass){
$script = '_id="'.$id.'";
_count='.$value.';
{
if ((getPlayerUID _x) == _id) then
{
_x setVariable ["ExileMoney", (_count), true];
};

} forEach allPlayers;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_TIMEOUT_MS, 50);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);

return $result;
}
    function RemoveItem( $id, $class, $count, $host, $port, $user, $pass){
$script = '["'.$id.'","'.$class.'",'.$count.'] call a3ep_removeitem;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
return $result;
}
    function GetMap(){
        global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
        $host = $a_host;
        $user = $a_user;
        $pass = $a_pass;
        $port = $a_port;
$script = 'worldName';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
return $result;
}
    function GetMapMarkers(){
        global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
        $host = $a_host;
        $user = $a_user;
        $pass = $a_pass;
        $port = $a_port;
$script = 'allMapMarkers';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
$result = str_replace ('"', '', $result);
$result = explode(",",$result);
return $result;
}
    function GetMarkerLocation($name){
        global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
        $host = $a_host;
        $user = $a_user;
        $pass = $a_pass;
        $port = $a_port;
$script = 'getMarkerPos "'.$name.'"';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
$result = explode(",",$result);
return $result;
}
    function GetMarkerRadius($name){
        global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
        $host = $a_host;
        $user = $a_user;
        $pass = $a_pass;
        $port = $a_port;
$script = 'getMarkerSize "'.$name.'"';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
return $result;
}
    function GetMarkerText($name){
        global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
        $host = $a_host;
        $user = $a_user;
        $pass = $a_pass;
        $port = $a_port;
$script = 'markerText "'.$name.'"';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);

return $result;
}
    function GetSize( ){
         global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
        $host = $a_host;
        $user = $a_user;
        $pass = $a_pass;
        $port = $a_port;
$script = 'getnumber (configfile >> "CfgWorlds" >> worldName >> "mapSize");';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
//$result = substr($result, 1, -1);
return $result;
}

    function PayTerritory( $tid){
                global $a_host;
        global $a_port;
        global $a_user;
        global $a_pass;
        $host = $a_host;
        $user = $a_user;
        $pass = $a_pass;
        $port = $a_port;
$script = '_territoryDatabaseID = "'.$tid.'"; format["maintainTerritory:%1", _territoryDatabaseID] call ExileServer_system_database_query_fireAndForget;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = substr($result, 1, -1);
return $result;
}
    function getPPO($count, $level, $host, $port, $user, $pass){
$script = 'getNumber (missionConfigFile >> "CfgTerritories" >> "popTabAmountPerObject");;';
$query = http_build_query([
 'script' => $script
]);
$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
$result = curl_exec($curl);
$result = (int)$result;
$result = ($result * $level * $count);
return $result;
}

    function updateServersetting($settingName, $value){
    			global $db;
    			global $tblpre;
    			$query = "UPDATE `".$tblpre."settings` SET `status` = :value WHERE name = :setting";
                $query_params = array(
    				':value' => $value,
    				':setting' => $settingName

                );

                try
                {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                }
                catch(PDOException $ex)
                {
                    die("Failed to run query: " . $ex->getMessage());
                }
    }
    function enableModule($module, $value){
    			global $db;
    			global $tblpre;
    			$query = "UPDATE `".$tblpre."modules` SET `module_enabled` = :enabled WHERE module_key = :module";
                $query_params = array(
    				':enabled' => $value,
    				':module' => $module

                );

                try
                {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                }
                catch(PDOException $ex)
                {
                    die("Failed to run query: " . $ex->getMessage());
                }
    }
    function getModule($module){
        global $db;
        global $tblpre;
        $query = "
            SELECT
                module_enabled
            FROM ".$tblpre."modules
            WHERE module_key=:name
            ";
        $query_params = array(
            ':name' => $module
				);

        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $modulestatus= $stmt->fetch();
        return $modulestatus['module_enabled'];
    }
	function getServerEmail(){
            global $db;
            global $tblpre;
            $query = "
            SELECT
                status
            FROM ".$tblpre."settings
            WHERE name=:name
            ";
            $query_params = array(
                ':name' => 'outgoing_email'
            );

            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $companyname = $stmt->fetch();
            return $companyname['status'];
        }
    function getServerName(){
                global $db;
                global $tblpre;
                $query = "
                SELECT
                    status
                FROM ".$tblpre."settings
                WHERE name=:name
                ";
                $query_params = array(
                    ':name' =>'servername'
                );

                try
                {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                }
                catch(PDOException $ex)
                {
                    die("Failed to run query: " . $ex->getMessage());
                }
                $companyname = $stmt->fetch();
                return $companyname['status'];
            }
    function getRecaptchaKey($option){
        switch($option){
                case "public":
                    global $db;
                    global $tblpre;
                    $query = "
                    SELECT
                        status
                    FROM ".$tblpre."settings
                    WHERE name=:name
                    ";
                    $query_params = array(
                        ':name' =>'recaptcha_key_public'
                    );

                    try
                    {
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    }
                    catch(PDOException $ex)
                    {
                        die("Failed to run query: " . $ex->getMessage());
                    }
                    $companyname = $stmt->fetch();
                    return $companyname['status'];
                    break;
                case "private":
                    global $db;
                    global $tblpre;
                    $query = "
                    SELECT
                        status
                    FROM ".$tblpre."settings
                    WHERE name=:name
                    ";
                    $query_params = array(
                        ':name' =>'recaptcha_key_private'
                    );

                    try
                    {
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    }
                    catch(PDOException $ex)
                    {
                        die("Failed to run query: " . $ex->getMessage());
                    }
                    $companyname = $stmt->fetch();
                    return $companyname['status'];
                    break;
                default:
                    return false;
                    break;
            }

        }
}
class userClass{
    function getUserlang($userid){
            global $db;
            global $tblpre;
            $userid = intval($userid);

            $query = "
                SELECT
                    `language` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            return $result['language'];
        }
	function updateUserPerm($user, $perm, $value){
                    global $db;
                    global $tblpre;

                    $query = "UPDATE ".$tblpre."user_permissions SET ".$perm." = :value WHERE id = :userid";

                    $query_params = array(
                        ':userid' => $user,
                        ':value' => $value
);
                    try
                    {
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);

                    }
                    catch(PDOException $ex)
                    {
                        die("Failed to run query: " . $ex->getMessage());
                    }
                    return true;

        }
    function isAdmin($userid){
            global $db;
            global $tblpre;
            $userid = intval($userid);

            $query = "
                SELECT
                    `admin` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            if($result['admin'] == 1){
                return true;
            } else return false;

        }
    function setuserprivacy($option ,$userid){
            switch($option){
                case "public":
                    global $db;
                    global $tblpre;
                    $query = "
                    UPDATE ".$tblpre."users SET private = '0' WHERE id = :userid
                    ";
                    $query_params = array(
                        ':userid' => $userid
                    );

                    try
                    {
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    }
                    catch(PDOException $ex)
                    {
                        die("Failed to run query: " . $ex->getMessage());
                    }

                    break;
                case "private":
                    global $db; global $tblpre;
                    $query = "
                     UPDATE ".$tblpre."users SET privacy = '1' WHERE id = :userid
                    ";
                    $query_params = array(
                        ':userid' => $userid
                    );


                    try
                    {
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    }
                    catch(PDOException $ex)
                    {
                        die("Failed to run query: " . $ex->getMessage());
                    }
                    break;
                default:
                    return false;
                    break;
            }

        }
    function getAllAdmins(){
			global $db;
			global $tblpre;
            $query = "
				SELECT * FROM `".$tblpre."users` WHERE admin = 1
            ";
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            return $stmt->fetchAll();
		}
    function userEmailResetRequest($userid){
			global $db;
			global $tblpre;
			// Generate User Key
			$userKey = substr(rtrim(base64_encode(md5(microtime())),"="), 0,25);
            $query = "
				UPDATE `".$tblpre."users` SET `passwordReset` = :option, `passwordKey` = :userkey WHERE `id` = :userid
            ";
            $query_params = array(
				':option' => 1,
                ':userkey' => $userKey,
				':userid' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            return $userKey;
		}
	function checkUserRequestNewPass($userid){
            global $db;
            global $tblpre;
            $query = "
                SELECT `passwordReset` FROM ".$tblpre."users WHERE id = :userid
            ";
            $query_params = array(
                ':userid' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            if($result['passwordReset'] == 1){
                return true;
            } else return false;
        }
	function checkUserPasswordReset($userid, $key, $raw_password){
            global $db;
            global $tblpre;

			$query = "
                SELECT `passwordKey` from `".$tblpre."users` WHERE id = :userid
                ";
            $query_params = array(
                ':userid' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();

			if($key != $result['passwordKey']){
				return false;
			} else {
				$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
				$password = hash('sha256', $raw_password . $salt);
				for($round = 0; $round < 65536; $round++)
				{
					$password = hash('sha256', $password . $salt);
				}
				$query = "
					UPDATE `".$tblpre."users` SET `password` = :password, `salt` = :salt, `passwordReset` = 0, `passwordKey` = NULL WHERE `id` = :userid
					";
				$query_params = array(
					':password' => $password,
					':salt' => $salt,
					':userid' => $userid
				);
				try
				{
					$stmt = $db->prepare($query);
					$result = $stmt->execute($query_params);
				}
				catch(PDOException $ex)
				{
					die("Failed to run query: " . $ex->getMessage());
				}
				return true;
			}
		}
	function checkUserAccountExistsByName($username){
			global $db;
			global $tblpre;

			$query = "
                SELECT `id` from `".$tblpre."users` WHERE username = :username
                ";
            $query_params = array(
                ':username' => $username
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->rowcount();
			if($result == 1){
				return true;
			} else {
				return false;
			}
		}
	function checkUserAccountExists($username, $email){
			global $db;
			global $tblpre;

			$query = "
                SELECT `id` from `".$tblpre."users` WHERE username = :username AND email = :email
                ";
            $query_params = array(
                ':username' => $username,
				':email' => $email
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->rowcount();
			if($result == 1){
				return true;
			} else {
				return false;
			}
		}
    function getUserAdminLevel($userid){
            global $db;
            global $tblpre;
            $userid = intval($userid);

            $query = "
                SELECT
                    `admin` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            return $result['admin'];

        }
	function changeUserSuspended($userid, $id){
			global $db;
			global $tblpre;
			$userid = intval($userid);
			$id = intval($id);

			$query = "
				UPDATE ".$tblpre."users SET suspended = :type WHERE id = :user
			";
			$query_params = array(
				':user' => $userid,
				':type' => $id
			);

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
		}
	function checkUserSuspended($userid){
			global $db;
			global $tblpre;
            $userid = intval($userid);
            $query = "
                SELECT `suspended` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            $sus = $result['suspended'];
			if($sus == 1){
				return true;
			} else {
				return false;
			}
		}
	function checkUserVerified($userid){
			global $db;
			global $tblpre;
            $userid = intval($userid);
            $query = "
                SELECT `verified` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            $sus = $result['verified'];
			if($sus == 1){
				return true;
			} else {
				return false;
			}
		}
    function getUserUsername($userid){
            global $db;
            global $tblpre;
            $userid = intval($userid);

            $query = "
                SELECT
                    `username` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            return $result['username'];
        }
	function getusernamesteam($steamid){
            global $db;
            global $tblpre;
            $steamid = intval($steamid);

            $query = "
                SELECT
                    `username` from `".$tblpre."users` WHERE steamid = :steamid
                ";
            $query_params = array(
                ':steamid' => $steamid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            return $result['username'];
        }
	function getusersteamid($userid){
            global $db;
            global $tblpre;
            $userid = intval($userid);

            $query = "
                SELECT
                    `steamid` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            return $result['steamid'];
        }
	function getUserEmail($userid){
            global $db;
            global $tblpre;
            $userid = intval($userid);

            $query = "
                SELECT
                    `email` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            return $result['email'];
        }
    function getUserAvatar($userid){
            global $db;
            global $tblpre;
            $userid = intval($userid);

            $query = "
                SELECT `username`, `avatar` from `".$tblpre."users` WHERE id = :id
                ";
            $query_params = array(
                ':id' => $userid
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
           return $result['avatar'];
        }
	function getUserUserid($username){
            global $db;
            global $tblpre;

            $query = "
                SELECT
                    `id` from `".$tblpre."users` WHERE username = :id
                ";
            $query_params = array(
                ':id' => $username
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $result = $stmt->fetch();
            return $result['id'];

        }
	function updateUserPassword($user, $rawPassword){
			$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
			$password = hash('sha256', $rawPassword . $salt);
			for($round = 0; $round < 65536; $round++)
			{
				$password = hash('sha256', $password . $salt);
			}

			global $db;
			global $tblpre;
			$query = "UPDATE `".$tblpre."users` SET `password` = :pass, `salt` = :salt WHERE `id` = :id";
            $query_params = array(
                ':pass' => $password,
				':salt' => $salt,
				':id' => intval($user)
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
			return true;
		}
	function updateUserEmail($user, $email){
			global $db;
			global $tblpre;
			$query = "UPDATE `".$tblpre."users` SET `email` = :email WHERE `id` = :id";
            $query_params = array(
                ':email' => $email,
				':id' => intval($user)
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
			return true;
		}
	function updateUser($user, $key, $value){
			global $db;
			global $tblpre;
			$query = "UPDATE `".$tblpre."users` SET `".$key."` = :value WHERE `id` = :id";
            $query_params = array(
                ':value' => $value,
				':id' => intval($user)
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
			return true;
		}
	function updateUserAvatar($user, $pic){
			global $db;
			global $tblpre;
			$query = "UPDATE `".$tblpre."users` SET `avatar` = :avatar WHERE `id` = :id";
            $query_params = array(
                ':avatar' => $pic,
				':id' => intval($user)
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
			return true;
		}
}
class statClass{
	function __construct($settings){
			$this->settings = $settings;
		}
    function getTotalusers(){
            global $dbo;
            $query = "
                SELECT
           *
        FROM account INNER JOIN player ON account.uid=player.account_uid WHERE last_disconnect_at > DATE_SUB(now(), INTERVAL 1 MONTH);
            ";

            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                 if($ex->getMessage() == 'SQLSTATE[3D000]: Invalid catalog name: 1046 No database selected' ){
                echo "test";
                 } else {
                die("Failed to run query: " . $ex->getMessage());
            }
            }

            $allusers = $stmt->rowCount();
            return $allusers;
        }
	function getMembers(){
            global $db;
            global $tblpre;
            $query = "
                SELECT
                    *
                    FROM ".$tblpre."users
                    WHERE verified = 1
            ";

            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {

                die("Failed to run query: " . $ex->getMessage());
            }

            $countmembers = $stmt->rowCount();
            return $countmembers;
        }
    function getTotalMoneyPlayer(){
            global $dbo;
            $query = "
                SELECT
                    SUM(money) as totalMoneyPlayer
                    FROM player
            ";

            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
			$row = $stmt->fetch();
			$totalmoney = $row['totalMoneyPlayer'];

            return $totalmoney;
        }
	function getTotalconnections(){
            global $dbo;
            $query = "
                SELECT
                    SUM(total_connections) as connections
                    FROM account
            ";

            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }

            $row = $stmt->fetch();
			$totalconnections = $row['connections'];
            return $totalconnections;
        }
    function getTotalKills(){
             global $dbo;
            $query = "
                SELECT
                    SUM(kills) as killcount
                    FROM account
            ";

            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }

            $row = $stmt->fetch();
			$totalkills = $row['killcount'];
            return $totalkills;
        }
    function getTotalDeaths(){
            global $dbo;
            $query = "
                SELECT
                    SUM(deaths) as deathcount
                    FROM account
            ";

            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }

            $row = $stmt->fetch();
			$totaldeaths = $row['deathcount'];
            return $totaldeaths;
        }
    function getTotalLocker(){
            global $dbo;
             $query = "
                SELECT
                    SUM(locker) as lockercount
                    FROM account
            ";

            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }

            $row = $stmt->fetch();
			$totallocker = $row['lockercount'];
            return $totallocker;

        }
    function getTotalScore(){
            global $dbo;
             $query = "
                SELECT
                    SUM(score) as scorecount
                    FROM account
            ";

            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }

            $row = $stmt->fetch();
			$totalscore = $row['scorecount'];
            return $totalscore;
		}
    function getPendingUsers(){
            global $db;
            global $tblpre;
             $query = "
                SELECT
                    *
                    FROM ".$tblpre."users
                    WHERE verified = 0
            ";

            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute();
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }

            $countpends = $stmt->rowCount();
            return $countpends;
        }
    function getTotalUnreadMail($id){
            $id = intval($id);
            global $db;
            global $tblpre;
            $query = "
                SELECT
                    *
                    FROM ".$tblpre."private_messages
                    WHERE
                        sentto = :id AND
                        status = 0
                ";
            $query_params = array(
                ':id' => $id
            );

            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
            $countUnread = $stmt->rowCount();
            return $countUnread;
        }
	function getUserTotalKills($steamid){
			global $dbo;
            $query = "
				SELECT `kills` FROM `account` WHERE `uid`= :player
            ";
			$query_params = array(
				":player"=>$steamid
			);
            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
           return $stmt->fetch()['kills'];
		}
    function getUserTotalDeaths($steamid){
			global $dbo;
                $query = "
				SELECT `deaths` FROM `account` WHERE `uid`= :player
            ";
			$query_params = array(
				":player"=>$steamid
			);
            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
           return $stmt->fetch()['deaths'];
		}
	function getUserTotalMoney($steamid){
			global $dbo;
                $query = "
				SELECT `money` FROM `player` WHERE `account_uid`= :player
            ";
			$query_params = array(
				":player"=>$steamid
			);
            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
           return $stmt->fetch()['money'];
		}
	function getUserTotalConnections($steamid){
			global $dbo;
                $query = "
				SELECT `total_connections` FROM `account` WHERE `uid`= :player
            ";
			$query_params = array(
				":player"=>$steamid
			);
            try
            {
                $stmt = $dbo->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
           return $stmt->fetch()['total_connections'];
		}
    }
class permissionClass{
	function changeUserPerms($permissionSet, $result, $user){
			global $db;
			global $tblpre;
			$user = intval($user);
					$query = "UPDATE `".$tblpre."user_permissions` SET `".$permissionSet."` = :result WHERE `id` = :id";

			$query_params = array(
				':result' => $result,
				':id' => $user
			);
			try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
		}
    function checkUserPerms($permissionSet, $user){
			global $db;
			global $tblpre;
			$user = intval($user);
					$query = "SELECT `".$permissionSet."` FROM `".$tblpre."user_permissions` WHERE `id` = :id";
					$resultVar = $permissionSet;

			$query_params = array(
				':id' => $user
			);
			try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query: " . $ex->getMessage());
            }
			$result = $stmt->fetch();
			if($result[$resultVar] == 1){
				return true;
			} else {
				return false;
			}
		}
	}




