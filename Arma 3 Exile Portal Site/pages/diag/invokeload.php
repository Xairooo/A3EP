<?php if(!isset($include)){die("INVALID REQUEST");} ?>
 <div id="message" class="container">
<div class="text-center lead alert alert-success">
Please wait while your inventory is loaded!
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
<div id="loader" class="loader"></div>
<?php
$qtest = $_POST["QTEST"];

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

$.ajax({
    type: "POST",
    url: "index.php?page=myinventory&hidefeatures",
    data: '',   //with the page number as a parameter
    async: true,
    success: function(msg)
    {
        if(parseInt(msg)!=0)
        {
            $('#div1').html(msg);    //load the returned html into pageContet
            $("#message").hide();
            $("#loader").hide()
        }
    }
});

});
</script>
<div name="div1" id="div1"></div>