<?php require('header.php');
	if(isset($_POST['recaptchaform']))
		{
				$RecaptchaPublic = $_POST['RecaptchaPublic'];
		$RecaptchaPrivate = $_POST['RecaptchaPrivate'];

		if($settingClass->getSetting("recaptcha_key_public") != $RecaptchaPublic){
			$settingClass->updateServersetting("recaptcha_key_public", $RecaptchaPublic);
		}
		if($settingClass->getSetting("recaptcha_key_private") != $RecaptchaPrivate){
			$settingClass->updateServersetting("recaptcha_key_private", $RecaptchaPrivate);
		}
			}
?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $langs->word($dlang,'spam_prevention'); ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li><a href="#"><?php echo $langs->word($dlang,'members'); ?></a></li>
        <li class="active"><?php echo $langs->word($dlang,'spam_prevention'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#CAPTCHA" data-toggle="tab"><?php echo $langs->word($dlang,'captcha'); ?></a></li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="CAPTCHA">
                         <!-- form start -->
            <form class="form-horizontal" method="POST" action="spamprevention.php">
              <div class="box-body">

                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'cap_site_key'); ?></label>
                  <div class="col-sm-5">
                	<input name="RecaptchaPublic" class="form-control" value="<?php echo $settingClass->getSetting('recaptcha_key_public'); ?>">
                    <a href="https://www.google.com/recaptcha/admin" target="_blank"><?php echo $langs->words($dlang,'cap_desc',0); ?></a>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'cap_private_key'); ?></label>

                  <div class="col-sm-5">
                 <input name="RecaptchaPrivate" class="form-control" value="<?php echo $settingClass->getSetting('recaptcha_key_private'); ?>">
         <a href="https://www.google.com/recaptcha/admin" target="_blank"><?php echo $langs->words($dlang,'cap_desc',0); ?></a>

                  </div>
                </div>
                <div class=" col-sm-4">

                </div>
                  <div class="col-sm-5">
               <?php echo $langs->word($dlang,'what_is_captcha'); ?></div>
              </div>
              <!-- /.box-body -->
              <div align="center" class="box-footer">
                <button type="submit" name="recaptchaform" class="btn btn-info "><?php echo $langs->word($dlang,'save'); ?></button>
              </div>
              <!-- /.box-footer -->
            </form>
              </div>

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php require('footer.php');?>