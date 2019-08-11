<?php
/*
 * Query shops in Jushuitan ERP (聚水潭)
 * Documetation: http://open.jushuitan.com/document/14.html
 */

require __DIR__ . '/../../lib/jushuitan/service.php';
require __DIR__ . '/../../lib/jushuitan/config.php';

require_once('../../config/config.inc.php');

$env = require __DIR__ . '/keys.php';

$cfg = new Config($env['sandbox'], $env['partner_id'], $env['partner_key'], $env['token'], $env['taobao_appkey'] = '', $env['taobao_secret'] = '', $env['debug_mode']);

$service = new Service($cfg);

//普通接口调用方式,查询全部店铺信息
$params = array(
    'shop_id' => 10039801,
    'name' => 'KUEGOU Classic Crew-Neck Grey Knit (AZ-14012)',
    'sale_price' => null,
    'enabled' => 1,
    'brand_name' => 'Kuegou 酷衣购',
    'i_id' => 'AZ-14012', // $supplier_reference
    'shop_i_id' => 'AZ-14012', // $supplier_reference
    // 'skus' => array(
    //     {
    //         'sku_id': 'AZ-14012C02', // $sku
    //         'shop_sku_id': 'AZ-14012C02', // $sku
    //         'name' => 'KUEGOU Classic Crew-Neck Grey Knit (AZ-14012)',
    //         'sale_price': null,
    //         'enabled': 1,
    //         'brand_name': 'Kuegou 酷衣购',
    //         'sku_code': '3357672750441', // 国际码
    //         'color': null,
    //         'properties_name': null,
    //         'properties_value': null,
    //         'pic': null,
    //         'pic_big': null,
    //         'weight': 0,
    //         'short_name': '1'
    //     }
    // )
);

$params['skus'][] = array(
    'sku_id' => 'AZ-14012C02', // $sku
    'shop_sku_id' => 'AZ-14012C02', // $sku
    'name' => 'KUEGOU Classic Crew-Neck Grey Knit (AZ-14012)',
    'sku_code' => '3357672750441', // 国际码 EAN-13
    'sale_price' => null,
    'enabled' => 1,
    'brand_name' => 'Kuegou 酷衣购',
    'color' => null,
    'properties_name' => null,
    'properties_value' => null,
    'pic' => null,
    'pic_big' => null,
    'weight' => 0,
    'short_name' => '1'
);

$params['skus'][] = array(
    'sku_id' => 'AZ-14012C03', // $sku
    'shop_sku_id' => 'AZ-14012C03', // $sku
    'name' => 'KUEGOU Classic Crew-Neck Grey Knit (AZ-14012)',
    'sale_price' => null,
    'enabled' => 1,
    'brand_name' => 'Kuegou 酷衣购',
    'sku_code' => '3846426917563', // 国际码
    'color' => null,
    'properties_name' => null,
    'properties_value' => null,
    'pic' => null,
    'pic_big' => null,
    'weight' => 0,
    'short_name' => '1'
);

print_r('<pre>'); print_r((object)$params); print_r('</pre>');

$response = $service->item_upload((object)$params); 

print_r('<pre>');
var_dump($response);
print_r('</pre>');
?>

<?php
/*
 * Upload a single item to ERP
*/
function item_upload($params, $service) {
    $response = $service->item_upload((object)$params); 
    return $response;
}

/*
 * Loop the products. When looping, upload invidual product to ERP
*/
function loop_products($products, $shop_id_erp = 10039801, $id_supplier = 9) {
    $cfg = new Config($env['sandbox'], $env['partner_id'], $env['partner_key'], $env['token'], $env['taobao_appkey'] = '', $env['taobao_secret'] = '', $env['debug_mode']);
    $service = new Service($cfg);

    foreach($products as $row) {
        $params = array(
            'shop_id' => $shop_id_erp,
            'name' => $row['name'],
            'sale_price' => null,
            'enabled' => 1,
            'brand_name' => 'Kuegou 酷衣购',
            'i_id' => 'AZ-14012', // $supplier_reference
            'shop_i_id' => 'AZ-14012',
        );

        $id_product = $row['id_product'];

        $supplier_reference = getSupplierReference($id_product, $id_supplier);

        $params['i_id'] = $supplier_reference;
        $params['shop_i_id'] = $supplier_reference;

        $attributes = Product::getProductAttributesIds($id_product);
        foreach ($attributes as $attribute) {
            $id_product_attribute = $attribute["id_product_attribute"];
            $combination = new Combination($id_product_attribute);
            $sku = $combination->reference;

            $params['skus'][] = array(
                'sku_id' => $sku,
                'shop_sku_id' => $sku,
                'name' => $row['name'],
                'sale_price' => null,
                'enabled' => 1,
				'brand_name' => 'Kuegou 酷衣购',
                'sku_code' => '3846426917563', // 国际码
                'color' => null,
                'properties_name' => null,
                'properties_value' => null,
                'pic' => null,
                'pic_big' => null
            );
        }

        $response = item_upload($params, $service);

        log($response, $row['id_product']);

        sleep(2);
    }
}

/*
 * Get a list of products from the manufacturer
*/
function getAllProducts($id_manfaucturer, $start = 0, $limit = 0) {
    $id_lang = getLanguageId();
    // Retrieve all products
    $results = Product::getProductsByIdManufacturer($id_lang, $id_manufacturer, $start, $limit, $order_by = "id_product", $order_way = "ASC", false, true);
    return $results;
}

/*
 * Get supplier reference (商品编码)
*/
function getSupplierReference($id_product, $id_supplier) {
    $id_lang = getLanguageId();
    $product = new Product($id_product, false, $id_lang);
    $attributes = Product::getProductAttributesIds($id_product);
    
    $supplier_reference = "";
    foreach ($attributes as $attribute) {
        $id_product_attribute = $attribute["id_product_attribute"];
        $supplier_reference = ProductSupplier::getProductSupplierReference($id_product, $id_product_attribute, $id_supplier);
        if (!empty($supplier_reference)) {
            return $supplier_reference;
        }
    }

    if (empty($supplier_reference))
        return false;
}

/*
 * Get id_lang from context
*/
function getLanguageId() {
    // Get context
    $context = Context::getContext();
    // Get language id
    $id_lang = $context->language->id;
    return $id_lang;
}

/*
* Log
*/
function logUpload($response, $id_product) {
    $array_response = json_decode($response, true);
    $fileLogger = new FileLogger(); // Log - init
    $fileLogger->setFilename(dirname(__FILE__) . "/item_upload.log");
    if ($array_response['issuccess']) {
        $fileLogger->logInfo("Success: " . $id_product);
    } else {
        $fileLogger->logWarning("Fail to upload: " . $id_product);
    }
}


?>
