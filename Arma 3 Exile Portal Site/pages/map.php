<?php if(!isset($include)){die("INVALID REQUEST");} ?>
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js" integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log==" crossorigin=""></script>
	<script src="./library/leaflet/leaflet.rotatedMarker.js"></script>
<?php
$map = $settingClass->GetMap();
$mapsize = $settingClass->GetSize();
$markerList= $settingClass->GetMapMarkers();
$showbases 		= 1; // 1 for yes, 0 for no
$showmarkers 	= 1;
$showplayers 	= 1;
// Get Data From Accounts Table 	- Main Map
$sql = "SELECT `uid`, `name` FROM `account` WHERE `last_connect_at` > `last_disconnect_at` OR `last_disconnect_at` IS NULL AND `last_connect_at` > SUBDATE( timestamp(now()), INTERVAL 3 HOUR) ORDER BY `score`";
try {
    $stmt1 = $dbo->prepare($sql);
    $stmt1->execute();
    }
catch (PDOException $e) {
    print $e->getMessage();
  }
// Get Data From Territory Table 	- Base Map
$sql = "SELECT `owner_uid`, `name`, `position_x`, `position_y`, `flag_stolen` FROM `territory` WHERE `deleted_at` IS NULL";
try {
    $stmt2 = $dbo->prepare($sql);
	$stmt2->execute();
    }
    catch (PDOException $e) {
    print $e->getMessage();
  }
// Get Data From Player_History 	- Player Map
$sql = "SELECT `position_x`, `position_y`, `direction`, `name`, `damage`, `account_uid` FROM `player`";
try {
    $stmt4 = $dbo->prepare($sql);
    $stmt4->execute();
    }
catch (PDOException $e) {
    print $e->getMessage();
  }

$markers[] = "";
$online[] = "";

if ($showplayers > 0) { // Players On Map
	$x = 1;
	$dire = "";
	$posx = "";
	$posy = "";

	while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
		$online[] = $row1['uid'];
	}
	while ($row2 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
		if (in_array($row2['account_uid'], $online)) {
			$posx = $row2['position_x'];
			$posy = $row2['position_y'];
			$dire = $row2['direction'];
			$players[] = "var player_".$x." =	L.marker([$posy,$posx],{icon: thePlayer, zIndexOffset: 110}).bindPopup('Name: ".$row2['name']."').addTo(player),
			direct_".$x." =	L.marker([$posy,$posx],{icon: DirePoint, zIndexOffset: 105, rotationAngle: ".$dire."}).addTo(player);";
			$x = $x + 1;
		}
	}
}
if ($showbases > 0) { // Bases On Map
	$x = 1;
	$posx = "";
	$posy = "";
	while ($row1 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
		$sql = "SELECT `uid`, `name` FROM `account` WHERE `uid` = ".$row1['owner_uid'];
		$flagdown = 0;
		if ($row1['flag_stolen'] == 1)
		$flagdown = 90;
		try {
    $stmts = $dbo->prepare($sql);
   $stmts->execute();
    }
    catch (PDOException $e) {
    print $e->getMessage();
  }
	while ($row2 = $stmts->fetch(PDO::FETCH_ASSOC)) {
			$posx = $row1['position_x'];
			$posy = $row1['position_y'];
			$bases[]="var base_".$x." = L.marker([$posy,$posx],{icon: theBase, zIndexOffset: 101, rotationAngle: ".$flagdown."}).bindPopup('".$row1['name']."').addTo(bases);";
		}
		$x = $x + 1;
	}
}
if ($showmarkers > 0) { // Markers On Map;
foreach ($markerList as $markername)
{
	$query = "SELECT Name,Loc,radius FROM ".$tblpre."mapmarkers WHERE `class` = '".$markername."' AND `map`='".$map."';";
	try
	{
		$stmt = $db->prepare($query);
		$result = $stmt->execute();
	}
	catch(PDOException $ex)
	{
    	die("Failed to run query: " . $ex->getMessage());
	}
	$count = $stmt->rowCount();
	$dbMarkerInfo = $stmt->fetch();
	if($count > 0)
	{
		$markertext = $dbMarkerInfo["Name"];
		$markerLocation = explode(",",$dbMarkerInfo["Loc"]);
		$markerradius = explode(",",$dbMarkerInfo["radius"]);
	}
	else
	{
		if(strpos($markername, 'SC_loot') === false)
			{
					if(strpos($markername, 'Icon') === false)
	{
							if(strpos($markername, 'ZCP') === false)
							{
	if(strpos($markername, 'DMS') === false)
							{
			$markerLocation = $settingClass->GetMarkerLocation($markername);
			$markertext = $settingClass->GetMarkerText($markername);
				if(!$markertext == "")

							{
			$markerradius = $settingClass->GetMarkerRadius($markername);
			if($makerradius == "")
			{
				$markerradius = "";
			}
			$markerradius = explode(",",$markerradius);
			$location = implode(",",$markerLocation);
			$query = "INSERT INTO ".$tblpre."mapmarkers (Name,class,Loc,map,radius) VALUES ('".$markertext."','".$markername."','".$location."','".$map."','".$markerradius."');";
    		try
    		{
        		$stmt = $db->prepare($query);
	    		$result = $stmt->execute();
    		}
    		catch(PDOException $ex)
    		{
    			die("Failed to run query: " . $ex->getMessage());
    		}
							}
							}
							}

		}
	}
	}
	$mlocy = $markerLocation[0];
	$mlocx = $markerLocation[1];
	if(strpos($markername, 'Spawn') !== false)
	{
	if(strpos($markername, 'Icon') === false)
	{
		$spawns[]="var $markername = L.marker([$mlocx,$mlocy],{icon: SpawnPoint, zIndexOffset: 99}).bindPopup('$markertext').addTo(spawns)
	L.circle([$mlocx,$mlocy], {radius: ".$markerradius[0].",color:'#0d0d0d',fillColor:'#d9d9d9'}).addTo(spawns);";

	}
	}
	if(strpos($markername, 'Trader') !== false)
	{
	if(strpos($markername, 'Icon') === false)
	{
		$traders[]="var $markername = L.marker([$mlocx,$mlocy],{icon: Trader, zIndexOffset: 99}).bindPopup('$markertext').addTo(traders);";
	}
	}

}
}
?>
	<style>
	#map {
		max-width: 1180px;
		max-height: 700px;
	}
	</style>
   <div class="container">
