<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
    if(!empty($AccountID) || isset($AccountID))
    {
        header("Location: ?page=dashboard");
        exit;
    } else {
        header("Location: ?page=login&signup");
        exit;
    }

?>
