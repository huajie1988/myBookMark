<?php
$root=$_SERVER['DOCUMENT_ROOT'];
include($root."/classes/dbbasecrud.php");
include($root."/public/common.php");

$userName=$_POST['userName'];
$password=$_POST['password'];

if(isset($_POST['rememberMe'])){
	$time=time()+3600*24*14;
}else{
	$time=time()+3600;
}

if(isset($_POST['is_cookie']) && $_POST['is_cookie']==1){
	$password=$password;
}else{
	$password=md5($password);
}

if(trim($userName)==""){
	error("请填写用户名");
}

if(trim($password)==""){
	error("请填写密码");
}

$mark_user_obj=new dbBaseCRUD("mark_user");
$ret=$mark_user_obj->search("(email='".$userName."' OR username='".$userName."') AND password='".$password."'");
if(!$ret){
	error("用户不存在或用户名与密码不匹配");
}else{
	setcookie("username", $ret[0]['username'], $time,"/");
	setcookie("password", $ret[0]['password'], $time,"/");
	setcookie("status", $ret[0]['status'], $time,"/");
	success("登录成功","/");
}