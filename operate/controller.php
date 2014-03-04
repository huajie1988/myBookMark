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

					$filename=$root.$val."/$val2";
					if (file_exists($filename) && $val2!=$filenamenow) {
					    require("$filename");
					}
			}
	}

}
spl_autoload_register('classAutoLoad');
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
				$files[$file] = my_scandir1($dir . "/" . $file);
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

