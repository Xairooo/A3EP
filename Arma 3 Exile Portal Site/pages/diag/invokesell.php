<?php if(!isset($include)){die("INVALID REQUEST");} ?>
     <div class="container">
    <div class="text-center lead alert alert-success">
Please wait while your item is posted!
</div></div>
<style type="text/css">
   .loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid red; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 1.5s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<div class="loader"></div>
<?php
$class = $_POST["item"];
$value = $_POST["value"];
$col = $_POST["col"];
$desc = $_POST["desc"];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
$.ajax({
    type: "POST",
    url: "index.php?page=myinventory&fnc=sell&hidefeatures=1",
    data: 'item=<?php echo $class;?>&value=<?php echo $value;?>&col=<?php echo $col;?>&desc=<?php echo $desc;?>',   //with the page number as a parameter
    async: true,
    success: function(msg)
    {
        if(parseInt(msg)!=0)
        {
            window.location.replace('?page=marketplace');
            }
    }
});
});
</script>