<div id='map'></div>
</div>
<script>
	var spawns = L.layerGroup();
	var traders = L.layerGroup();
	var bases = L.layerGroup();
	var player = L.layerGroup();
	var thePlayer  	= L.icon({ iconUrl: './images/icons/player.png', 		iconSize: [16, 16], iconAnchor: [8, 8] });
	var SpawnPoint 	= L.icon({ iconUrl: './images/icons/spawn.png', 		iconSize: [16, 16], iconAnchor: [8, 8] });
    var contaZone 	= L.icon({ iconUrl: './images/icons/biohaz.png', 		iconSize: [16, 16], iconAnchor: [8, 8] });
	var mixerPoint 	= L.icon({ iconUrl: './images/icons/mixer.png', 		iconSize: [16, 16], iconAnchor: [8, 8] });
	var specOps 	= L.icon({ iconUrl: './images/icons/specops.png', 	iconSize: [16, 16], iconAnchor: [8, 8] });
	var Trader 		= L.icon({ iconUrl: './images/icons/trader.png', 		iconSize: [16, 16], iconAnchor: [8, 8] });
	var airTrader 	= L.icon({ iconUrl: './images/icons/airport.png', 	iconSize: [16, 16], iconAnchor: [8, 8] });
	var DirePoint 	= L.icon({ iconUrl: './images/icons/direction.png', 	iconSize: [40, 40], iconAnchor: [20, 20] });
	var theBase 	= L.icon({ iconUrl: './images/icons/baseflag.png',	iconSize: [16, 16], iconAnchor: [8, 8] });

	<?php
	/////////////////////////////////////
	// -- Do not edit below this line! --
	foreach ($spawns as $spawn) {
		echo $spawn;
	}
	foreach ($traders as $trader) {
        echo $trader;
    }
    foreach ($bases as $base) {
        echo $base;
    }
    foreach ($players as $player) {
        echo $player;
    }
	// -- Do not edit above this line! --
	/////////////////////////////////////
	?>
	var yx = L.latLng;
	var xy = function(x, y) {
		if (L.Util.isArray(x)) {
			return yx(x[1], x[0]);
		}
		return yx(y, x);
	};
	var bounds = [xy(0, 0), xy(<?php echo $mapsize;?>, <?php echo $mapsize;?>)]; // this is map size

	var image = L.imageOverlay('./images/maps/<?php echo $map; ?>.jpg', bounds);
	var imagep = L.imageOverlay('./images/maps/<?php echo $map; ?>-sat.jpg', bounds);
var map = L.map('map', {
		crs: L.CRS.Simple,
		center: [<?php echo $mapsize /2;?>, <?php echo $mapsize /2;?>],
		zoom: -4.5,
		minZoom: -4.5,
		maxZoom: -1.5,
		maxBounds: L.latLngBounds(bounds),
		layers: [image, spawns, traders, mixers, contaZoned, bases, player]
	});
	var baseMaps = {
    "Map": image,
    "Sat": imagep
};
var overlayMaps = {
    "Spawn": spawns,
    "Traders": traders,
    "Mixers": mixers,
    "Contaminated Zone": contaZoned,
    "Bases": bases,
    "Player": player
};
map.attributionControl.setPrefix(false);
L.control.attribution({prefix: '<a href="https:/\/\a3exileportal.com" target="_blank">© A3ExilePortal 2017-2018</a>'}).addTo(map);
L.control.layers(baseMaps, overlayMaps).addTo(map);


$(window).on("resize", function() {
    $("#map").height($(window).height()).width($(window).width());
    map.invalidateSize();
}).trigger("resize");


</script>
</div>