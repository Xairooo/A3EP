<!DOCTYPE html>
<html>
  <head>
		<title><?php echo $settingClass->getServerName(); ?></title>
    <meta charset="UTF-8">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $settingClass->getServerName(); ?> A3EP Exile Portal Content Management System">
    <meta name="author" content="Taylor M">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
		<link href="./bootstrap/fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<?php include("bootstrap/css.php");
	$google = $settingClass->getSetting('GoogleAna');
		if($google == '')
{
}else{
	?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $google; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
gtag('config', '<?php echo $google; ?>');
</script><?php }
?>
<!-- FAVICON SECTION -->

<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
<link rel="manifest" href="images/favicon/manifest.json">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">
<!-- FAVICON SECTION END -->
<script type="text/javascript" src="./library/ticker.js"></script>
<script type="text/javascript" src="./library/letteravatar.js"></script>
<script src='./library/tinymce/tinymce.min.js'></script>
  <script>
  tinymce.init({
    selector: '#cpedit',
		plugins : 'advlist autolink link image lists charmap code preview spellchecker hr importcss textcolor',
		toolbar: 'undo redo | styleselect | bold italic | forecolor | alignleft aligncenter alignright alignjustify | code | link image | hr | html',
		height : 500,
		content_css : "./css/bootstrap.css",
		  protect: [
    /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
    /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
    /<\?php.*?\?>/g  // Protect php code
  ],
importcss_append: true

  });
  </script>

<style>
.notification-icon .badges {

  position: absolute;
  right: 7px;
  top: 5px;
  z-index: 3;

}
.NotificationCount {
    position: absolute;
    top: 6px;
    font-size: 11px;
    color: #fff;
    display: inline-block;
    text-indent: 0%;
    line-height: 18px;
    padding: 0 6px;
    border-radius: 8px;
    z-index: 2;
    background: #b63f3f;
}

