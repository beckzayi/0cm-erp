<?php
interface ErpBaseInterface {
    public function loop_product($products, $shop_id_erp, $id_supplier);
    public function getAllProducts($id_manufacturer, $start, $limit);
    public function getSupplierReference($id_product);
}