<?php
class operate{

	function __construct(){
	}

	public function login($args=array())
	{
		$userName="";
		$password="";
		$nologin_id=$this->createNologinId();		

		if(isset($args['userName'])){
			$userName=$args['userName'];
		}

		if(isset($args['password'])){
			$password=md5($args['password']);
		}
		
		if(isset($args['rememberMe'])){
			$time=time()+3600*24*14;
			$nologin_id=$this->createNologinId('2',$userName);
		}else{
			$time=time()+3600;
		}

		if(trim($userName)==""){
			common::error("请填写用户名");
		}

		if(trim($password)==""){
			common::error("请填写密码");
		}

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->search("(email='".$userName."' OR username='".$userName."') AND password='".$password."'");
		if(!$ret){
			common::error("用户不存在或用户名与密码不匹配");
		}else{
			$data_user['nologin_id']=$nologin_id;
			$mark_user_obj->update($data_user,"id=".$ret[0]['id']);
			setcookie("username", $ret[0]['username'], $time,"/");
			setcookie("user_id", $ret[0]['id'], $time,"/");
			setcookie("nologin_id", $nologin_id, $time,"/");
			setcookie("status", $ret[0]['status'], $time,"/");
			common::success("登录成功","/");
		}
	}

	public function nologin($args=array())
	{
		$userName="";
		$nologin_id=$this->createNologinId();		

		if(isset($args['userName'])){
			$userName=$args['userName'];
		}

		if(isset($args['nologin_id'])){
			$nologin_id=$args['nologin_id'];
		}

		if(trim($userName)==""){
			common::error("请填写用户名");
		}

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->search("(email='".$userName."' OR username='".$userName."') AND nologin_id='".$nologin_id."'");
		if(!$ret){
			common::error("用户不存在");
		}else{
			common::success("登录成功","/");
		}
	}


	public function getmark($args=array())
	{
		$where="";

		if(isset($args['where']) && trim($args['where'])!=""){
			$where=" AND ".$args['where'];
		}

		$userName=$_COOKIE['username'];

		if(!$userName || trim($userName)==""){
			common::error("请先登录") ;
		}

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->searchone("(email='".$userName."' OR username='".$userName."')");

		if(empty($ret))
		{
			common::error("用户不存在") ;
		}

		$mark_url_obj=new dbBaseCRUD("mark_url AS a");
		// $join="LEFT JOIN mark_url_tag AS c ON c.url_id=a.id LEFT JOIN mark_tag AS b ON b.id=c.tag_id";
		$ret=$mark_url_obj->search("user_id=".$ret['id'].$where," a.*","all");
		$mark_tag_obj=new dbBaseCRUD("mark_url_tag AS a");
		foreach ($ret as $key => $val) {
			$name="";
			$join="LEFT JOIN mark_tag AS b ON a.tag_id=b.id ";
			$ret2=$mark_tag_obj->search("url_id=".$val['id'],"b.name","all",$join);
			if(!empty($ret2)){
				foreach ($ret2 as $key2 => $val2) {
					$name.=$val2['name'].",";
				}
				$ret[$key]['tags']=trim($name,",");
			}else
			{
				$ret[$key]['tags']="";
			}
			if(strlen($val['title'])>100)
			$ret[$key]['title']=mb_strcut($val['title'],0,72,"utf-8")."...";
			if(strlen($val['note'])>100)
			$ret[$key]['note']=mb_strcut($val['note'],0,50,"utf-8")."...";
		}

		common::success("查询成功",$ret);
	}

