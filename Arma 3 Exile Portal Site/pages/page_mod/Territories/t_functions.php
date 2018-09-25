<?php
    $posted_tid = $_GET["territory"];
    if(isset($_GET["1023984"]))//Remove Memeber
    {
        $query = "SELECT * FROM territory WHERE owner_uid = :steam AND id=".$posted_tid.";";
		$query_params = array(':steam' => $userClass->getusersteamid($AccountID));
        try
        {
            $stmt = $dbo->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
		$rows = $stmt->fetch();
		$t_members = explode(",",str_replace ('"', '', substr($rows["build_rights"], 1, -1)));
        $t_moderators = explode(",",str_replace ('"', '', substr($rows["moderators"], 1, -1)));
        $t_members = array_diff($t_members, [$_GET["uid"]]);
        $t_moderators = array_diff($t_members, [$_GET["uid"]]);
        //execute code on sever to update flag
    }
    if(isset($_POST["1249241"]))//Vacation Payment
    {

    }
    if(isset($_POST["1499234"]))//Leave Territory
    {

    }
    if(isset($_POST["1495283"]))//Rename Territory
    {

    }
?>