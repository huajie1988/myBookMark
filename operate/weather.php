<?php
class weather{
	
	function __construct(){
		
	}
	
	public function run(){
		$weather_apiurl="http://www.weather.com.cn/data/cityinfo/";
		$weather_apiurl_now="http://www.weather.com.cn/data/sk/";
		$weather_apiphotourl="http://m.weather.com.cn/img/";
		
		$ipaddr_apiurl=array("format"=>"json","ip"=>"");
		$weather=new weatherAPI($ipaddr_apiurl);		
		$weather_all=$weather->getWeather($weather_apiurl)->weatherinfo;
		$weather_now=$weather->getWeather($weather_apiurl_now)->weatherinfo;
		
		$weather_info=array();
		$weather_info['city']		=	$weather_all->city;
		$weather_info['minTemp']	=	min($weather_all->temp1,$weather_all->temp2);
		$weather_info['maxTemp']	=	max($weather_all->temp1,$weather_all->temp2);
		$weather_info['nowTemp']	=	$weather_now->temp;
		$weather_info['weather']	=	$weather_all->weather;
		$weather_info['windDir']	=	$weather_now->WD;
		$weather_info['windPow']	=	$weather_now->WS;
		$weather_info['humidity']	=	$weather_now->SD;
		$weather_info['dayImg']		=	$weather_apiphotourl.(strstr($weather_all->img2,"d")?$weather_all->img2:$weather_all->img1);
		$weather_info['nightImg']	=	$weather_apiphotourl.(strstr($weather_all->img2,"d")?$weather_all->img1:$weather_all->img2);
		common::success("查询成功",$weather_info);
	}
	
}
?>
