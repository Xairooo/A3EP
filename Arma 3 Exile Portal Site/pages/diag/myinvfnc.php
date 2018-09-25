<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
///////////////////////////////////////////////////////////////
//Begin LIST
///////////////////////////////////////////////////////////////
//Assigned Items
$assitem = substr($row[assigned_items], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
foreach($assitemarr as $ai)
{
    if(!$ai == "")
    {
	$string = $ai .",".$string;
    }
}
$assigned_items = explode(",",$string);
//backpacl
$backpack = explode(",",$row['backpack'].',');
//BackPack Items
$assitem = substr($row['backpack_items'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
$string = explode(",", $string);
$string = array_unique($string);
$backpackitems = $string;
//BackPack Magazines
$assitem = substr($row['backpack_magazines'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$backpack_magazines = $string;
//BackPack Weapons
$assitem = substr($row['backpack_weapons'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$backpack_weapons = $string;
//Current Weapons
$current_weapon = explode(",",$row['current_weapon'].',');
//goggles
$goggles = explode(",",$row['goggles'].',');
//Handgun Items
$assitem = substr($row['handgun_items'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$handgun_items = $string;
//HandGun
$handgun_weapon = explode(",",$row['handgun_weapon'].',');
//Headgear
$headgear = explode(",",$row['headgear'].',');
//Binoculars
$binocular = explode(",",$row['binocular'].',');
//Loaded Magazines
$assitem = substr($row['loaded_magazines'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$loaded_magazines = $string;
//Primary Weapon
$primary_weapon = explode(",",$row['primary_weapon'].',');
//Primary Weapon Items
$assitem = substr($row['primary_weapon_items'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$primary_weapon_items = $string;
//Secondary Weapon
$secondary_weapon = explode(",",$row['secondary_weapon'].',');
//Secondary Weapon Items
$assitem = substr($row['secondary_weapon_items'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$secondary_weapon_items = $string;
//Uniform
$uniform = explode(",",$row['uniform'].',');
//Uniform items
$assitem = substr($row['uniform_items'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$uniform_items =$string;
//Uniform mag
$assitem = substr($row['uniform_magazines'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$uniform_magazines = $string;
//Uniform weaoibs
$assitem = substr($row['uniform_weapons'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$uniform_weapons = $string;
//Vests
$vest = explode(",",$row['vest'].',');
//Vest Items
$assitem = substr($row['vest_items'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$vest_items = $string;
//Vest MAg
$assitem = substr($row['vest_magazines'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$vest_magazines =$string;
//Vest Weapons
$assitem = substr($row['vest_weapons'], 1 ,-1);
$assitem = str_replace('"','', $assitem);
$assitem = str_replace('[','', $assitem);
$assitem = str_replace(']','', $assitem);
$assitemarr= explode(",", $assitem);
$string = "";
$arr = array_filter($assitemarr);
$printed = [];
$count_values = array();
foreach($arr as $ai){
$indexes = array_keys($arr, $ai);
$cnt = count($indexes);
	if(strlen ($ai) < 4)
	{
	}
		else{
$name = $ai;
		 $string = $string ."," .$name;
	}
		}
		$string = explode(",", $string);
		$string = array_unique($string);
$vest_weapons = $string;