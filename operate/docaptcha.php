<?php
class doCAPTCHA{
	function __construct(){	
	}
	
	public function run(){
		$v = new CAPTCHA();		//实例化一个对象
   		$v->doimg();
	}
}
