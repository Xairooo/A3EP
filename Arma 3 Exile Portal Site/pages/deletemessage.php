<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
    if(empty($AccountID) || !isset($AccountID))
    {
        header("Location: ?page=login");
        exit;
    }

	if(empty($_GET['id']))
	{
		header("Location: ?page=index");
		exit;
	}
	$id = $_GET['id'];
	$id = intval($id);

	if(!is_numeric($id))
	{
		header("Location: ?page=index");
		exit;
	}

	$query = "
        SELECT
			*
		FROM
			".$tblpre."private_messages
		WHERE
			id = :to AND
			status != 2
	";

	$query_params = array(
		':to' => $id
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
	$rows = $stmt->fetchall();

	foreach($rows as $row):
	if($AccountID != $row['sentto'])
	{
		header("Location: ?page=main");
        exit;
	}
	else
	{
		$query = "
            UPDATE ".$tblpre."private_messages
			SET
				status = 2
        ";
		$query_params = array(
            ':id' => $id,
        );
        $query .= "
            WHERE
                id = :id
        ";

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }

        header("Location: ?page=inbox");
        exit;
	}
	endforeach;

?>
