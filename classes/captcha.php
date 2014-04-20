<?php
//验证码类
class CAPTCHA {
  private $code;              		//验证码
  private $codelen = 5;          	//验证码长度
  private $width = 130;          	//宽度
  private $height = 30;          	//高度
  private $img;                		//图形资源句柄
  private $font;                	//指定的字体
  private $fontsize = 20;        	//指定字体大小
  private $fontcolor;            	//指定字体颜色
  private $bgred=66;            		//背景红色
  private $bggreen=139;            		//背景绿色
  private $bgblue=202;            		//背景蓝色
  private $wordheightoffset=1.2;		//高度偏移量
  private $wordred=255;            		//文字红色
  private $wordgreen=255;            		//文字绿色
  private $wordblue=255;            		//文字蓝色
  private $linenum=10;            		//干扰线数量
  private $linered=200;            		//干扰线红色
  private $linegreen=200;            		//干扰线绿色
  private $lineblue=200;            		//干扰线蓝色
  private $charactersnum=100;					//干扰字符数量
  private $charactersred=220;            		//干扰字符红色
  private $charactersgreen=220;            		//干扰字符绿色
  private $charactersblue=220;            		//干扰字符蓝色
  private $wordangle=30;            		//验证码角度

  //构造方法初始化
  public function __construct($arr=array()) {
//	imagettftext函数会挑字体，某些字体会无法显示。Huajie 2014-04-20 16:49
    $this->font = $_SERVER['DOCUMENT_ROOT'].'/fonts/AdobeGothicStd-Bold.otf';
	if(is_array($arr)){
		foreach($arr as $key=>$val){
			$this->$key=$val;
		}
	}
  }


  //生成随机码
  private function createCode() {
    for ($i=0;$i<$this->codelen;$i++) {
      	$charset=sha1(time().$i);
      	$this->code .= substr($charset,rand(0,39),1);
    }
	$_SESSION['code'] =$this->code;
  }


  //生成背景
  private function createBg() {
    $this->img = imagecreatetruecolor($this->width, $this->height);
    $color = imagecolorallocate($this->img, $this->bgred, $this->bggreen, $this->bgblue);
    imagefilledrectangle($this->img,0,0,$this->width,$this->height,$color);
  }


  //生成文字
  private function createFont() {  
    $wordwidth = $this->width / $this->codelen;
	$this->fontcolor = imagecolorallocate($this->img,$this->wordred, $this->wordgreen, $this->wordblue);
	$this->fontcolor=imagecolorallocate($this->img,$this->wordred, $this->wordgreen, $this->wordblue);
    for ($i=0;$i<$this->codelen;$i++) {
      $this->fontcolor = imagecolorallocate($this->img,$this->wordred, $this->wordgreen, $this->wordblue);
      imagettftext($this->img,$this->fontsize,mt_rand(-$this->wordangle,$this->wordangle),$wordwidth*$i+mt_rand(1,5),$this->height / $this->wordheightoffset,$this->fontcolor,$this->font,$this->code[$i]);
    }
  }


  //生成线条、雪花
  private function createLine() {
    for ($i=0;$i<$this->linenum;$i++) {
      $color = imagecolorallocate($this->img,$this->linered, $this->linegreen, $this->lineblue);
      imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
    }
    for ($i=0;$i<$this->charactersnum;$i++) {
      $color = imagecolorallocatealpha($this->img,$this->charactersred, $this->charactersgreen, $this->charactersblue,rand(60,80));
	  $character=rand(33,126);
      imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),$character,$color);
    }
  }


  //输出
  private function outPut() {
    header('Content-type:image/png');
    imagepng($this->img);
    imagedestroy($this->img);
  }


  //对外生成
  public function doimg() {
    $this->createBg();
    $this->createCode();
    $this->createLine();
    $this->createFont();
    $this->outPut();
  }

}		
