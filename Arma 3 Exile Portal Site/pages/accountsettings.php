<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
    if(empty($AccountID) || !isset($AccountID))
    {
        header("Location: ?page=login");
        exit;
    }

	if(!empty($_POST)){


if(isset($_POST['submitemail'])){
			// Update the email
			$email = (filter_var($_POST['email'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS));

			if($userClass->updateUserEmail($AccountID, $email)){
				header("Location: ?page=accountsettings");
				exit;
			} else {
				$errorMessage = '<div class="alert alert-danger" style="text-align: center;">'.$langs->word($dlang,'update_something_went_wrong').'</div>';
			}
		}
	if(isset($_POST["submitavatar"])) {

		$target_dir = "images/uploads/";
$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if($check !== false) {
        echo $langs->word($dlang,'file_is_image'). $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo $langs->word($dlang,'file_is_image');
        $uploadOk = 0;
    }

// Check if file already exists
if (file_exists($target_file)) {
    echo $langs->word($dlang,'file_exists');
    $uploadOk = 1;
}
// Check file size
if ($_FILES["avatar"]["size"] > 500000) {
    echo $langs->word($dlang,'file_large');
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo $langs->word($dlang,'avatar_wrong_file_type');
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo $langs->word($dlang,'not_uploaded');
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {

       $pic = $target_file;
       	if($userClass->updateUserAvatar($AccountID, $pic)){
			 echo $langs->word($dlang,'the_file'). $pic .$langs->word($dlang,'has_uploaded');
			}

    } else {
        echo $langs->word($dlang,'avatar_error');
    }
}
}
if(isset($_POST['submitprivacy'])){
			// Update the password
			$privacy = $_POST['privacy'];

			if($userClass->setuserprivacy($privacy, $AccountID)){
				header("Location: ?page=accountsettings");
				exit;
			} else {
				$errorMessage = '<div class="alert alert-danger" style="text-align: center;">'.$langs->word($dlang,'update_something_went_wrong').'</div>';
			}
		}

		if(isset($_POST['submit_pass'])){
			// Update the password
			$rawPassword = (filter_var($_POST['password'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS));

			if($userClass->updateUserPassword($AccountID, $rawPassword)){
				header("Location: ?page=accountsettings");
				exit;
			} else {
				$errorMessage = '<div class="alert alert-danger" style="text-align: center;">'.$langs->word($dlang,'update_something_went_wrong').'</div>';
			}
		}
	}
?>
<?php
if(ISSET($_GET["f"]))
{
	$F = $_GET["f"];
	?>
	<script type="text/javascript">

       document.getElementById("1901").className  = '';
        document.getElementById("<?php echo $F;?>").className = 'active';
</script>



	<?php
}?>
</script>
<style>
    @import url(https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css);
body{margin-top:20px;}
.fa-fw {width: 2em;}
</style>
<body>


	       <div class="container">
    <div class="row">
        <h2><?php echo $langs->word($dlang,'account_settings');?></h2>
			<?php

			?>
        <div class="col-md-2">
					<div class = "row">
            <ul class="nav nav-pills nav-stacked admin-menu">
                <li id="1901" class="active"><a href="?page=accountsettings" data-target-id="overview"><i class='fa fa-tachometer'></i> <?php echo $langs->word($dlang,'overview');?></a></li>
                <li id="email"><a href="?page=accountsettings&f=email" data-target-id="email"><i class="fa fa-list-alt fa-fw"></i><?php echo $langs->word($dlang,'email');?></a></li>
                <li id="pass"><a href="?page=accountsettings&f=pass" data-target-id="password"><i class="fa fa-file-o fa-fw"></i><?php echo $langs->word($dlang,'password');?></a></li>
                <li id="avatar"><a href="?page=accountsettings&f=avatar" data-target-id="avatar"><i class="fa fa-bar-chart-o fa-fw"></i><?php echo $langs->word($dlang,'avatar');?></a></li>
                <li id="privacy"><a href="?page=accountsettings&f=privacy" data-target-id="privacy"><i class="fa fa-table fa-fw"></i><?php echo $langs->word($dlang,'privacy');?></a></li>
							 <li id="steam"><a href="?page=accountsettings&f=steam" data-target-id="steam"><i class="fa fa-table fa-fw"></i><?php echo $langs->word($dlang,'link_steam');?></a></li>

            </ul>
							</div>
        </div>
			<div class="col-md-10">

				<div style="display: none;" class="row" id="overview1">
				<div style=" text-align: left;">


      <p>
                <strong><?php echo $langs->word($dlang,'display_name');?></strong><br/><?php echo $userClass->getUserUsername($AccountID); ?>
            </p>
              <p>
                <strong><?php echo $langs->word($dlang,'email_address');?></strong><br/><?php echo $userClass->getUserEmail($AccountID); ?>
            </p>

             <p>
                <strong><?php echo $langs->word($dlang,'avatar');?></strong><br/></p>
                <?php
				    $null = $userClass->getUserAvatar($AccountID);
				    if (is_null($null)) { ?>

				    <img class="avatar img-responsive img-circle" avatar="<?php echo $userClass->getUserUsername($AccountID);?>"><?php
				    } else {?></div><div class="avatar">
				<img class="avatar img-responsive img-circle" src="<?php echo $INFO['base_url'];?>/<?php echo $userClass->getUserAvatar($AccountID); ?>"><?php
				    }?>
				</p>
								</div>
				</div>

				       <div style="display: none; padding-left:10px;" class="row" id="email1">
								 <div style=" text-align: left;">
            <form action="?page=accountsettings&f=email" method="post" enctype="multipart/form-data">
							<h4><?php echo $langs->word($dlang,'change_email'); ?></h4>
   						 <input type="text" name="email" class="form-control" placeholder="<?php echo $userClass->getUserEmail($AccountID); ?>"><br />

    							<input type="submit" value="<?php echo $langs->word($dlang,'update_email');?>" name="submitemail">
						</form>
			 </div>
        </div>
        <div style="display: none; padding-left:10px;" class="row" id="pass1">
					<div style=" text-align: left;">

			 <form action="?page=accountsettings&f=email" method="post" enctype="multipart/form-data">
							<h4><?php echo $langs->word($dlang,'change_password'); ?></h4>
   						<input type="password" name="password" class="form-control" placeholder="Password"><br />
    							<input type="submit" value="<?php echo $langs->word($dlang,'update_password');?>" name="submit_pass">
						</form>
			 </div>
        </div>

        <div style="display: none; padding-left:10px;" class="row" id="avatar1">
					<div style=" text-align: left;">
            <form action="?page=accountsettings&f=avatar" method="post" enctype="multipart/form-data">
							<h4>
								<?php echo $langs->word($dlang,'change_avatar'); ?>
							</h4></br>
<div class="custom-file">
	<input type="file" class ="custom-file-input" name="avatar" id="avatar">
	<span class="custom-file-control"></span>
	</div>

    						<input type="hidden" name="user" value=<?php echo $AccountID;?>>
    						<input type="submit" value="<?php echo $langs->word($dlang,'update_avatar'); ?>" name="submitavatar">
						</form>
						 </div>
        </div>

        <div style="display: none; padding-left:10px;" class="row" id="privacy1">
					<div style=" text-align: left;">
						  <form action="?page=accountsettings&f=privacy" method="post">
							<h4><?php echo $langs->word($dlang,'profile_privacy'); ?></h4>
					<div class="form-check" style="color:#fff">
  <label class="form-check-label">
    <input class="form-check-input" type="checkbox" name="privacy" value="public">
<?php echo $langs->word($dlang,'public_profile'); ?>
  </label>
</div>
<div class="form-check"  style="color:#fff;">
  <label class="form-check-label">
    <input class="form-check-input" type="checkbox" name="privacy" value="private">
 <?php echo $langs->word($dlang,'private_profile'); ?>
  </label>
</div>
<input type="submit" value="<?php echo $langs->word($dlang,'update_privacy'); ?>" name="submitprivacy">
						</form>
						 </div>
        </div>
				 <div style="display: none; padding-left:10px;" class="row" id="steam1">

					<div style=" text-align: left; color:white;">

						<?php	if(is_null($userClass->getusersteamid($AccountID)) OR $userClass->getusersteamid($AccountID) == ''){
				 require ('linksteam.php'); ?>
                                      <a href='<?php echo $auth->GetLoginURL(); ?>'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png'></a><?php
} else { ?>
You are signed into Steam as
<?php $steamid = $userClass->getusersteamid($AccountID);
	$key = $settingClass->getSteamapi();
											$sapi ="http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$key."&steamids=".$steamid;
											$json = file_get_contents($sapi);
											$parsed = json_decode($json);
                    foreach($parsed->response->players as $player):
                 echo $player->personaname;
                    endforeach;
                 }?>

				 </div>
        </div>
			</div>





    </div>
</div>
</body>
<?php
if(ISSET($_GET["f"]))
{
	$F = $_GET["f"];
	$R = $_GET["f"]."1";
		?>
	<script type="text/javascript">

       document.getElementById("1901").className  = '';
       document.getElementById("<?php echo $F;?>").className = 'active';
		   document.getElementById("<?php echo $R;?>").style = '';
</script>
<?php
}
else
{

		$F = "overview";
	$R = $F."1";
				?>
	<script type="text/javascript">
		   document.getElementById("<?php echo $R;?>").style = '';
</script>
<?php
}
?>

   <script src="../js/bootstrap4.js"></script>
