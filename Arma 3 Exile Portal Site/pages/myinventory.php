<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
    if($settingClass->getModule('inventory') =='0'){
echo '<div class="container"><h1><center>'. $langs->word($dlang,'module Disabled') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'disabled_desc') .' </div></div></div>';
		die();
    } else {
	if(!$permClass->checkUserPerms("inventory_access", $AccountID)){
			echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {
$query = "SELECT * FROM account INNER JOIN player ON account.uid=player.account_uid WHERE account.uid ='".$userClass->getusersteamid($AccountID)."';";
    try
    {
      $stmt = $dbo->prepare($query);
			$result = $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
    $rows = $stmt->fetchAll();
    $count = $stmt->rowCount();
    if($count < 1)
    {
        ?>
         <div id="message" class="container">
<div class="text-center lead alert alert-warning">
You have no character on the selected server.
</div></div>
        <?php
    }
?>
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
<?php //Disabled Catagories  ,"handgun_items" "primary_weapon_items", ,"secondary_weapon_items"
$collumnarray = ["assigned_items","backpack","backpack_items","backpack_magazines","backpack_weapons","goggles","handgun_weapon","headgear","binocular","loaded_magazines","primary_weapon","secondary_weapon","uniform","uniform_items","uniform_magazines","uniform_weapons","vest","vest_items","vest_magazines","vest_weapons"];
foreach($rows as $row){
if(isset($_POST["item"]))
{
if(!isset($_GET["hidefeatures"]))
{
include("diag/invokesell.php");
}
if(isset($_GET["fnc"]))
{
    include("diag/invsell.php");
}
}
else {
?>
<div class="container">
<div class="row" style="background:#2d3035;">
<?php
include("diag/myinvfnc.php");
foreach($collumnarray as $iinfo){
include("diag/myinvdiag.php");
}

?>
</div></div>
<?php
}

}
}
}
?>