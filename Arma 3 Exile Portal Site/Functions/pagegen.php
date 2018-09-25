<?php
eval($CMS->funcDecrypt('=0nC9BCIgAiC7kyJUNURSJ1TD5USgMVSgUETJZEIFhEVgwSRE9UTWVERgQUQPxEIPRFIEVETJFkRngSZpRGIgACIgACIgowegACIgoQKnk0ViZnSXp1bShVZzZUbjxmUIRGc4JzYKJFSkxmSul1Jg0TIgUGZv1mdlRWZsJWYuVGJoYWagACIgowOpcCcoBnLFR0TNZVREdCKlRWdsNmbpBCIgAiC7pQKpICcoBnLFR0TNZVREJCKzR3cphXZfVGbpZGKmlmC7kCKoNGdlZmPtQXb0NHJg0DI05WY0xWdzVmckoQfKsTKpgSZnF2czVWT0V2Z+0CelRCIuAiIgoTeyVWdxBib1JHIvRHIkVGbpFmRigSZpRWCKsnCpgXZkAibvlGdwV2Y4V0TEBFKoNGdhNmC9pwOpMXbhJXYw9VeyVWdxRCKlRXdjVGel5TL01GdzRCI9ACduFGdsV3clJHJgACIgowOpknclVXckgSZyFGclJHc+0iYkRCI9ACIgQXb0NHJgACIgowe5JHdJkQCKsTKJkQCKU2ZhBHJg4TPgcCZpBnOnkQCJkgCokXYyJXYg0DIz1WYyFGcflnclVXckkgC7ICZpBnO9AGZpBHYgUkUFh0VgA2cldWYw9VblR3c5NnIuUmcwxmY0RiLiAGIN9kUGBiKgQ1QFxURTJCI9ASeyVWdxRCIgACIKsTKnB3YulGJoUGbpZ2X1QWbg0DI1QWbldWYwRCIgACIK0nC7ICcoBnLiAiLgU2ZhBHJuIyLzV2ZhBnIg0DInB3YulGJgACIgoQfgACIgowOi4Wah1mIg0DIldWYwRCIgACIgACIgowegACIgoQKigXZk5Wai0TPldWYwRCKmlGIgACIKsnClNHblpQfKsjIwhGcu4Wah1mIuIyLzV2ZhBnIg0DInB3YulGJgACIgowOi4Wah1mIg0DIldWYwRCIgACIKsnCpkycldWYwRCLnFGckgSehJnch9lbpFCKmlmC9pwOiAHaw5iIg4CIldWYwRiLi8ycldWYwJCI9AyZwNmbpRCIgACIKoQfgACIgowOi4Wah1mIg0DIldWYwRCIgACIgACIgowegACIgoQKigXZk5Wai0TPldWYwRCKmlGIgACIKsnClNHblpQfKsjIwhGcu4Wah1mIuIyLzV2ZhBnIg0DInB3YulGJgACIgoweKkSKzV2ZhBHJscWYwRCK5FmcyF2XulWIoYWaKsTKnMXZnFGcv4yJoIXak5WYjNHI9AycldWYwRiC7ICcoBnLiAiLgU2ZhBHJg0DInFGckowOdJSZnFGcisFVFd0XkASPgU2ZhBHJ'));
eval($CMS->funcDecrypt('==gC9lQCJkQCKsTKpgSZnF2czVWT0V2Z+0CelRCIuAiIgoTeyVWdxBib1JHIvRHIkVGbpFmRigSZpRWCJkQCJkgC7lQCJkQCKkCelRCIu9Wa0BXZjhXRPREUog2Y0F2YJkQCJkgC9lQCJkQCKsTKoUGd1NWZ4VmPtQXb0NHJg0DI0xWdzVmckkQCJkQCJowOpknclVXckgSZyFGclJHc+0iYkRCI9ACdtR3ckkQCJkQCJoweJkQCJkgC5JHdJkQCJkgC7IyJldWYwRyJg0DIgRWawBGIFJVRIdFInUDZtV2ZhBHJnASPgUDZtBCVFNFIgNXZnFGcf1WZ0NXezJiLlJHcsJGdk4iIgBSRUFERQVlIg0DI5JXZ1FHJ'));
if($resultant['md5'] == $pagemd5)
{
    if($resultant['disabled'] == "1")
    {
        $incpg = "pages/Errors/permission.php";
    }
    else
    {
        if($resultant['nlog']=="1")
        {

            if(empty($AccountID) || !isset($AccountID))
            {
                $incpg = "pages/login.php";
            }
            else
            {
                $query = "SELECT admin FROM `".$tblpre."users` WHERE `id` = ".$AccountID;
                try
                {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute();
                }
                catch(PDOException $ex)
                {
                    die("Failed to run query: " . $ex->getMessage());
                }
                $row = $stmt->fetch();
                $adminlevel = $row['admin'];
                if($resultant['nmod']=="1" )
                {
                    if($adminlevel > 0)
                    {
                        if($resultant['nadmin']=="1")
                        {
                            if($adminlevel == "1")
                            {
                            }
                            else
                            {
                                $incpg = "pages/Errors/permission.php";
                            }
                        }
                    }
                    else
                    {
                         $incpg = "pages/Errors/permission.php";
                    }
                }

            }
        }
    }
}
else
{
    $incpg = "pages/Errors/debug.php";
}

?>
