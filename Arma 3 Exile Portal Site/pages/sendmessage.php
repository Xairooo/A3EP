<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
    if(empty($AccountID) || !isset($AccountID))
    {
        header("Location: ?page=login");
        exit;
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
		#compose-textarea
		{
    display: block;
    background-color: rgb(255, 255, 255);
    border-collapse: separate;
    border-color: rgb(210, 214, 222);
    border-style: solid;
    border-width: 1px;
    clear: none;
    float: none;
    margin: 0px;
    outline: rgb(85, 85, 85) none 0px;
    outline-offset: 0px;
    padding: 6px 12px;
    position: static;
    top: auto;
    left: auto;
    right: auto;
    bottom: auto;
    z-index: auto;
    vertical-align: baseline;
    text-align: start;
    box-sizing: border-box;
    box-shadow: none;
    border-radius: 0px;
    width: 100%;
    height: 300px;
}
	</style>

	<div class="container">
		<div class="row new">

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
							<a href="?page=inbox" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>

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
										<li class="active"><a href="#"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right"><?php echo $count;?></span></a></li>

									</ul>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /. box -->
						</div>
    <?php
	if(!empty($_GET['id']))
	{
		$sendto = $_GET['id'];
		$sendto = intval($sendto);

		if(!is_numeric($sendto))
		{
			header("Location: ?page=index");
			exit;
		}
		$query = "
			SELECT
				username
				FROM ".$tblpre."users
			WHERE
				id = :id
		";
		$query_params = array(
			':id' => $sendto
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
		$row7 = $stmt->fetch();
		$sendtoname = $row7['username'];

	}

	if(!empty($_POST))
    {
		$userid = $AccountID;

		$userid2 = $_POST['name'];
		$query2 = "
			SELECT
				id
				FROM ".$tblpre."users
			WHERE
				username = :id
		";
		$query_params2 = array(
			':id' => $userid2
		);
		try
		{
			$stmt = $db->prepare($query2);
			$result = $stmt->execute($query_params2);
		}
		catch(PDOException $ex)
		{
			die("Failed to run query: " . $ex->getMessage());
		}
		$row3 = $stmt->fetch();

		if($row3)
		{

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

			$content = addslashes((filter_var($_POST['message'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
			$subject = addslashes((filter_var($_POST['subject'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
			$to = intval($row3['id']);
            $userid = intval($userid);
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

			header("Location: ?page=inbox");
			exit;
		}
		else
		{
			?>
<div class="col-lg-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Compose New Message</h3>
            </div>
          <div class="alert alert-danger"><?php echo $lang['sendMess_error']; ?></div>
								<!-- /.box-header -->

	<script src='./library/tinymce/tinymce.min.js'></script>
  <script>
  tinymce.init({
    selector: '#cpedit',
		plugins : 'advlist autolink link image lists charmap code preview spellchecker hr importcss textcolor',
		toolbar: 'undo redo | styleselect | bold italic | forecolor | alignleft aligncenter alignright alignjustify | code | link image | hr | html',
		height : 500,
		content_css : "./css/bootstrapcondensed.css",
		  protect: [
    /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
    /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
    /<\?php.*?\?>/g  // Protect php code
  ],
importcss_append: true

  });
  </script>
            <div class="box-body">
            	<form action="?page=sendmessage" method="post">
              <div class="form-group">
                <input type="text" id="name" name="name" placehodler="To:" class="form-control"></input>
              </div>
              <div class="form-group">
             	<input type="text" name="subject" class="form-control" placeholder="Subject:">
              </div>
         <div class="form-group">
         <textarea name="message" id="cpedit" ></textarea>
         </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="submit" value="Submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div></form>
              <a href="?page=inbox" class="btn btn-default"><i class="fa fa-times"></i> Discard</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
<?php
		}
    }
	else
	{ ?>


	<div class="col-lg-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Compose New Message</h3>
            </div>

								<!-- /.box-header -->


            <div class="box-body">
            	<form action="?page=sendmessage" method="post">
              <div class="form-group">
                <input type="text" id="name" name="name" value="<?php if(!empty($_GET['id'])){ echo $sendtoname; } ?>" placehodler="To:" class="form-control"></input>
              </div>
              <div class="form-group">
             	<input type="text" name="subject" class="form-control" placeholder="Subject:">
              </div>
              <div class="form-group">
         <textarea name="message" id="cpedit" ></textarea>
         </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="submit" value="Submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div></form>
              <a href="?page=inbox" class="btn btn-default"><i class="fa fa-times"></i> Discard</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <?php
	}

?>
</div></div>