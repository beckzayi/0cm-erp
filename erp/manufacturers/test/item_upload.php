<?php
/*
 * Query shops in Jushuitan ERP (聚水潭)
 * Documetation: http://open.jushuitan.com/document/14.html
 */

require __DIR__ . '/../../lib/jushuitan/service.php';
require __DIR__ . '/../../lib/jushuitan/config.php';

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
    'sku_code' => '3357672750441', // 国际码
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