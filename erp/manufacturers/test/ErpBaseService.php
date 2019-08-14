<?php
require __DIR__ . '/ErpBaseInterface.php';
require_once('../../config/config.inc.php');

class ErpBaseService implements ErpBaseInterface {
    private $id_manfaucturer;
    private $id_supplier;
    private $shop_id_erp; // Ask the manufacturer
    private $id_lang;
    private $products; // Products of this manufacturer

    public function construct($id_manfaucturer, $id_supplier, $shop_id_erp) {
        $this->id_manfaucturer = $id_manfaucturer;
        $this->id_supplier = $id_supplier;
        $this->shop_id_erp = $shop_id_erp;

        // Init
        $this->init();
    }

    public function init() {
        $this->id_lang = $this->getLanguageId();
        $this->products = $this->getAllProducts($this->id_manufacturer);
    }

    public function getAllProducts($id_manufacturer, $start = 0, $limit = 0) {
        $id_lang = $this->id_lang;
        $results = Product::getProductsByIdManufacturer($id_lang, $id_manufacturer, $start, $limit, $order_by = "id_product", $order_way = "ASC", false, true);
        return $results;
    }

    public function getSupplierReference($id_product) {
        $id_lang = $this->id_lang;
        $product = new Product($id_product, false, $id_lang);
        $attributes = Product::getProductAttributesIds($id_product);
        
        $supplier_reference = "";
        foreach ($attributes as $attribute) {
            $id_product_attribute = $attribute["id_product_attribute"];
            $supplier_reference = ProductSupplier::getProductSupplierReference($id_product, $id_product_attribute, $this->id_supplier);
            if (!empty($supplier_reference)) {
                return $supplier_reference;
            }
        }

        if (empty($supplier_reference))
            return false;
    }

    public function getLanguageId() {
        $context = Context::getContext();
        $id_lang = $context->language->id;
        return $id_lang;
    }
}