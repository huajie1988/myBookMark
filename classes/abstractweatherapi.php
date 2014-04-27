<?php
abstract class abstractweatherapi{
	
	private $ipaddr_apiurl="http://int.dpool.sina.com.cn/iplookup/iplookup.php";
/*
 *  备用地址:
 * 		  http://whois.pconline.com.cn/ipJson.jsp
 * 		  http://ip.taobao.com/service/getIpInfo.php
 * 		  http://ip.ws.126.net/ipquery
 *  传递参数均为ip=
 */		
	private $ip;
	
	abstract protected function getAreaCode($area_name);
	abstract protected function getWeather($weather_apiurl);
	
	function __construct($iparr=array()){
		if(is_array($iparr) && !empty($iparr)){
			$param="?";
			foreach ($iparr as $key => $val) {
				$param.="$key=$val&";
			}
			$this->ipaddr_apiurl.=$param;
		}
	}
	
	protected function getIpInfo(){
		$this->ip=$_SERVER["REMOTE_ADDR"];
//		$url = $this->get_ipaddr_apiurl.$this->ip; 
  		$url = trim(trim($this->ipaddr_apiurl,"&"),"=")."="."222.64.104.143";
		$ip_info=$this->getAPIJSON($url);
		if($ip_info->ret!==1){
			common::error("获取IP失败");
		}		
		return $ip_info;	
	}
	
	protected function getAPIJSON($url){
		$ch = curl_init(); 
		$timeout = 5; 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
		$contents = curl_exec($ch); 
		curl_close($ch);
		$obj=json_decode($contents);
		return $obj;
	}
	
	
}
?>
