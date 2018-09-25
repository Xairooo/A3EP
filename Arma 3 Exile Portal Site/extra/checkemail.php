
<script type="text/javascript" src="check/jquery-1.2.6.min.js"></script><?php
require('common.php');
if(isSet($_POST['email']))
{
$email = $_POST['email'];
$query = "
				SELECT
					*
				FROM ".$tblpre."users
				WHERE
					email = :email
			";

			$query_params = array(
		':email' => (filter_var($_POST['email'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS))
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
			echo 'The email <STRONG>'.$email.'</STRONG> is already in use.';
			} else {
echo 'OK';
}

}

?>