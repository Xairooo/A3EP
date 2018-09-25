<?php
if ($defaultConstants['COOKIE_PATH']== NULL)
{
  $path = "/";
} else
{
  $path = $defaultConstants['COOKIE_PATH'];
}
setcookie('a3ep_sessionid', $sid, -1, $path);
header("location: ?page=main");
?>