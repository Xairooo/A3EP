<?php
require('header.php'); ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
			<?php
	if(!$permClass->checkUserPerms("view_enhancements", $AccountID)){
			echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {?>
		<?php
				if(isset($_POST['generalform']))
		{
			$incoming = $_POST['incomingemail'];
		$outgoing = $_POST['outgoingemail'];
	$smtp_host = $_POST['smtp_host'];
		$smtp_protocol = $_POST['smtp_protocol'];
			$smtp_port = $_POST['smtp_port'];
				$smtp_username = $_POST['smtp_username'];
					$smtp_password = $_POST['smtp_password'];
	$mail_delivery_method = $_POST['mail_delivery_method'];

		if($settingClass->getSetting("outgoing_email") != $outgoing){
			$settingClass->updateServersetting("outgoing_email", $outgoing);
		}
		if($settingClass->getSetting("incoming_email") != $incoming){
			$settingClass->updateServersetting("incoming_email", $incoming);
		}
if($settingClass->getSetting("smtp_host") != $smtp_host){
			$settingClass->updateServersetting("smtp_host", $smtp_host);
		}
	if($settingClass->getSetting("smtp_protocol") != $smtp_protocol){
			$settingClass->updateServersetting("smtp_protocol", $smtp_protocol);
		}
		if($settingClass->getSetting("smtp_port") != $smtp_port){
			$settingClass->updateServersetting("smtp_port", $smtp_port);
		}
		if($settingClass->getSetting("smtp_username") != $smtp_username){
			$settingClass->updateServersetting("smtp_username", $smtp_username);
		}
if($settingClass->getSetting("smtp_password") != $smtp_password){
			$settingClass->updateServersetting("smtp_password", $smtp_password);
		}
		if($settingClass->getSetting("mail_delivery_method") != $mail_delivery_method){
			$settingClass->updateServersetting("mail_delivery_method", $mail_delivery_method);
		}
	 header("Location: emailsettings.php");
        exit;
	}

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <?php echo $langs->word($dlang,'email_settings'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li><?php echo $langs->word($dlang,'settings'); ?></li>
        <li class="active"><?php echo $langs->word($dlang,'email_settings'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">

         <!-- form start -->
            <form class="form-horizontal" method="POST" action="emailsettings.php">
 <div class="box-header with-border">

								<?php echo $langs->word($dlang,'basic_settings'); ?>

<div class="box-tools pull-right">
<!--<button type="button" data-toggle="modal" data-target="#testsettings" class="btn btn-success"><i class="fa fa-cog"></i> <?php // echo $langs->word($dlang,'test_settings'); ?></button> -->
</div>
</div>

							 <div class="box-body">

                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'in_email'); ?></label>

                  <div class="col-sm-5">
                   <input name="incomingemail" class="form-control" value="<?php echo $settingClass->getSetting('incoming_email'); ?>">
										<p class="small">
										<?php echo $langs->word($dlang,'in_email_desc'); ?>
										</p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'out_email'); ?></label>
                  <div class="col-sm-5">
                 <input name="outgoingemail" class="form-control" value="<?php echo $settingClass->getSetting('outgoing_email'); ?>">
										<p class="small">
									<?php echo $langs->word($dlang,'out_email_desc'); ?></p>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->


               <div class="box-header with-border">

								<?php echo $langs->word($dlang,'advanced_settings'); ?>
 </div>

							 <div class="box-body">
<script>
    $(document).ready(function() {
    $("input[name$='mail_delivery_method']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
        $("#mail_delivery_method_" + test).show();
    });
});

</script>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'mail_delivery_method'); ?></label>

                  <div class="col-sm-7">

                  <div class="radio">
                    <label>
                      <input type="radio" name="mail_delivery_method" value="php" <?php if ($settingClass->getSetting('mail_delivery_method') =='php'){ echo 'checked'; } else {} ?>>
                    PHP
                    <span class="help-block">Uses your local server to send emails. Sufficient for most sites, but reliability may vary depending on your hosting provider.</span>
                    </label>


                    <label>
                      <input type="radio" name="mail_delivery_method" value="smtp"<?php if ($settingClass->getSetting('mail_delivery_method') =='smtp'){ echo 'checked'; } else {} ?>>
                    SMTP
                    <span class="help-block">Allows you to specify custom SMTP details.</span>
                    </label>

                  </div>
                  </div>
                </div>
                <br>
                <br>
                 <div id="mail_delivery_method_smtp" class="desc" <?php if ($settingClass->getSetting('mail_delivery_method') =='smtp'){} else {echo 'style="display: none;"';} ?>>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'smtp_host'); ?></label>
                  <div class="col-sm-5">
                 <input name="smtp_host" class="form-control" value="<?php echo $settingClass->getSetting('smtp_host'); ?>">

                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'smtp_protocol'); ?></label>
                  <div class="col-sm-5">
                 <select name="smtp_protocol" class="form-control" id="smtp_protocol">


			<option value="plain" selected="">Standard / Plaintext</option>



			<option value="ssl">SSL</option>



			<option value="tls">TLS</option>


</select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'smtp_port'); ?></label>
                  <div class="col-sm-5">
                 <input name="smtp_port" class="form-control" value="<?php echo $settingClass->getSetting('smtp_port'); ?>">

                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'smtp_username'); ?></label>
                  <div class="col-sm-5">
                 <input name="smtp_username" class="form-control" value="<?php echo $settingClass->getSetting('smtp_username'); ?>">

                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'smtp_password'); ?></label>
                  <div class="col-sm-5">
                 <input type="password" name="smtp_password" class="form-control" value="<?php echo $settingClass->getSetting('smtp_password'); ?>">

                  </div>
                </div>
                </div>
              </div>
              <div align="center" class="box-footer">
                <button type="submit" name="generalform" class="btn btn-info "><?php echo $langs->word($dlang,'save'); ?></button>
              </div>
              <!-- /.box-footer -->
            </form>


      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
			 }
require('footer.php');?>