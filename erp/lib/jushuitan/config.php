<?php
class Config {
    private $__url_map = array(
        "jst"=>null,
        "qm"=>null
    );

    function __construct($sandbox, $partner_id, $partner_key, $token, $taobao_appkey, $taobao_secret, $debug_mode) {
        $this->sandbox = $sandbox;
        $this->partner_id = $partner_id;
        $this->partner_key = $partner_key;
        $this->token = $token;
        $this->taobao_appkey = $taobao_appkey;
        $this->taobao_secret = $taobao_secret;
        $this->debug_mode = $debug_mode;
    }

    public function get_request_url(){
        if($this->sandbox) {
            $this->__url_map["jst"] = "http://c.sursung.com/api/open/query.aspx";
        }
        else {
            $this->__url_map["jst"] = "http://open.erp321.com/api/open/query.aspx";
        }

        return $this->__url_map;
    }
}
?>