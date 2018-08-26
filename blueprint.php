<?php
// Get parameters from url
$id = $_GET['id'];
$location = $_GET['location'];

// Get itemname
$blueprints = json_decode(file_get_contents('http://sw-gaming.org/eve-service/blueprints.json'), true);
// add price of all materials
echo "<h2>" . getitemname($id) . "</h2>";
echo "<h3>" . getlocationname($location) . "</h3>";
echo "<table border=1><tr><th>id</th><th>name</th><th>single price</th><th>quantity</th><th>price</th></tr>";
$price = 0;
foreach ($blueprints[$id]["activities"]["manufacturing"]["materials"] as $material) {
	$cur_price = bestprice($material["typeID"], $location);
	$price = $price + $cur_price * $material["quantity"];
	echo "<tr>";
	echo "<td>" . $material["typeID"] . "</td>";
	echo "<td>" . getitemname($material["typeID"]) . "</td>";
	echo "<td>" . $cur_price . "</td>";
	echo "<td>" . $material["quantity"] . "</td>";
	echo "<td>" . $cur_price * $material["quantity"] . "</td>";
	echo "</tr>";
}
echo "</table><br /><b>" . $price . "ISK</b>";


// Determine best price for item
function bestprice($itemid, $locationid) {
	$item_prices = json_decode(file_get_contents('https://esi.tech.ccp.is/latest/markets/' . 
	$locationid . '/orders/?datasource=tranquility&order_type=sell&type_id=' . $itemid), true);
	$bestprice = $item_prices[0];
	foreach ($item_prices as $price) {
	    if ($bestprice["price"] > $price["price"]) {
		$bestprice = $price;
	    }
	}
	return $bestprice["price"];
}

// Get itemname
function getitemname($itemid) {
	$itemnames = file_get_contents('http://sw-gaming.org/eve-service/typeIDs.txt');
	$itemnames = explode("\n", $itemnames);
	foreach ($itemnames as $itemn) {
	    if (explode("\t", $itemn)[0] == $itemid) {
		$itemname = explode("\t", $itemn)[1];
	    }
	}
	return $itemname;
}

// Get location name
function getlocationname ($locationid) {
	$locationnames = file_get_contents('http://sw-gaming.org/eve-service/locations.txt');
	$locationnames = explode("\n", $locationnames);
	foreach ($locationnames as $locationn) {
	    if (explode("\t", $locationn)[0] == $locationid) {
		$locationname = explode("\t", $locationn)[1];
	    }
	}
	return $locationname;
}

?>
