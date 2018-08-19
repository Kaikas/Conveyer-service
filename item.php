<?php
//header('Content-Type: application/json');

// Get parameters from url
$item = $_GET['item'];
$quantity= $_GET['quantity'];

// Determine best price for item
$item_prices = json_decode(file_get_contents('https://esi.tech.ccp.is/latest/markets/10000002/orders/?datasource=tranquility&order_type=sell&type_id=' . $item), true);
$bestprice = $item_prices[0];
foreach ($item_prices as $price) {
    if ($bestprice["price"] > $price["price"]) {
        $bestprice = $price;
    }
}

// Get itemname
$itemnames = file_get_contents('http://sw-gaming.org/eve-service/typeIDs.txt');
$itemnames_array = explode("\t", $itemnames);

// output
echo $itemnames_array[0][2];
echo $bestprice["price"];

?>
