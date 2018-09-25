<?php require('header.php');
?>
<div class="content-wrapper">
	<?php
		if(!$permClass->checkUserPerms("manage_announcement", $AccountID)){
			echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
			die();
		} else {
	?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>
     		<?php echo $langs->word($dlang,'manage_announcements'); ?>
      	</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
			<li><?php echo $langs->word($dlang,'portal'); ?></li>
			<li class="active"><?php echo $langs->word($dlang,'announcements'); ?></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<?php
			if(isset($_POST['addannounce']))
			{
				if(!$permClass->checkUserPerms("add_announcement", $AccountID)){
					echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
				} else {
					$query = "
						INSERT INTO ".$tblpre."serverannouncements (
							title,
							content,
							username
		 				) VALUES (
							:title,
							:content,
							:username
						)
					";
					$query_params = array(
						':title' => addslashes($_POST['title']),
						':content' => addslashes($_POST['content']),
						':username' => $AccountID
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
					header("Location: manageannouncements.php");
		        	exit;
				}
			}
			if(isset($_POST['deletesannounce'])){

				$id = $_POST['id'];
				$id = intval($id);

				if(!is_numeric($id))
				{
					header("Location: manageannouncements.php");
					exit;
				}

				$query = "
		            DELETE FROM ".$tblpre."serverannouncements WHERE id = :id
		        ";
				$query_params = array(
		            ':id' => $id,
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

		        header("Location: ?page=admin/manageannouncements.php");

		        exit;
			}
			$query = "
		            SELECT * FROM ".$tblpre."serverannouncements
		        ";
	        try
	        {
	            $stmt = $db->prepare($query);
	            $result = $stmt->execute();
	        }
	        catch(PDOException $ex)
	        {
	            die("Failed to run query: " . $ex->getMessage());
	        }
	        $results = $stmt->fetchAll();
		?>
		<script>
		  $(function () {
		    $('#announcements').DataTable({
		      'paging'      : true,
		      'lengthChange': false,
		      'searching'   : true,
		      'ordering'    : true,
		      'info'        : true,
		      'autoWidth'   : false
		    })
		  })
		</script>
	<!-- Main row -->
	    <div class="row">
	        <!-- Left col -->
	        <div class="col-md-8">
	           	<div class="box box-success">
		            <div class="box-header with-border">
		              <h3 class="box-title"><?php echo $langs->word($dlang,'manage_announcements'); ?></h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
						<table id="announcements" class="table dataTable no-footer">
			                <thead>
								<tr>
									<th><?php echo $langs->word($dlang,'title'); ?></th>
									<th><?php echo $langs->word($dlang,'link'); ?></th>
									<th><?php echo $langs->word($dlang,'date_posted'); ?></th>
									<th><?php echo $langs->word($dlang,'action'); ?></th>
								</tr>
							</thead>
							<tbody>
				                <?php foreach($results as $res){ ?>
								<tr>
									<td><?php echo $res['title'] ;?></td>
									<td><?php echo $res['content'] ;?></td>
									<td><?php echo date('F j, Y g:i A',strtotime($res['date']));?></td>
									<td>
										<form action="manageannouncements.php" method="post">
											<input type="hidden" name="id" value="<?php echo $res['id'];?>">
											<input type="submit" value="<?php echo $langs->word($dlang,'delete'); ?>" name="deletesannounce">
										</form>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot>
				                <tr>
									<th><?php echo $langs->word($dlang,'title'); ?></th>
									<th><?php echo $langs->word($dlang,'link'); ?></th>
									<th><?php echo $langs->word($dlang,'date_posted'); ?></th>
									<th><?php echo $langs->word($dlang,'action'); ?></th>
				                </tr>
				            </tfoot>
		                </table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-primary">
	            	<div class="box-header with-border">
	              		<h3 class="box-title"><?php echo $langs->word($dlang,'add_announcement'); ?></h3>
	              		<div class="box-tools pull-right">
	                		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              		</div>
	            	</div>
	            	<!-- /.box-header -->
	            	<div class="box-body">
						<form action="manageannouncements.php" method="POST">
							<div class="form-group">
	    						<label for="content"><?php echo $langs->word($dlang,'title'); ?></label>
	    						<input type="text" class="form-control" name="title">
	  						</div>
							<div class="form-group">
							    <label for="content"><?php echo $langs->word($dlang,'link'); ?></label>
							    <input type="text" class="form-control" name="content">
	  						</div>
							<button class="btn btn-lg btn-primary btn-block" type="submit" name="addannounce"><?php echo $langs->word($dlang,'submit'); ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>



<?php
	}
		require('footer.php');
?>



