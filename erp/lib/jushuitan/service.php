<?php 
include 'rpc_client.php';
class Service {
    private $__client = null;
    public function __construct($cfg, $ts = null) {
        $this->__client = new RpcClient($cfg);
    }

    // 店铺查询  普通接口
    public function shops_query($params = null) {
        if($params == null) {
            $params = (object)array();
        }
        return $this->__client->call('shops.query', $params);
    }

    // 普通商品上传
    public function item_upload($params = null) {
        if($params == null) {
            $params = (object)array();
        }
        return $this->__client->call('item.upload', [$params]);
    }

    // 普通商品查询
    public function sku_query($params = null) {
        if($params == null) {
            $params = (object)array();
        }
        return $this->__client->call('sku.query', $params);
    }

    // 刷新 token - 解决Token已超时
    public function refresh_token() {
        return $this->__client->call('refresh.token', null);
    }
}
?>