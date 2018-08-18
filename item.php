<?php

$json = file_get_contents('https://esi.tech.ccp.is/latest/markets/10000002/orders/?datasource=tranquility&order_type=sell&type_id=16670');

echo substr($json, 1, -1);

?>
