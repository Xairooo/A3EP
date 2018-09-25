<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
$query = "
        SELECT
           *
        FROM ".$tblpre."users WHERE verified = 1
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
    $count = $stmt->rowCount()." ";

?>

<body>

<div class="container">
   <div class="row new">
	   <?php if(!isset($AccountID) && empty($_SESSION['user'])) { ?>
		<div class='red-box'>
			<h3><?php echo $langs->word($dlang,'uh-oh');?></h3>
			<div class='text'><?php echo $langs->word($dlang,'not_logged_in');?><a href="?page=register"><?php echo $langs->word($dlang,'register_here');?></a> ~ <a href="?page=login"><?php echo $langs->word($dlang,'login_here');?></a>.
			</div>
		</div>
		<?php } ?>
		<div class="col-md-9">
            <div class="col-sm-12">
                <h2 class="h-color">
                    <span class="white"><?php echo $settingClass->getServerName(); ?>(</span>
                    <span class="orange"> <?php echo $count;?></span><span class="white">)</span>
                    <span class="white"> <?php echo $langs->word($dlang,'navbar_players');?>
                    </span>
                </h2>
                <!--<script>
                    $(document).ready(function(){
                        $('[data-toggle="popover"]').popover();
                    });
                </script>-->
                <?php foreach($rows as $row){ if($row['admin'] == 1){ $adminlabel = 'tile c-member'; } else { $adminlabel = 'tile'; }?>
                <div class="col-md-3"  style="text-align:left;">
                    <div class="<?php echo $adminlabel;?>" style="padding-left:20px; padding-right:20px;">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="info">
                                    <div class="value">
                                        <a title="Header" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Some content" href="?page=profile&id=<?php echo $row['id']; ?>"><?php echo  strtolower(htmlentities($row['username'], ENT_QUOTES, 'UTF-8')); ?></a>
                                    </div>
                                    <div class="desc"><?php echo $row['regdate'];?></div>
                                </div>
                                <div class="icon">
                                    <a href="?page=profile&id=<?php echo $row['id']; ?>">
                									<?php  if (is_null($row['avatar'])) {
                						?><img class="avatar img-responsive img-circle" width="175" height="175" avatar="<?php echo $row['username'];?>"><?php
                				    } else {
                							?><img class="avatar img-responsive img-circle" src="<?php echo $INFO['base_url'];?>/<?php echo $row['avatar'];?>"><?php
                				    }	?>
                				    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><?php } ?>
            </div>
	   </div>
    </div>
</body>