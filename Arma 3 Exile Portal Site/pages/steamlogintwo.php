<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
include_once("extra/steamAuth/SteamAuth.class.php");

$auth = new SteamAuth();
$auth->SetOnLoginCallback(function($steamid){return true;});
$auth->SetOnLoginFailedCallback(function(){return true;});
$auth->SetOnLogoutCallback(function($steamid){return true;});
$auth->Init();
if($auth->IsUserLoggedIn()){
$auth->Logout();
$_SESSION['a3epsteamid'] = $auth->SteamID;
require_once("extra/steamAuth/functions.php");

$query = "SELECT id FROM ".$tblpre."users WHERE steamid=:steamID";
$query_params = array(":steamID"=> $_SESSION['a3epsteamid']);
 try {
       $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $companyname = $stmt->fetch();
$userid = $companyname['id'];
         $results = $stmt->rowcount();
			if($results > 0){

						 //NEWSESSIONHANDLER
				$query = "UPDATE `".$tblpre."sessions`
							SET accountid = :userid
							WHERE sid = :sid
						";

						$query_params = array(
							':userid' => $userid,
							':sid' => $SID
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
						$queryl = "
							UPDATE ".$tblpre."users
								SET lastlogged = :date
							WHERE
								id = :username
						";

						$query_paramsl = array(
							':date' => date('Y-m-y H:i:s'),
							':username' => $userid
						);

						try
						{
							$stmtl = $db->prepare($queryl);
							$resultl = $stmtl->execute($query_paramsl);
						}
						catch(PDOException $ex)
						{

							die("Failed to run query: " . $ex->getMessage());
						}


						header("Location: ?page=index");
						exit;
			} else {
				header("Location: ?page=login&signup=$auth->SteamID");
			}
}
	if($userClass->getusersteamid($AccountID !== null)){
	header("Location: ?page=main");	}
else	{
	if(isset($_SESSION['a3epErr']))
	{
echo $_SESSION['a3epErr'] . "<br /><br />";
}
}
?>

