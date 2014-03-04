<?php
/**
* @author Huajie1988
* @copyright (c) 2014 Huajie.php
* @date 2014-03-03
* @version 0.1
* @use $args=array("content"=>"112","logName"=>"qqq","path"=>$_SERVER['DOCUMENT_ROOT']."/");
*	   log::createLog($args);
*
*/
class log{

/*	private $path;

	function __construct($path='./')
	{
		$this->path=$path;
	}

	public static function setPath($path='./'){
		$this->path=$path;
	}

	public static function getPath(){
		return $this->path;
	}*/

	private static function createDir($dirPath){
		if (!file_exists($dirPath)){
			try {
				mkdir ($dirPath);
			} catch (Exception $e) {
				return $e->getMessage();
			}
		}
		return true;
	}

	private static function writeLog($content,$fileName,$filePath,$needTime,$needServer)
	{
		date_default_timezone_set('Asia/Shanghai');
		if($needTime){
			$fileName.="_".date("Y_m_d",time()).".log";
		}

		$filePath.=$fileName;
		$header="\n===============================================\n";
		$header.="错误信息：\n\t发生时间".date("Y-m-d H:i:s",time());

		$serverInfo="";
		if($needServer){
			$serverInfo="\n\t主机信息\n";
			foreach ($_SERVER as $key => $val) {
				$serverInfo.="\t\t".$key."=>".$val."\n";
			}			
		}

		$header.=$serverInfo."\n===============================================\n";
		$content=$header.$content;
		return file_put_contents($filePath,$content,FILE_APPEND|LOCK_EX);

	}

	public static function createLog($args=array()){
		$content="";
		$logType="error";
		$logName="";
		$path="./";
		$logDirName="errDir";
		$needTime=true;
		$needServer=false;

		if(!empty($args)){
			foreach ($args as $key => $val) {
				$$key=$val;
			}
		}


		if(trim($logName)==""){
			$logName=$logType."Log";
		}

		$logDirPath=trim($path,"/")."/".$logDirName;
		$ret=self::createDir($logDirPath);
		if($ret!==true){
			echo $ret;
			exit();
		}
		$logDirPath.="/";
		$ret=self::writeLog($content,$logName,$logDirPath,$needTime,$needServer);

		if($ret===false){
			echo "创建日志文件失败";
			exit();
		}

		return true;

	}

}
