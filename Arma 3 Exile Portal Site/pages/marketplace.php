<?php if(!isset($include)){die("INVALID REQUEST");}
    if($settingClass->getModule('marketplace') =='0'){
echo '<div class="container"><h1><center>'. $langs->word($dlang,'module Disabled') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'disabled_desc') .' </div></div></div>';
		die();
    } else {
    	if(!$permClass->checkUserPerms("marketplace_access", $AccountID)){
		echo '<div class="container"><h1><center>'. $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .', PERM:"garage_access" </div></div></div>';
		die();
	}
	else { ?>
<style>
        .product_view .modal-dialog{max-width: 800px; width: 100%;}
        .pre-cost{text-decoration: line-through; color: black;}
        .space-ten{padding: 10px 0;}
.dd
{
    margin-left:0px;
    float: left; !important
}
</style>
<?php
if(isset($_GET["claim"]))
{
    $pstat = $settingClass->isOnline($userClass->getusersteamid($AccountID) ,$a_host, $a_port, $a_user, $a_pass);
if($pstat == "true")
{
       $query = " SELECT * FROM ".$tblpre."marketplace WHERE status='1' AND buyer=".$userClass->getusersteamid($AccountID);
         try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
      $rows = $stmt->fetchAll();
       foreach($rows as $row){
        $settingClass->AddItems($userClass->getusersteamid($AccountID), $row["class"], "1" ,$a_host, $a_port, $a_user, $a_pass);
        $query = "UPDATE ".$tblpre."marketplace SET status = '2' WHERE id = ".$row["id"];
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
       }
        ?>
    <h2  style="text-align: center;">Item Claimed</h2>
    <?php
}
else
{
    ?>
     <div class="container" style="padding-top: 15px;">
        <div class="text-center lead alert alert-danger">
        You are not logged into the server and cannot claim this item, Please try again once you have logged in.

        </div>
    </div>
    <?php
}
}
if (isset($_POST["item"]))
{
    if (isset($_POST["buy"]))
{
    $settingClass->AddItems($userClass->getusersteamid($AccountID), $_POST["class"], "1" ,$a_host, $a_port, $a_user, $a_pass);
    $settingClass->Tabs($userClass->getusersteamid($AccountID),$_POST["tabs"],$a_host, $a_port, $a_user, $a_pass);
     $query = "UPDATE player SET money = ".$_POST["tabs"]." WHERE account_uid = ".$userClass->getusersteamid($AccountID);
        try
        {
            $stmt = $dbo->prepare($query);
            $result = $stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
$pstat = $settingClass->isOnline($userClass->getusersteamid($AccountID) ,$a_host, $a_port, $a_user, $a_pass);
if($pstat == "true")
{
     $query = "UPDATE ".$tblpre."marketplace SET status = '2', buyer= '".$userClass->getusersteamid($AccountID)."',  bought= NOW() WHERE id = ".$_POST["item"];
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());

        }
}
else
{
         $query = "UPDATE ".$tblpre."marketplace SET status = '1', buyer= '".$userClass->getusersteamid($AccountID)."', bought= NOW() WHERE id = ".$_POST["item"];
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }

        $query3 = "
				INSERT INTO `".$tblpre."private_messages` (
					`sentby`,
					`sentto`,
					`subject`,
					`message`
				) VALUES (
					:from,
					:name,
					:subject,
					:content
				)
			";
			$ITEMNAME = $_POST["itemname"];
            include("diag/marketmessage.php");
			$content = $message;
			$subject = "CLAIM ITEM PURCHASE";
			$to = $AccountID;
            $userid = $_POST["seller"];
			$query_params3 = array(
				':from' => $userid,
				':name' => $to,
				':content' => $content,
				':subject' => $subject
			);

			try
			{
				$stmt2 = $db->prepare($query3);
				$result2 = $stmt2->execute($query_params3);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
}
$query = "SELECT money FROM player WHERE account_uid = :user";
    $query_params = array(
        ":user" => $userClass->getusersteamid($_POST["seller"])
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
    $ply = $stmt->fetch();
    $steamsellid = $userClass->getusersteamid($_POST["seller"]);
    $balance = (int)$statClass->getUserTotalMoney($steamsellid);

    $v2 = $_POST["cost"];
    $total = $balance + $v2;
$settingClass->Tabs($steamsellid,$total,$a_host, $a_port, $a_user, $a_pass);
     $query = "UPDATE player SET money = ".$total." WHERE account_uid = ".$steamsellid;

        try
        {
            $stmt = $dbo->prepare($query);
            $result = $stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
    header("location: ?page=marketplace");
}
}
else
{
    require("diag/marketmain.php");
}
}
}
?>



