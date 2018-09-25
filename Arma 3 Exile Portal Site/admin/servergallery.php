<?php
include("header.php");
		if(isset($_POST['addimages']))
		{
			$ur = "";
$target_dir = "../images/custom/";
$target_file = $target_dir . basename($_FILES["customimage"]["name"]);
			$fil = "images/custom/" . basename($_FILES["customimage"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["customimage"]["tmp_name"], $target_file)) {

       $pic = $target_file;
$ur = $pic;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


			$query = "
				INSERT INTO ".$tblpre."site_images (
					name,
					location,
					`desc`,
					func
 				) VALUES (
					:name,
					:location,
					:desc,
					:func
				)
			";
			$query_params = array(
				':name' => $_POST['name'],
				':location' => $fil,
				':desc' => $_POST['desc'],
				':func' => $_POST['func']
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

			header("Location: servergallery.php");
       exit;


	}
		if(isset($_POST['deleteimages'])){

		$id = $_POST['id'];
		$id = intval($id);

		if(!is_numeric($id))
		{
			header("Location: ?page=index");
			exit;
		}

		$query = "
            DELETE FROM ".$tblpre."site_images WHERE id = :id
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

        header("Location: servergallery.php");

        exit;
	}
				if(isset($_POST['updateimages'])){

		$id = $_POST['id'];
		$id = intval($id);

		if(!is_numeric($id))
		{
			header("Location: ?page=index");
			exit;
		}

		$query = "
            UPDATE ".$tblpre."site_images SET name = :name, `desc` = :desc , `func` = :func WHERE id = :id
        ";
		$query_params = array(
            ':id' => $id,
			':name' =>  $_POST['name'],
			':desc' =>  $_POST['desc'],
			':func' =>  $_POST['func']
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

        header("Location: servergallery.php");

        exit;
				}
		$query = "
            SELECT * FROM ".$tblpre."site_images";
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

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
			<?php echo $langs->word($dlang,'manage_server_images') ;?>
				<small><?php echo $langs->word($dlang,'images_notice') ;?></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home') ;?></a></li>
				<li><?php echo $langs->word($dlang,'customization') ;?></li>
				<li class="active"><?php echo $langs->word($dlang,'manage_server_images') ;?></li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<div class="col-md-8">
					<div class="box box-success">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $langs->word($dlang,'server_images') ;?></h3>

						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<table id="blogposts" class="table table-striped">
								<thead>
									<tr>
										<th><?php echo $langs->word($dlang,'title') ;?> </th>
										<th><?php echo $langs->word($dlang,'file') ;?> </th>
										<th><?php echo $langs->word($dlang,'content') ;?> </th>
										<th><?php echo $langs->word($dlang,'location') ;?> </th>
										<th></th>
										<th><?php echo $langs->word($dlang,'action') ;?> </th>
										<th></th>
										</tr>
								</thead>
								<tbody>
									<?php

        foreach($results as $res){

			?>
										<tr>
											<td>
												<?php echo $res['name'] ;?>
											</td>
											<td>

												<?php echo $res['location']; ?>
											</td>
											<td>
												<?php echo $res['desc'];?>
											</td>
											<td>
												<?php echo $res['func'];?>
											</td>

											<td>
												<form action="servergallery.php" method="post">
													<input type="hidden" name="id" value="<?php echo $res['id'];?>">
													<input type="submit" value="<?php echo $langs->word($dlang,'delete') ;?>" name="deleteimages">
												</form>
											</td>
											<td><a href="#" id="<?php echo $res['id']; ?>"><?php echo $langs->word($dlang,'modify') ;?></a></td>
											<td><a href="#" id="<?php echo $res['location']; ?>"><?php echo $langs->word($dlang,'view') ;?></a></td>
										</tr>


										<script>
											document.getElementById("<?php echo $res['id']; ?>").addEventListener("click", displayDate);
											document.getElementById("<?php echo $res['location']; ?>").addEventListener("click", displayimage);
											<?php
				$imgloc =	"../". $res['location'];
					?>

											function displayimage() {
												document.getElementById("102").src = "<?php echo $imgloc;?>";
												document.getElementById("3213").style.display = 'block';
											};

											function displayDate() {
												document.getElementById("203").setAttribute("value", "<?php echo $res['name'];?>");
												document.getElementById("202").setAttribute("value", "<?php echo $res['desc'];?>");
												document.getElementById("201").setAttribute("value", "<?php echo $res['id'];?>");
													document.getElementById("299").setAttribute("value", "<?php echo $res['func'];?>");
												document.getElementById("gallery").style.display = 'block';
											};
										</script>

										<?php
		}
		?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $langs->word($dlang,'add_image') ;?></h3>

							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<form action="servergallery.php" method="POST" enctype="multipart/form-data">
								<div class="form-group" style="padding-top:10px;">
									<label for="content"><?php echo $langs->word($dlang,'name') ;?></label>
									<input type="text" class="form-control" name="name">
								</div>
								<div class="form-group" style="padding-top:10px;">
									<label for="content"><?php echo $langs->word($dlang,'desc') ;?></label>
									<input class="form-control" name="desc" type="text"></input>
								</div>
								<div class="form-group" style="padding-top:10px;">
									<label for="content"><?php echo $langs->word($dlang,'upload') ;?></label>
									<input type="file" name="customimage" id="customimage">
								</div>
								<div class="form-group" style="padding-top:10px;">
									<label><?php echo $langs->word($dlang,'function') ;?></label>
									<select class="form-control" name="func">
  <option value="front_carousel"><?php echo $langs->word($dlang,'f_slider') ;?></option>
  <option value="header_logo"><?php echo $langs->word($dlang,'header_image') ;?></option>
  <option value="background"><?php echo $langs->word($dlang,'background') ;?></option>
</select>
								</div>
								<button class="btn btn-lg btn-primary btn-block" type="submit" name="addimages">Submit</button>
							</form>
						</div>
						<!-- /.box-body -->

					</div>
				</div>
			</div>
		</section>
	</div>

	<div class="modal fade in" id="gallery">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Image</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="POST" action="servergallery.php">
						<div class="box-body">
							<div class="form-group">
								<label class="col-sm-4 control-label">Name</label>

								<div class="col-sm-6">
									<input type="text" class="form-control" id="203" name="name">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Description</label>

								<div class="col-sm-6">
									<input class="form-control" name="desc" id="202" type="text"></input>
								</div>
								<input type="hidden" name="id" id="201">
							</div>
						<div class="form-group">
								<label class="col-sm-4 control-label">Function</label>

								<div class="col-sm-6">
																<select class="form-control" name="func" id="299">
  <option value="front_carousel">Front Slider</option>
  <option value="header_logo">Header Image</option>
  <option value="background">Site Background</option>
</select>
								</div>

							</div>
								</div>
				<!-- /.box-body -->

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" onclick="document.getElementById('gallery').style.display='none'" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" name="updateimages">Save</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade in" id="3213">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" aria-label="Close" onclick="document.getElementById('3213').style.display='none'">
                  <span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">View Image</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
						<div class="box-body">
							<img id="102" height="auto" width="550">
						</div>
						<!-- /.box-body -->

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" onclick="document.getElementById('3213').style.display='none'" data-dismiss="modal">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>


	<?php require('footer.php');?>