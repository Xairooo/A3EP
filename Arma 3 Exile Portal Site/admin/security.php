<?php
require('header.php');
if(isset($_POST['commonperm']))
		{
if (!@chmod('../extra/common.php', 0444 ) )
		{
		echo "Common no Altered";
		}
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
	<?php
	if(!$permClass->checkUserPerms("view_security_center", $AccountID)){
		echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {?>
  <section class="content-header">
    <h1>
     <?php echo $langs->word($dlang,'security_center'); ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
      <li><?php echo $langs->word($dlang,'overview'); ?></li>
      <li class="active"><?php echo $langs->word($dlang,'security_center'); ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
<h1>
  <?php echo $langs->word($dlang,'recommendations'); ?>
    </h1>
<?php echo $langs->word($dlang,'recommendations_desc'); ?>
    <br></br>
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->

      <?php
      if ( is_writable('../extra/common.php' ) )
		{
	?>
      <div class="col-md-3">
        <div class="box box-danger box-solid" style="height: 283px;">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $langs->word($dlang,'config_read_only'); ?> </h3> <h3 class="box-title pull-right"><?php echo $langs->word($dlang,'high'); ?></h3>
          </div>
          <div class="box-body">
            <p>
             <?php echo $langs->word($dlang,'config_read_only_desc'); ?></p>

          </div>
          <div class="box-footer">
            <form action="security.php" method="post">
               <button type="submit" name="commonperm" class="btn btn-block btn-default">
                <?php echo $langs->word($dlang,'enable'); ?>
              </button>
            </form>

          </div>

        </div>
        <!-- /.box -->
      </div><?php
      }

      $functionsToDisable = array( 'exec', 'system', 'passhtru', 'pcntl_exec', 'popen', 'proc_open', 'shell_exec' );
		$showingFunctionWarning = FALSE;

		foreach ( $functionsToDisable as $k => $function )
		{
			if ( function_exists( $function ) )
			{
				$showingFunctionWarning = TRUE;
			}
			else
			{
				unset( $functionsToDisable[ $k ] );
			}
		}

		if ( $showingFunctionWarning )
		{
		?>
        <div class="col-md-3">
     <div class="box box-danger box-solid" style="height: 283px;">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $langs->word($dlang,'danger_php_func'); ?> </h3> <h3 class="box-title pull-right"><?php echo $langs->word($dlang,'high'); ?></h3>
          </div>
          <div class="box-body">
            <p>
              <?php echo $langs->word($dlang,'high'); ?>
          <br><br> <?php echo implode( ', ', $functionsToDisable );?>
            </p>
       </div>

        </div>
        <!-- /.box -->
        </div><?php
       	}
      /* Display Errors */
		if ( ini_get( 'display_errors' ) )
		{
	?>
          <div class="col-md-3">
             <div class="box box-warning box-solid" style="height: 283px;">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $langs->word($dlang,'display_php_errors'); ?></h3> <h3 class="box-title pull-right"><?php echo $langs->word($dlang,'medium'); ?></h3>
          </div>
          <div class="box-body">
            <p>
              <?php echo $langs->word($dlang,'display_php_errors_desc'); ?>
            </p>
          </div>

        </div>
        <!-- /.box -->
          </div><?php } ?>

    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
	}
require('footer.php');
?>