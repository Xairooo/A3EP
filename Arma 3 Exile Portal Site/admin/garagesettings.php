<?php
require("header.php");
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<?php
 $query = "
         SELECT * FROM ".$tblpre."modules
            WHERE
                module_key = :id
        ";

        $query_params = array(
            ':id' => 'mygarage'
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

        $row = $stmt->fetch();

if(isset($_POST['garagesettingsform']))
		{
			$garage_on = $_POST['module_e'];

				if($row['module_enabled'] != $garage_on){
			$settingClass->enableModule('mygarage', $garage_on);
		}
		 header("location: garagesettings.php");
		}
		?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $langs->word($dlang,'garage'); ?> <?php echo $langs->word($dlang,'settings'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li> <?php echo $langs->word($dlang,'portal'); ?></li>
        <li class="active"><?php echo $langs->word($dlang,'garage'); ?> <?php echo $langs->word($dlang,'settings'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    	<section class="content container-fluid">

          <div class="row">
            <div class="col-md-12">
              <!-- USERS LIST -->
              <div class="box box-danger">

                <div class="box-body padding">
                  <form class="form-horizontal" method="POST" action="">
                    <div class="form-group">
    									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'module_enabled');?></label>
    									<div class="col-sm-4">
    										<input type="hidden" name="module_e" value="0" />
                        <input type="checkbox" <?php if ($row[ 'module_enabled']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="module_e" name="module_e" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
    									</div>
    								</div>
                    <!-- /.box-footer -->
                  	<div align="center" class="box-footer">
  								    <button type="submit" name="garagesettingsform" class="btn btn-info "><?php echo $langs->word($dlang,'save');?></button>
                    </div>
							    </form>
                </div>
              <!--/.box -->
              </div>
            <!-- /.col -->
            </div>
          <!-- /.row -->
</div>
    </section>
    <!-- /.content --

<?php require('footer.php');?>