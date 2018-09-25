</body>
<?php
 if(!isset($include)){die("INVALID REQUEST");}


				$query = "SELECT * FROM ".$tblpre."site_images
WHERE func = 'front_carousel'
ORDER BY id DESC";
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch(PDOException $ex)
{
    die("Failed to run query:t " . $ex->getMessage());
}
$crows = $stmt->fetchAll();
$ccount = $stmt->rowcount();


?>
<div class="container">

	<div class="row" style="background: #2d3035;">
		<div class="" style="text-align:center; max-width: 1157px; height: auto; position:relative;margin:0 auto;">
			<?php if($ccount > 1)
			{ ?>
<div class="h-image" style="right:0;left:0">
			<script>
			$('.carousel').carousel()
			</script>
<div id="carousel-example-generic" style="infinite: true" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->

<style>	.carousel-caption
			{
				position: absolute;
				right: 0;
				bottom: 0;
				left: 0;
				z-index: 10;
				padding-top: 20px;
				padding-bottom: 20px;
				color: #fff;
				text-align: center;
				background: rgba(0,0,0,0.4);
			}
			</style>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
		<?php $crss = 0; ?>
    <?php  foreach($crows as $row): ?>
		 <?php

		if ($crss++ == 1)
		{
			?>
		<div class="item active">
		<?php
		}
		else{
						?>
		<div class="item">
		<?php
		}
		  ?>

     	<img style="max-height:380px; width:100%" src="<?php echo $row['location']; ?>">
       <div class="carousel-caption">
    <h3><?php echo $row['name']; ?></h3>
    <p><?php echo $row['desc']; ?></p>
  </div>
    </div>

  <?php endforeach; ?>

					</div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>

</div>

			</div>
		</div>
<?php } ?>

			      <?php

$query = "
    SELECT
      *
    FROM ".$tblpre."serverannouncements
ORDER BY id DESC
";

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
$count = $stmt->rowcount();

