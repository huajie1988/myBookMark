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
		$limit="all";
		$pageSize=20;
		$page=1;
		$pageNow=1;
		if(isset($args['where']) && trim($args['where'])!=""){
			$where=str_replace(" or ", " AND ", " AND ".strtolower($args['where']));

		}
		
		$pageWhere=$args['where'];
		
		if(isset($args['limit']) && trim($args['limit'])!=""){
			$limit_t=trim($args['limit'],",");
			if(substr_count($limit_t,",")>=0){
				$limit_t=explode(",", $limit_t);
				$limitStart=abs(intval($limit_t[0]));
				$limit=$limitStart.",".$pageSize;
				$pageNow=ceil($limitStart/$pageSize)+1;
			}
		}
		
		$userName=$_COOKIE['username'];

		if(!$userName || trim($userName)==""){
			common::error("请先登录") ;
		}

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$user=$mark_user_obj->searchone("(email='".$userName."' OR username='".$userName."')");

		if(empty($user))
		{
			common::error("用户不存在") ;
		}

		$mark_url_obj=new dbBaseCRUD("mark_url AS a");
		$args=array(
			'join'=>"LEFT JOIN mark_url_tag AS b ON b.url_id=a.id",
			'where'=>"user_id=".$user['id']." AND status=1 ".$where,
			'col'=>" a.*",
			'limit'=>$limit,
			'group'=>"a.id"
			);
		
		$ret=$mark_url_obj->query($args);
		
		$SQL="SELECT COUNT(*) AS totalCol 
			  FROM ( SELECT a.* FROM mark_url AS a
			  LEFT JOIN mark_url_tag AS b ON b.url_id=a.id
			  WHERE user_id=".$user['id'].$where." 
			  GROUP BY a.id) AS m";
  		$totalCol=$mark_url_obj->querySql($SQL);
		$totalCol=$totalCol[0]['totalCol'];
		$page=ceil($totalCol/$pageSize);
		
		
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
			$ret[$key]['title']=mb_strcut($val['title'],0,70,"utf-8")."...";
			if(strlen($val['note'])>100)
			$ret[$key]['note']=mb_strcut($val['note'],0,50,"utf-8")."...";
		}
		
		$rets['Page']=array(
			'pagetotal'=>$totalCol,
			'page'=>$page,
			'pagenow'=>$pageNow,
			'pagesize'=>$pageSize,
			'where'=>$pageWhere,
		);
		$rets['ret']=$ret;

		common::success("查询成功",$rets);
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
//		下面的try catch暂时无用
	try {
			if($contents){
/*	
 *				2014-04-18 23:03 Huajie
 *				获取charset代码在第四版中去除，第五版中恢复
 *				原因：如果为设置charset则在转码时如果采集网页为非UTF-8时可能导致最终转换为乱码，
 *				故需要手动指定源编码
 * 
 */	
				//开始处理
	
				$charset="UTF-8";
				$charset_tmp="";
				preg_match('/<meta.+http-equiv="Content-Type"(.*)(charset=[\"|\']?\S*[\"|\']?).+>/i',strtolower($contents),$matches); 
				if(!empty($matches)){
					$tmp_attr=explode("=", $matches[count($matches)-1]);
	  				$tmp_attr=explode("\"", $tmp_attr[1]);
					$charset_tmp=$tmp_attr[0];
				}else{
					preg_match('/<meta.+?charset=[^\w]?([-\w]+)/i',strtolower($contents),$matches);				
					if(!empty($matches)){			
					$tmp_attr=explode("=", $matches[count($matches)-1]);
					if(count($tmp_attr)>1){
						$tmp_attr=explode("\"", $tmp_attr[1]);
						$charset_tmp=$tmp_attr[1];	
						}else{
							$charset_tmp=$tmp_attr[0];
						}
					}
					
				}
				
  				if(trim($charset_tmp)!="")
					$charset=$charset_tmp;
	
				$title='';
				preg_match_all("/<title.*>(.*)<\/title>/isU", strtolower($contents), $matches); 
				$matches=array_filter($matches);
				
				if(!empty($matches)){
					
					mb_convert_encoding($contents, "UTF-8", $charset);
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
					$tmp_attr=str_replace("'","\"",mb_convert_encoding($matches[count($matches)-1], "UTF-8", $charset));
					$tmp_attr=explode("\"", $tmp_attr);
					$keywords=$tmp_attr[1];
	
				}
				$data=array('title'=>mb_convert_encoding($title, "UTF-8", $charset),'keywords'=>$keywords,'url'=>$url);
				common::success("查找成功",$data);
			}else{
				common::error("查找失败");
			}
		}catch (Exception $e) {
			echo $e->getMessage();
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
			"status"=>1,
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
			if($key > 9)
				break;
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
			'join'	=>'LEFT JOIN (select * from  mark_url where status=1) AS b ON a.id = b.favorites_id',
			'limit'=>'10',
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
		$user_id=0;
		if(isset($args['favoriteName']))
			$favoriteName=$args['favoriteName'];

		if(isset($_COOKIE['user_id']))
			$user_id=intval($_COOKIE['user_id']);

		if(trim($favoriteName)=="")
			common::error("请输入收藏夹名称") ;

		if($user_id==0){
			common::error("请先登录") ;
		}

		$data_fav=array(
			'user_id'=>$user_id,
			'name'=>$favoriteName,
			'create_time'=>time(),
			);

		$mark_favorites_obj=new dbBaseCRUD("mark_favorites");
		$mark_favorites=$mark_favorites_obj->searchone("name='".$favoriteName."' AND user_id=".$user_id);
		$mark_favNum=$mark_favorites_obj->searchone(" user_id=".$user_id,"count(*) as favNum");
		if(!empty($mark_favorites)){
			common::error("该收藏夹已经存在") ;
		}

		if($mark_favNum['favNum']>=10){
			common::error("收藏夹请不大于10个") ;
		}

		$favorites_id=$mark_favorites_obj->add($data_fav);
		$data_fav['favorites_id']=$favorites_id;
		common::success("新建成功",$data_fav);

	}


	public function move2Favorite($args)
	{
		$mark_ids=array();
		$favorite_id="";

		if(isset($args['mark_id'])){
			$mark_ids=$args['mark_id'];
		}

		if(isset($args['favorite_id'])){
			$favorite_id=intval($args['favorite_id']);
		}

		if(empty($mark_ids)){
			common::error("请选择书签");
		}

		if(trim($favorite_id)=="" || $favorite_id==0){
			common::error("请选择收藏夹");
		}

		$user_id=intval($_COOKIE['user_id']);

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}

		$mark_ids="(".trim(implode(",", $mark_ids),",").")";

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->searchone("id=$user_id");

		if(empty($ret))
		{
			common::error("用户不存在") ;
		}

		$data['favorites_id']=$favorite_id;
		$mark_url_obj=new dbBaseCRUD("mark_url");
		$mark_url_obj->update($data,"id IN $mark_ids");
		common::success("保存成功");
	}


	public function createMyTagsCloud($args=array())
	{
		$userName="";
		$nologin_id=$this->createNologinId();	
		$user_id="";

		if(isset($_COOKIE['user_id'])){
			$user_id=intval($_COOKIE['user_id']);
		}

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}	

		if(isset($_COOKIE['username'])){
			$userName=$_COOKIE['username'];
		}

		if(isset($_COOKIE['nologin_id'])){
			$nologin_id=$_COOKIE['nologin_id'];
		}

		if(trim($userName)==""){
			common::error("请填写用户名");
		}

		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->searchone("(email='".$userName."' OR username='".$userName."') AND nologin_id='".$nologin_id."'");

		if(empty($ret)){
			common::error("用户不存在");
		}

		$mark_tag_obj=new dbBaseCRUD("mark_tag as a");
		$queryArr= array(
			'where' =>'c.user_id = '.$ret['id'] , 
			'col'	=>'a.id,a.name,count(c.id) AS weights',
			'join'	=>'LEFT JOIN mark_url_tag as b ON a.id=b.tag_id LEFT JOIN (select * from  mark_url where status=1) as c ON c.id=b.url_id',
			'group'	=>'a.name',
			);
		$ret=$mark_tag_obj->query($queryArr);
		
		foreach ($ret as $key => &$val) {
			$val['name']=mb_strcut(htmlentities($val['name'],ENT_QUOTES ,"UTF-8"),0,30,"utf-8");			
			// $val['name']=mb_strcut($val['name'],0,30,"utf-8");
		}
		// print_r($ret);exit();
		shuffle($ret);
		common::success("查询成功",$ret);
	}

	public function saveTags($args=array())
	{
		$url_id="";	
		$user_id="";
		$tags="";
		$tagArr=array();

		if(isset($_COOKIE['user_id'])){
			$user_id=intval($_COOKIE['user_id']);
		}

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}

		if(isset($args['url_id'])){
			$url_id=intval($args['url_id']);
		}

		if(isset($args['tags'])){
			$tags=$args['tags'];
		}

		$tags=str_replace("，", ",", $tags);

		if(trim($tags)!=""){
			$tagArr=explode(",", $tags);
		}

		if(count($tagArr)>10){
			common::error("标签数量请小于10个") ;
		}

		$mark_url_obj=new dbBaseCRUD("mark_url");
		$ret=$mark_url_obj->searchone("id=$url_id AND user_id=$user_id");

		if(empty($ret)){
			common::error("未找到该书签") ;
		}



		$mark_url_tag_obj = new dbBaseCRUD("mark_url_tag");
		$mark_url_tag_obj->delete("url_id=$url_id");

		$mark_tag_obj=new dbBaseCRUD("mark_tag");
		$tag_id=0;
		foreach ($tagArr as $key => $val) {			
			$ret_tag=$mark_tag_obj->searchone("name='$val'");

			if(!empty($ret_tag)){
				$tag_id=$ret_tag['id'];
			}else{
				$data_tag=array(
					'name'=>"$val",
					);
				$tag_id=$mark_tag_obj->add($data_tag);
			}

			$data_url_tag=array(
				"url_id"=>"$url_id",
				"tag_id"=>"$tag_id",
				);
			$mark_url_tag_obj->add($data_url_tag);
		}

		// print_r("修改成功");exit();
		common::success("修改成功",$ret);

	}

	public function changeLike($args=array())
	{
		$url_id="";	

		if(isset($_COOKIE['user_id'])){
			$user_id=intval($_COOKIE['user_id']);
		}

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}

		if(isset($args['url_id'])){
			$url_id=intval($args['url_id']);
		}

		$mark_url_obj=new dbBaseCRUD("mark_url");
		$ret=$mark_url_obj->searchone("id=$url_id AND user_id=$user_id");

		if(empty($ret)){
			common::error("未找到该书签") ;
		}

		$is_like=0;

		if($ret['is_like']==0 || trim($ret['is_like'])=="" || $ret['is_like']==null){
			$is_like=1;
		}

		$data=array("is_like"=>$is_like);
		$mark_url_obj->update($data,"id=$url_id AND user_id=$user_id");
		// print_r("修改成功");exit();
		$ret['is_like']=$is_like;
		common::success("修改成功",$ret);

	}

	public function changePrivate($args=array())
	{
		$url_id="";	

		if(isset($_COOKIE['user_id'])){
			$user_id=intval($_COOKIE['user_id']);
		}

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}

		if(isset($args['url_id'])){
			$url_id=intval($args['url_id']);
		}

		$mark_url_obj=new dbBaseCRUD("mark_url");
		$ret=$mark_url_obj->searchone("id=$url_id AND user_id=$user_id");

		if(empty($ret)){
			common::error("未找到该书签") ;
		}

		$is_private=0;

		if($ret['is_private']==0 || trim($ret['is_private'])=="" || $ret['is_private']==null){
			$is_private=1;
		}

		$data=array("is_private"=>$is_private);
		$mark_url_obj->update($data,"id=$url_id AND user_id=$user_id");
		// print_r("修改成功");exit();
		$ret['is_private']=$is_private;
		common::success("修改成功",$ret);

	}

	public function getMarkByDate($args=array())
	{
		$url_id="";	

		if(isset($_COOKIE['user_id'])){
			$user_id=intval($_COOKIE['user_id']);
		}

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}


		$mark_url_obj=new dbBaseCRUD("mark_url");
		$data_where=array(
			"col"=>" count(id) as markNum,FROM_UNIXTIME(createtime,'%Y年%m月') as month,FROM_UNIXTIME(createtime,'%y年%m月') as month_short",
			"where"=>"user_id=$user_id",
			"group"=>"FROM_UNIXTIME(createtime,'%Y年%m月')",
			"limit"=>"all",
			);
		$ret=$mark_url_obj->query($data_where);

		if(empty($ret)){
			common::error("未找到该书签") ;
		}

		common::success("修改成功",$ret);

	}

	public function delMark($args=array())
	{
		$mark_id="";	

		if(isset($_COOKIE['user_id'])){
			$user_id=intval($_COOKIE['user_id']);
		}

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}

		if(isset($args['mark_id'])){
			$mark_id=$args['mark_id'];
		}
		$mark_ids=implode(",", $mark_id);
		$mark_url_obj=new dbBaseCRUD("mark_url");
		$ret=$mark_url_obj->search("id IN ($mark_ids) AND user_id=$user_id");

		if(empty($ret)){
			common::error("未找到该书签") ;
		}

		$data=array("status"=>2);
		$mark_url_obj->update($data,"id IN ($mark_ids) AND user_id=$user_id");
		common::success("修改成功",$ret);

	}


	public function favoriteChangeSave($args)
	{
		$favorite_id="";
		$favoriteName="";

		if(isset($args['favorite_id'])){
			$favorite_id=intval($args['favorite_id']);
		}
		
		if(isset($args['favoriteName'])){
			$favoriteName=trim($args['favoriteName']);
		}
		
		if(trim($favorite_id)=="" || $favorite_id==0){
			common::error("请选择收藏夹");
		}
		
		if(trim($favoriteName)==""){
			common::error("请输入收藏夹名");
		}
		
		$user_id=intval($_COOKIE['user_id']);

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}


		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->searchone("id=$user_id");

		if(empty($ret))
		{
			common::error("用户不存在") ;
		}


		$data['name']=$favoriteName;
		$mark_favorites_obj=new dbBaseCRUD("mark_favorites");
		$mark_favorites_obj->update($data,"id = $favorite_id");
		common::success("修改成功");
	}

	public function deleteFavorite($args)
	{
		$favorite_id="";

		if(isset($args['favorite_id'])){
			$favorite_id=intval($args['favorite_id']);
		}
		
		
		if(trim($favorite_id)=="" || $favorite_id==0){
			common::error("请选择收藏夹");
		}
		
		
		$user_id=intval($_COOKIE['user_id']);

		if($user_id==0 || trim($user_id)==""){
			common::error("请先登录") ;
		}


		$mark_user_obj=new dbBaseCRUD("mark_user");
		$ret=$mark_user_obj->searchone("id=$user_id");

		if(empty($ret))
		{
			common::error("用户不存在") ;
		}

		$mark_favorites_obj=new dbBaseCRUD("mark_favorites");
		$mark_favorites_obj->delete("id = $favorite_id");
		
		$data['favorites_id']=0;
		$mark_url_obj=new dbBaseCRUD("mark_url");
		$mark_url_obj->update($data,"favorites_id = $favorite_id");
		
		common::success("删除成功");
	}

}