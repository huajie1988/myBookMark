<?php
$root=$_SERVER['DOCUMENT_ROOT'];
include($root."/classes/dbbasecrud.php");
include($root."/public/common.php");

$where="";

if(isset($_POST['where']) && trim($_POST['where'])!=""){
	$where=" AND ".$_POST['where'];
}

$userName=$_COOKIE['username'];

if(!$userName || trim($userName)==""){
	error("请先登录") ;
}

$mark_user_obj=new dbBaseCRUD("mark_user");
$ret=$mark_user_obj->searchone("(email='".$userName."' OR username='".$userName."')");

if(empty($ret))
{
	error("用户不存在") ;
}

$mark_url_obj=new dbBaseCRUD("mark_url AS a");
$join="LEFT JOIN mark_url_tag AS c ON c.url_id=a.id LEFT JOIN mark_tag AS b ON b.id=c.tag_id";
$ret=$mark_url_obj->search("user_id=".$ret['id'].$where,"a.*,b.name as tags","all",$join);
foreach ($ret as $key => $val) {
	if( isset($ret[$key+1]) && ($ret[$key+1]['id']==$ret[$key]['id'])){
		$ret[$key]['tags'].=",".$ret[$key+1]['tags'];
		array_remove($ret,$key+1);
	}	
}
success("查询成功",$ret);
// print_r($ret);exit();