.NotificationCount {
    right: 6px;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style><?php

$query = "SELECT location FROM ".$tblpre."site_images WHERE func = 'background' LIMIT 1";
try
{
$stmt = $db->prepare($query);
$result = $stmt->execute();
}
catch(PDOException $ex)
{
  die($ex->getMessage());
}
$backgroundimage = $stmt->fetch();
?>
		<link rel="icon" href="<?php echo $dirUp ?>favicon.ico">
</head>
<body style="background: rgb(81, 92, 94) url('<?php echo $backgroundimage["location"];?>') repeat top center">
    <div class="container">
    	<?php		if(isset($_GET["hidefeatures"]))
						{

						}
						else
						{ ?>
    <div id="your-img">
			<a href="?page=main">
				<?php

				$query = "SELECT * FROM ".$tblpre."site_images WHERE func = 'header_logo' LIMIT 1";
        try
        {
            $stmt = $db->prepare($query);
            $resultd = $stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
        $resultd = $stmt->fetch(); ?>

<img style=" max-width: 100%;
    height: auto;" src="<?php echo $resultd["location"]; ?>">
			</a>
		<?php }	?>
		</div>
			<?php
			if ($settingClass->getSetting("portal_online") == '0'){
?>

			<div class="row" style="text-align:center;">
		<h1 style="color:white;">Portal is Offline</h1>
		<p>Check back later to ee if its back online</p>
	</p></div>
	</div>
</html>
	<?php
				die();
					} else {
						if(isset($_GET["hidefeatures"]))
						{

						}
						else
						{
			?>
<div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        </div>

        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="?page=main"><i style="color:white;" class="fa fa-home fa-lg" aria-hidden="true"></i></a></li>
			<li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $langs->word($dlang,'navbar_players'); ?><b class="caret"></b></a>
                          <ul class="dropdown-menu">
                            <li><a href="<?php echo $dirUp ?>?page=members"><?php echo $langs->word($dlang,'navbar_members'); ?>- <span class="badge"><?php echo $statClass->getMembers(); ?></span></a></li>
                            <li><a href="<?php echo $dirUp ?>?page=players"><?php echo $langs->word($dlang,'navbar_players'); ?>- <span class="badge"><?php echo $statClass->getTotalusers(); ?></span></a></li>
                          </ul>
                        </li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $langs->word($dlang,'navbar_about'); ?> <b class="caret"></b></a>
				<ul class="dropdown-menu">

					<!-- <li><a href="?page=faq"><?php// echo $langs->word($dlang,'navbar_faq'); ?></a></li> -->
					<li><a href="?page=status"><?php echo $langs->word($dlang,'general_status'); ?></a></li>
				</ul>
			</li>
			<li><a href="?page=leaderboard"><?php echo $langs->word($dlang,'navbar_leaderboard'); ?></a></li>
			<li><a href="?page=blog"><?php echo $langs->word($dlang,'navbar_blog'); ?></a></li>
				<li><a href="?page=marketplace"><?php echo $langs->word($dlang,'marketplace'); ?></a></li>
          </ul>

		  <?php if(!isset($AccountID) && empty($AccountID)) { ?>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="?page=login"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo $langs->word($dlang,'navbar_signin'); ?></a></li>
						<li><a href="?page=register"><i class="fa fa-key" aria-hidden="true"></i> <?php echo $langs->word($dlang,'navbar_register'); ?></a></li>
					</ul>
            <?php } else {

                    $query = "
        SELECT
			*
		FROM
			".$tblpre."private_messages
		WHERE
			sentto = :to
			AND status != 2
		ORDER BY time DESC LIMIT 5
	";

	$query_params = array(
		':to' => $AccountID
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
	$rows = $stmt->fetchall();
	$count = $stmt->rowCount();

?>
<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					  <a href="?page=dashboard" class="dropdown-toggle" data-toggle="dropdown">
					  	<div class="notification-icon">
    <i class="fa fa-envelope fa-lg"></i>
    <?php if($statClass->getTotalUnreadMail($AccountID) > 0)
    {
    ?>
    <span class="NotificationCount"><?php echo $statClass->getTotalUnreadMail($AccountID); ?></span>
<?php } ?>
</div>
</a>
					<ul class="dropdown-menu" style="padding-top:15px;width:400px">
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                	<?php
                	 foreach($rows as $row):
					 $query = "
						SELECT
							*
							FROM ".$tblpre."users
						WHERE
							id = :id
						";
						$query_params = array(
							':id' => $row['sentby']
						);

						try
						{   $stmt = $db->prepare($query);
							$result = $stmt->execute($query_params);
						}
						catch(PDOException $ex)
						{
							die("Failed to run query: " . $ex->getMessage());
						}
						$row2 = $stmt->fetch();  ?>
          <li>
                    <a href="?page=viewmessage&id=<?php echo $row[ 'id'];?>">
                     <div class="pull-left">
                    <?php  	if (is_null($row2['avatar'])) {
						?><img class="img-circle" width="40" height="40" avatar="<?php echo $row2['username'];?>"><?php
				    } else {
							?><img class=" img-circle" height="40" width="40" src="<?php echo $INFO['base_url'];?>/<?php echo $row2['avatar'];?>"><?php
				    }	?>

                      </div>
                      <h4 style="padding-left:50px">
                      <?php echo $row2['username'] ;?>
                        <!--<small class="pull-right" style="padding-right:15px"><i class="fa fa-clock-o"></i> Yesterday</small>-->
                      </h4>
                      <p style="padding-left:50px"><?php echo stripslashes(substr($row['subject'], 0, 50)). "..."; ?>
                      </p>
                    </a>
                  </li>
                  <?php endforeach;?>
                </ul>
              </li>
              <li class="footer" style="text-align:center"><a href="?page=inbox">See All Messages</a></li>
            </ul>
					</li>
				</ul>
				  <ul class="nav navbar-nav navbar-right" style="margin-right: 0 !important; margin-left: 1px;">
					<li class="dropdown">
					  <a href="?page=dashboard" class="dropdown-toggle" data-toggle="dropdown"><?php echo $userClass->getUserUsername($AccountID); ?><b class="caret"></b></a>
					  <ul class="dropdown-menu">
						<li><a href="?page=profile&id=<?php echo $AccountID; ?>"><i class="fa fa-user" aria-hidden="true"></i>  <?php echo $langs->word($dlang,'navbar_profile'); ?></a></li>
						<li><a href="?page=accountsettings"><i class="fa fa-cog" aria-hidden="true"></i>  <?php echo $langs->word($dlang,'navbar_account_settings'); ?></a></li>
						<li class="divider"></li>
						<li class="dropdown-header">Quick Links</li>
						<li><a href="?page=mygarage"><i class="fa fa-car" aria-hidden="true"></i>  Your Garage</a>
						<li><a href="?page=myinventory"><i class="fa fa-list" aria-hidden="true"></i>  Your Inventory</a>
						<li><a href="?page=myterritories"><i class="fa fa-home" aria-hidden="true"></i>  Your Territories</a>


						<?php
						if($userClass->getUserAdminLevel($AccountID) > 0)
                    {
                    ?>
	<li class="divider"></li>
                        <li >
                          <a href="admin"><i class="fa fa-lock" aria-hidden="true"></i>  <?php echo $langs->word($dlang,'navbar_admincp'); ?><b class=""></b></a>
                        </li>
	<li class="divider"></li>
                    <?php }	?>
                    	<li><a href="?page=logout"><i class="fa fa-sign-out" aria-hidden="true"></i>  <?php echo $langs->word($dlang,'navbar_logout'); ?></a></li>
					  </ul>
					</li>
				  </ul>









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
	$CHNAME = $hconf;
	?>


					<?php
			  $query = "SELECT * FROM ".$tblpre."custom_pages ";

    try
    {
						$stmt = $db->prepare($query);
						$result = $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
    $data = $stmt->fetchAll();
	$count = $stmt->rowcount();
	if ($count > 0)
	{
	?>

 <ul class="nav navbar-nav navbar-right" style="margin-right: 0 !important;">
					<li class="dropdown">
					  <a href="?page=dashboard" class="dropdown-toggle" data-toggle="dropdown"><?php echo $hconf['status']; ?><b class="caret"></b></a>
					  <ul class="dropdown-menu">
							<?php


	foreach($data as $info){
	?>
						<li><a href="?page=cpage&id=<?php echo $info['id']; ?>"><?php echo $info['name']; ?></a></li>
							<?php }?>
					  </ul>
					</li>
				  </ul>
            <?php }} ?>
     <ul class="nav navbar-nav navbar-right" style="margin-right: 0 !important;">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $langs->word($dlang,'server').": ".$CURRENTSERVERNAME; ?><b class="caret"></b></a>
					  <ul class="dropdown-menu">
							<?php
	for ($kg = 0 ; $kg < count($SERVERNAMES); $kg++){
	?>

						<li><a href="?page=<?php echo $_GET["page"];?>&SERVERCHANGE=<?php echo $kg ?>"><?php echo $SERVERNAMES[$kg]; ?></a></li>
							<?php }?>
					  </ul>
					</li>
				  </ul>
        </div>
      </div>
      <?php
if (isset($AccountID))
{
if ($userClass->checkUserVerified($AccountID))
    { } else { ?>
<div class="alert alert-info">
  <strong><i class='fa fa-lg fa-envelope'></i></strong> You will need to validate email before you will be able to access our site as a registered member.
</div>
<?php
		}
} else {}
 ?>    </div>

  <?php
	if(isset($AccountID) && $userClass->checkUserSuspended($AccountID)){
			echo '<div class="container"><h1><center>'. $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div>';
			die;
		}
	?>
<?php
}}



?>