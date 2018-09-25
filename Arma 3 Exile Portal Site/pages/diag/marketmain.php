 <div class="container">
                <div class="row" style="background-color: #2d3035">
 <?php
$offset = 0;
$page_result = 20;
	if($_GET['p'] == 0 || !isset($_GET['p']))
	{
		header("location: ?page=marketplace&p=1");
		exit();
	}
if($_GET['p'])
{
 $page_value = $_GET['p'];
 if($page_value > 1)
 {
  $offset = ($page_value - 1) * $page_result;
 }
}
   $query = " SELECT * FROM ".$tblpre."marketplace WHERE status='0' AND server=".$LINKID." LIMIT $offset, $page_result";
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
    $steamid = $userClass->getusersteamid($AccountID);
    $balance = $statClass->getUserTotalMoney($steamid);

     $query2 = " SELECT * FROM ".$tblpre."marketplace WHERE status='0' AND server=".$LINKID;
    try
    {
        $stmt2 = $db->prepare($query2);
        $stmt2->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
	$count = $stmt2->rowcount();
?>
<div class="col-lg-4" style="padding-left:15px">
<button type="button" style="font-size:16px;" onclick="window.location.href='?page=myinventory'" class="text-muted lead text-center btn btn-primary"> <?php echo $langs->word($dlang,'add_item');?></button>
</div>
<div class="col-lg-4 text-muted lead text-center"><?php echo $langs->word($dlang,'marketplace');?></div>
<div class="col-lg-4 text-muted text-center lead"><?php echo $langs->word($dlang,'balance');?>: <?php echo number_format($balance);?> Tabs</div><br><br>
<div style="border-bottom: 2px solid #4A4A4A; padding: 30px 0px 7px 0px;"> </div>
<br>
<?php
 	if(!$rows) {
 	    ?>
 	    </div></div>
 	    <?php
 	}
 	else {
 foreach($rows as $row){
     if (!$row['class']=="")
     {
     $seller = $userClass->getUserUsername($row['seller']);
     $sid = $row['seller'];
$itemclass = $row['class'];
$id = $row['id'];
$query = "SELECT name FROM ".$tblpre."items WHERE class='".$itemclass."';";
try
{
  $stmt = $db->prepare($query);
	$result = $stmt->execute();
}
catch(PDOException $ex)
{
    die("Failed to run query: " . $ex->getMessage());
}
$rows = $stmt->fetch();
$item =  urldecode ($rows["name"]);
    $price = $row['price'];
    $newbalance = ($balance - $price);
        ?>
<div class="col-lg-3" style="padding-left:3px;padding-right:3px;">
              <div class="thumbnail" style="max-height:300px; min-height:300px">
                <!--<img src="./images/uploads/favicon.png" alt="" class="img-responsive"> Why is this a favicon??-->
                <div class="caption">
                  <h4><?php echo $item;?></h4>
                    <p><?php echo $row['description'];?></p>
                </div>
                <div class="ratings" style="padding: 9px 9px 0px 9px;border-top: 2px solid #4A4A4A;color: #fff;">
                  <?php echo $langs->word($dlang,'seller');?>: <?php echo $seller;?>
                </div>
                <div class="space-ten"></div>
                <div class="btn-ground text-center" style="position: absolute;
bottom:  40px;
 left:0;right:0;">
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#product_view<?php echo $id;?>"> <?php echo $langs->word($dlang,'buy_for');?></i> <?php echo $row['price'];?></button>
                </div>
                <div class="space-ten"></div>
              </div>

<div class="modal fade product_view" id="product_view<?php echo $id;?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title"><?php echo $langs->word($dlang,'buy_confirm');?> <?php echo $item;?>?</h3>
            </div>
            <div class="modal-body">
<div class="box-body">
              <dl style="color:white;" class="dl-horizontal">
                <dt><?php echo $langs->word($dlang,'your_balance');?></dt>
                <dd><?php echo number_format($balance);?></dd>
                <dt><?php echo $langs->word($dlang,'item_cost');?></dt>
                <dd><?php echo number_format($row['price']);?></dd>
                <dt><?php echo $langs->word($dlang,'new_balance');?></dt>
                <dd><?php echo number_format($newbalance);?></dd>
              </dl>
              <br><br>
            </div>
                    <div class=" product_content" style="padding-left:40%;">
                        <div class="btn-ground">
                           <?php if ($newbalance < 0 ) { ?> <button type="button" data-dismiss="modal" class="btn btn-primary"><?php echo $langs->word($dlang,'no');?></button> <button type="button" class="btn btn-primary disabled"> <?php echo $langs->word($dlang,'yes');?></button><?php } else { ?>
                           <form action="" method="POST">
                              <input type="hidden" name="seller" value="<?php echo $row['seller'] ;?>">
                                <input type="hidden" name="itemname" value="<?php echo $item;?>">
                              <input type="hidden" name="item" value="<?php echo $id;?>">
                                <input type="hidden" name="cost" value="<?php echo $row['price'];?>">
                              <input type="hidden" name="class" value="<?php echo $itemclass ;?>">
                                <input type="hidden" name="tabs" value="<?php echo $newbalance ;?>">
                              <button type="button" data-dismiss="modal" class="btn btn-primary"><?php echo $langs->word($dlang,'no');?></button>
                              <button type="submit" name="buy" class="btn btn-primary"><?php echo $langs->word($dlang,'yes');?></button>
                          </form>
                           <?php }  ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php }} ?>
<div class="col-md-12" style="padding-left:3px;padding-right:3px">
				<nav aria-label="...">
  <ul class="pager">
					<?php
					$pagecount = $count;
$num1 = ceil($pagecount / $page_result);
$num = (int)$_GET['p']  ;
$float = (float)$num;
if($float > 1)
{
 echo "<li class='previous'><a href='?page=marketplace&p=".($float - 1)."'><span aria-hidden='true'>&larr;</span> Previous</a></li>";
}

if($num1 != $num)
{
 echo "<li class='next''><a href='?page=marketplace&p=".($float+ 1)."'>Next <span aria-hidden='true'>&rarr;</span></a></li>";
} ;
					?>
</ul>
</nav>
</div>
<?php } ?>
 </div>
 </div>
