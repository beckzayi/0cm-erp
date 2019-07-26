<?php
class RpcClient {
  public function __construct($cfg, $ts = null) {
      $this->config = $cfg;
      $this->ts = $ts;
  }

  // Call an API method with parameters
  public function call($action, $parameters) {
    $system_params = $this->get_system_params($action, $parameters);
    
    $request_url = $this->get_request_url($system_params);
    
    $result = $this->post($request_url, $parameters, $system_params, $action);
    
    return $result;
  }

  public function get_request_url($params = null) {
    $url_map = $this->config->get_request_url();
    
    return $url_map['jst'];
  }

  public function get_system_params($action, $params, $sys_params = []) {
    # 默认系统参数
    $system_params = array(
      'partnerid' => $this->config->partner_id,
      'token' => $this->config->token,
      'method' => $action,
      'ts' => time()
    );
    
    return $this->generate_signature($system_params, $params);
  }

  //计算验签
  public function generate_signature($system_params, $params = null) {
    $sign_str = '';
    ksort($system_params);
    
    $no_exists_array = array('method',' sign', 'partnerid', 'partnerkey');
    
    $sign_str = $system_params['method'].$system_params['partnerid'];

    foreach($system_params as $key=>$value) {  
      if(in_array($key,$no_exists_array)) {
        continue;
      }
      $sign_str.=$key.strval($value); 
    }

    $sign_str.=$this->config->partner_key;

    if($this->config->debug_mode) {
      echo '计算sign源串'.$sign_str;
    }

    $system_params['sign'] = md5($sign_str);

    return $system_params;
  }

  //发送请求
  public function post($url, $data, $url_params, $action) {
    $post_data = '';
    try {
      $post_data = json_encode($data);
      $url .='?'.http_build_query($url_params);
      if($this->config->debug_mode) echo $url;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded'
      ));

      $result = curl_exec($ch);
      if (curl_errno($ch)) {
        print curl_error($ch);
      }
      curl_close($ch);
      return json_decode($result,true);
    } catch(Exception $e) {
      return null;
    }
  }
}
?>