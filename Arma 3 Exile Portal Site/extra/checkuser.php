
<script type="text/javascript" src="check/jquery-1.2.6.min.js"></script><?php
require('common.php');
if(isSet($_POST['username']))
{
$username = $_POST['username'];
$query = "
				SELECT
					*
				FROM ".$tblpre."users
				WHERE
					username = :username
			";

			$query_params = array(
		':username' => (filter_var($_POST['username'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS))
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


			 $count = $stmt->rowCount();

			if($count>=1)
			{
			echo '<font color="red">The nickname <STRONG>'.$username.'</STRONG> is already in use.</font>';
			} else {
echo 'OK';
}

}

?>