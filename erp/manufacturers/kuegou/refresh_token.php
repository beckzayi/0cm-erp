<?php
/*
 * Refresh token in Jushuitan ERP (聚水潭)
 * Documetation: http://open.jushuitan.com/document/2135.html
 */

require __DIR__ . '/../../lib/jushuitan/service.php';
require __DIR__ . '/../../lib/jushuitan/config.php';

$env = require __DIR__ . '/keys.php';

$cfg = new Config($env['sandbox'], $env['partner_id'], $env['partner_key'], $env['token'], $env['taobao_appkey'] = '', $env['taobao_secret'] = '', $env['debug_mode']);

$service = new Service($cfg);

$response = $service->refresh_token(); 

print_r('<pre>');
var_dump($response);
print_r('</pre>');
