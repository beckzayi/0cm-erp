<?php
/*
 * SKU query in Jushuitan ERP (聚水潭)
 * Documetation: http://open.jushuitan.com/document/13.html
 */

require __DIR__ . '/../../lib/jushuitan/service.php';
require __DIR__ . '/../../lib/jushuitan/config.php';

$env = require __DIR__ . '/keys.php';

$cfg = new Config($env['sandbox'], $env['partner_id'], $env['partner_key'], $env['token'], $env['taobao_appkey'] = '', $env['taobao_secret'] = '', $env['debug_mode']);

$service = new Service($cfg);

//普通接口调用方式,查询全部店铺信息
$params = array(
    'page_index' => 1,
    'page_size' => 30,
    // 'sku_ids' => '0000032545501',
    'sku_ids' => 'HMC027101B48'
    // 'modified_begin' => '2019-07-26 13:55:06',
    // 'modified_end' => '2019-07-27 15:55:06'
);

$response = $service->sku_query((object)$params); 

print_r('<pre>');
var_dump($response);
print_r('</pre>');
?>