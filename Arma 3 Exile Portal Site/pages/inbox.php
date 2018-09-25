<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<script src="./library/jquery/dist/jquery.min.js"></script>
	<div class="container">
		<div class="row new" style="background-color: #2d3035;">
			<?php
    if(empty($AccountID) || !isset($AccountID))
    {
        header("Location: ?page=login");
        exit;
    }
    if(isset($_GET['folder']))
    {
    if($_GET['folder'] == 'sent')
    {
        $query = "
        SELECT
			*
		FROM
			".$tblpre."private_messages
		WHERE
			sentby = :by AND status != 2
		ORDER BY time DESC
	";

	$query_params = array(
		':by' => $AccountID
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
	$rows = $stmt->fetchall();
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
			<script src="./library/datatables.net/js/jquery.dataTables.min.js"></script>
				<link rel="stylesheet" href="./library/datatables.net/css/dataTables.bootstrap.min.css">
				<script>
					$(document).ready(function() {
						$('#inbox').DataTable({
							'paging': true,
							'lengthChange': false,
							'searching': true,
							'ordering': false,
							'info': true,
							'autoWidth': true
						})
					})
				</script>
				<link rel="stylesheet" href="./library/admin-css/css/Admin.min.css">
				<style>
					.box{
						position: relative;
						border-radius: 3px;
						background: #22252a !important;
						color: #fff;
						margin-bottom: 20px;
						width: 100%;
					}
				</style>
						<div class="col-lg-3">
							<a href="?page=sendmessage" class="btn btn-primary btn-block margin-bottom">Compose</a>
							<div class="box box-solid">
								<div class="box-header with-border">
									<h3 class="box-title" style="color:black">Folders</h3>

									<div class="box-tools">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
									</div>
								</div>
								<div class="box-body no-padding">
									<ul class="nav nav-pills nav-stacked">
									<li  style="color:black" class="active"><a href="?page=inbox"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right"><?php echo $count;?></span></a></li>


									</ul>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /. box -->
						</div>
						<!-- /.col -->
						<div class="col-lg-9">
							<div class="box box-primary">
								<div class="box-header with-border">
									<h3 class="box-title" style="color:black">Inbox</h3>


								</div>
								<!-- /.box-header -->
								<div class="box-body no-padding">
									<div class="table-responsive mailbox-messages">
										<table id="inbox" class="table">
											<thead>
    <tr>
        <th>Status</th>
        <th>To</th>
        <th>Subject</th>
			<th>Time</th>

    </tr>
</thead>
											<tbody>

												<?php
					 foreach($rows as $row):
					 $query = "
						SELECT
							*
							FROM ".$tblpre."users
						WHERE
							id = :id
						";
						$query_params = array(
							':id' => $row['sentto']
						);

						try
						{   $stmt = $db->prepare($query);
							$result = $stmt->execute($query_params);
						}
						catch(PDOException $ex)
						{
							die("Failed to run query: " . $ex->getMessage());
						}
						$row2 = $stmt->fetch();  ?>

													<tr>
														<td class="mailbox-star">
															<?php if($row['status'] == 0) { echo "Unread"; } elseif($row['status'] == 1) { echo "Read"; } ?>
														</td>
														<td class='mailbox-name'><a href="?page=profile&id=<?php echo $row2[ 'id'] ;?>"><?php echo $row2['username'] ;?> </a></td>
														<td class="mailbox-subject"><a href="?page=viewmessage&folder=sentid=<?php echo $row[ 'id'];?>"><?php echo $row['subject']; ?></a></td>
														<td class="mailbox-date">
															<?php echo $row['time']; ?>
														</td>
														</a>
														</tr>
													<?php endforeach; ?>

											</tbody>
										</table>
										<!-- /.table -->
									</div>
									<!-- /.mail-box-messages -->
								</div>
								<!-- /.box-body -->

							</div>
							<!-- /. box -->



				</div>
				<?php } }
	else {

    $query = "
        SELECT
			*
		FROM
			".$tblpre."private_messages
		WHERE
			sentto = :to AND status != 2
		ORDER BY time DESC
	";

	$query_params = array(
		':to' => $AccountID
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
	$rows = $stmt->fetchall();
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
			<script src="./library/datatables.net/js/jquery.dataTables.min.js"></script>
				<link rel="stylesheet" href="./library/datatables.net/css/dataTables.bootstrap.min.css">
				<script>
					$(document).ready(function() {
						$('#inbox').DataTable({
							'paging': true,
							'lengthChange': false,
							'searching': true,
							'ordering': false,
							'info': true,
							'autoWidth': true
						})
					})
				</script>
				<link rel="stylesheet" href="./library/admin-css/css/Admin.min.css">



						<div class="col-lg-3">
							<a href="?page=sendmessage" class="btn btn-primary btn-block margin-bottom">Compose</a>

							<div class="box box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Folders</h3>


								</div>
								<div class="box-body no-padding">
									<ul class="nav nav-pills nav-stacked">
									<li class="active"><a href="?page=inbox"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right"><?php echo $count;?></span></a></li>

									</ul>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /. box -->
						</div>
						<!-- /.col -->
						<div class="col-lg-9">
							<div class="box box-primary">
								<div class="box-header with-border">
									<h3 class="box-title">Inbox</h3>


								</div>
								<!-- /.box-header -->
								<div class="box-body no-padding">
									<div class="table-responsive mailbox-messages">
										<table id="inbox" class="table">
											<thead>
    <tr>
        <th>Status</th>
        <th>From</th>
        <th>Subject</th>
			<th>Time</th>
			<th>Actions</th>
    </tr>
</thead>
											<tbody>

												<?php
					 foreach($rows as $row):
					 $query = "
						SELECT
							*
							FROM ".$tblpre."users
						WHERE
							id = :id
						";
						$query_params = array(
							':id' => $row['sentby']
						);

						try
						{   $stmt = $db->prepare($query);
							$result = $stmt->execute($query_params);
						}
						catch(PDOException $ex)
						{
							die("Failed to run query: " . $ex->getMessage());
						}
						$row2 = $stmt->fetch();  ?>

													<tr>
														<td class="mailbox-star">
															<?php if($row['status'] == 0) { echo "Unread"; } elseif($row['status'] == 1) { echo "Read"; } ?>
														</td>
														<td class='mailbox-name'><a href="?page=profile&id=<?php echo $row2[ 'id'] ;?>"><?php echo $row2['username'] ;?> </a></td>
														<td class="mailbox-subject"><a href="?page=viewmessage&id=<?php echo $row[ 'id'];?>"><?php echo $row['subject']; ?></a></td>
														<td class="mailbox-date">
															<?php echo $row['time']; ?>
														</td>
														</a>
														<td> <a href="?page=sendmessage&id=<?php echo $row['sentby']; ?>" class="button2">Reply</a> - <a href="?page=deletemessage&id=<?php echo $row['id']; ?>" class="button2">Delete</a> </td>
													</tr>
													<?php endforeach; ?>

											</tbody>
										</table>
										<!-- /.table -->
									</div>
									<!-- /.mail-box-messages -->
								</div>
								<!-- /.box-body -->

							</div>
							<!-- /. box -->



				</div>
				<?php }?>
		</div>
	</div>