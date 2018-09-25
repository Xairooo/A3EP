<?php require( 'header.php'); ?>
<div class="content-wrapper">
	<?php if(!$permClass->checkUserPerms("support", $AccountID)){
	echo '<div class="container">
		<h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1>
		<div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div>
	</div>
</div>';
die();
} else {
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
      	<?php echo  $langs->word($dlang,'support') ;?>


      </h1>
	<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo  $langs->word($dlang,'home') ;?></a>
		</li>
		<li>
			<?php echo $langs->word($dlang,'support') ;?></li>
		<li class="active">
			<?php echo $langs->word($dlang,'support') ;?></li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<?php if(isset($_POST['addticket'])) {
	if(!$permClass->checkUserPerms("submit_support", $AccountID)){
	echo '<div class="container">
		<h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1>
		<div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div>
	</div>
	</div>';

	}
	else {
	     $key = $settingClass->getSetting('lkey');
  $url = "https://a3exileportal.com/license/".$key;
 $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    $data = curl_exec($curl);
 $datasearch = json_decode($data, true);
$owner = $datasearch['account'];
$message = $_POST['content'];
$req = 'https://a3exileportal.com/api/nexus/supportrequests';
$req .= "?key=482a838c87ff443d4ea8df38a56e201e";
$req .= "&department=2";
$req .= '&account='.$owner;
$req .= '&message='.urlencode($message);
$req .= '&lkey='.$key;
$req .= '&title='.$_POST['subject'].'';

 $curl1 = curl_init($req);
	     curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER,false);
           curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);

        $ticket = curl_exec( $curl1 );

	}

	}
	?>

	<!-- Main row -->
	<div class="row">
		<!-- Left col -->
		<div class="col-md-8">
		<div class="box box-warning">
            <div class="box-header with-border">
            	<h3 class="box-title">Create Ticket</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="support.php" method="POST" role="form">
                <!-- text input -->
                <div class="form-group">
                  <label>Subject</label>
                  <input type="text" class="form-control" name="subject">
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Content</label>
                  <textarea class="form-control" rows="10" placeholder="Enter issue here" name="content"></textarea>
                </div>
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="addticket">
				<?php echo $langs->word($dlang,'submit');?></button>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
		</div>
		<div class="col-md-4">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $langs->word($dlang,'sys_info');?></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				<dl class="dl-horizontal">
                <dt style="width:100px">PHP Version</dt>
                <dd style="margin-left:130px"><?php echo phpversion(); ?></dd>
                <br>
                <dt style="width:115px">MYSQL Version</dt>
                <dd style="margin-left:130px"><?php $version = $db->query('select version()')->fetchColumn(); echo $version;?></dd>
               <br>
                <dt style="width:95px">Server Path</dt>
                <dd style="margin-left:130px"><?php echo realpath(dirname(__FILE__,2));?></dd>
                <br>
                <dt style="width:80px">Server IP</dt>
                <dd style="margin-left:130px"><?php $host= gethostname(); $ip = gethostbyname($host); echo $_SERVER['SERVER_ADDR'];?>
                </dd>
              </dl>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
<?php }
require( 'footer.php'); ?>
