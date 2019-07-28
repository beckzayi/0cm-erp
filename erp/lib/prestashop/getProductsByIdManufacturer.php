<?php
require_once('../../config/config.inc.php');

$results = Product::getProductsByIdManufacturer($id_lang, $id_manufacturer, $start = 0, $limit = 0, $order_by = "id_product", $order_way = "ASC", false, true);

return $results;
