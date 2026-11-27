<?php namespace App\Services;
class LinkChecker {
 // Only HTTPS public IPv4 destinations; pin resolved address and never follow redirects.
 public function check(string $url):string {
  $p=parse_url($url); if(!$p||($p['scheme']??'')!=='https'||isset($p['user'])||isset($p['pass'])||isset($p['port'])&&$p['port']!==443)return 'unsupported';
  $host=$p['host']??'';if(!preg_match('/^[a-z0-9.-]+$/iD',$host)||!str_contains($host,'.')||filter_var($host,FILTER_VALIDATE_IP))return 'unsupported';
  $ips=gethostbynamel($host);if(!$ips)return 'dns_error';foreach($ips as $ip)if(!filter_var($ip,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4|FILTER_FLAG_NO_PRIV_RANGE|FILTER_FLAG_NO_RES_RANGE)||!filter_var($ip,FILTER_VALIDATE_IP,FILTER_FLAG_GLOBAL_RANGE))return 'blocked';
  $c=curl_init($url);curl_setopt_array($c,[CURLOPT_NOBODY=>true,CURLOPT_RETURNTRANSFER=>true,CURLOPT_FOLLOWLOCATION=>false,CURLOPT_PROTOCOLS=>CURLPROTO_HTTPS,CURLOPT_CONNECTTIMEOUT=>5,CURLOPT_TIMEOUT=>10,CURLOPT_PROXY=>'',CURLOPT_RESOLVE=>[$host.':443:'.$ips[0]],CURLOPT_SSL_VERIFYPEER=>true,CURLOPT_SSL_VERIFYHOST=>2,CURLOPT_USERAGENT=>'OBM-LinkReview/1.0']);$result=curl_exec($c);$code=curl_getinfo($c,CURLINFO_HTTP_CODE);curl_close($c);if($result===false)return 'connection_error';if($code>=200&&$code<300)return 'reachable';if($code>=300&&$code<400)return 'redirect_review';if(in_array($code,[404,410]))return 'not_found';return 'http_'.$code;
 }
}
