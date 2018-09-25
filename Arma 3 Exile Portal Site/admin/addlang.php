<?php
require ('header.php');
$query = " LOAD XML local INFILE 'lang.xml' INTO TABLE `".$tblpre."lang_words` (@lang, @wkey, @module, @wdefault, @wdefault) SET lang_id=@lang, word_key=@wkey, word_module=@module, word_default=@wdefault, word_custom=@wdefault; "; try { $stmt = $db->prepare($query);
$result = $stmt->execute(); } catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); } echo $result; ?>
?>