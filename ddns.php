<?php
function mycurl($url, $type = 'GET', $data = null){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL            , $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER , true);
	if($type != 'GET'){
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST , false);
	curl_setopt($curl, CURLOPT_ENCODING       , 'gzip,deflate');
	$res  = curl_exec($curl);
	curl_close($curl);
	return $res;
}
//cmd run
//php_path\php.exe -f "file_path\ddns.php"
define('LOGIN_TOKEN','API ID,API TOKEN' );
define('DOMAIN','you domain,example:abc.com' );
define('SUB_DOMAIN','you sub domain,example:www' );
define('IP_SERVER','ip.cip.cc');


//current ip
$current_ip = mycurl(IP_SERVER);

$domain_post_data = array(
	"login_token"=>LOGIN_TOKEN,
	"domain"=>DOMAIN,
	"sub_domain"=>SUB_DOMAIN,
	"format"=>"json"
);
$domains_info = mycurl('https://dnsapi.cn/Record.List','POST',$domain_post_data);
$domains_info = json_decode($domains_info,true);
$old_ip = $domains_info['records'][0]['value'];
$record_id = $domains_info['records'][0]['id'];

$new_domain_post_data = array(
	"login_token"=>LOGIN_TOKEN,
	"domain"=>DOMAIN,
	"record_id"=>$record_id,
	"sub_domain"=>SUB_DOMAIN,
	"value"=>$current_ip,
	"record_type"=>'A',
	"record_line"=>'默认',
	"format"=>"json"
);
if ($current_ip != $old_ip){
	$domains_info = mycurl('https://dnsapi.cn/Record.Modify','POST',$new_domain_post_data);
	//print_r($domains_info);
}
?>
