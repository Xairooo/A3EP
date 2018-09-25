    	<?php		if(isset($_GET["hidefeatures"]))
						{

						}
						else
						{ ?>
 <footer class="container" style="padding-bottom:10px">
       <div class="white pull-right">
     <?php echo $settingClass->getSetting('user_copyright'); ?>
  </div><br>
  <div class="pull-left">
      <ul class="list-inline">
      <li class="dropdown dropup">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $langs->word($dlang,'language'); ?> <i class="fa fa-caret-down"></i></a>
				<ul class="dropdown-menu">
  <?php
     $query = "SELECT * FROM ".$tblpre."lang;";
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
    	foreach($rows as $row): ?>
<li><a href="?page=main&language=<?php echo $row['lang_short'];?>"><?php echo $row['lang_title'];?></a></li>

                <?php endforeach;?>

				</ul>
			</li>
			 <li><a href="?page=contactus"><?php echo $langs->word($dlang,'navbar_contact'); ?></a></li>
			</ul>

      </div>
  <div class="pull-right">
     <a class="orange" rel="nofollow" title="Version <?php echo $settingClass->getA3EPVersion(); ?>" href="https://a3exileportal.com/">Powered by ESS</a></div>
  </div>
</footer>
 </div>
<?php } ?>