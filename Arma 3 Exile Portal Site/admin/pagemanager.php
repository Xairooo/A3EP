<?php
if (isset($_GET["fnc"]))
{
require('strippedheader.php');
if (isset($_GET["disable"]))
{
	$page=  $_GET["page"];
	$query = "SELECT * FROM ".$tblpre."system_pages WHERE `pid` ='".$page."';";
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $rows = $stmt->fetch();
    if($rows["disabled"]=='0')
    {
    	$dis = "1";
    }
    else
    {
    	$dis = "0";
    }

   $query = "UPDATE ".$tblpre."system_pages SET `disabled` =  '".$dis."' WHERE `pid` ='".$page."';";
   $stmt = $db->prepare($query);
   $stmt->execute();
}
}
else{
require('header.php');
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
					<?php
	if(!$permClass->checkUserPerms("view_login_handlers", $AccountID)){
		echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {?>
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
   <?php echo $langs->word($dlang,'page_manager'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li><?php echo $langs->word($dlang,'settings'); ?></li>
        <li class="active"><?php echo $langs->word($dlang,'page_manager'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box box-primary">
            <div class="box-header with-border">
<br>  </div>
	<?php
                 $query = "SELECT * FROM ".$tblpre."system_pages;";
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
?>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                  <?php  foreach($rows as $row): ?>
                <li class="item">
                  <div class="product-info">
                    <span class="product-title"><?php echo $row['pagename'];?></span>
                      <div class="pull-right">
                      	<script>
function toggleCheckbox(a)
{

$.ajax({
    type: "POST",
    url: "pagemanager.php?fnc&disable&page="+a,
    data: '',
    async: false,
    success: function(msg)
    {
        if(parseInt(msg)!=0)
        {

        }
    }
});

}</script>

<?php if($row["disabled"]==0)
{
	$checked="checked";

}?>
					<input type="checkbox" value="<?php echo $row['pid'];?>" autocomplete="off"  <?php echo $checked;?> data-size="small" data-toggle="toggle" onchange="toggleCheckbox('<?php echo $row['pid'];?>')" id="<?php echo $row['pid']."_cb";?>" >
</div>
                  </div>
                </li>
                <!-- /.item -->
	<?php endforeach;?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>


        </section>

</div>

<?php
}

		require('footer.php');
}
?>