?>
<?php if(!$count == 0) { ?>


<div class='col-lg-12' style="width: 100%; ">
  <div class="ta_NT" style="width: 100%">
    <div class="newsTicker" style="width: 100%;">
      <div class="ta_tickerTitle"><span class="white"><?php echo $langs->word($dlang,'news');?></span></div>
      <div class="ta_tickerStatus">
        <span>
      <?php if(!isset($AccountID) && empty($AccountID)) { ?>
        <i class="fa fa-pause" aria-hidden="true"  _title="Pause"></i>
        <i class="fa fa-forward" aria-hidden="true" _title="Continue"></i>
        <?php } else {
         if($userClass->getUserAdminLevel($AccountID) > 0)
                {
        ?>
        <a href="admin/manageannouncements.php">
            <i class="fa fa-pencil" aria-hidden="true" _title="Add/Edit tickers"></i>
        </a>
        <i class="fa fa-pause" aria-hidden="true"  _title="Pause"></i>
        <i class="fa fa-forward" aria-hidden="true" _title="Continue"></i>
        <?php } else {  ?>
        <i class="fa fa-pause" aria-hidden="true"  _title="Pause"></i>
        <i class="fa fa-forward" aria-hidden="true" _title="Continue"></i>
        <?php } }?>
        </span>
      </div>






      <div class="container" style="height: 50px; overflow: hidden;">
        <div class="mask" style="max-with: 100%;">
          <ul id="ta_webticker" style="max-with: 100%;" >




<?php if($count == 0) { ?>
            <li style="white-space: nowrap; float: left; padding: 0px 7px; line-height: 50px;">
              <a href="#" target="_blank" rel="noopener"><?php echo $langs->word($dlang,'no_server_announcement');?></a>
            </li>

<?php }
else foreach($rows as $row): ?>
<li style="white-space: nowrap; float: left; padding: 0px 7px; line-height: 50px;">
<a href="<?php echo $row['content'];?>" target="_blank" rel="noopener"><?php echo $row['title']; ?></a>
</li>
<?php endforeach; ?>



          </ul>
          <span class="tickeroverlay-left" style="display: none;">&nbsp;</span>
          <span class="tickeroverlay-right" style="display: none;">&nbsp;</span>
        </div>
      </div>


    </div>
  </div>
</div>

<?php } ?>



		<div class="col-lg-9">
			<div class="row" style="padding-top:0px;border-radius:10px;">
				<div class="h-header">
					<h1>
						<span class="orange"><?php echo $settingClass->getServerName(); ?></span> Features
					</h1>
				</div>
				<div class="h-container">


					<div class="col-lg-4">
						<h3>
							<a href ="?page=myinventory">
							</span><span class="black"><?php echo $langs->words($dlang,'main_view_inventory',0);?></span> <span class="orange"><?php echo $langs->words($dlang,'main_view_inventory',1);?></span>
							</a>
						</h3>
						<div class="info"><?php echo $langs->word($dlang,'main_view_inventory_desc');?></div>
					</div>
					<div class="col-lg-4">
						<h3>
							</span><span class="black"><?php echo $langs->words($dlang,'main_online_players',0);?></span> <span class="orange"><?php echo $langs->words($dlang,'main_online_players',1);?></span>
						</h3>
						<div class="info"><?php echo $langs->word($dlang,'main_online_players_desc');?></div>
					</div>
					<div class="col-lg-4">
						<h3>
							</span><span class="black"><?php echo $langs->words($dlang,'main_stats_tracker',0);?></span> <span class="orange"><?php echo $langs->words($dlang,'main_stats_tracker',1);?></span>
						</h3>
						<div class="info"><?php echo $langs->word($dlang,'main_stats_tracker_desc');?></div>
					</div>
					<div class="h-container"></div>
					<div class="col-lg-4">
						<h3>
							<a href ="?page=marketplace">
						<span class="black"><?php echo $langs->words($dlang,'main_marketplace',0);?> </span><span class="orange"><?php echo $langs->words($dlang,'main_marketplace',1);?></span>
						</a>
						</h3>
						<div class="info"><?php echo $langs->word($dlang,'main_marketplace_desc');?></div>
					</div>
					<div class="col-lg-4">
						<h3>
							<a href ="?page=myterritories">
							<span class="black"><?php echo $langs->words($dlang,'main_tc_management',0);?></span><span class="orange"> <?php echo $langs->words($dlang,'main_tc_management',1);?></span>
						</a>
						</h3>
						<div class="info"><?php echo $langs->word($dlang,'main_tc_management_desc');?></div>
					</div>
					<div class="col-lg-4">
						<h3>
							<a href ="?page=mygarage">
							</span><span class="black"><?php echo $langs->words($dlang,'main_online_garage',0);?></span> <span class="orange"><?php echo $langs->words($dlang,'main_online_garage',1);?></span>
						</a>
						</h3>
						<div class="info"><?php echo $langs->word($dlang,'main_online_garage_desc');?></div>
					</div>
				</div>
			</div>
			<div class="row" style="padding-top:0px;border-radius:10px;">
				<div class="h-header">
					<h1>
						<?php echo $langs->words($dlang,'main_server_statistics',0);?> <span class="orange"> <?php echo $langs->words($dlang,'main_server_statistics',1);?></span>
					</h1>
				</div>
				<div class="h-container">
					<div class="rowtwo">
						<div class="col-md-3">
							<h4>
								<i class="fa fa-usd" aria-hidden="true"></i></span> <?php echo $langs->word($dlang,'total');?> <span class="orange"><?php echo $langs->words($dlang,'main_server_statistics_titles',0);?></span>
							</h4>
							<span class="white"><?php echo number_format($statClass->getTotalMoneyPlayer()); ?></span></div>
						<div class="col-md-3">
							<h4>
								<span class="fa fa-line-chart" aria-hidden="true"></span> <?php echo $langs->word($dlang,'total');?> <span class="orange"><?php echo $langs->words($dlang,'main_server_statistics_titles',1);?></span>
							</h4>
							<span class="white"><?php echo number_format($statClass->getTotalconnections()); ?></span> </div>
						<div class="col-md-3">
							<h4>
								<span class="fa fa-pie-chart" aria-hidden="true"></span> <?php echo $langs->word($dlang,'total');?> <span class="orange"><?php echo $langs->words($dlang,'main_server_statistics_titles',2);?></span>
							</h4>
							<span class="white"><?php echo number_format($statClass->getTotalKills()); ?></span> </div>
						<div class="col-md-3">
							<h4>
								<span class="fa fa-heartbeat" aria-hidden="true"></span> Total <span class="orange"><?php echo $langs->words($dlang,'main_server_statistics_titles',3);?></span>
							</h4>
							<span class="white"><?php
						 echo number_format($statClass-> getTotaldeaths()); ?></span> </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3" style="padding-top:10px;">
			<div class="h-box">
				<?php if(!isset($AccountID) && empty($AccountID)) { ?>

				<div class="r-button">
					<a class="btn btn-sign" href="?page=register" style="font-size:16px"><?php echo $langs->word($dlang,'sign_up');?></a>
				</div>
				<?php } else { ?> <?php echo $langs->word($dlang,'welcome_back');?>
				<?php echo $userClass->getUserUsername($AccountID); ?>

				<?php } ?><br><br>
				Online Players:<br>
					<?php

					$result = explode(",",$settingClass->getOnlinePlayers($a_host, $a_port, $a_user, $a_pass));

foreach($result as $player)
                    {

                            if (!$player == "") {
                                if(!next($result)) {
                                    echo $player;
                                } else {
                                    echo $player.", ";
                                }
                            }
                            else {
                                echo "Nobody is online";
                            }

                    }
					?>
			</div>

		</div>

	</div>
</div>
<script type="text/javascript">
	$('#webTicker').webTicker({
		height: '45px',
		speed: 70,
	});
	if (null !== document.querySelector("#ta_webticker")) {
			$("#ta_webticker").webTicker({
						height: '50px',
				width:'100%',
			speed: 70,
			hoverpause: true

		});

		$(".ta_tickerStatus .fa-pause").click(function() {
			$("#ta_webticker").webTicker('stop');
		});
		$(".ta_tickerStatus .fa-forward").click(function() {
			$("#ta_webticker").webTicker('cont');
		});

	}
</script>
