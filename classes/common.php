<?php
/**
* 
*/
class common 
{
	
	function __construct()
	{
		# code...
	}

	public static function is_array_null($value) 
	{ 
		if (empty($value)) 
		{ 
			return $value; 
		} else 
		{ 
			return is_array($value) ? array_map('is_array_null', $value) : addslashes($value); 
		} 
	}

	public static function error($msg,$data="",$url="."){
		$data=array(
				"status"=>1,
				"msg"=>$msg,
				"url"=>$url,
				"data"=>$data,
			);
		echo json_encode($data);
		exit();
	}

	public static function success($msg,$data="",$url="."){
		$data=array(
				"status"=>0,
				"msg"=>$msg,
				"url"=>$url,
				"data"=>$data,
			);
		// print_r(json_encode($data));
		echo json_encode($data);
		exit();
	}

	public static function array_remove(&$arr, $offset) 
	{ 
		array_splice($arr, $offset, 1); 
	}
	
	public static function pt($v){
		echo "<pre>";
		print_r($v);
		echo "<pre>";
		exit;
	}
	
	public static function createDir($dirPath){
		if (!file_exists($dirPath)){
			try {
				mkdir ($dirPath);
			} catch (Exception $e) {
				return $e->getMessage();
			}
		}
		return true;
	}
	
	public static function download($file,$fileNmae){
		
		if (!file_exists($file)){
			header("Content-type: text/html; charset=utf-8");
			echo "File not found!";
			exit; 
		} else {		 
			header("Content-type: application/octet-stream");
		    header('Content-Disposition: attachment; filename="' . $fileNmae . '"');
		    header("Content-Length: ". filesize($file));
		    readfile($file);
		}
	}
	 
}
