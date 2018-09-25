<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
if(isset($_GET["id"]))
{
	  $query = "SELECT content FROM ".$tblpre."custom_pages WHERE ID = :id LIMIT 1";
						$query_params = array(
						':id' => (filter_var($_GET["id"] , FILTER_SANITIZE_FULL_SPECIAL_CHARS))
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
    $data = $stmt->fetch();

	?>
<div class="container">
	<div class="row">
	<?php
		echo $data["content"];
	?>
	</div>
</div>
<script>
var arr = document.querySelectorAll("div");
arr.forEach(function(x) {
if (x.innerHTML == "$USERNAME")
{
  	x.innerHTML = "<?php echo $userClass->getUserUsername($AccountID); ?>";
}
if (x.innerHTML == "$")
{
  	x.innerHTML = "<?php echo $userClass->getUserUsername($AccountID); ?>";
}
})
</script>
<?php
}
else
{
	header("location: ?page=main");
}
?>