	public function reg($args=array())
	{
		$email=$args['email'];
		$password=$args['password'];
		$repassword=$args['repassword'];
		$nologin_id=$this->createNologinId();

		if(!$email){
			common::error("请填写邮箱");
		}

		if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)){
			common::error("邮箱格式不正确");
		}

		if(!$password || trim($password)==""){
			common::error("请填写密码");
		}

		if($password!=$repassword || trim($repassword)==""){
			common::error("密码不一致");
		}

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->search("email='".$email."'");
		if(!empty($ret)){
			common::error("此邮箱已注册，请更换邮箱");
		}

		$data_user=array(
			"username"=>$email,
			"email"=>$email,
			"password"=>md5($password),
			"status"=>1,//未审核用户
			"nologin_id"=>$nologin_id,
			);

		$user_id=$mark_user_obj->add($data_user);
			
		//写入cookie 必须加作用域"/" 2014/02/04 WHJ
		setcookie("username", $email, time()+3600,"/");
		setcookie("user_id", $user_id, $time,"/");
		setcookie("nologin_id", $nologin_id, time()+3600,"/");
		setcookie("status", 1, time()+3600,"/");


		common::success("注册成功","/");
	}

	public function add($args=array())
	{
		$url = $args['addUrl']; 
		$ch = curl_init(); 
		$timeout = 5; 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
		//在需要用户检测的网页里需要增加下面两行 
		// curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY); 
		// curl_setopt($ch, CURLOPT_USERPWD, US_NAME.":".US_PWD); 
		$contents = curl_exec($ch); 
		curl_close($ch);

		if($contents){


			//开始处理

			$charset="UTF-8";
			preg_match('/<meta.+http-equiv="Content-Type"(.*)(charset=[\"|\']?\S*[\"|\']?).+>/i',strtolower($contents),$matches); 
			if(!empty($matches)){
				$tmp_attr=explode("=", $matches[count($matches)-1]);
				$tmp_attr=explode("\"", $tmp_attr[1]);
				$charset=$tmp_attr[0];
			}else{
				preg_match('/<meta.+?charset=[^\w]?([-\w]+)/i',$contents,$matches);
				if(!empty($matches)){
				$tmp_attr=explode("=", $matches[count($matches)-1]);
				$tmp_attr=explode("\"", $tmp_attr[1]);
				$charset=$tmp_attr[1];	
				}
				
			}


			$title='';
			preg_match_all("/<title.*>(.*)<\/title>/isU", strtolower($contents), $matches); 
			$matches=array_filter($matches);
			
			if(!empty($matches)){
				iconv($charset, "UTF-8", $contents);
				$tmp_attr=explode("title", $contents);				
				$tmp_attr=explode(">", $tmp_attr[1]);
				$tmp_attr=explode("<", $tmp_attr[1]);				
				$title=$tmp_attr[0];
			}



			if(trim($title)=="")
				$title=$url;

			preg_match('/<meta.+name="keywords"(.*)(content=[\"|\']?\S*[\"|\']?).+>/i',strtolower($contents),$matches); 
			$keywords="";
			if(!empty($matches)){
				$tmp_attr=str_replace("'","\"",iconv($charset, "UTF-8", $matches[count($matches)-1]));
				$tmp_attr=explode("\"", $tmp_attr);
				$keywords=$tmp_attr[1];

			}
			$data=array('title'=>iconv($charset, "UTF-8", $title),'keywords'=>$keywords,'url'=>$url);
			common::success("查找成功",$data);
		}else{
			common::error("查找失败");
		}
	}

	public function save($args=array())
	{

		$url=$args['url'];
		$title=$args['title'];
		$keywords=$args['keywords'];
		$note=$args['note'];

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->search("username='".$_COOKIE['username']."'");
		
		//保存url
		if(empty($ret)){
			common::error("请先登录！");
			exit();
		}
		$data_mark=array(
			"url"=>$url,
			"title"=>$title,
			"user_id"=>$ret[0]['id'],
			"createtime"=>time(),
			"note"=>$note,
			);
		$mark_url_obj=new dbBaseCRUD("mark_url");
		$url_id=$mark_url_obj->add($data_mark);

		//保存tag和tag_url
		$keywords=str_replace("，", ",", $keywords);
		$keywords=explode(",", $keywords);

		$mark_tag_obj=new dbBaseCRUD("mark_tag");
		$mark_url_tag_obj=new dbBaseCRUD("mark_url_tag");
		$tag_id=0;
		foreach ($keywords as $key => $val) {
			$ret=$mark_tag_obj->search("name='$val'");
			if(!$ret){
				$data_tag=array("name"=>$val);
				$tag_id=$mark_tag_obj->add($data_tag);
			}else{
				$tag_id=$ret[0]['id'];
			}

			$data_url_tag=array(
				'url_id'=>$url_id,
				'tag_id'=>$tag_id,
				);
			$mark_url_tag_obj->add($data_url_tag);
		}


		common::success("保存成功！");
	}


	public function getFavorite($args=array())
	{
		$where="";

		if(isset($args['where']) && trim($args['where'])!=""){
			$where=" AND ".$args['where'];
		}

		$userName=$_COOKIE['username'];

		if(!$userName || trim($userName)==""){
			common::error("请先登录") ;
		}

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->searchone("(email='".$userName."' OR username='".$userName."')");

		if(empty($ret))
		{
			common::error("用户不存在") ;
		}


		$mark_url_obj=new dbBaseCRUD("mark_favorites as a");
		$queryArr= array(
			'where' =>'a.user_id = '.$ret['id'] , 
			'col'	=>'a.name,a.id,COUNT(favorites_id) as favNum',
			'join'	=>'LEFT JOIN mark_url AS b ON a.id = b.favorites_id',
			'group'	=>'a.name',
			'order'	=>'a.create_time asc',
			);
		$ret=$mark_url_obj->query($queryArr);
		common::success("查询成功",$ret);


	}

	private function createNologinId($type=1,$str="")
	{
		if($type=1)
			$nologin_id=sha1(md5("mosquito".time()).$str);
		else
			$nologin_id=md5($time . mt_rand(1,1000000).$str);

		return $nologin_id;
	}


	public function saveFavorite($args=array())
	{
		$favoriteName="";
		$user_id=$_COOKIE['user_id'];
		if(isset($args['favoriteName']))
			$favoriteName=$args['favoriteName'];

		if(trim($favoriteName)=="")
			common::error("请输入收藏夹名称") ;

		if(!isset($user_id)){
			common::error("请先登录") ;
		}

		$data_fav=array(
			'user_id'=>$user_id,
			'name'=>$favoriteName,
			'create_time'=>time(),
			);

		$mark_favorites_obj=new dbBaseCRUD("mark_favorites");
		$mark_favorites=$mark_favorites_obj->searchone("name='".$favoriteName."' AND user_id=".$user_id);
		if(!empty($mark_favorites)){
			common::error("该收藏夹已经存在") ;
		}
		$favorites_id=$mark_favorites_obj->add($data_fav);
		$data_fav['favorites_id']=$favorites_id;
		common::success("新建成功",$data_fav);

	}


}