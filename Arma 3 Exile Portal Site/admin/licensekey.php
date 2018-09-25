<?php
require('header.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
					<?php
	if(!$permClass->checkUserPerms("view_lkey", $AccountID)){
		echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else { ?>
		<?php

function curPageURL() {
            $pageURL = "http://".$_SERVER["SERVER_NAME"];
            return $pageURL;
        }
   $u = curPageURL();

	if(isset($_POST['generalform']))
		{
			$lkeynew = $_POST['key'];

			$settingClass->updateServersetting("lkey", $lkeynew);

  $urln = "https://a3exileportal.com/license/".$lkeynew."&reset=".$u;
 $curln = curl_init($urln);
    curl_setopt($curln, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curln, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curln, CURLOPT_SSL_VERIFYPEER,false);
    $datan = curl_exec($curln);
    $datasearchn = json_decode($datan, true);

		}

   if(isset($_POST['refresh_data']))
{

  $keyr = $settingClass->getSetting('lkey');
  $urlr = "https://a3exileportal.com/license/".$keyr."&log";
 $curlr = curl_init($urlr);
    curl_setopt($curlr, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curlr, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    $datar = curl_exec($curlr);
    $datasearchr = json_decode($datar, true);


}


?>


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>  <?php echo $langs->word($dlang,'lkey'); ?> </h1> <form action="" method="POST">
        <button type="submit" name="refresh_data" class="btn btn-default btn-lg"><i class="fa fa-refresh"></i> <?php echo $langs->word($dlang,'refresh_l_data'); ?></button>
      <button type="button" data-toggle="modal" data-target="#changelkey" class="btn btn-default btn-lg"><i class="fa fa-pencil"></i> <?php echo $langs->word($dlang,'change_l_data'); ?></button></form>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li><?php echo $langs->word($dlang,'settings'); ?></li>
        <li class="active"><?php echo $langs->word($dlang,'lkey'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<!-- Modal -->
<div class="modal fade" id="changelkey" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="a3lkey"><?php echo $langs->word($dlang,'lkey'); ?></h4>
      </div>
      <div class="modal-body">
    <div class="form-group">

            <label class="form-label col-sm-4"><?php echo $langs->word($dlang,'lkey'); ?></label>
        <div class="col-sm-5">

									<form action="" method="POST">
										<input id="key" size="24" type="text" name="key">
 </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
        <button type="submit" name="generalform" class="btn btn-primary"><?php echo $langs->word($dlang,'save'); ?></button>
      </div>
									</form>
        </div>



    </div>
  </div>
</div>
      <!-- Default box -->
      <div class="box">
        <div class="box-body">
        <h3> A3 Exile Portal
        <?php

  $key = $settingClass->getSetting('lkey');
  $url = "https://a3exileportal.com/license/".$key;
 $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    $data = curl_exec($curl);
 $datasearch = json_decode($data, true);

        if ( $datasearch['active'] =='True') {
        $status = 'active';
        ?>

  <span class="label label-success pull-right"><?php echo $langs->word($dlang,'renews');?> <?php echo $datasearch['expires'];?></span><?php
} else {
  $status = 'expired';
  ?>
  <span class="label label-danger pull-right"><?php echo $langs->word($dlang,'renews');?> <?php echo $datasearch['expires'];?></span><?php }
    ?>
           <br>
          <?php echo substr_replace( $settingClass->getSetting('lkey'), '*******', -9 );?></h3>
  <?php echo $langs->word($dlang,'url');?> <?php echo $datasearch['url'];?><br>

        <?php echo $langs->words($dlang,'used_connections',0);?> <?php echo $datasearch['usedconnections'];?> <?php echo $langs->words($dlang,'used_connections',1);?><br>
  </div>

      </div>
      <!-- /.box -->

   <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $langs->word($dlang,'lbenifits');?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <tbody>

                <tr><td><i class="fa fa-check"></i>
                  <?php if (isset($datasearch['maxconnections']))
                  { ?>
                  <?php echo $datasearch['maxconnections'];
             }
                  ?></td>
                </tr>
                 <tr><td><?php if ($status =='active')
                 { ?>
                 <i class="fa fa-check"></i> <?php }
                 else
                 { ?>
                 <i class="fa fa-warning"></i> <?php } ?>
                 <?php if (isset($datasearch['support']))
                 { ?>
                  <?php echo $datasearch['support'];?> Support
                  <?php }
                  ?></td>
                </tr>

              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  </div>
   </section>
<?php
	}
require('footer.php');
?>
