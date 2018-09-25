<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php


    if(empty($AccountID) || !isset($AccountID))
    {
        header("Location: ?page=login");
        exit;
    }

    if(empty($_GET['id']))
    {
        header("Location: ?page=index");
        exit;
    }
    $id = $_GET['id'];
    $id = intval($id);

    if(!is_numeric($id))
    {
        header("Location: ?page=index");
        exit;
    }

    $query = "
        SELECT
			*
		FROM
			".$tblpre."private_messages
		WHERE
			id = :to AND
			status != 2
	";

	$query_params = array(
		':to' => $id
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
		 foreach($rows as $row):
	if($AccountID != $row['sentto'])
	{
	die("not your message");
	} 	 endforeach;

	if($rows)
	{
		$query = "
            UPDATE ".$tblpre."private_messages
			SET
				status = 1
        ";
		$query_params = array(
            ':id' => $_GET['id']
        );
        $query .= "
            WHERE
                id = :id
        ";

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
?>
	<script src="./library/jquery/dist/jquery.min.js"></script>
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

	<div class="container">
		<div class="row new">

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
			$row2 = $stmt->fetch();
			$db2 = $row['time'];
			$timestamp = strtotime($db2);
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

									<div class="box-tools">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
									</div>
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
          	<?php
				$message = $row['message'];
				$message = stripslashes($message);
				$message = nl2br($message);
			?>
            <div class="box-header with-border">
              <h3 class="box-title">Read Mail</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?php echo stripslashes($row['subject']); ?></h3>
                <h5>From: <?php echo "<a href=\"?page=profile&id=" . $row2['id'] ."\">". $row2['username'] ."</a>";?>
                  <span class="mailbox-read-time pull-right"><?php echo date("m-d-Y @ G:i", $timestamp); ?></span></h5>
              </div>
              <!-- /.mailbox-read-info -->

              <div class="mailbox-read-message">
             	<?php echo htmlspecialchars_decode(stripslashes($message)); ?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
      <a href="?page=sendmessage&id=<?php echo $row2['id'];?>" class="btn btn-default"><i class="fa fa-reply"></i> Reply</a>
                      <a href="?page=deletemessage&id=<?php echo $row['id'];?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
              <a onclick="window.print();return true;" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>

		<?php endforeach; ?>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>

	<?php }
		else
		{
			echo "<div class= \"container\">";
				echo "<h2>". $lang['messages_error_title'] ."</h2>";
				echo "<h4>". $lang['messages_error_notexist'] ."</h4><br />";
				echo "<p>". $lang['messages_error_notexist_desc'] ."</p>";
			echo "</div>";
		}
	?>
	</div>
	</div>

