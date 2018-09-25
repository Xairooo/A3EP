<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
	if(isset($_GET['do']))
	{
		if (($_GET['do'] =='confirm') && !empty($_GET['do']) AND isset($_GET['id']) && !empty($_GET['id'])){
			$id = $_GET['id'];
			$queryv = "UPDATE ".$tblpre."users SET verifypend = 0, verified = 1  WHERE username = :id";
				$query_paramsv = array(
					':id' => $id,
				);
	        try
	        {
	            $stmtv = $db->prepare($queryv);
	            $resultv = $stmtv->execute($query_paramsv);
	            header("location: ?page=main");
	        }
	        catch(PDOException $ex)
	        {
	            die("Failed to run query: " . $ex->getMessage());
	        }
		}
	}
	if(!empty($AccountID))
	{
			header("Location: ?page=main");
			exit();
	}
	// GET LOGIN STATUS
	$query = "SELECT status FROM ".$tblpre."settings WHERE name=:status";
	$query_params = array(':status' => 'logindisabled');
	try
	{
    	$stmt = $db->prepare($query);
		$result = $stmt->execute($query_params);
	}
	catch(PDOException $ex)
	{
		die("Failed to run query: " . $ex->getMessage());
	}
	$loginstature = $stmt->fetch();
	$query = "SELECT status FROM ".$tblpre."settings WHERE name=:status";
	$query_params = array(':status' => 'login_providers');
	try
	{
    	$stmt = $db->prepare($query);
		$result = $stmt->execute($query_params);
	}
	catch(PDOException $ex)
	{
		die("Failed to run query: " . $ex->getMessage());
	}
	$types = $stmt->fetch();
	if ($loginstature['status'] == 1)
	{
		?>
			<div class="container" style="width:450px;">
				<div class="alert alert-danger" style="text-align: center;">
					<a class="alert-link"><?php echo $langs->word($dlang,'login_disabled');?></a>
				</div>
			</div>
		<?php
	}
	else
	{
	//GET LOGIN TYPE
	$includelogin = "1";
	$type = explode(',',$types["status"]);
	if(in_array("steam",$type))
	{
		if (in_array("intergrated",$type))
		{
			require("defaultlogin_COMBINED.php");
		}
		else
		{
			require("defaultlogin_STEAM.php");
		}
	}
	else if (in_array("intergrated",$type))
	{
		require("defaultlogin_INTERGRATED.php");
	}
	else
	{
	}
	}
?>