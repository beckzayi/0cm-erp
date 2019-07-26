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
$params = (object)array(
    'nicks' => ['qzhihe']
);

$response = $service->shops_query($params); 

print_r('<pre>');
var_dump($response);
print_r('</pre>');
?>