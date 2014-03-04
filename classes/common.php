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
}
