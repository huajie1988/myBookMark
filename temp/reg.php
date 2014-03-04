<?php
$root=$_SERVER['DOCUMENT_ROOT'];
include($root."/classes/dbbasecrud.php");
include($root."/public/common.php");
$email=$_POST['email'];
$password=$_POST['password'];
$repassword=$_POST['repassword'];

if(!$email){
	error("请填写邮箱");
}

if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)){
	error("邮箱格式不正确");
}

if(!$password || trim($password)==""){
	error("请填写密码");
}

if($password!=$repassword || trim($repassword)==""){
	error("密码不一致");
}

$mark_user_obj=new dbBaseCRUD("mark_user");
$ret=$mark_user_obj->search("email='".$email."'");
if(!empty($ret)){
	error("此邮箱已注册，请更换邮箱");
}

$data_user=array(
	"username"=>$email,
	"email"=>$email,
	"password"=>md5($password),
	"status"=>1,//未审核用户
	);

$mark_user_obj->add($data_user);

//写入cookie 必须加作用域"/" 2014/02/04 WHJ
setcookie("username", $email, time()+3600,"/");
setcookie("password", md5($password), time()+3600,"/");
setcookie("status", 1, time()+3600,"/");


success("注册成功","/");