<?php
//header('Content-Type: application/json');

// Get parameters from url
$item = $_GET['item'];
$location = $_GET['location'];

// Determine best price for item
$item_prices = json_decode(file_get_contents('https://esi.tech.ccp.is/latest/markets/' . 
$location . '/orders/?datasource=tranquility&order_type=sell&type_id=' . $item), true);
$bestprice = $item_prices[0];
foreach ($item_prices as $price) {
    if ($bestprice["price"] > $price["price"]) {
        $bestprice = $price;
    }
}

// Get itemname
$itemnames = file_get_contents('http://sw-gaming.org/eve-service/typeIDs.txt');
$itemnames = explode("\n", $itemnames);
foreach ($itemnames as $itemn) {
    if (explode("\t", $itemn)[0] == $item) {
        $itemname = explode("\t", $itemn)[1];
    }
}

// output
echo $itemname . ' ' . $bestprice["price"];

?>
