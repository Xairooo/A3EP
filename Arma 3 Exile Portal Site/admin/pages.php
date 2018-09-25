<?php
include("header.php");
?>
	<?php
		$query = "SELECT `status` FROM ".$tblpre."settings WHERE `name` = 'cpagename' ";
		$query_params = array();
    try
    {
						$stmt = $db->prepare($query);
						$result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
    $hconf = $stmt->fetch();
	$CHNAME = $hconf["status"];
	?>



	<script src='../library/tinymce/tinymce.min.js'></script>
  <script>
  tinymce.init({
    selector: '#cpedit',
		plugins : 'advlist autolink link image lists charmap code preview spellchecker hr importcss textcolor',
		toolbar: 'undo redo | styleselect | bold italic | forecolor | alignleft aligncenter alignright alignjustify | code | link image | hr | html',
		height : 500,
		content_css : "../css/bootstrapcondensed.css",
		  protect: [
    /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
    /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
    /<\?php.*?\?>/g  // Protect php code
  ],
importcss_append: true

  });
    tinymce.init({
    selector: '#cpedittwo',
		plugins : 'advlist autolink link image lists charmap code preview spellchecker hr importcss textcolor',
		toolbar: 'undo redo | styleselect | bold italic | forecolor | alignleft aligncenter alignright alignjustify | code | link image | hr | html',
		height : 500,
		content_css : "../css/bootstrapcondensed.css",
		  protect: [
    /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
    /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
    /<\?php.*?\?>/g  // Protect php code
  ],
importcss_append: true

  });
  </script>
<?php
				if(isset($_POST['pname']))
		{

			$query = "
				UPDATE ".$tblpre."settings
					SET status =
					:name WHERE name = 'cpagename'

			";
			$query_params = array(
				':name' => $_POST['name']
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

			header("Location: pages.php");
        exit;


	}
				if(isset($_POST['addpage']))
		{

			$query = "
				INSERT INTO ".$tblpre."custom_pages (
					name,
					content
 				) VALUES (
					:name,
					:content
				)
			";
			$query_params = array(
				':name' => $_POST['name'],
				':content' => $_POST['contents']
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

			header("Location: pages.php");
        exit;


	}
					if(isset($_POST['addurl']))
		{

			$query = "
				INSERT INTO ".$tblpre."custom_pages (
					name
 				) VALUES (
					:name
				)
			";
			$query_params = array(
				':name' => "<a href='".$_POST['url']."'>".$_POST['name']."</a>"
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

			header("Location: pages.php");
        exit;


	}
		if(isset($_POST['deletepage'])){

		$id = $_POST['id'];
		$id = intval($id);

		if(!is_numeric($id))
		{
			header("Location: ?page=index");
			exit;
		}

		$query = "
            DELETE FROM ".$tblpre."custom_pages WHERE id = :id
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

        header("Location: pages.php");

        exit;
	}
		$query = "
            SELECT * FROM ".$tblpre."custom_pages
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
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $langs->word($dlang,'page_manager'); ?>
        <small></small>
      </h1>
      <div class="col-md-3">

      </div>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li><?php echo $langs->word($dlang,'customization'); ?></li>
        <li class="active"><?php echo $langs->word($dlang,'page_manager'); ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
             <h3 class="box-title"><?php echo $langs->word($dlang,'pages'); ?></h3>
             <div class="box-tools pull-right">
<button type="button" style="margin-left:25px;" class="btn btn-primary" data-toggle="modal" data-target="#addpage"><?php echo $langs->word($dlang,'add_page'); ?></button>
<button type="button" style="margin-left:15px;" class="btn btn-primary" data-toggle="modal" data-target="#editsettings"><?php echo $langs->word($dlang,'page_manager_settings'); ?></button>
<button type="button" style="margin-left:15px;" class="btn btn-primary" data-toggle="modal" data-target="#addurl">Add URL</button>



             </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="blogposts" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>
                      <?php echo $langs->word($dlang,'name'); ?> </th>
                    <th>
                     <?php echo $langs->word($dlang,'content'); ?> </th>
                </thead>
                <tbody>
                  <?php foreach($results as $res) { ?>
                  <tr>
                    <td>
                      <?php echo $res['name'] ;?>
                    </td>
                    <td>
                      <?php if(strip_tags ( substr($res['content'],0,90)) == '') { echo "URL"; } else { echo substr($res['content'],0,90) ."...";} ?>
                    </td>
                    <td>
                      <form action="pages.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $res['id'];?>">
                        <input type="submit" style="color:black"   class="btn btn-primary" value="Delete" name="deletepage">
                        <?php if(strip_tags ( substr($res['content'],0,90)) == ''){
                                                    ?>
                                        <button type="button" style="color:black" class="btn btn-primary" data-toggle="modal" data-target="#editurl">Edit</button>
                          <?php
                        }
                        else{
                          ?>
                          <button type="button" style="color:black" class="btn btn-primary" data-toggle="modal" data-target="#editpage">Edit</button>
                          <?php
                        }
                        ?>

                      </form>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="modal fade in" id="editsettings">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="color:white"><?php echo $langs->word($dlang,'page_manager_settings'); ?></h4>
        </div>
        <form class="form-horizontal" method="POST" action="pages.php">
				<div class="modal-body">
						<div class="box-body">
							<div class="form-group">
								<label class="col-sm-2 control-label" style="color:white"><?php echo $langs->word($dlang,'tab_name'); ?></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo $CHNAME; ?>" name="name">
									<p class="small" style="color:white">
									<?php echo $langs->word($dlang,'tab_name_desc'); ?>
								</p>
								</div>
							</div>
								</div>
				<!-- /.box-body -->
				</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" onclick="document.getElementById('editsettings').style.display='none'" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
          <button type="submit" class="btn btn-primary" name="pname"><?php echo $langs->word($dlang,'submit'); ?></button>
        </div>
        </form>
      </div>
    </div>
  </div>
    <div class="modal fade in" id="addurl">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-label="Close" onclick="document.getElementById('addpage').style.display='none'">
                  <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add URL</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="POST" action="pages.php">
								<label class="control-label" style="color:white"><?php echo $langs->word($dlang,'name'); ?></label>
									<input class="form-control" name="name" style="width:200px"type="text"></input>
									<label class="control-label" style="color:white">URL </label>
									<input class="form-control" name="url" style="width:200px"type="text" value="http://"></input>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" onclick="document.getElementById('addpage').style.display='none'" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
          <button type="submit" class="btn btn-primary" name="addurl"><?php echo $langs->word($dlang,'submit'); ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade in" id="addpage">
    <div class="modal-dialog" style="width:95%; height:80%">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-label="Close" onclick="document.getElementById('addpage').style.display='none'">
                  <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?php echo $langs->word($dlang,'add_page'); ?></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="POST" action="pages.php">
								<label class="control-label"><?php echo $langs->word($dlang,'name'); ?></label>

									<input class="form-control" name="name" style="width:200px"type="text"></input>
								<label class="control-label"><?php echo $langs->word($dlang,'content'); ?></label>
            <textarea name="contents" id="cpedit" ></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" onclick="document.getElementById('addpage').style.display='none'" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
          <button type="submit" class="btn btn-primary" name="addpage"><?php echo $langs->word($dlang,'submit'); ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>


    <div class="modal fade in" id="editurl">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-label="Close" onclick="document.getElementById('addpage').style.display='none'">
                  <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit URL</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="POST" action="pages.php">
								<label class="control-label" style="color:white"><?php echo $langs->word($dlang,'name'); ?></label>
									<input class="form-control" name="name" style="width:200px" id="editurl-name" type="text"></input>
									<label class="control-label" style="color:white">URL </label>
									<input class="form-control" name="url" style="width:200px"type="text" id="editurl-url" value="http://"></input>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" onclick="document.getElementById('addpage').style.display='none'" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
          <button type="submit" class="btn btn-primary" name="addurl"><?php echo $langs->word($dlang,'submit'); ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade in" id="editpage">
    <div class="modal-dialog" style="width:95%; height:80%">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-label="Close" onclick="document.getElementById('addpage').style.display='none'">
                  <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Page</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="POST" action="pages.php">
								<label class="control-label"><?php echo $langs->word($dlang,'name'); ?></label>
									<input class="form-control" name="name" style="width:200px" id="editpage-name"  type="text"></input>
								<label class="control-label"><?php echo $langs->word($dlang,'content'); ?></label>
            <textarea name="contents" id="cpedittwo" id="editpage-content" ></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" onclick="document.getElementById('addpage').style.display='none'" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
          <button type="submit" class="btn btn-primary" name="addpage"><?php echo $langs->word($dlang,'submit'); ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php require('footer.php');?>