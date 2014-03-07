<?php
/**
* 
*/

class dbBaseCRUD
{
	private $dbh;
	private $table;
	function __construct($table,$ATTR_PERSISTENT=true)
	{
		# code...
		$root=$_SERVER['DOCUMENT_ROOT'];
		$dbinfo=include($root."/config.php");
		$dsn=$dbinfo['dbtype'].":dbname=".$dbinfo['dbname'].";host=".$dbinfo['dbhost'].";";//charset=utf-8会链接错误，原因在查Huajie 2014/03/05
		try {
			$this->dbh = new PDO($dsn, $dbinfo['dbuser'], $dbinfo['dbpasswd'], array(PDO::ATTR_PERSISTENT => $ATTR_PERSISTENT));	
			$this->dbh->query('set names utf8;');
			$this->table=$table;
			return $this->dbh;
		} catch (PDOException $e) {
		    die ("Error!: " . $e->getMessage() . "<br/>");
		}
	}

	public function search($where,$col="*",$limit=500,$join="",$having="",$group="",$order=""){
		
		if(trim($where)==""){
			echo "搜索条件不能为空";
		}
		if(is_array($col)){
			$col=implode(",", $col);
		}

		$SQL="select $col FROM ".$this->table." $join WHERE $where";
		// print_r($SQL);exit();
		if(trim($having)!=""){
			$SQL.=" HAVING $having";
		}

		if(trim($group)!=""){
			$SQL.=" GROUP BY $group";
		}

		if(trim($order)!=""){
			$SQL.=" ORDER BY $order";
		}
		if($limit!="all"){
			$SQL.=" LIMIT ".$limit;
		}
		$rs=$this->dbh->query($SQL);
		$rs->setFetchMode(PDO::FETCH_ASSOC);
		$result_arr = $rs->fetchAll();
		return $result_arr;
	}

	public function searchone($where,$col="*",$limit=1,$join="",$having="",$group="",$order=""){
		$ret=$this->search($where,$col,$limit,$join,$having,$group,$order);
		return empty($ret)?$ret:$ret[0];
	}

	public function query($args=array())
	{
		$where="1";
		$col="*";
		$limit=500;
		$join="";
		$having="";
		$group="";
		$order="";
		if(!is_array($args)){
			$args=array(
				'content'=>"类".__CLASS__."中函数".__FUNCTION__.'传入的参数不正确！',
				'logName'=>"error",
				"path"=>$_SERVER['DOCUMENT_ROOT']."/",
				);
			log::createLog($args);
			exit();
		}
		foreach ($args as $key => $val) {
			$$key=$val;
		}
		return $this->search($where,$col,$limit,$join,$having,$group,$order);
	}

	public function querySql($SQL)
	{
		$rs=$this->dbh->query($SQL);
		$rs->setFetchMode(PDO::FETCH_ASSOC);
		$result_arr = $rs->fetchAll();
		return $result_arr;
	}

	public function add($data){
		if(empty($data)){
			echo "插入的数据不能为空";
		}
		$col="";
		$value="";
		foreach ($data as $key => $val) {
			$col.=",".$key;
			$value.=",'".$val."'";
		}
		$col=trim($col,",");
		$value=trim($value,",");
		$SQL="INSERT INTO ".$this->table." ($col) VALUES($value)";
		$rs=$this->dbh->query($SQL);
		$error=$this->dbh->errorInfo();		
		$insertid=$this->dbh->lastInsertId();
		return $this->errorMsg($error,$insertid);
	}

	public function update($data,$where){
		if(empty($data)){
			echo "更新的数据不能为空";
		}

		if(trim($where)==""){
			echo "更新条件不能为空";
		}

		$value="";
		foreach ($data as $key => $val) {
			$value.=",".$key."='".$val."'";
		}

		$value=trim($value,",");
		$SQL="UPDATE ".$this->table." SET $value WHERE $where";
		$rs=$this->dbh->query($SQL);
		$error=$this->dbh->errorInfo();
		return $this->errorMsg($error,"更新成功");
	}

	public function delete($where){

		if(trim($where)==""){
			echo "删除条件不能为空";
		}

		$SQL="DELETE FROM ".$this->table." WHERE $where";
		$rs=$this->dbh->query($SQL);
		$error=$this->dbh->errorInfo();
		return $this->errorMsg($error,"删除成功");
	}

	private function errorMsg($error,$subject){				
		if(intval($error[0])===0){
			return $subject;
		}
		else{
			if(is_array($error)){
				$error=implode(" ", $error);
			}
			$args=array("content"=>$error,"path"=>$_SERVER['DOCUMENT_ROOT']."/");
			log::createLog($args);
			exit();
		}
	}

}
