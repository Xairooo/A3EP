<?php if(!isset($include)){die("INVALID REQUEST");} ?>

<?php
	if(empty($_GET['id']))
	{
		header("Location: ?page=index");
		exit;
	}
	$userid = $_GET['id'];
	$userid = intval($userid);

	if(!is_numeric($userid))
	{
		header("Location: ?page=index");
		exit;
	}

	$submitted_username = '';

        $query = "
            SELECT
				*
				FROM ".$tblpre."users
            WHERE
                id = :id
        ";

        $query_params = array(
            ':id' => $userid
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

$steamid = $row['steamid'];
		if($row['verified'] == 0 && $row['suspended'] == 0)
		{
			$verified = "<span class=\"label label-warning\">". $langs->word($dlang,'unverified') ."</span>";
		}
		else if($row['verified'] == 0 && $row['suspended'] == 1)
		{
			$verified = "<span class=\"label label-danger\">". $langs->word($dlang,'suspended') ."</span>";
		}
		else if($row['verified'] == 1 && $row['suspended'] == 0)
		{
			$verified = "<span class=\"label label-success\">". $langs->word($dlang,'verified') ."</span>";
		}
		else if($row['verified'] == 1 && $row['suspended'] == 1)
		{
			$verified = "<span class=\"label label-danger\">". $langs->word($dlang,'suspended') ."</span>";
		}
		if($row['admin'] == 1)
		{
			$admin = "<span class=\"label label-danger\">". $langs->word($dlang,'admin') ."</span>";
		}
			if($row['donator'] == 1)
		{
			$donator = "<span class=\"label label-primary\">". $langs->word($dlang,'donator') ."</span>";
		}
        if($row)
        {

			$regdate = htmlentities($row['regdate'], ENT_QUOTES, 'UTF-8');
			$regdate = strtotime($regdate);
            ?>

	<body>
		<link rel="stylesheet" href="library/admin-css/css/Admin.min.css">


		<div class="container">
			<div class="row">
				<?php if(!isset($AccountID) && empty($AccountID)) { ?>
					<div class='red-box'>
			<h3><?php echo $langs->word($dlang,'uh-oh');?></h3>
			<div class='text'><?php echo $langs->word($dlang,'not_logged_in');?><a href="?page=register"><?php echo $langs->word($dlang,'register_here');?></a> ~ <a href="?page=login"><?php echo $langs->word($dlang,'login_here');?></a>.
			</div>
		</div>
				<?php if($row['private'] == 1)
			{ ?>
				<div class='red-box'>
					<h3><?php echo $langs->word($dlang,'private_profile');?></h3>
					<div class='text'><?php echo $langs->word($dlang,'private_profile_desc');?></a>.
					</div>
				</div>
				<?php

			die();
		} else
		{

		}
		}

			?>
<style>

	.nav-tabs>li>a
	{
		border:0px;
	}
	.p
	{
		text-color:black;
	}
	b, strong {
    font-weight: bold;
    color:white;
}
.container .text-muted{
	margin: 0;
}
hr{
	margin-top:5px;
	margin-bottom:5px;
}
</style>

        <div class="col-lg-3" style="padding-right:5px">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
            	<?php
				    if (is_null($row['avatar'])) {
						?><img class="profile-user-img img-responsive img-circle" width="175" height="175" avatar="<?php echo $row['username'];?>"><?php
				    } else {
							?><img class="profile-user-img img-responsive img-circle" src="<?php echo $INFO['base_url'];?>/<?php echo $row['avatar'];?>"><?php
				    }	?>

              <h3 class="profile-username text-center"><?php echo $row['username'];?></h3>

              <p class="text-muted text-center"><?php echo $verified;?> <?php echo $admin;?> <?php echo $donator;?></p>
              <br>
	<?php
    $query = "
							SELECT
								*
								FROM account
								WHERE uid = :user
						";
    $query_params = array(
        ":user" => $steamid
    );
    try
    {
        $stmt = $dbo->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
    $counttabs = $stmt->rowCount();
    $rows3 = $stmt->fetchAll();
      $totalkills = 0;
        $totaldeaths = 0;
        $totalconnect = 0;
    foreach($rows3 as $row){

        $totalkills = $row['kills'];
        $totaldeaths = $row['deaths'];
        $totalconnect = $row['total_connections'];

    }
                            ?>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b><?php echo $langs->word($dlang,'kills');?></b> <a class="pull-right white"><?php echo $totalkills; ?></a>
                </li>
                <li class="list-group-item">
                  <b><?php echo $langs->word($dlang,'deaths');?></b> <a class="pull-right white"><?php echo $totaldeaths; ?>	</a>
                </li>
                <li class="list-group-item">
                  <b><?php echo $langs->word($dlang,'total_connections');?></b> <a class="pull-right white"><?php echo $totalconnect; ?></a>
                </li>
              </ul>

              <a href="?page=sendmessage&id=<?php echo $userid;?>" class="btn btn-primary btn-block" style="margin-left: 35px;;width: 80%;"><b>message</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header
            <div class="box-body">

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>admin staff notes?</p>
            </div>
            <!-- /.box-body
          </div>
          <!-- /.box-->
        </div>
        <!-- /.col -->
        <div class="col-md-9" style="padding-left:5px;width: 75%">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">marketplace activity</a></li>
              <!--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>-->

            </ul>
            <div class="tab-content">
             <div class="tab-pane active" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label
                  <li class="time-label">
                        <span class="bg-red">
                        Today
                        </span>
                  </li>
                   /.timeline-label -->
                  <!-- timeline item -->
<?php
   $query = " SELECT * FROM ".$tblpre."marketplace WHERE bought != '0000-00-00 00:00:00' AND (seller = '".$_GET['id']."' OR buyer = '".$userClass->getusersteamid($_GET['id'])."') AND server=".$LINKID." ORDER BY bought DESC" ;


         try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $rows = $stmt->fetchAll();
    $steamid = $userClass->getusersteamid($_GET['id']);
    $balance = $statClass->getUserTotalMoney($steamid);
    foreach ($rows as $row){
$itemclass = $row['class'];
$item = $settingClass->getItemName($itemclass, $a_host, $a_port, $a_user, $a_pass);

if($row["seller"] == $_GET['id'])
{
?>

                  <li>
                    <i class="fa fa-dollar bg-green" style="padding-left: 5px;"></i>

                    <div class="timeline-item">
                   <h3 class="timeline-header no-border"><a href="#">Sold</a> <?php echo $item;?> for <?php echo number_format($row['price']);?> Tabs</h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
<?php }
else
{
 ?>

                  <li>
                    <i class="fa fa-dollar bg-red"></i>

                    <div class="timeline-item">
                   <h3 class="timeline-header no-border"><a href="#">Purchased</a> <?php echo $item;?> for <?php echo number_format($row['price']);?> Tabs</h3>
                    </div>
                  </li>

 <?php
}
}
?>
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">


              </div>
              <!-- /.tab-pane -->


            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->

</div></div>




			<?php
}
else
{
    echo"<div class= \"container \">";
    echo"		<br />";
    echo"		<h2>Error!</h2>";
    echo"		<p>This profile doesn't exist, try another!</p>";
    echo"</div>";
}

            ?>

	</body>