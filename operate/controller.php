<?php

$class=$_REQUEST['class'];
$func=$_REQUEST['func'];
$args=$_REQUEST;

function classAutoLoad(){
	$root=$_SERVER['DOCUMENT_ROOT'];
	$config=include($root."/config.php");
	$class_path=$config['class_path_auto'];
	foreach ($class_path as $key => $val) {
			$filenamenow=substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 );
			foreach (my_scandir($root.$val) as $key2 => $val2) {
					if(!is_array($val2)){
						$filename=$root.$val."/$val2";
						if (file_exists($filename) && $val2!=$filenamenow) {
						    require("$filename");
						}
					}else{
						//暂时不准备将操作类里面添加其他辅助类，可以将需要的类放在classes里面
						// 20140311 Huajie
					}
			}
	}

}
spl_autoload_register('classAutoLoad');
date_default_timezone_set('Asia/Shanghai');
function my_scandir($dir)
{
	$files = array();
	$dir_list = scandir($dir);
	foreach($dir_list as $file)
	{
		if ( $file != ".." && $file != "." ) 
		{
			if ( is_dir($dir . "/" . $file) ) 
			{
				$files[$file] = my_scandir($dir . "/" . $file);
			}
			else 
			{
				$files[] = $file;
			}
		}
	}
	
	return $files;
}

if(trim($class)==""){
	return false;	
}

if(trim($func)==""){
	return false;	
}

$obj=new $class();
$obj->$func($args);

