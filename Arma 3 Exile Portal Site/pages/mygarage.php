<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php

    if(empty($AccountID) || !isset($AccountID))
    {
        header("Location: ?page=login");
        exit;
    }
    if($settingClass->getModule('mygarage') =='0'){
echo '<div class="container"><h1><center>'. $langs->word($dlang,'module Disabled') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'disabled_desc') .' </div></div></div>';
		die();
    } else {

    	if(!$permClass->checkUserPerms("garage_access", $AccountID)){
		echo '<div class="container"><h1><center>'. $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .', PERM:"garage_access" </div></div></div>';
		die();
	}
	else {
	$userid = intval($AccountID);
    if(isset ($_POST["pin"]))
    {
	if(!$permClass->checkUserPerms("garage_change_pin", $AccountID)){
		echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {
		$query = "

		UPDATE `vehicle` SET `pin_code` = :pin WHERE `vehicle`.`id` = :id;

		";

		$query_params = array(
		':id' => $_POST['id'],
		':pin' => $_POST['pinc']

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
		$query = "SELECT `class`,`position_x`,`position_y`,`position_z` FROM `vehicle` WHERE `id` = :id;";

		$query_params = array(
		':id' => $_POST['id']
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
		$info =  $stmt->fetch();
		$class = $info["class"];
		$loc = $info["position_x"].",".$info["position_y"].",".$info["position_z"];
		$pin = $_POST['pinc'];
		$settingClass->VehiclePin($pin, $class, $loc, $a_host, $a_port, $a_user, $a_pass);

	}
	//die($loc.$class);
		header("Location: ?page=mygarage");
		exit;
    }
    if(isset ($_POST["togglelock"]))
    {
		if($_POST['locked'] == "-1")
		{
			$stat = "0";
		}
		else
		{
			$stat = "-1";
		}
		$query = "

		UPDATE `vehicle` SET `is_locked` = :islocked WHERE `vehicle`.`id` = :id;

		";

		$query_params = array(
		':id' => $_POST['id'],
		':islocked' => $stat

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
		try
		{
			$stmt = $dbo->prepare($query);
			$result = $stmt->execute($query_params);
		}
		catch(PDOException $ex)
		{
			die("Failed to run query: " . $ex->getMessage());
		}
		$query = "SELECT `class`,`position_x`,`position_y`,`position_z` FROM `vehicle` WHERE `id` = :id;";

		$query_params = array(
		':id' => $_POST['id']
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
		$info =  $stmt->fetch();
		$class = $info["class"];
		$loc = $info["position_x"].",".$info["position_y"].",".$info["position_z"];
		$settingClass->VehicleLock($class, $loc, $a_host, $a_port, $a_user, $a_pass);
		header("Location: ?page=mygarage");
		exit;

    }
    $query = "
        SELECT
          *
			FROM vehicle
			WHERE account_uid = :steam
		";
		 $query_params = array(
			':steam' => $userClass->getusersteamid($AccountID)
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
		$rows = $stmt->fetchAll();
	    $count = $stmt->rowcount();

?>
	<style>
		.chosen-container {
			width: 100% !important;
		}

		.text_button {
			border: none;
			background-color: transparent;
			padding: 0;
		}
	</style>
	<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>

	<script>
		$(document).ready(function() {
			var table = $('#tableList').DataTable({
				"lengthMenu": [
					[25, 50, 100, -1],
					[25, 50, 100, "All"]
				],
				"columnDefs": [{
					"orderSequence": ["desc", "asc"],
					"targets": [1, 2, 3, 4, 5]
				}]
			});
			table
				.order([0, 'desc'])
				.draw();
		});
	</script>

	<div class="container">
		<div class="row new">
			<?php if(!isset($AccountID) && empty($AccountID)) { ?>
			<div class='red-box'>
			<h3><?php echo $langs->word($dlang,'uh-oh');?></h3>
			<div class='text'><?php echo $langs->word($dlang,'not_logged_in');?><a href="?page=register"><?php echo $langs->word($dlang,'register_here');?></a> ~ <a href="?page=login"><?php echo $langs->word($dlang,'login_here');?></a>.
			</div>
			<?php } ?>
			<div class="col-md-9">
				<h2>Your Garage</h2>
				<div class="c-box">

					<div class="table-responsive">
						<table id="tableList" class="table table-striped table-condensed">
							<thead>
								<tr>
									<th><?php echo $langs->word($dlang,'id');?></th>
									<th><?php echo $langs->word($dlang,'vehicle');?></th>
									<th><?php echo $langs->word($dlang,'status');?></th>
									<th><?php echo $langs->word($dlang,'fuel');?></th>
									<th><?php echo $langs->word($dlang,'money');?></th>
									<th><?php echo $langs->word($dlang,'action');?></th>

								</tr>
							</thead>
							<tbody>
								<?php  foreach($rows as $row):

		if($row['is_locked'] == 0)
		{
			$status = "<span class=\"label label-success\">".$langs->word($dlang,'unlocked')."</span>";
		}
		else if($row['is_locked'] == -1)
		{
			$status = "<span class=\"label label-danger\">".$langs->word($dlang,'locked')."</span>";
		}
		$vehicle = $row['class'];
		$totalfuel = 1;
		$TotalDamage = 1;
$currentfuel = $row['fuel'];
$percentage = $currentfuel/$totalfuel * 100;
$percentage =	round( $percentage, 1, PHP_ROUND_HALF_UP);
$currentdamage = $row['damage'];
$damage = $currentdamage/$TotalDamage * 100;
$bought = $row['spawned_at'];
$bought = strtotime($bought);
$updated = $row['last_updated_at'];
$updated = strtotime($updated);
$pin = $row['pin_code'];
$vehname = $settingClass->getItemName($vehicle, $a_host, $a_port, $a_user, $a_pass);

			?>

								<tr>
									<td>
										<?php echo $row['id']; ?>
									</td>
									<td>
										<?php echo $vehname;?>
									</td>
									<td>
										<?php echo $status; ?>
									</td>
									<td>
										<?php echo htmlentities($percentage, ENT_QUOTES, 'UTF-8'); ?>%</td>
									<td>
										<?php echo htmlentities($row['money'], ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td><button id="<?php echo $row['id'];?>">View Details</button></td>
								</tr>

								</tr>
								<script>
									<?php
									$fstat = "1";
									$fsta = "1";
									$id = $row["id"];
									if($row['is_locked'] == -1)
									{
										$status = $langs->word($dlang,'vehicle_locked');
										$sts = $langs->word($dlang,'unlock_vehicle');
									}
									else if($row['is_locked'] == 0)
									{
											$status = $langs->word($dlang,'vehicle_unlocked');
										$sts = $langs->word($dlang,'lock_vehicle');
									}

									?>
									document.getElementById("<?php echo $row['id']; ?>").addEventListener("click", displayDate);

									function displayDate() {
										document.getElementById("fullvehiclename").innerHTML = "Vehicle ID: <span class='blue'><?php echo $row['id'];?></span>";
										document.getElementById("1023").innerHTML = "<?php echo $vehname;?>";
										document.getElementById("1025").setAttribute("name","<?php echo $fstat;?>");
										document.getElementById("1026").setAttribute("value","<?php echo $id;?>");
										//document.getElementById("1027").setAttribute("name","<?php echo $fsta;?>");
										document.getElementById("1027").setAttribute("value","<?php echo $sts;?>");
										document.getElementById("1028").innerHTML = "<?php echo $status;?>";
										document.getElementById("stat").setAttribute("value","<?php echo $row['is_locked'];?>");
										document.getElementById("1030").innerHTML = "<?php echo $damage;?>%";
										document.getElementById("1031").innerHTML = "<?php echo $percentage;?>%";
										document.getElementById("1032").innerHTML = "<?php echo $row['money'];?>";
										document.getElementById("1033").innerHTML = "<?php echo $pin;?>";
										document.getElementById("1034").setAttribute("value","<?php echo $id;?>");
										document.getElementById("1035").setAttribute("value","<?php echo $pin;?>");
										document.getElementById("1036").innerHTML = "<?php echo date('F j, Y g:i A', $bought);?>";
										document.getElementById("1037").innerHTML = "<?php echo date('F j, Y g:i A', $updated);?>";
										document.getElementById("fullvehicle").style.display = 'block';

									}
								</script>


								<?php endforeach; ?>



							</tbody>


						</table>
					</div>
				</div>
			</div>
		</div>
</div>


<?php
include("diag/garagedetailed.php");
}
}
?>