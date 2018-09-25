<?php
require "config.php";
require "init.php";
$host = $INFO["sql_host"];
$port = $INFO["sql_port"];
$username = $INFO["sql_user"];
  $password = $INFO["sql_pass"];
  $dbname = $INFO["sql_database"];
  $tblpre = $INFO["sql_tbl_prefix"];
  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

  try
  {
    $db = new PDO("mysql:host={$host};port={$port};charset=utf8", $username, $password, $options);
  }
 catch(PDOException $ex)
  {
    $message = $ex->getMessage();
    include("error.php");
    die();
  }
  $query = "CREATE DATABASE IF NOT EXISTS ". $dbname .";";
  try
  {   $stmt = $db->prepare($query);
    $result = $stmt->execute();
  }
  catch(PDOException $ex)
  {
    die("Failed to run query: " . $ex->getMessage());
  }

  $db->exec("USE {$dbname}");

  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  if(function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())
  {
    function undo_magic_quotes_gpc(&$array)
    {
      foreach($array as &$value)
      {
        if(is_array($value))
        {
          undo_magic_quotes_gpc($value);
        }
        else
        {
          $value = strlashes($value);
        }
      }
    }

    undo_magic_quotes_gpc($_POST);
    undo_magic_quotes_gpc($_GET);
    undo_magic_quotes_gpc($_COOKIE);
  }

  FUNCTION br2nl($string){
    RETURN PREG_REPLACE("#<br\s*?/?>
#i", "\n", $string); } header("Content-Type: text/html; charset=utf-8");
;
