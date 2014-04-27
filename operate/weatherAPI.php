<?php
class weatherAPI extends abstractweatherapi{
	private $ip;
		
	function __construct($ipaddr_apiurl=array()){			
  			parent::__construct($ipaddr_apiurl);
	}

	protected function getAreaCode($area_name){
  		$mark_area_obj=new dbBaseCRUD("mark_area");
  		$mark_area=$mark_area_obj->searchone("area_name='$area_name'");
  		return $mark_area;
	}
	
	
	public function getWeather($weather_apiurl){
  		$ip_info=parent::getIpInfo();		
  		if(empty($ip_info->district)){
  			$ret=$this->getAreaCode($ip_info->city);
  		}else{
  			$ret=$this->getAreaCode($ip_info->district);
  		} 		
  		$url=$weather_apiurl.$ret['area_code'].".html";
  		$weather_info=parent::getAPIJSON($url);
		return $weather_info;
	}

}

