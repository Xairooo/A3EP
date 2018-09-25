<?php
require('header.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
			<?php
	if(!$permClass->checkUserPerms("view_enhancements", $AccountID)){
		echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {?>
    <section class="content-header">
      <h1>
       <?php echo $langs->word($dlang,'enhancements'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li><?php echo $langs->word($dlang,'portal_features'); ?></li>
        <li class="active"><?php echo $langs->word($dlang,'enhancements'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

     <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-4">
           <div class="box box">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $langs->word($dlang,'steam_web_api'); ?></h3>
        </div>
        <div class="box-body">
        <?php echo $langs->word($dlang,'enhancement_steam_desc'); ?><br>
<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-steam">
                <?php echo $langs->word($dlang,'configure'); ?>
              </button>
        </div>

      </div>
      <!-- /.box -->
        </div>
        <?php
        if(isset($_POST['steamform']))
		{
				$SteamApi = $_POST['SteamApi'];

		if($settingClass->getSetting("steamapi") != $SteamApi){
			$settingClass->updateServersetting("steamapi", $SteamApi);
		}
	}?>
   <div class="modal fade" id="modal-steam">
          <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="POST" action="enhancements.php">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $langs->word($dlang,'steam_web_api'); ?></h4>
              </div>
              <div class="modal-body">
                  <div class="box-body">
               <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'steam_web_api'); ?></label>

                  <div class="col-sm-6">
              <input name="SteamApi" class="form-control" value="<?php echo $settingClass->getSetting('steamapi'); ?>"><br />
                  </div>
                </div>
              </div>

              <!-- /.box-body -->

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
                <button type="submit" name="steamform" class="btn btn-primary"><?php echo $langs->word($dlang,'save'); ?></button>

              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="col-md-4">
           <div class="box box">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $langs->words($dlang,'google_ana', 0); ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
      <?php echo $langs->word($dlang,'google_ana_desc'); ?>
					<a href="http://www.google.com/analytics/"><?php echo $langs->words($dlang,'google_ana', 0); ?></a> <?php echo $langs->words($dlang,'google_ana', 1); ?>
        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-google">
               <?php echo $langs->word($dlang,'configure'); ?>
              </button>
        </div>

      </div>
      <!-- /.box -->
        </div>
        <?php
        if(isset($_POST['googleform']))
		{
				$GoogleAna = $_POST['GoogleAna'];

		if($settingClass->getSetting("GoogleAna") != $GoogleAna){
			$settingClass->updateServersetting("GoogleAna", $GoogleAna);
		}
	}?>
   <div class="modal fade" id="modal-google">
          <div class="modal-dialog">
            <div class="modal-content">
               <form class="form-horizontal" method="POST" action="enhancements.php">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $langs->word($dlang,'google_ana'); ?></h4>
              </div>
              <div class="modal-body">

              <div class="box-body">
               <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'google_tracking'); ?></label>

                  <div class="col-sm-6">
              <input name="GoogleAna" class="form-control" value="<?php echo $settingClass->getSetting('GoogleAna'); ?>"><br />
                  </div>
                </div>
              </div>

              <!-- /.box-body -->

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
                <button type="submit" name="googleform" class="btn btn-primary"><?php echo $langs->word($dlang,'save'); ?></button>

              </div>
                   </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
                <div class="col-md-4">
           <div class="box box">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $langs->words($dlang,'disqus', 0); ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
					<a href="https://disqus.com/profile/signup/"><?php echo $langs->words($dlang,'disqus', 0); ?></a> <?php echo $langs->words($dlang,'disqus', 1); ?>
        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-disqus">
               <?php echo $langs->word($dlang,'configure'); ?>
              </button>
        </div>

      </div>
      <!-- /.box -->
        </div>
        <?php
        if(isset($_POST['disqusform']))
		{
				$disqus = $_POST['disqus'];

		if($settingClass->getSetting("disqus_shortcode") != $disqus){
			$settingClass->updateServersetting("disqus_shortcode", $disqus);
		}
	}?>
   <div class="modal fade" id="modal-disqus">
          <div class="modal-dialog">
            <div class="modal-content">
               <form class="form-horizontal" method="POST" action="enhancements.php">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $langs->word($dlang,'disqus'); ?></h4>
              </div>
              <div class="modal-body">

              <div class="box-body">
               <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'disqus_shortcode'); ?></label>

                  <div class="col-sm-6">
              <input name="disqus" class="form-control" value="<?php echo $settingClass->getSetting('disqus_shortcode'); ?>"><br />
                  </div>
                </div>
              </div>

              <!-- /.box-body -->

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
                <button type="submit" name="disqusform" class="btn btn-primary"><?php echo $langs->word($dlang,'save'); ?></button>

              </div>
               </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
	}
require('footer.php');
?>
