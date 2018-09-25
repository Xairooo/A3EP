<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
include_once("extra/steamAuth/SteamAuth.class.php");
$auth = new SteamAuth();
$auth->SetOnLoginCallback(function($steamid){return true;});
$auth->SetOnLoginFailedCallback(function(){return true;});
$auth->SetOnLogoutCallback(function($steamid){return true;});
$auth->Init();
	if(isset($_POST['unlink'])){
			//TODO: save steam id to db;
			require_once("extra/steamAuth/functions.php");
			$pdo = mysqli($host,$username,$password,$dbname);
			$request = $pdo->prepare("UPDATE ".$tblpre."users SET steamID = :steamID WHERE id=:userID");
			$request->execute([
				":steamID"=>null,
				":userID"=>$AccountID
			]);
			unset($_SESSION['a3epsteamid']);
		}
if($auth->IsUserLoggedIn()){
$auth->Logout();
$_SESSION['a3epsteamid'] = $auth->SteamID;
require_once("extra/steamAuth/functions.php");
$querys = "SELECT id FROM ".$tblpre."users WHERE steamid=:steamID";
$query_paramss = array(":steamID"=> $_SESSION['a3epsteamid']);
 try {
       $stmts   = $db->prepare($querys);
        $results = $stmts->execute($query_paramss);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
 $companyname = $stmts->fetch();

         $results = $stmts->rowcount();
			if($results > 0){


			} else {
			$query = "UPDATE ".$tblpre."users SET steamID = :steamID WHERE id=:userID";
$query_params = array(":steamID"=> $_SESSION['a3epsteamid'], ":userID"=> $AccountID);
 try {
       $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
     	header("location: ?page=accountsettings&f=steam");
			}

}

?>

