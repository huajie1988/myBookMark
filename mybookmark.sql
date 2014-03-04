/*
Navicat MySQL Data Transfer

Source Server         : localHostWamp
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : mybookmark

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2014-03-04 23:02:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mark_favorites
-- ----------------------------
DROP TABLE IF EXISTS `mark_favorites`;
CREATE TABLE `mark_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mark_favorites
-- ----------------------------
INSERT INTO `mark_favorites` VALUES ('1', '1393944627', 'Java', null);
INSERT INTO `mark_favorites` VALUES ('2', '1393944633', 'PHP', null);

-- ----------------------------
-- Table structure for mark_tag
-- ----------------------------
DROP TABLE IF EXISTS `mark_tag`;
CREATE TABLE `mark_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mark_tag
-- ----------------------------
INSERT INTO `mark_tag` VALUES ('1', 'android');
INSERT INTO `mark_tag` VALUES ('2', 'java');
INSERT INTO `mark_tag` VALUES ('3', 'jquery');
INSERT INTO `mark_tag` VALUES ('4', 'css');
INSERT INTO `mark_tag` VALUES ('5', '在线');
INSERT INTO `mark_tag` VALUES ('6', 'ruby');
INSERT INTO `mark_tag` VALUES ('7', 'search');
INSERT INTO `mark_tag` VALUES ('8', 'html5');
INSERT INTO `mark_tag` VALUES ('14', 'charset');
INSERT INTO `mark_tag` VALUES ('15', '正则表达式');
INSERT INTO `mark_tag` VALUES ('16', '截取');
INSERT INTO `mark_tag` VALUES ('17', '网页');
INSERT INTO `mark_tag` VALUES ('18', '编码');

-- ----------------------------
-- Table structure for mark_url
-- ----------------------------
DROP TABLE IF EXISTS `mark_url`;
CREATE TABLE `mark_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text,
  `title` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `createtime` int(11) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `favorites_id` int(4) DEFAULT NULL,
  `is_like` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mark_url
-- ----------------------------
INSERT INTO `mark_url` VALUES ('1', 'http://blog.jobbole.com/54201/', 'php开发者应了解的24个库', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('2', 'http://isux.tencent.com/learn-android-from-zero-session1.html', '前端之android入门(1) – 环境配置-腾讯isux – 社交用户体验设计 – better experience through design', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('3', 'http://www.gbtags.com/gb/share/2576.htm', '10个超实用的jquery代码片段分享 极客标签', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('4', 'http://hao.jobbole.com/online-python-tutor/', 'online python tutor：python 初学者的好帮手', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('5', 'http://www.gbtags.com/gb/share/2604.htm', '2604.htm', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('6', 'http://blog.jobbole.com/53573/', '15分钟学会使用git和远程代码库', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('7', 'http://blog.jobbole.com/53376/', '编写你的第一个垃圾收集器', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('8', 'http://www.gbtags.com/gb/share/2518.htm', '了解html5标准中的websockets 极客标签', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('9', 'http://www.csdn.net/article/2013-11-18/2817533-10-best-html5-code-snippets-to-simplify-your-tasks', '分享10段实用的html5代码-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('10', 'http://www.csdn.net/article/2013-11-01/2817365-useful-snippets-for-php-developers', '开发者必备，超实用的php代码片段！-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('11', 'http://www.gbtags.com/gb/share/2268.htm', '绝对应当收藏的10个实用html5代码片段 极客标签', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('12', 'http://bbs.csdn.net/topics/390435195', '390435195', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('13', 'http://vk.com/yjgjtfyjfyjftyuf?z=albums30623792', 'lina merkalina', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('14', 'http://blog.jobbole.com/50051/', 'sublime text 2 技巧：导航/命令面板/多重选择', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('15', 'http://www.baidu.com/s?wd=%5b%a5%e1%a5%ea%a9%60%a5%b8%a5%a7%a9%60%a5%f3%5d+%c3%c3%a4%d1%a4%e9%a4%c0%a4%a4%a4%b9%a3%a12+%cf%c2%8e%86+%b6%c0%a4%ea%d5%bc%a4%e1%a1%a2%a5%f4%a5%a1%a9%60%a5%b8%a5%f3%a4%d6%a4%ec%a4%a4%a4%af', '[メリージェーン] 妹ぱらだいす!2 下巻 独り占め、ヴァージンぶれいく', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('16', 'http://www.forehack.com/3d-css-cube/', '详解用css绘制3d旋转立方体', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('17', 'http://tangram.baidu.com/', 'tangram', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('18', 'http://www.baidu.com/s?wd=decodeuri', 'decodeuri', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('19', 'http://www.owe-love.com/myspace/?action=show&amp;id=100', 'php soap 调用webservice 已测试成功  - php,soap,webservice,shf321,学会做人，学会做事！', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('20', 'http://blog.sina.com.cn/s/blog_582246d20100dhh6.html', '终于解决了php调用soap过程中的种种问题。', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('21', 'https://www.google.com/webdesigner/', 'google web designer', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('22', 'http://www.mb5u.com/jscode/45854/', '模板无忧www.mb5u.com', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('23', 'http://www.cnblogs.com/faron/articles/874388.html', 'js添加、修改、删除xml节点例子', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('24', 'http://bbs.csdn.net/topics/390577446', '390577446', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('25', 'http://liyandong.duapp.com/?m=study', '?m=study', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('26', 'http://blog.sina.com.cn/s/blog_711afaa90100ucd9.html', 'php 正则表达式 抓取网页内容', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('27', 'http://www.csdn.net/article/2013-08-28/2816732-60-free-resources-you-really-must-try', '60个开发者不容错过的免费资源库-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('28', 'http://www.cnblogs.com/wzh2010/archive/2012/05/21/2511130.html', 'html5项目笔记4：使用audio api设计绚丽的html5音乐播放器', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('29', 'http://g.kehou.com/t1029846752.html', '开源免费天气预报接口api以及全国所有地区代码！！（国家气象局提供）', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('30', 'http://blog.csdn.net/hguisu/article/details/7448528', 'guisu，程序人生。', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('31', 'http://www.php100.com/html/webkaifa/html5/2012/0404/10191.html', '10 个基于 web 的 html5 音乐播放器', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('32', 'http://www.csdn.net/article/2013-08-26/2816691-html5-development-tools', '简化工作流程，10款必备的html5开发工具-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('33', 'http://www.csdn.net/article/2013-08-20/2816643-word2vec', '[开源推荐]google开源基于deep learning的word2vec工具-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('34', 'http://www.shejidaren.com/jquery-drag-and-drop-plugins.html', '11个好用的jquery拖拽拖放插件', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('35', 'http://developer.51cto.com/art/201103/250511.htm', 'jquery拖动布局实现排序结果同步数据库', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('36', 'http://www.blogguy.cn/show-723-1.html', 'func,php,wayswang,博客小子,blogguy', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('37', 'http://www.csdn.net/article/2013-08-07/2816477-6-source-code-search-engines-you-can-use-for-programming-projects', '开发者必备的6款源码搜索引擎-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('38', 'http://huuuxi.iteye.com/blog/816574', 'ssh全注解-annotation详细配置.', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('39', 'http://yuwenlin.iteye.com/blog/1883492', 'ssh开发环境详细搭建(配置文件)', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('40', 'http://www.360doc.com/content/11/0703/18/2617151_131268343.shtml', 'ssh实现的增删改查实例', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('41', 'http://songjianyong.iteye.com/blog/1497588', 'php 获取客户端的真实ip', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('42', 'http://www.cnblogs.com/younes/archive/2011/12/21/2295759.html', '用myeclipse搭建ssh框架 struts spring hibernate', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('43', 'http://wenku.baidu.com/view/14e0a48ecc22bcd126ff0c0e', 'myeclipse搭建ssh环境以及实例(图文教程)', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('44', 'http://wenku.baidu.com/view/887df6dece2f0066f5332283.html', 'myeclipse整合ssh步骤(基于操作和配置文件)', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('45', 'http://blog.csdn.net/jessielee_yoyo/article/details/4871901', '4871901', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('46', 'http://wuqishi.com/zend-studio-10/', 'zend-studio-10', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('47', 'http://www.csdn.net/article/2013-07-16/2816238-15-jquery-code-snippets-for-developers', '可以直接拿来用的15个jquery代码片段-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('48', 'http://www.csdn.net/article/2013-07-23/2816316-10-php-snippets-for-developers', '直接拿来用，10个php代码片段-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('49', 'http://www.csdn.net/article/2013-07-22/2816301', '推荐给开发者的20款响应式jquery插件-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('50', 'http://www.html5cn.org/article-5340-1.html', '分享10个超实用的jquery代码片段', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('51', 'http://blog.imbolo.com/dynamic-image-resize-via-jquery-javascript/', '动态调整图片尺寸bolo的博客', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('52', 'http://www.jb51.net/article/7584.htm', '可定制的php缩略图生成程式(需要gd库支持)', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('53', 'http://blog.csdn.net/yyzsyx/article/details/6039869', 'qt 简介－－qt 类简介专题（一）', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('54', 'http://blog.csdn.net/orbit/article/details/9210413', '算法系列之二十：计算中国农历（一）', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('55', 'http://qt.digia.com/china/qt-developer-day-china-2013/sessions/', 'digia plc', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('56', 'http://www.cnblogs.com/58top/archive/2012/12/17/10-useful-widgets-for-developers-designers.html', '分享开发人员和设计人员10个有用的小工具', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('57', 'http://blog.csdn.net/column/details/android123.html?page=3', '专栏：从零开始学android', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('58', 'http://www.csdn.net/article/2013-07-01/2816068-best-javascript-libraries-and-tools', '超棒的30款js类库和工具-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('59', 'http://fenby.com/learn/courseexercises/21', '对象的行为和方法 : 使用java函数库', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('60', 'http://hi.baidu.com/hisuperadmin', '程序员小刚', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('61', 'http://blog.csdn.net/knight_zhangyl/article/details/8499917', '8499917', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('62', 'http://www.youku.com/playlist_show/id_18600474_ascending_1_mode_pic_page_1.html', '传智播客 毕向东 java', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('63', 'http://ux.sohu.com/topics/50972d9ae7de3e752e0081ff#', 'nutux', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('64', 'http://www.mobify.com/blog/70-stunning-responsive-sites-for-your-inspiration/', '70 stunning responsive sites for your inspiration', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('65', 'http://inspiretrends.com/effective-website-navigation-designs/', 'effective-website-navigation-designs', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('66', 'http://www.csdn.net/article/2013-05-29/2815470-css-snippets-for-designers', 'web开发者的福利 30段超实用css代码-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('67', 'http://www.csdn.net/article/2013-05-24/2815422-20-useful-css-snippets-every-designer-should-have/1', 'web开发者不容错过的20段css代码-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('68', 'http://smti.tumblr.com/', 'smti.tumblr.com', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('69', 'http://edu.csdn.net/main/javavideo.shtml', 'android培训-不花1分钱即可入学！不4k就业不给1分学费！黑马程序员java培训、android培训平均就业薪水7k+', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('70', 'http://ju.outofmemory.cn/entry/22712', '[老法新用]使用padding-top:(percentage)实现响应式背景图片', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('71', 'http://cnbeta.com/articles/236638.htm', '在整个互联网中 成人网站有多大？_通信技术_cnbeta.com', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('72', 'http://download.csdn.net/detail/tiger86521/5300336', '1000个常用网页小图标 - 下载频道 - csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('73', 'http://www.baidu.com/s?wd=skin+to+the+max&amp;rsv_spt=1&amp;issp=1&amp;rsv_bp=0&amp;ie=utf-8&amp;tn=baiduhome_pg&amp;rsv_n=2&amp;rsv_sug3=1&amp;rsv_sug=0&amp;rsv_sug1=1&amp;rsv_sug4=26&amp;inputt=763', 'skin to the max_百度搜索', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('74', 'http://cnbeta.com/articles/235064.htm', '2013年google夏季编程计划开始报名_google / 谷歌_cnbeta.com', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('75', 'http://cnbeta.com/articles/234877.htm', '微软发布kb2839011补丁 替换导致win7无限重启的kb2840149_windows 7_cnbeta.com', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('76', 'http://cloudbbs.org/forum.php?mod=viewthread&amp;tid=14033', '码农如何快速打造一个有设计感的网站 - 技术讨论 - 云计算开发者社区 - powered by discuz!', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('77', 'http://www.bootcss.com/', 'bootstrap中文网', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('78', 'http://oosaka8kurodo.blog46.fc2.com/blog-entry-1214.html', 'ガンダムseed　フレイ　エロ画像　５回目', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('79', 'http://akaimato.blog.fc2.com/blog-entry-29.html', 'あかいまとのまと  何気に一周年', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('80', 'http://www.iteye.com/news/26040', '20个web响应式设计必备的jquery插件', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('81', 'http://www.iteye.com/news/27598', '11个新鲜出炉的jquery图像滑块插件', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('82', 'http://www.axure.org/start.html', 'axure介绍 axure中文社区 axure rp 6.5,下载,汉化,教程,视频,组件,培训,案例,产品经理,交互设计,企业内训,原型设计', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('83', 'http://www.csdn.net/article/2013-04-17/2814939-wireframing-prototyping-tools', '十大界面原型与布局工具-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('84', 'http://www.iteye.com/news/27580', 'emmet：html/css代码快速编写神器 - web前端 - iteye资讯', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('85', 'http://www.modern.ie/zh-cn/', '主页 | internet explorer 中的测试变得更加轻松 | modern.ie', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('86', 'http://v.youku.com/v_show/id_xntizmza0njg4.html', '不同游戏版本的爱情观—在线播放—优酷网，视频高清在线观看', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('87', 'http://www.zhaojian.net/?s=php%e5%b8%b8%e8%a7%81%e9%97%ae%e9%a2%98%e5%92%8c%e8%a7%a3%e5%86%b3%e6%96%b9%e6%b3%95', 'php常见问题和解决方法', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('88', 'http://beforweb.com/node/23', 'foundation框架 - 快速创建跨平台的网站页面原型 | be for web - 为网而生', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('89', 'http://dribbble.com/', 'dribbble', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('90', 'http://www.csdn.net/article/2013-04-02/2814743-9-valuable-css-tricks-for-responsive-design', '用于响应式设计的9个css技巧-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('91', 'http://www.csdn.net/article/2013-01-02/2813378-web-tool', '2012年度最佳web前端开发工具和框架-csdn.net', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('92', 'http://weibojs.com/', '新浪微博jssdk官方网站', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('93', 'http://acg.78dm.net/ct/2540.html', 'nendoroid系列玩具', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('94', 'http://fate-extra-ccc.jp/saber/index.html', '「フェイト／エクストラ ccc」公式サイト', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('95', 'http://alloyteam.github.com/alloyphoto/', 'alloyimage', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('96', 'http://rghost.net/44736831', '9364.0.fbl_partner_out13.130315-2105_x86fre_client_en-us-imp_ccsa_dv5.iso.torrent — rghost — file sharing', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('97', 'http://x-art.com/', 'x-art.com ~ beautiful erotica.', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('98', 'http://www.imdb.com/', 'imdb - movies, tv and celebrities', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('99', 'http://u.115.com/file/f8b51650e8', 'nos-cecilia_valdes-ballet_nacional_de_cuba.rar网盘下载', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('100', 'http://www.baidu.com/s?wd=%e6%80%92%e7%81%ab%e6%94%bb%e5%bf%83&amp;rsv_spt=1&amp;issp=1&amp;rsv_bp=0&amp;ie=utf-8&amp;tn=baiduhome_pg&amp;rsv_n=2&amp;rsv_sug3=1&amp;rsv_sug=0&amp;rsv_sug1=1&amp;rsv_sug4=23&amp;inputt=1075', '百度搜索_怒火攻心', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('101', 'http://www.code.org/', 'code.org | anybody can learn', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('102', 'http://code.google.com/p/zopfli/', 'zopfli - zopfli compression algorithm - google project hosting', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('103', 'http://java.itcast.cn/news/97682098/c17e/4f15/8c2e/44c97c9c5df4.shtml', '30天轻松掌握javaweb视频-传智播客java培训', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('104', 'http://java.itcast.cn/news/e393b086/ebce/4f94/9d48/94ed86bcf5ef.shtml', '历经5年锤炼（史上最适合初学者入门的java基础视频）-传智播客java培训', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('105', 'http://css.doyoe.com/', 'css参考手册v4.0.1_web前端开发参考手册系列', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('106', 'http://www.websjy.com/club/websjy_index/32/', '50个css超炫丽button样式代码下载 -www.websjy.com', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('107', 'http://edyfox.codecarver.org/html/index.html', '滇狐的个人主页', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('108', 'http://www.36ria.com/', 'ria之家–ria三部曲：jquery、ext、flex', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('109', 'http://developer.51cto.com/art/200509/3940.htm', '专题：python实用开发指南_51cto.com - 技术成就梦想 - 中国领先的it技术网站', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('110', 'http://railscasts.com/?type=free', 'ruby on rails screencasts - railscasts', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('111', 'http://www.ziyuanhai.com/', '资源海 - 资源搜索引擎', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('112', 'http://jqueryfordesigners.com/tag/easy/', 'easy | jquery for designers - tutorials and screencasts', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('113', 'http://fins.iteye.com/category/7347', 'fins的博客 - web前端分类文章列表 - iteye技术网站', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('114', 'http://www.hotavxxx.com/category/jav-uncensored/page/5', 'jav uncensored 無碼 | hotavxxx.com - part 5', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('115', 'http://tutorialzine.com/2011/06/beautiful-portfolio-html5-jquery/', 'making a beautiful html5 portfolio | tutorialzine', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('116', 'http://www.mhtml5.com/2011/10/3249.html', '分享25个优秀的 html5 开发教程_html5研究小组_html5教程_html5资源_html5游戏', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('117', 'http://www.mhtml5.com/application/littlepig', '小猪斗恶狼_html5研究小组_html5教程_html5资源_html5游戏', '4', '1391520178', '书签导入', '0', null);
INSERT INTO `mark_url` VALUES ('122', 'http://blog.csdn.net/shrimpma/article/details/7586660', 'php数组使用json_encode函数中文被编码成null的原因和解决办法 - shrimpma的专栏        - 博客频道 - CSDN.NET', '7', '1393254544', 'ss', '2', null);
INSERT INTO `mark_url` VALUES ('123', 'http://blog.csdn.net/default7/article/details/6796208', 'PHP 正则表达式 获取网页charset 编码 ，可以获取任意网页charset（代码备份） - default7        - 博客频道 - CSDN.NET', '7', '1393254679', '', '2', null);
INSERT INTO `mark_url` VALUES ('124', 'http://www.baidu.com/s?wd=%E6%AD%A3%E5%88%99%E8%A1%A8%E8%BE%BE%E5%BC%8F+%E7%BD%91%E9%A1%B5%E7%BC%96%E7%A0%81&rsv_spt=1&issp=1&rsv_bp=0&ie=utf-8&tn=baiduhome_pg&rsv_sug3=37&rsv_sug4=8412&rsv_sug1=27&oq=zheng&rsp=0&rsv_sug2=1&rsv_sug5=0&inputT=13385&sug=%E6%AD%A3%E5%88%99%E8%A1%A8%E8%BE%BE%E5%BC%8F&rsv_n=1&rsv_sug=0', '正则表达式 网页编码_百度搜索', '7', '1393255592', '', '0', null);
INSERT INTO `mark_url` VALUES ('126', 'http://zhidao.baidu.com/link?url=RO_-_9nxZCAWeP15yE0ZZE0pmTkMSS0YZbIP49H0nefy90c1gbbNSRMUE6BqEZzIyiUoUWPDl6JrNHPgIENi5a', '求截取网页中的charset编码的正则表达式_百度知道', '7', '1393257474', 'ssd', '0', null);

-- ----------------------------
-- Table structure for mark_url_tag
-- ----------------------------
DROP TABLE IF EXISTS `mark_url_tag`;
CREATE TABLE `mark_url_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mark_url_tag
-- ----------------------------
INSERT INTO `mark_url_tag` VALUES ('1', '2', '1');
INSERT INTO `mark_url_tag` VALUES ('2', '40', '2');
INSERT INTO `mark_url_tag` VALUES ('3', '42', '2');
INSERT INTO `mark_url_tag` VALUES ('4', '43', '2');
INSERT INTO `mark_url_tag` VALUES ('5', '44', '2');
INSERT INTO `mark_url_tag` VALUES ('6', '45', '2');
INSERT INTO `mark_url_tag` VALUES ('7', '47', '3');
INSERT INTO `mark_url_tag` VALUES ('8', '49', '3');
INSERT INTO `mark_url_tag` VALUES ('9', '50', '3');
INSERT INTO `mark_url_tag` VALUES ('10', '51', '4');
INSERT INTO `mark_url_tag` VALUES ('11', '56', '4');
INSERT INTO `mark_url_tag` VALUES ('12', '58', '3');
INSERT INTO `mark_url_tag` VALUES ('13', '59', '2');
INSERT INTO `mark_url_tag` VALUES ('14', '60', '2');
INSERT INTO `mark_url_tag` VALUES ('15', '61', '2');
INSERT INTO `mark_url_tag` VALUES ('16', '62', '5');
INSERT INTO `mark_url_tag` VALUES ('17', '66', '4');
INSERT INTO `mark_url_tag` VALUES ('18', '67', '4');
INSERT INTO `mark_url_tag` VALUES ('19', '70', '4');
INSERT INTO `mark_url_tag` VALUES ('20', '72', '4');
INSERT INTO `mark_url_tag` VALUES ('21', '80', '3');
INSERT INTO `mark_url_tag` VALUES ('22', '81', '3');
INSERT INTO `mark_url_tag` VALUES ('23', '90', '4');
INSERT INTO `mark_url_tag` VALUES ('24', '103', '2');
INSERT INTO `mark_url_tag` VALUES ('25', '104', '2');
INSERT INTO `mark_url_tag` VALUES ('26', '105', '4');
INSERT INTO `mark_url_tag` VALUES ('27', '106', '4');
INSERT INTO `mark_url_tag` VALUES ('28', '110', '6');
INSERT INTO `mark_url_tag` VALUES ('29', '111', '7');
INSERT INTO `mark_url_tag` VALUES ('30', '112', '3');
INSERT INTO `mark_url_tag` VALUES ('31', '113', '8');
INSERT INTO `mark_url_tag` VALUES ('32', '115', '8');
INSERT INTO `mark_url_tag` VALUES ('33', '116', '8');
INSERT INTO `mark_url_tag` VALUES ('34', '117', '8');
INSERT INTO `mark_url_tag` VALUES ('35', '117', '4');
INSERT INTO `mark_url_tag` VALUES ('36', '110', '5');
INSERT INTO `mark_url_tag` VALUES ('37', '124', '14');
INSERT INTO `mark_url_tag` VALUES ('38', '124', '15');
INSERT INTO `mark_url_tag` VALUES ('39', '124', '16');
INSERT INTO `mark_url_tag` VALUES ('40', '124', '17');
INSERT INTO `mark_url_tag` VALUES ('41', '124', '18');
INSERT INTO `mark_url_tag` VALUES ('47', '126', '14');
INSERT INTO `mark_url_tag` VALUES ('48', '126', '15');
INSERT INTO `mark_url_tag` VALUES ('49', '126', '16');
INSERT INTO `mark_url_tag` VALUES ('50', '126', '17');
INSERT INTO `mark_url_tag` VALUES ('51', '126', '18');

-- ----------------------------
-- Table structure for mark_user
-- ----------------------------
DROP TABLE IF EXISTS `mark_user`;
CREATE TABLE `mark_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mark_user
-- ----------------------------
INSERT INTO `mark_user` VALUES ('1', 'asd1@qq.com', 'asd1@qq.com', '96e79218965eb72c92a549dd5a330112', '1');
INSERT INTO `mark_user` VALUES ('2', '111@qq.com', '111@qq.com', '96e79218965eb72c92a549dd5a330112', '1');
INSERT INTO `mark_user` VALUES ('3', 'asd2@qq.com', 'asd2@qq.com', '96e79218965eb72c92a549dd5a330112', '1');
INSERT INTO `mark_user` VALUES ('4', 'asd@qq.com', 'asd@qq.com', '96e79218965eb72c92a549dd5a330112', '1');
INSERT INTO `mark_user` VALUES ('5', 'huajie2012@yahoo.cn', 'huajie2012@yahoo.cn', 'e10adc3949ba59abbe56e057f20f883e', '1');
INSERT INTO `mark_user` VALUES ('6', 'huajie2002@yahoo.cn', 'huajie2002@yahoo.cn', '96e79218965eb72c92a549dd5a330112', '1');
INSERT INTO `mark_user` VALUES ('7', '43@qq.com', '43@qq.com', '96e79218965eb72c92a549dd5a330112', '1');

-- ----------------------------
-- Table structure for mark_user_favorites
-- ----------------------------
DROP TABLE IF EXISTS `mark_user_favorites`;
CREATE TABLE `mark_user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `favorites_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mark_user_favorites
-- ----------------------------
INSERT INTO `mark_user_favorites` VALUES ('1', '7', '2');
