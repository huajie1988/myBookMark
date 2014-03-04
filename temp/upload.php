<?php
$root=$_SERVER['DOCUMENT_ROOT'];

if($_FILES["file"]['error']!=0){
	echo "上传失败";
	exit();
}	
if($_FILES["file"]['size']==0 ){
	echo "上传文件为空";
	exit();
}	
if($_FILES["file"]['size']>200000 ){
	echo "上传文件为大于2M"; 
	exit();
}
$fileType=$_FILES["file"]['type'];
if($fileType!='text/html' && $fileType!='text/plain'){
	echo "上传文件类型不正确";
	exit();
}

/*
	暂时设计的为不保存，直接读取上传文件内容 2014/01/29 huajie
*/

if($fileType=='text/html'){

	$fileName=$_FILES["file"]['tmp_name'];
	$handle = fopen($fileName, "r");
	$contents = strtolower(fread($handle, filesize ($fileName)));
	fclose($handle);
	preg_match_all("/<[A|a].*>(.+)<\/[A|a]>/i", $contents, $matches);
	
	if(empty($matches[0])){
		echo "未匹配到标签";
		exit();
	}

	$bookMarks=array();

	foreach ($matches[0] as $key => $val) {
	# code...
		$bookMark=array();
		preg_match('/<a.+(href=[\"|\']?\S*[\"|\']?).+>/i',$val,$matche); 
		$tmp_attr=str_replace("'","\"",$matche[1]);
		$tmp_attr=explode("\"", $tmp_attr);
		$bookMark['url']=$tmp_attr[1];

		preg_match('/<a.+(tags=[\"|\']?\S*[\"|\']?).+>/i',$val,$matche); 
		$tmp_attr=str_replace("'","\"",$matche[1]);
		$tmp_attr=explode("\"", $tmp_attr);
		$bookMark['tags']=$tmp_attr[1];

		preg_match('/>(.+)</i',$val,$matche); 
		$tmp_attr=str_replace("'","\"",$matche[1]);
		$bookMark['title']=$tmp_attr;

		$bookMarks[]=$bookMark;
	}
	include($root."/classes/dbbasecrud.php");
	$mark_url_obj=new dbBaseCRUD("mark_url");
	$mark_tag_obj=new dbBaseCRUD("mark_tag");
	$mark_url_tag_obj=new dbBaseCRUD("mark_url_tag");
	$url_id="";
	$url_id="";
	foreach ($bookMarks as $key => $val) {
		$data_mark_url=array(
				"title"=>$val['title'],
				"url"=>$val['url'],
				"note"=>"书签导入",
				);
		$url_id=$mark_url_obj->add($data_mark_url);
		if(trim($val['tags'])!=""){
			$ret=$mark_tag_obj->search("name LIKE '%".$val['tags']."%'");
			if(empty($ret)){
				$data_mark_tag['name']=$val['tags'];
				$tag_id=$mark_tag_obj->add($data_mark_tag);
			}else{
				$tag_id=$ret[0]['id'];
			}

			$data_mark_tag_url['url_id']=$url_id;
			$data_mark_tag_url['tag_id']=$tag_id;
			$mark_url_tag_obj->add($data_mark_tag_url);
		}	
	}
	echo "导入完毕";	
}
