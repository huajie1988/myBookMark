<?php
$root=$_SERVER['DOCUMENT_ROOT'];
include($root."/public/common.php");

$url = $_REQUEST['addUrl']; 
$ch = curl_init(); 
$timeout = 5; 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
//在需要用户检测的网页里需要增加下面两行 
// curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY); 
// curl_setopt($ch, CURLOPT_USERPWD, US_NAME.":".US_PWD); 
$contents = curl_exec($ch); 
curl_close($ch);

if($contents){


	//开始处理

	$charset="UTF-8";
	preg_match('/<meta.+http-equiv="Content-Type"(.*)(charset=[\"|\']?\S*[\"|\']?).+>/i',strtolower($contents),$matches); 

	if(!empty($matches)){
		$tmp_attr=explode("=", $matches[count($matches)-1]);
		$tmp_attr=explode("\"", $tmp_attr[1]);
		$charset=$tmp_attr[0];
	}else{
		preg_match('/<meta.+(charset=[\"|\']?\S*[\"|\']?).+>/i',strtolower($contents),$matches);
		$tmp_attr=explode("=", $matches[count($matches)-1]);
		$tmp_attr=explode("\"", $tmp_attr[1]);
		$charset=$tmp_attr[1];
	}


	$title='';
	// preg_match_all("/<title.*>(.*)<\/title>/i", strtolower($contents), $matches); 

	$tmp_attr=explode("title", $contents);
	$tmp_attr=explode(">", $tmp_attr[1]);
	$tmp_attr=explode("<", $tmp_attr[1]);
	$title=$tmp_attr[0];


	if(trim($title)=="")
		$title=$url;

	preg_match('/<meta.+name="keywords"(.*)(content=[\"|\']?\S*[\"|\']?).+>/i',strtolower($contents),$matches); 
	$keywords="";
	if(!empty($matches)){
		$tmp_attr=str_replace("'","\"",iconv($charset, "UTF-8", $matches[count($matches)-1]));
		$tmp_attr=explode("\"", $tmp_attr);
		$keywords=$tmp_attr[1];

	}
	$data=array('title'=>$title,'keywords'=>$keywords,'url'=>$url);
	success("查找成功",$data);
}else{
	error("查找失败");
}