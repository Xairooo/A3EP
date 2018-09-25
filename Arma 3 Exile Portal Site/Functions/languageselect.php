<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php

 if(empty($AccountID) || !isset($AccountID))
    {
    	if(isset($_COOKIE[$defaultConstants['COOKIE_PREFIX'].'language'])) {
    		$dlang = $_COOKIE[$defaultConstants['COOKIE_PREFIX'].'language'];
    	} else {
      $dlang = $settingClass->getdefaultlang();
    	}
    } else {
    	$dlang = $userClass->getUserlang($AccountID);
    }
    if(isset($_GET['language']))
{
if(!isset($AccountID) && empty($AccountID)) {
if ($defaultConstants['COOKIE_PATH']== NULL)
{
  $path = "/";
} else
{
  $path = $defaultConstants['COOKIE_PATH'];
}
setcookie($defaultConstants['COOKIE_PREFIX'].'language', $_GET['langauge'], time() + (10 * 365 * 24 * 60 * 60), $path);
}
	$query = "UPDATE `".$tblpre."users` SET `language` = :lang WHERE id = :user";
            $query_params = array(
				':lang' => $_GET['language'],
				':user' => $AccountID

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
            $redirect = $_SERVER['HTTP_REFERER'];
header("location:".$redirect);
}
    ?>