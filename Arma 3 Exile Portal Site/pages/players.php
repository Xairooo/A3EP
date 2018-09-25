<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
$uid= "";
$damage = "";
$name = "";

$query = "SELECT * FROM account INNER JOIN player ON account.uid=player.account_uid WHERE last_disconnect_at > DATE_SUB(now(), INTERVAL 1 MONTH)";

    try
    {
        $stmt = $dbo->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $rows = $stmt->fetchAll();
    $count = $stmt->rowCount();

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
				[25],
				[25]
			],
			"columnDefs": [{
				"orderSequence": ["desc", "asc"],
				"targets": [1, 2, 3, 4, 5, 6, 7]
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
		</div>
		<?php } ?>
		<div class="col-md-9">
			<div class="col-sm-12">
				<h2 class="h-color">
					<span class="black">
                        <?php echo $settingClass->getServerName(); ?></span><span class="white"> Players </span><span class="orange"></span><span class="white"></span></h2>
				<div class="c-box">
					<div class="table-responsive">
						<table id="tableList" class="table table-striped table-condensed">
							<thead>
								<tr>
									<th><?php echo $langs->word($dlang,'player');?></th>
									<th><?php echo $langs->word($dlang,'score');?></th>
									<th><?php echo $langs->word($dlang,'kills');?></th>
									<th><?php echo $langs->word($dlang,'deaths');?></th>
									<th><?php echo $langs->word($dlang,'first_seen');?></th>
									<th><?php echo $langs->word($dlang,'last_seen');?></th>
									<th><?php echo $langs->word($dlang,'total_connections');?></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php  foreach($rows as $row): ?>
								<tr>
									<td>
										<?php echo htmlentities($row['name'], ENT_QUOTES, 'UTF-8');?>
									</td>
									<td>
										<?php echo $row['score'];?>
									</td>
									<td>
										<?php echo $row['kills']; ?>
									</td>
									<td>
										<?php echo $row['deaths']; ?>
									</td>
									<td>

										<?php
										echo date('F j, Y', strtotime($row['first_connect_at']));?>
									</td>
									<td>
										<?php echo date('F j, Y', strtotime($row['last_disconnect_at']));?>
									</td>
									<td>
										<?php echo $row['total_connections']; ?>
									</td>
									<td>
									<button type="button" id="<?php $counter = $row['uid']; echo $counter ?>" class="btn btn-primary" data-toggle="modal" data-target="#fullplayer"><?php echo $langs->word($dlang,'view_player'); ?></button>

									</td>
								</tr>

								<script>
									document.getElementById("<?php echo $counter ?>").addEventListener("click", displayDate);
									function displayDate() {
										<?php $uid = $counter;
										$damage = $row['damage'];
										$name = $row['name'];?>
										<?php $steamid = $uid;
									?>              <?php	$totaldamage = "1";
																$currentdamage =  $damage;
																$damagepercent = $currentdamage/$totaldamage * 100;
															    $totalhealth = "100";
																$health = round($totalhealth - $damagepercent);
																$money = number_format($row['money']);
																$temp = $row['temperature'] * 9/5 + 32;
																$hunger = round($row['hunger']);
																$thirst = round($row['thirst']);
																?>
										document.getElementById("fullplayerTitle").innerHTML =  "<?php echo $langs->word($dlang,'player_id');?><span class='blue'><?php echo $uid;?></span>";
										document.getElementById("1029").setAttribute("avatar","<?php echo $name;?>");
										document.getElementById("1024").innerHTML = "<?php echo $name; ?>";

										document.getElementById("1025").innerHTML = "<?php echo $health; ?>%";
										document.getElementById("1026").innerHTML = "<?php echo $temp; ?>";
										document.getElementById("1027").innerHTML = "<?php echo $hunger; ?>";
										document.getElementById("1028").innerHTML = "<?php echo $thirst; ?>";

										document.getElementById("fullplayer").style.display='block';
  LetterAvatar.transform();
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
</div>
<?php include("diag/fullplayer.php");?>
      <script type="text/javascript" src="./library/letteravatar.js"></script>