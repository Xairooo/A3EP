<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
$lary = array_filter(eval('return $'. $iinfo . ';'));
$coll = $iinfo;
if($lary == NULL)
{
}
else{
?>
<div class="col-lg-3" style="padding-left:3px;padding-right:3px">
              <div class="thumbnail" style="min-height:150px">
                <div class="caption">
                  <h4><?php echo $langs->word($dlang,$iinfo);?></h4>
                    <br>
                </div>
                <div class="ratings">
                  <?php
                  foreach($lary as $item)
                  {
                      if(!$item == "")
                      {
                          if($_GET["QTEST"]=="1")
                          {
                              $nameitem = $item;
                          }
                          else {
                              $query = "SELECT name FROM ".$tblpre."items WHERE class='".$item."';";
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
$count = $stmt->rowCount();


if($count > 0)
{

    $nameitem =  urldecode ($rows["name"]);

}
else {
    $nameitem = $settingClass->getItemName($item, $a_host, $a_port, $a_user, $a_pass);

    $query = "INSERT INTO ".$tblpre."items (name,class) VALUES ('".urlencode($nameitem)."','".$item."');";
    try
    {
        $stmt = $db->prepare($query);
	    $result = $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
}

                          }
                      echo "<p>".$nameitem.':<button id="'.$item.$iinfo.'" data-toggle="modal" data-target="#product_view" type="button" style="padding: 0px 5px 0px 5px;" class=" text-center btn btn-primary">'.$langs->word($dlang,"sell").'</button>'."</p>";
                      ?>
                      <script>
									document.getElementById("<?php echo $item.$iinfo; ?>").addEventListener("click", displayDate);
									function displayDate() {
										document.getElementById("title").innerHTML = "Are you sure you want to sell:<?php echo $nameitem;?>";
										document.getElementById("colm").setAttribute("value","<?php echo $coll;?>");
										document.getElementById("itemclass").setAttribute("value","<?php echo $item;?>");
										if((document.getElementById("title").innerHTML) == "")
										{
										    window.alert("This item cannot be sold..");
										    $('#product_view').modal('hide');

										}
									}
								</script>
                      <?php
                      }
                  }
                  ?>
                </div>
              </div>
<div class="modal fade product_view" id="product_view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title" id="title"></h3>
            </div>
            <div class="modal-body">
<div class="box-body">

    <form action="" method="POST" id="sellinv">
  <div class="form-group">
    <label style="color:white" class="col-sm-2 col-form-labe" for="value"><?php echo $langs->word($dlang,'item_cost');?></label>
       <div class="col-sm-10"><input style="color:black" type="number" pattern="\d{4}" class="form-control" name="value" id="value" placeholder="Enter Price"></div>
  </div>
  <div class="form-group">
    <label style="color:white" class="col-sm-2 col-form-labe" for="exampleInputPassword1"><?php echo $langs->word($dlang,'description');?></label>
       <div class="col-sm-10"><input style="color:black" type="desc" name="desc" class="form-control" id="desc" placeholder="Short Description"></div>
  </div>
<br><br>
            </div>
                    <div class=" product_content">
                        <div class="btn-ground">
                            <input name="col" id="colm" value="" type="hidden">
                            <input name="item" id="itemclass" value="" type="hidden">
                           <button type="submit" name="buy" class="btn btn-primary"><?php echo $langs->word($dlang,'sell');?></button>
                        </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php }?>