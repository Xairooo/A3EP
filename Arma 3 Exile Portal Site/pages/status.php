<?php if(!isset($include)){die("INVALID REQUEST");}

?>
<div class="container">

	<div class="row" style="background: #333;">

<div class="col-lg-9">
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
		<div class="col-lg-3" style="padding-top:10px;border-radius:10px;">
			<div class="h-box">
Server Uptime: <?php echo 	$settingClass->getServerUpTime($a_host, $a_port, $a_user, $a_pass);?>
<br> Player List<br><br>
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