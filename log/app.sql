/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : app

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2015-02-28 00:03:12
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `cms_column`
-- ----------------------------
DROP TABLE IF EXISTS `cms_column`;
CREATE TABLE `cms_column` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `pid` int(11) DEFAULT '0' COMMENT '上级栏目',
  `pid_path` char(50) DEFAULT NULL COMMENT '父路径',
  `model_id` int(11) DEFAULT NULL COMMENT '模型ID',
  `name` varchar(100) NOT NULL COMMENT '栏目名称',
  `url` varchar(100) DEFAULT NULL COMMENT 'Url链接',
  `description` varchar(250) DEFAULT NULL COMMENT '栏目描述',
  `is_ok` int(11) NOT NULL COMMENT '是否启用',
  `alias` varchar(20) DEFAULT NULL COMMENT '栏目别名',
  `menu` int(11) DEFAULT '1' COMMENT '显示到导航',
  `fixed` int(11) DEFAULT NULL COMMENT '固定栏目',
  `corder` int(11) DEFAULT NULL COMMENT '排序',
  `created_at` int(10) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=379 DEFAULT CHARSET=utf8 COMMENT='cms栏目表';

-- ----------------------------
-- Records of cms_column
-- ----------------------------
INSERT INTO cms_column VALUES ('15', '8', '8,15', '1', '学校领导', '', '', '1', '', '1', '0', '14', '1384485482');
INSERT INTO cms_column VALUES ('16', '8', '8,16', '1', '我校风光', '', '', '1', '', '1', '0', '16', '1384497712');
INSERT INTO cms_column VALUES ('19', '0', '0,19', '3', '家长子栏目', '#', '88', '1', '', '1', '0', '73', '1384504991');
INSERT INTO cms_column VALUES ('163', '0', '0,163', '2', '学校简介', '', '', '1', 'schoolprofile', '1', '1', '164', '1392100418');
INSERT INTO cms_column VALUES ('176', '16', '8,16,176', '1', '三级文章', '', '', '1', '', '1', '0', '176', '1393320297');
INSERT INTO cms_column VALUES ('181', '19', '0,19,181', '1', '家长课堂', '', '', '1', '', '1', '0', '181', '1395367156');
INSERT INTO cms_column VALUES ('182', '19', '0,19,182', '1', '入学准备', '', '', '1', '', '1', '0', '182', '1395367173');
INSERT INTO cms_column VALUES ('348', '163', '0,163,348', '4', '成果展示', '', '展示学校成果', '1', '', '1', '0', '348', '1419908658');
INSERT INTO cms_column VALUES ('377', '0', '0,377', null, 'sasfa', null, null, '1', '222', '1', null, null, null);
INSERT INTO cms_column VALUES ('378', '377', '0,377,378', null, 'asas', null, null, '1', 'wewww1111', '1', null, '21', null);

-- ----------------------------
-- Table structure for `cms_content`
-- ----------------------------
DROP TABLE IF EXISTS `cms_content`;
CREATE TABLE `cms_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '内容',
  `relate_id` int(11) NOT NULL COMMENT '关联',
  `body` text NOT NULL COMMENT '正文',
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8 COMMENT='cms内容表';

-- ----------------------------
-- Records of cms_content
-- ----------------------------
INSERT INTO cms_content VALUES ('72', '73', '<p><span style=\"color:#343436;font-family:宋体;line-height:21px;\">农民有本事可以一亩地卖几百万上千万，就像现在政府卖地一样；农民高兴也可以分毫不取出让土地。最终能卖什么样的价格不重要，重要的是要把这自主权交换给农民，而不是说只要政府高兴了，就可以随便从农民手中掠夺土地，然后说爱给你多少补偿就给多少。有限的进步　　周克成（财经评论员）　　在28日召开的国务院常务会议上，讨论通过《中华人民共和国土地管理法修正案（草案）》，对农民集体所有土地征收补偿制度作了修改。有业内专家推测，此次修改，主要内容是提高征地补偿数额，提高额度可能至少为现行标准的10倍。　　如果征地补偿数额真能提高到现行标准的10倍，倒也是一个进步。不过这依然只是一个非常有限的进步。　　中国人老爱说“我们过去欠农民太多了”，这话说得好听，就像现在不亏欠农民了似的。实际上，我们亏欠、压榨农民的政策限制依然无处不在，其中征地条款是最重要一条。在现行的土地征收补偿办法中，规定征收土地的，按照被征收土地的原用途给予补偿。土地补偿费和安置补助费的总和不得超过土地被征收前三年平均年产值的30倍。　　考虑到土地是强制征收的，以及目前工商业用地的巨大价值，这个补偿标准是非常低的。目前一亩农地用来种植农作物，年平均产值一般不过一两千元，就算以两千元计算，农民所得最高补偿也不过6万元人民币。而政府征收土地转手拍卖的时候，一亩地价往往高达上百万甚至数百万。　　更加让人气短的是，现行法规只规定了征地补偿的最高标准，而没有规定征地补偿的最低标准，也就是说，征地官员即使不给农民一分钱补贴，从法律上讲也是“合法”的。你说这算哪门子道理？不过就是觉得农民好欺负嘛。不过你要欺人太甚可不是没代价的，全国每年数以万起的上访、群体事件就是代价。　　现在考虑提高征地补偿，算是一个进步，但这是一个非常有限的进步。真正到位靠谱的办法是做到如下两步：　　第一，大规模收缩政府征地规模，明确执行现行法律中的一些合理规定。比如现行法律就已经规定，政府征地必须以公益为目的，那么，如果是非公益的、商业性的用地，就再也不能使用强制征收手段。与此相匹配的，就是何谓公益需要有十分明晰可靠的界定。　　第二，完全放开土地交易市场。政府不再征地之后，工商业用地从哪来？很简单，就让工商业建设者自己和农民协商收购土地。要卖多少地，以什么样的价成交，应包含或满足什么样的条款，一律由商人和农民自己商议完成。　　农民有本事可以一亩地卖几百万上千万，就像现在政府卖地一样；农民高兴也可以分毫不取出让土地。最终能卖什么样的价格不重要，重要的是要把这自主权交换给农民，而不是说只要政府高兴了，就可以随便从农民手中掠夺土地，然后说爱给你多少补偿就给多少。　　我当然知道天下有无数的人反对农民出售土地，他们认为他们这是爱护、保护农民，真是荒唐可笑！政府强制征收农民土地，自己决定补偿标准，你们不反对，而农民自主决定是否出售土地、以什么样的价格出售土地，你们倒反对了。　　事实上，很多人可能不明白这样的逻辑，就是如果你反对农民自主出售土地，就等于鼓励政府强征土地，因为在农业往工商业转变的大背景下，无论如何是会有很多农地会转为工商业用地的，你不允许农民自主出售，政府自然只能去抢了。当然，更进一步，是政府为了垄断土地供应，而不允许农民转让土地。　　土地自由流转还有非常多的好处，提高资源使用效率、减少征地纠纷、缓解社会矛盾，这些都是非常重要的，我们的任何改革，都应该往这方面靠近，能靠多近是多近。从这个意义上讲，我们不能满足于提高农地征收补偿标准，而应该进一步要求放松农地转让限制。　　本文刊发于搜狐财经《微观财经》栏目，转载请注明出处，并保持文章完整性。</span></p>', '100001');
INSERT INTO cms_content VALUES ('73', '74', '', '0');
INSERT INTO cms_content VALUES ('74', '75', '', '0');
INSERT INTO cms_content VALUES ('75', '76', '', '0');
INSERT INTO cms_content VALUES ('76', '77', '', '0');
INSERT INTO cms_content VALUES ('77', '78', '', '0');
INSERT INTO cms_content VALUES ('78', '79', '', '0');
INSERT INTO cms_content VALUES ('79', '80', '', '0');
INSERT INTO cms_content VALUES ('80', '81', '', '0');
INSERT INTO cms_content VALUES ('81', '82', '', '0');
INSERT INTO cms_content VALUES ('82', '83', '', '0');
INSERT INTO cms_content VALUES ('83', '84', '', '0');
INSERT INTO cms_content VALUES ('84', '85', '', '0');
INSERT INTO cms_content VALUES ('85', '86', '', '0');
INSERT INTO cms_content VALUES ('86', '87', '', '0');
INSERT INTO cms_content VALUES ('87', '88', '', '0');
INSERT INTO cms_content VALUES ('88', '89', '', '0');
INSERT INTO cms_content VALUES ('89', '90', '', '0');
INSERT INTO cms_content VALUES ('90', '91', '', '0');
INSERT INTO cms_content VALUES ('91', '92', '', '0');
INSERT INTO cms_content VALUES ('92', '93', '', '0');
INSERT INTO cms_content VALUES ('93', '94', '<p><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">码头工潮中工人们把他画成奸商和魔鬼，李嘉诚还开玩笑：把我的头画得还是笑的</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　创业至今六十多年，虽历经多次经济危机，但没有一年亏损；自从1999年被福布斯评为全球华人首富以来，15年间不管风云如何变幻始终稳居这一宝座。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　这就是李嘉诚。他究竟是怎样的一个人？</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\"></span></p><div class=\"video\" style=\"border:1px solid #D1D1D1;margin:26px 30px 0px 0px;padding:5px 0px;font-size:12px;float:left;width:368px;background-color:#F1F1F1;color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;\"><div class=\"text-video-focus\" style=\"border:0px;margin:0px;padding:0px;text-align:center;\"><embed id=\"player44\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"360\" height=\"305\" src=\"http://tv.sohu.com/upload/swf/20131128/Main.swf\" quality=\"high\" bgcolor=\"#000000\" allowfullscreen=\"true\" allowscriptaccess=\"always\" wmode=\"transparent\" flashvars=\"&cmscat=200057137;221409837;250176934;390999609&oad=&ead=&pad=&fbarad=&flogoad=&flogodelay=&tlogoad=&tlogodelay=&fbottomad=&fbottomdelay=&ftitlead=&ftitledelay=&domain=inner&sogouBtn=0&skin=0&api_key=&enforceMP4=&xuid=&recommend=&showRecommend=&playercover= http://i2.itc.cn/20131129/3122_63ba202e_8db2_87fd_8cdf_507bb8cf41e1_1.jpg&vid=673016&autoplay=false&pageurl=http://business.sohu.com/20131129/n390999609.shtml&showCtrlBar=1&jump=0&sid=1304190843476442&pid=338173608&topBarFull=1\" style=\"border:0px;margin:0px;padding:0px;\" /></div><div class=\"num-share\" style=\"border:0px;margin:7px auto 0px;padding:0px;height:23px;width:360px;\"><div class=\"btn-num\" style=\"border:0px;margin:0px 0px 0px 10px;padding:0px;float:left;display:inline;\"><a class=\"vbtn-ding\" href=\"http://business.sohu.com/20131129/n390999609.shtml\" style=\"border:0px;margin:0px;padding:0px 10px 0px 35px;color:#666666;text-decoration:none;float:left;cursor:pointer;display:inline-block;height:20px;overflow:hidden;line-height:22px;background-image:url(http://news.sohu.com/upload/article/2012/images/video_icon.gif);background-position:0px -3px;background-repeat:no-repeat no-repeat;\">5517</a><a class=\"vbtn-cai\" href=\"http://business.sohu.com/20131129/n390999609.shtml\" style=\"border-width:0px 0px 0px 1px;border-left-style:solid;border-left-color:#C7C7C7;margin:0px;padding:0px 10px 0px 35px;color:#666666;text-decoration:none;float:left;cursor:pointer;display:inline-block;height:20px;overflow:hidden;line-height:22px;background-image:url(http://news.sohu.com/upload/article/2012/images/video_icon.gif);background-position:0px -123px;background-repeat:no-repeat no-repeat;\"><em style=\"border:0px;margin:0px;padding:0px;font-style:normal;\">1635</em></a></div><div class=\"vbtn-fa\" style=\"border:0px;margin:0px;padding:2px 0px 0px 35px;float:right;cursor:pointer;height:21px;overflow:hidden;line-height:22px;background-image:url(http://news.sohu.com/upload/article/2012/images/video_icon.gif);width:78px;background-position:0px -243px;background-repeat:no-repeat no-repeat;\"><ul style=\"list-style-type:none;\" class=\" list-paddingleft-2\"><li class=\"s-wb-sohu\"><p><a href=\"http://business.sohu.com/20131129/n390999609.shtml#\" title=\"转发至搜狐微博\" style=\"border:0px;margin:0px;padding:0px;color:#005599;text-decoration:none;width:16px;height:16px;display:block;background-image:url(http://news.sohu.com/upload/article/2012/images/bg_video_share.gif);background-position:0px 0px;background-repeat:no-repeat no-repeat;\"></a></p></li><li class=\"s-wb-sina\"><p><a href=\"http://business.sohu.com/20131129/n390999609.shtml#\" title=\"转发至新浪微博\" style=\"border:0px;margin:0px;padding:0px;color:#005599;text-decoration:none;width:16px;height:16px;display:block;background-image:url(http://news.sohu.com/upload/article/2012/images/bg_video_share.gif);background-position:0px -20px;background-repeat:no-repeat no-repeat;\"></a></p></li><li class=\"s-kj-qq\"><p><a href=\"http://business.sohu.com/20131129/n390999609.shtml#\" title=\"转发至QQ空间\" style=\"border:0px;margin:0px;padding:0px;color:#005599;text-decoration:none;width:16px;height:16px;display:block;background-image:url(http://news.sohu.com/upload/article/2012/images/bg_video_share.gif);background-position:0px -40px;background-repeat:no-repeat no-repeat;\"></a></p></li><li class=\"s-rr\"><p><a href=\"http://business.sohu.com/20131129/n390999609.shtml#\" title=\"转发至人人网\" style=\"border:0px;margin:0px;padding:0px;color:#005599;text-decoration:none;width:16px;height:16px;display:block;background-image:url(http://news.sohu.com/upload/article/2012/images/bg_video_share.gif);background-position:0px -60px;background-repeat:no-repeat no-repeat;\"></a></p></li></ul></div></div><div class=\"video-mutu\" style=\"border-width:1px 0px 0px;border-top-style:solid;border-top-color:#D1D1D1;margin:4px auto 0px;padding:3px 0px 0px;width:358px;height:20px;overflow:hidden;line-height:20px;color:#666666;\">[热点]<a href=\"http://tv.sohu.com/20131114/n390112877.shtml?pvid=c37eb8a749117397\" target=\"_blank\" title=\"病危者捐遗体 红会：来填表\" style=\"border:0px;margin:0px;padding:0px;color:#005599;text-decoration:none;\">病危者捐遗体 红会：来...</a> |  <a href=\"http://tv.sohu.com/20131125/n390721792.shtml?pvid=c37eb8a749117397\" target=\"_blank\" title=\"“讹人”老太接受采访 痛哭喊冤\" style=\"border:0px;margin:0px;padding:0px;color:#005599;text-decoration:none;\">“讹人”老太接受采访 痛...</a></div></div><p><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　创业至今六十多年，虽历经多次经济危机，但没有一年亏损；自从1999年被福布斯评为全球华人首富以来，15年间不管风云如何变幻始终稳居这一宝座。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　这就是李嘉诚。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　但此时，他正前所未有地深陷入一场“撤资”风波。接连抛售内地和香港的一些资产，掀起轩然大波，被舆论认为是一个“风向标事件”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　2013年11月22日，南方周末记者探秘风波的最中心，位于香港中环的长江集团中心，李嘉诚的办公所在地。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　14：30，门打开，85岁的李嘉诚满面笑容地走进来，步子很快，没有任何搀扶。他和每一个人握手，微微弯腰递上名片，微笑着，认真地看着每一个人，近乎多余地用带潮州音的普通话自我介绍：“李嘉诚”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚，究竟是怎样一个人？</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\"></span><strong style=\"border:0px;margin:0px;padding:0px;color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">成为超人之前的那个人</strong><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“外人都将他看作超人，而他自己，则始终将自己看成是变成超人之前的那个人。”</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　85岁的李嘉诚，从早年创业至今，一直保持着两个习惯：一是睡觉之前，一定要看书，非专业书籍，他会抓重点看，如果跟公司的专业有关，就算再难看，他也会把它看完；二是晚饭之后，一定要看十几二十分钟的英文电视，不仅要看，还要跟着大声说，因为“怕落伍”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　这种勤奋和自律，非一般人能比。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　关于工作习惯，最为著名的细节是李嘉诚的作息时间：不论几点睡觉，一定在清晨5点59分闹铃响后起床。随后，他听新闻，打一个半小时高尔夫，然后去办公室。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　熟悉李嘉诚的人士表示，他是一个危机感很强的人，他每天90%的时间，都在考虑未来的事情。他总是时刻在内心创造公司的逆境，不停地给自己提问，然后想出解决问题的方式，“等到危机来的时候，他就已经做好了准备”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　一个被广为传播的事实是，2008年，金融危机爆发，而在这之前，李嘉诚已经准确预见，并早已做好了准备，等到危机来临时，集团不但安然无恙，还从中获得了扩张的机会。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　作为一个商人，李嘉诚对数字尤其敏感。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　从20岁起，李嘉诚便热衷于阅读其他公司的年报。除了寻找投资机会，也从中学习其他公司会计处理方法的优点和漏弊，以及公司资源的分布。他自称可以对集团内任何一间公司近年发展的数据，准确地说出其中的百分之九十以上：“看一看便能牢记，是因为我投入。”</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　对于信息的重要性，李嘉诚常常一再强调。虽已85岁高龄，但他对新技术的了解，并不逊于年轻人。在李的办公室，左手边摆着两台电脑，实时显示旗下公司的股价变动。而在侧面办公桌上，则摆着他的苹果笔记本，这是他日常工作所用的。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　每天早晨，李嘉诚都能在办公桌上收到一份当日的全球新闻列表。据一位跟随他十余年的人士透露，这份新闻列表并非摘要，而是一个又一个的新闻标题，多来自《华尔街日报》、《经济学人》、《金融时报》等全球知名媒体。李会先浏览，然后选择其中想看的文章，让人翻译出来细读。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚的这个习惯坚持了十余年，并因此而专门设立了一个四人小组，负责这项工作。而他之所以看标题，不看摘要，是不想被别人误导。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　据另一位员工透露，以前，李嘉诚看新闻喜欢纸质版，iPad出来之后，他就只看电子版了。李现在用的是iPhone手机。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　这些习惯，让李嘉诚始终站在资讯的最前沿，也让这个老人投资了一系列高科技公司。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚旗下的维港投资，最近这两年，投资了六十多家科技公司，其中不乏很多明星项目，例如Facebook、Skype、Siri、Waze、Spotify、Summly等等，而这个团队总共不过8个人。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“他并不是一个生活在象牙塔中的人，相反，他对潮流的把握远超很多年轻人。”一位下属透露。李嘉诚旗下公司无数，连很多下属都数不清，直接向他汇报的，就有200人左右。每个月，李都会跟海外管理层进行会议，每年会“出外巡检”三四次。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李的多位下属向南方周末记者透露，李嘉诚非常善于问问题，遇到一个新事物，他总是会想，这和我、和我的公司有什么关系？他总是会将自己的问题交给专业的人去寻找答案。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　比如，在Facebook等社交媒体开始火起来的时候，李嘉诚曾经问过旗下公关团队一个问题：怎么看待其和平面媒体以及网上媒体对集团公关的影响？</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　为了回答李嘉诚的这个问题，公关团队专门召开最高会议进行讨论，形成专题报告向李汇报。有趣的是，最后这个团队甚至开发了一款软件，专门用以评价不同渠道的公关效果。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“如果李先生是个停滞的人，就不可能有今日之成就。”李嘉诚的一位下属感叹，“外人都将他看成超人，而他自己，则始终将自己看着是变成超人之前的那个人”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\"></span><strong style=\"border:0px;margin:0px;padding:0px;color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">与自己相处</strong><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　他几乎从不生气，见到所有人，都是一副标准的笑脸。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　熟悉李嘉诚的人，也常说他们看不懂他。他几乎从不生气，见到所有人，都是一副标准的笑脸。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“他真的没有生气过吗？他会因为什么事情而难过？他发过火吗？”面对这一连串问题，几位跟了李嘉诚十年以上的下属一脸迷茫，想了很久，他们实在回忆不起是否有过这样的场景。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　当你问起李嘉诚强势的一面时，其中一位跟了李二十余年的高层反问：强势怎么定义？</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　在她这么多年的印象中，李决断非常之快，但并不是个咄咄逼人的人，他很会倾听下属的意见，“如果你是对的，他会听你的，而不是坚持他的”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　在生活中，李嘉诚时常表现出单纯快乐的一面。走在香港的大街上，李就变成了一个念旧好玩的老头，总是和身边的人说，这里原来是啥样的。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚还每周为儿孙们亲任导师，自己准备课程、案例，据一位接近李的下属透露，3年来，他给孙辈们上的课，既有道德讨论，也有文化批评、世界经济。孙子、孙女年纪都很小，要演绎生动，难度很高，但李却乐此不疲。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　为了告诉儿孙们风险是怎么回事，李嘉诚甚至还专门花了8000美元，去印出了四张AIG股票。他把这张股票裱起来，标注了这个世界上最大的保险公司在金融危机中破产的故事，并且写上“以此为鉴，可惕未来”。有趣的是，这时候他的孙儿们还不过几岁。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　另一位跟了李十几年的下属透露，李嘉诚喜欢看电影，而且，看电影时，他的“代入感”很强，每次都会选择一个自己喜欢的角色，然后随着剧情起伏，“过他们的生活”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　在这位下属看来，李嘉诚其实是个感情很丰富的人，但他与众不同之处在于，他很懂得控制自己的情感。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　1996年，李嘉诚的长子李泽钜被世纪大盗张子强绑架，对方单枪匹马到李家中，开口就要20亿，李当场同意，但表示“现金只有10亿，如果你要，我可以到银行给你提取”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李的镇静，连张子强都很意外，张问他：你为何这么冷静？</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李回答道：因为这次是我错了，我们在香港知名度这么高，但是一点防备都没有，比如我去打球，早上五点多自己开车去新界，在路上，几部车就可以把我围下来，而我竟然一点防备都没有，我要仔细检讨一下。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚告诉南方周末记者，当时他劝告张子强：你拿了这么多钱，下辈子也够花了，趁现在远走高飞，洗心革面，做个好人；如果再弄错的时候，就没有人可以再帮到你了。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　有趣的是，据李嘉诚透露，后来张子强又打来电话，李说，你搞什么鬼，怎么还有电话？张子强在电话中说，李生，我自己好赌，钱输光了，你教教我，还有什么是可以保险投资的？</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚答道：我只能教你做好人，但你要我做什么，我不会了。你只有一条大路，远走高飞，不然，你的下场将是很可悲的。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　2013年11月22日，李嘉诚向南方周末记者回忆当时的情形时，语气平静，就像是在讲述一段别人的历史。其中的惊险和锥心之痛，似乎全都烟消云散。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚将这种冷静归于他喜欢看书，“我喜欢看书，什么书都看，这对我都有用，今天有用，明天也有用。所以，很多大事来的时候，我也能解决”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　而一位跟了李十几年的下属则将这种冷静归结到他少年的成长经历上。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚出身于书香门第，爷爷是清朝最后一科秀才，两位伯父在民国初年，还曾跨海留洋取得日本东京帝国大学博士学位。而李的父亲，则是小学校长。但因为二战爆发，故乡潮州被日本侵袭，李和家人逃难到香港。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　没想到，1941年日本攻占香港，母亲只好带着弟妹回老家。更没想到，贫困抑郁的父亲染上肺结核，半年之后就去世了。14岁的李，独自面对父亲的死亡与埋葬，“一夕长大”。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　更祸不单行的是，年少的李嘉诚也染上了肺结核。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“这是我一生中最艰难的时刻。”李嘉诚回忆说，“我告诉自己不能死，身为大儿子，为了母亲和弟妹，为了前途，一定要做好自己的工作。”</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　没有钱去看病，李嘉诚便只能用自己发明的方法对付肺病，清晨到山顶呼吸新鲜空气，李替厨师写家信，以交换鱼汁与鱼杂汤，强迫自己喝下这平日最讨厌的食物，只因知道这些汤有营养价值……</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　一位采访过李嘉诚的记者写道：李嘉诚的心胸之大—收购和记黄埔此等之事一直秘不外宣，甚至自己的老婆也不知道，一切都自己心算—是撑出来的：丧父、养家、肺病、贫穷……当一个人在自己15岁左右经历这一切挑战而没有被打垮，他就没有什么是不能承受的了。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\"></span><strong style=\"border:0px;margin:0px;padding:0px;color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">孤独是他最自然的常态</strong><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“他会不断自己抛问题、自己回答。”</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　虽为华人首富，但李嘉诚却过着清教徒般的生活。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“他11岁就逃出来，一路上都是一个人在奋斗，他老和我们讲自己缝衣服，到现在依然如此。”一位下属告诉南方周末记者，李的袜子都是不能见人的，因为他自己缝补了好多次。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李鼻梁上的黑框眼镜，打从1972年长江实业上市记者会开始，就再也没有变过。手上的手表，也总是同一块，直到最近在一次旅行中看到一款西铁城的太阳能手表，他非常喜欢，才很大方地跟售货员说：“你不用给我打折啦。”这款手表的售价是3000港币。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　镜头前，李总是蓝黑色西装套装搭配白衬衫，而领带永远是蓝白色系，李乐于向别人展示他穿了数十年的西装皮鞋胜于向别人展示他成功的生意。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李的办公室，像他的打扮一样简单，除了一望无际的维多利亚港海景。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　偌大的办公桌上，只有一沓很小的便笺纸，两支笔，一副放大镜，李每周在这里工作五天半。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　办公桌的对面，是黑色的沙发和茶几。没有靠垫，没有烟灰缸，也没有潮州人最喜欢的功夫茶具，只是孤零零地摆着一个装饰盒。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李办公室最惹眼的，是清代儒将左宗棠题于江苏无锡梅园的诗句：“发上等愿，结中等缘，享下等福；择高处立，寻平处住，向宽处行。”</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　这24个字，凝聚着深刻的人生哲理，而李嘉诚则将其视为自己的人生信条。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“孤独感是他最好的朋友，也是他最自然的常态。”那位熟知李嘉诚经历的高层如此评价道。在她看来，经历过少年磨难的李嘉诚，早已习惯了孤独的感觉。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　回忆早年的苦学生涯，李说，“别人是自学，我是‘抢学问’，抢时间自学。一本旧《辞海》，一本老师版的教科书，自己自修。”</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　这是一个孤独之旅，命运剥夺他的，李要靠自己抢回来。没有学历、人脉、资金，想出人头地，自学是他唯一武器。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　李嘉诚自律惊人，除了《三国志》与《水浒传》，他不看小说，不看“没有用”的书。捡起教科书，李时而扮演学生，时而扮演老师，摸索教学和出题的逻辑，寻找每个篇章的关键词句，模拟师生对话，自问自答。</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　“孤独是他的能量，也是他的朋友。独处时，他脑海会开始做思想的挣扎，会不断自己抛问题、自己回答。”李的一位友人说，“他现在的习惯，就是来自于此。”</span><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><br style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\" /><span style=\"color:#333333;font-family:宋体, simsun, sans-serif, Arial;line-height:26px;background-color:#FFFFFF;\">　　在创办长江塑料厂时，李又开始订阅英文《当代塑料》及其他西方专门的塑料杂志。与此同时，李开始将部分资金投资华尔街上市公司股票，李从不按直觉投资，而是仔细研读公司财报，研究商业规则。华尔街财报是李的英文老师、商业教练，也是李的私人投资获利来源。</span></p><p><br /></p>', '100001');
INSERT INTO cms_content VALUES ('94', '95', '<p>sdfgsd</p>', '100001');
INSERT INTO cms_content VALUES ('95', '96', '', '100001');
INSERT INTO cms_content VALUES ('96', '97', '', '100001');
INSERT INTO cms_content VALUES ('168', '169', '<p><span style=\"color:#666666;font-family:Arial, Helvetica, &#39;Microsoft YaHei&#39;, simsun;font-size:12px;font-weight:600;line-height:39px;background-color:#FFFFFF;\">我校风光</span></p>', '121502');
INSERT INTO cms_content VALUES ('169', '170', '<p><span style=\"color:#666666;font-family:Arial, Helvetica, &#39;Microsoft YaHei&#39;, simsun;font-size:12px;font-weight:600;line-height:39px;background-color:#FFFFFF;\">学校领导<img src=\"http://dev-images.dodoedu.com/image/school_cms_121502_13977120601437-650.jpg\" title=\"hrj_看图王.jpg\" /></span></p>', '121502');
INSERT INTO cms_content VALUES ('170', '171', '<p><span style=\"color:#666666;font-family:Arial, Helvetica, &#39;Microsoft YaHei&#39;, simsun;font-size:12px;font-weight:600;line-height:39px;background-color:#FFFFFF;\">三级文章</span></p>', '121502');
INSERT INTO cms_content VALUES ('173', '174', '<p><img src=\"http://dev-images.dodoedu.com/image/school_cms_121584_14044435547436-650.jpg\" title=\"Chrysanthemum.jpg\" /></p><script _ue_org_tagname=\"script\">window.parent.UE.instants[\'ueditorInstant0\']._setup(document);</script>', '121584');
INSERT INTO cms_content VALUES ('174', '175', '<p>sadfas</p><p><br /></p><script _ue_org_tagname=\"script\">window.parent.UE.instants[\'ueditorInstant0\']._setup(document);</script>', '121584');
INSERT INTO cms_content VALUES ('175', '176', '<p>434434334</p>', '121584');
INSERT INTO cms_content VALUES ('183', '184', '<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"1008\" style=\"width:739px;\"><tbody><tr><td align=\"center\" valign=\"top\" width=\"749\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"749\" style=\"width:739px;\"><tbody><tr><td align=\"center\" background=\"http://www.sghex.com/images/about_mid.jpg\" height=\"680\" valign=\"top\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"680\"><tbody><tr><td colspan=\"2\" class=\"txt\" align=\"left\"><p style=\"text-align:left;\"><img src=\"http://www.sghex.com/editor/uploadfile/20141112094646461.jpg\" border=\"0\" /></p><p style=\"text-align:left;\"><span style=\"font-size:12px;\">湖北省武昌水果湖二小位于美丽的东湖之滨，地处省委、省政府所在地，直属于省教育厅，学生主要来源于省直机关干部的子弟。始建于</span><span lang=\"EN-US\">1962年，1978年独立成校，是一所规模较大的省级示范学校和首批武昌名校。<o:p></o:p></span></p><p><span style=\"font-size:12px;\">　　学校现有42个教学班，在校学生2262人。学校师资力量雄厚，在职教职 &nbsp;107人，其中特级教师5人，中学高级教师15人，小学高级教师62人，省级专家2人。本科学历56人，大专学历32人，中专学历16人，其他4人，研究在读2人。全国艺术教育先进个人1人，全国“星星火炬”奖章获得者1人，省、市优秀教师5人，省“十佳”辅导员2人，受市、区表彰的教师40余人次。近10位学科带头人参加了我省语文、音乐、美术、思想品德、科学、心理、计算机等教材的编写工作。<o:p></o:p></span></p><p><span style=\"font-size:12px;\">　　学校占地17500平方米，(约21亩地)，建筑总面积15000多平方米。现有教学楼两栋，综合办公楼一栋。拥有一流的教学设施和人文化环境，逸夫教学楼装有中央空调，所有办公，室配备了电脑，教室内配有图书柜、电教讲台、网络系统，每位学生都有一个“学具柜”。在“每日钢琴之星”优美的琴声中步入独具匠心的校门，只见大厅中间置放着一台钢琴和一个大地球仪，抬头看见满天星星闪烁，九大行星高高悬挂，仿佛进入了宇宙星空。师生每日伴随40分钟的音乐铃声上课、下课、放学，在既紧张又轻松的环境中学习工作。今年正在兴建新科技楼和艺术楼各一栋，将为全面实施素质教育提供更优良的物质条件。<o:p></o:p></span></p><p><span style=\"font-size:12px;\">　　学校管理做到科学化、人文化、情感化、信息化。领导班子由罗汉萍校长、徐明娜书记等七人组成，精干务实、团结协作、开拓进取，每位领导各负其责，独当一面，是一个充满活力的集体。学校实行“分层管理、民主管理、自主管理”的管理模式，各年级设立年级组长(教育)、教研组长(教学)、科研组长(科研)，分工合作，齐抓共管。各班级配备正副班主任，每位教师都肩负着“既教书又育人”的使命。此举措极大地调动了广大师生全员参与、自我管理的主动性和积极性，提高了教育教学管理效率。<o:p></o:p></span></p><p><span style=\"font-size:12px;\">　　广大教职工明确学校办学理念：育人为本，共同成长(即学生、教师、家长、校长、学校共同成长)牢记校训：求实、合作、创新、超越和教风：敬业、爱生、博学、奉献。努力培养教师的“四心”：政治上要有上进心，工作上要有责任心，学习上要虚心，生活上要有爱心。要求教师努力做到“四求”：“求真”：真诚、真实、真理；“求实”：务实、扎实、踏实：“求勤”：勤奋、勤正、勤俭：“求和”：和气、和蔼、和谐。<o:p></o:p></span></p><p><span style=\"font-size:12px;\">　　学校实施“科研兴校”战略，大力推进课程改革。为拓宽学校教育时空，着力开发学校课程，不断丰富、完善课程结构，加大改革力度，教学内容从书本知识向社会实践拓展，教学形式从封闭走向开放，逐步形成了“课堂+社会、书本+实践”的办学特色。课程改革注重教学过程研究，构建民主、平等、和谐的教学氛围；运用自主、探究、合作的学习方式；突出发展、创新、开放的教育理念。对课堂结构大胆的改革与创新，注意学生原有的知识层面、生活经验对新的学习的影响，注意评价对学生发展的影响，注意学生的年龄特征、心理需求对学习的影响。<o:p></o:p></span></p><p><span style=\"font-size:12px;\">　　大力开发校本课程，突出“六性两化”——地方性、特色性、教育性、灵活性、持续性、科学性、个性化、人文化。课程表上赫然印着电影、英语唱游、陶艺、音乐创作、心理素质教育等课程。周大春老师把小器材引入体育课堂，孩子们像民间艺人一样抖起了空竹，抛接自如；彭利明老师用“MIDI”辅助音乐教学，小小孩童竟当上了“作曲家”，作品还堂而皇之地结集出版；马新银主任和美术组的张一帆等老师让“陶泥巴”走进了美术教室，孩子们居然让泥巴“讲”起了故事，烧成的陶器还能走出国门，与外国的学生交流技艺，传递<span style=\"font-size:16px;font-family:宋体;font-size:12px;font-family:Times New Roman;\">文华……</span></span></p><p><span style=\"font-size:12px;\">　　大力加快信息化进程。提高师生运用信息技术的效率，教师用计算机辅助教学，使用电子备课本；通过光纤宽带上网，实现千兆到学校，百兆到桌面，学生运用e21网站高速获取网络教育信息资源，并将自己的作品上网交流：建立和推广班级网站，家长与老师通过网上谈话，了解学生学习情况等。<o:p></o:p></span></p><p><span style=\"font-size:12px;\">　　加强英语教学研究，加大对外交流力度。设立“英语角”，为学生自由交流创造和谐的环境。引进外籍教师，逐步推行双语教学，努力培养能适应国际化社会需求的复合型人才。加强学生艺术修养的培养，增设音乐欣赏课，提高学生艺术欣赏素养。经常举行“艺术节”、 “体育节”、“科技节”，为学生的小发明，小创造，小制作，艺术作品提供展示空间。加强科科学、综合实践活动课的教学研究，增强学生环保意识和创新意识，培养学生实践能力和创<span lang=\"EN-US\"><o:p></o:p></span><span style=\"font-size:16px;font-family:宋体;\">造能力。<span lang=\"EN-US\"><o:p></o:p></span></span></span></p><p><span style=\"font-size:12px;\">　　改革评价制度。评价采用等级评价，注重形成性评价、科学性评价、发展性评价、个性化评价。多一把尺子，多一个衡量标准，多一个学生发展的空间。家长有了评价权，学生的《成长记录手册》和《联系本》上写满了他们对教改、对学校、对教师＼、对学生成长的评语……<span lang=\"EN-US\"><o:p></o:p></span></span></p><p><span style=\"font-size:12px;\">　　继续深化教育教学改革，加强课题研究管理。落实<span lang=\"EN-US\">{学校“十五”科研规划}，以科研促进教学，做好三项国家级课题(即《小学生健康心理培养与研究》、《全脑型体育教育模式研究》、《学科四结合实验研究》)、五项省级课题(即《小学艺术教育和学生审美能力的培养研究》、《新课程实施中的合作学习方式研究》、《新课程实施中的主体性及其发展的研究》、《新课程实施中综合实践活动研究》、《班级为本管理模式的研究》)以及四项市、区级课题的科研工作。<o:p></o:p></span></span></p><p><span style=\"font-size:12px;\">　　近两年学校被评为“省绿色学校”、“省教改名校”、“湖北省活动课先进学校”、“区最佳文明单位”、“区科技特色学校”、“区艺术教育先进学校”等。《湖北日报》、《长江日报》、《楚天都市报》、《武汉晚报》等新闻媒体多次对我校的教育改革成果进行报道。“九五”期间，教育科研给我校带来了新的生机，也取得了许多骄人的成绩：“行为规范养成教育”、“小学音乐电子琴<span lang=\"EN-US\">MID工辅助教学实验”、“体育小器材———空竹进课堂实验”被列为湖北省重点实验课题，已通过湖北省教科所、教研室和国家教育部规划办鉴定，并验收结题。教师获省级二等奖以上的论文、比赛课等多达百余人次；在国家级刊物上发表的沦文、出版的专著达90余篇(部)。在武汉市“楚才杯”作文竞赛中，该校学生获奖人数及获奖等级一直名列前茅，学生陈薇、陈梦颖、张百渺、吴戈立更是“三连冠”乃至“四连冠”：在省、市、区艺术小人才、科技、体育等比赛中获奖300余人次。<o:p></o:p></span></span></p><p><span style=\"font-size:12px;\">　　学校拟定了今后五年的发展规划，描绘了学校发展蓝图，教师要成为“情感型”、“学习型”、“科研型”、“专家型”的教育者。学校更构建成为“学习型组织”，要成为省内龙头，国内知名，国际有影响的名校。让校园飘满书香，成为艺术的摇篮，科技的天堂，—个让人充满幸福回忆的学习乐园。</span></p></td></tr></tbody></table></td></tr><tr><td height=\"55\"><img src=\"http://www.sghex.com/images/about_btn.jpg\" border=\"0\" height=\"55\" width=\"749\" /></td></tr></tbody></table></td><td width=\"20\"><br /></td></tr></tbody></table><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"1008\" style=\"width:739px;\"><tbody><tr><td bgcolor=\"#d9ebdf\" height=\"45\"><br /></td></tr><tr><td class=\"foot\" align=\"center\" background=\"http://www.sghex.com/images/infoot.jpg\" height=\"149\"><br /> &nbsp; &nbsp; &nbsp;武昌水果湖第二小学 版权所有 地址：湖北省武昌水果湖横路31号 邮编：430071<br /> &nbsp; &nbsp; &nbsp;电话：027-87236058 传真<br /> &nbsp; &nbsp; &nbsp;鄂ICP证1103685-2号 技术支持：<a href=\"http://www.wuda-website.com/\" target=\"_blank\">珞珈学子网站建设</a><a href=\"http://whwm.cjn.cn/\" target=\"_blank\">武汉文明网</a></td></tr></tbody></table><div id=\"Div2\" style=\"width:335px;height:186px;position:absolute;left:361.134px;top:569.95px;\"><img src=\"http://www.sghex.com/images/1.jpg\" border=\"0\" /></div><p><br /></p>', '117686');

-- ----------------------------
-- Table structure for `cms_relate`
-- ----------------------------
DROP TABLE IF EXISTS `cms_relate`;
CREATE TABLE `cms_relate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `column_id` int(11) NOT NULL COMMENT '栏目',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `tag` varchar(150) NOT NULL COMMENT '标签',
  `file` varchar(150) NOT NULL COMMENT '附件',
  `vnum` int(11) NOT NULL COMMENT '浏览数',
  `keywords` varchar(100) NOT NULL COMMENT '关键字',
  `description` varchar(250) NOT NULL COMMENT '摘要',
  `notice` varchar(500) NOT NULL COMMENT '通知对象',
  `content_id` int(11) NOT NULL COMMENT '关联内容',
  `school_id` int(11) NOT NULL COMMENT '学校ID',
  `user_id` varchar(21) NOT NULL COMMENT '用户ID',
  `top` int(11) NOT NULL COMMENT '内容置顶',
  `allowcomments` int(11) NOT NULL COMMENT '是否允许评论',
  `state` int(11) NOT NULL COMMENT '状态',
  `rorder` int(11) NOT NULL COMMENT '排序',
  `created_at` int(11) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `column_id` (`column_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8 COMMENT='cms栏目内容关联表';

-- ----------------------------
-- Records of cms_relate
-- ----------------------------
INSERT INTO cms_relate VALUES ('73', '21', '征地补偿提高十倍农民成土地市场主体', '', '', '25', '', '农民有本事可以一亩地卖几百万上千万，就像现在政府卖地一样；农民高兴也可以分毫不取出让土地。最终能卖什么样的价格不重要，重要的是要把这自主权交换给农民，而不是说只要政府高兴了，就可以随便从农民手中掠夺土地，然后说爱给你多少补偿就给多少。有限的进步　　周克成（财经', '', '72', '100001', 'w36451978107373010061', '0', '0', '1', '73', '1385711588');
INSERT INTO cms_relate VALUES ('94', '22', '李嘉诚自述长子遭绑架：绑匪索要20亿当场获准', '', '', '14', '', '码头工潮中工人们把他画成奸商和魔鬼，李嘉诚还开玩笑：把我的头画得还是笑的　　创业至今六十多年，虽历经多次经济危机，但没有一年亏损；自从1999年被福布斯评为全球华人首富以来，15年间不管风云如何变幻始终稳居这一宝座。　　这就是李嘉诚。他究竟是怎样的一个人？55', '', '93', '100001', 'w36451978107373010061', '0', '0', '1', '94', '1385712208');
INSERT INTO cms_relate VALUES ('95', '22', 'sdfg', '', '', '3', '', 'sdfgsd', '', '94', '100001', 'w36451978107373010061', '0', '0', '1', '95', '1385712685');
INSERT INTO cms_relate VALUES ('96', '28', 'dfs', '', '', '3', '', 'dfg', '', '95', '100001', 'w36451978107373010061', '0', '0', '1', '58', '1385712705');
INSERT INTO cms_relate VALUES ('97', '28', '恩施教育网', '', '', '0', '', 'esedu.com', '', '96', '100001', 'w36451978107373010061', '0', '0', '1', '96', '1385713002');
INSERT INTO cms_relate VALUES ('169', '16', '我校风光', '', '', '10', '', '我校风光', 'a:5:{s:7:\"teacher\";N;s:7:\"student\";N;s:6:\"parent\";N;s:5:\"class\";N;s:5:\"grade\";N;}', '168', '121502', 'w36451978107373010061', '0', '0', '1', '169', '1394088864');
INSERT INTO cms_relate VALUES ('170', '15', '学校领导', '', 'http://dev-images.dodoedu.com/image/school_cms_121502_13977121009495-650.jpg', '16', '', '学校领导', 'a:5:{s:7:\"teacher\";N;s:7:\"student\";N;s:6:\"parent\";N;s:5:\"class\";N;s:5:\"grade\";N;}', '169', '121502', 'w36451978107373010061', '0', '0', '1', '170', '1394088875');
INSERT INTO cms_relate VALUES ('171', '176', '三级文章', '', '', '14', '', '三级文章', 'a:5:{s:7:\"teacher\";N;s:7:\"student\";N;s:6:\"parent\";N;s:5:\"class\";N;s:5:\"grade\";N;}', '170', '121502', 'w36451978107373010061', '0', '0', '1', '171', '1394091004');
INSERT INTO cms_relate VALUES ('174', '115', 'aaa', '', 'http://dev-images.dodoedu.com/image/school_cms_121584_14044435626206-650.jpg', '23', 'aaa', '', 'a:5:{s:7:\"teacher\";N;s:7:\"student\";N;s:6:\"parent\";N;s:5:\"class\";N;s:5:\"grade\";N;}', '173', '121584', 'w36451978107373010061', '0', '0', '1', '175', '1404443575');
INSERT INTO cms_relate VALUES ('175', '115', 'aaa', '', '', '14', 'dasd,werqer', 'sadfas', 'a:5:{s:7:\"teacher\";N;s:7:\"student\";N;s:6:\"parent\";N;s:5:\"class\";N;s:5:\"grade\";N;}', '174', '121584', 'w36451978107373010061', '0', '0', '1', '1', '1404458878');
INSERT INTO cms_relate VALUES ('176', '123', '3434343', '', '', '7', '', '434434334', 'a:5:{s:7:\"teacher\";N;s:7:\"student\";N;s:6:\"parent\";N;s:5:\"class\";N;s:5:\"grade\";N;}', '175', '121584', 'w36451978107373010061', '0', '0', '1', '176', '1411437967');
INSERT INTO cms_relate VALUES ('184', '163', '学校简介 About', '', 'http://dev-images.dodoedu.com/image/school_cms_117686_14199087740482-650.jpg', '7', '', '湖北省武昌水果湖二小位于美丽的东湖之滨，地处省委、省政府所在地，直属于省教育厅，学生主要来源于省直机关干部的子弟。始建于1962年，1978年独立成校，是一所规模较大的省级示范学校和首批武昌名校。　　学校现有42个教学班，在校学生2262人。学校师资力量雄厚，', 'a:5:{s:7:\"teacher\";N;s:7:\"student\";N;s:6:\"parent\";N;s:5:\"class\";N;s:5:\"grade\";N;}', '183', '117686', 'w36451978107373010061', '0', '0', '1', '184', '1419908779');

-- ----------------------------
-- Table structure for `cus_cate`
-- ----------------------------
DROP TABLE IF EXISTS `cus_cate`;
CREATE TABLE `cus_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(120) NOT NULL COMMENT '分类名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `obj_id` char(32) NOT NULL COMMENT '对象ID',
  `obj_type` char(15) NOT NULL COMMENT '对象名称',
  `pid_path` char(100) DEFAULT NULL COMMENT '父ID 路径',
  `corder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `obj_id` (`obj_id`,`obj_type`,`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COMMENT='自定义分类';

-- ----------------------------
-- Records of cus_cate
-- ----------------------------
INSERT INTO cus_cate VALUES ('19', '小站文库', '0', '365', 'site_element', '0,19', null);
INSERT INTO cus_cate VALUES ('21', '学校分类', '0', '121502', 'school', '0,21', null);
INSERT INTO cus_cate VALUES ('22', '课程资源', '0', '375', 'site_element', '0,22', null);
INSERT INTO cus_cate VALUES ('26', '小站文库', '0', '381', 'site_element', '0,26', null);
INSERT INTO cus_cate VALUES ('28', '课件视频', '0', '385', 'site_element', '0,28', null);
INSERT INTO cus_cate VALUES ('29', '学校分类2', '21', '121502', 'school', '0,21,29', null);
INSERT INTO cus_cate VALUES ('30', '学校分类3', '29', '121502', 'school', '0,21,29,30', null);
INSERT INTO cus_cate VALUES ('31', '小站文库', '0', '388', 'site_element', '0,31', null);
INSERT INTO cus_cate VALUES ('48', '44444', '47', '121502', 'school', '0,21,47,48', null);
INSERT INTO cus_cate VALUES ('49', '55555', '47', '121502', 'school', '0,21,47,49', null);
INSERT INTO cus_cate VALUES ('61', '11111', '21', '121502', 'school', '0,21,61', null);
INSERT INTO cus_cate VALUES ('62', '22222', '21', '121502', 'school', '0,21,62', null);
INSERT INTO cus_cate VALUES ('63', '3333', '21', '121502', 'school', '0,21,63', null);
INSERT INTO cus_cate VALUES ('64', '5555555', '0', '121584', 'school', '0,64', null);
INSERT INTO cus_cate VALUES ('68', '分类1', '0', 'm36359802300862200030', 'user', '0,69', null);
INSERT INTO cus_cate VALUES ('71', '才下班vcxvb', '0', '236', 'user', '0,71', '0');
INSERT INTO cus_cate VALUES ('72', 'wwww', '0', '232', 'user', '0,72', '1');
INSERT INTO cus_cate VALUES ('74', '小站文库', '0', '419', 'site_element', '0,74', null);
INSERT INTO cus_cate VALUES ('80', '23', '21', '34', '33', '0,21,80', '2');

-- ----------------------------
-- Table structure for `sch_log`
-- ----------------------------
DROP TABLE IF EXISTS `sch_log`;
CREATE TABLE `sch_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `log_type` int(11) NOT NULL COMMENT '0 为后台操作，1 为前台操作',
  `log_title` varchar(255) NOT NULL COMMENT '操作描述',
  `log_controller` char(255) NOT NULL COMMENT '控制器',
  `log_action` char(255) NOT NULL COMMENT '操作',
  `log_ip` char(20) NOT NULL COMMENT 'IP地址',
  `log_school_id` int(11) NOT NULL COMMENT '学校ID',
  `log_user_id` char(21) NOT NULL COMMENT '用户',
  `log_user_name` varchar(50) NOT NULL,
  `log_time` int(11) NOT NULL COMMENT '时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1113 DEFAULT CHARSET=utf8 COMMENT='学校cms操作记录表';

-- ----------------------------
-- Records of sch_log
-- ----------------------------
INSERT INTO sch_log VALUES ('21', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386836091');
INSERT INTO sch_log VALUES ('22', '0', '添加学校管理员', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386838281');
INSERT INTO sch_log VALUES ('23', '0', '用户组：修改状态', 'School_Admin_Group', 'isok', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386840937');
INSERT INTO sch_log VALUES ('24', '0', '用户组：修改状态', 'School_Admin_Group', 'isok', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386840941');
INSERT INTO sch_log VALUES ('25', '0', '用户组：修改状态', 'School_Admin_Group', 'isok', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386840973');
INSERT INTO sch_log VALUES ('26', '0', '用户组：修改状态', 'School_Admin_Group', 'isok', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386840973');
INSERT INTO sch_log VALUES ('27', '0', '用户组：信息排序', 'School_Admin_Group', 'order', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386841167');
INSERT INTO sch_log VALUES ('28', '0', '用户组：信息排序', 'School_Admin_Group', 'order', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386841203');
INSERT INTO sch_log VALUES ('29', '0', '用户组：修改信息', 'School_Admin_Group', 'editPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386841590');
INSERT INTO sch_log VALUES ('30', '0', '用户组：修改信息', 'School_Admin_Group', 'editPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386842401');
INSERT INTO sch_log VALUES ('31', '0', '用户组：修改信息', 'School_Admin_Group', 'editPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386842430');
INSERT INTO sch_log VALUES ('32', '0', '用户组：修改状态', 'School_Admin_Group', 'isok', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386842445');
INSERT INTO sch_log VALUES ('33', '0', '用户组：修改状态', 'School_Admin_Group', 'isok', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386842447');
INSERT INTO sch_log VALUES ('34', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386842463');
INSERT INTO sch_log VALUES ('35', '0', '添加学校管理员吴鹏', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386895851');
INSERT INTO sch_log VALUES ('36', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.16', '121502', 's35951247001862320095', '覃俊华', '1386896203');
INSERT INTO sch_log VALUES ('37', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.16', '121502', 's35951247001862320095', '覃俊华', '1386896205');
INSERT INTO sch_log VALUES ('38', '0', '添加学校管理员徐杰', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386896579');
INSERT INTO sch_log VALUES ('39', '0', '添加学校管理员徐杰', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386900740');
INSERT INTO sch_log VALUES ('40', '0', '修改管理员权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386904702');
INSERT INTO sch_log VALUES ('41', '0', '修改管理员权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386904706');
INSERT INTO sch_log VALUES ('42', '0', '添加学校投票春节放假你满意吗？', 'School_Admin_Vote', 'addPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386905794');
INSERT INTO sch_log VALUES ('43', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386920607');
INSERT INTO sch_log VALUES ('44', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386920690');
INSERT INTO sch_log VALUES ('45', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386920736');
INSERT INTO sch_log VALUES ('46', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386920794');
INSERT INTO sch_log VALUES ('47', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386920797');
INSERT INTO sch_log VALUES ('48', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386920800');
INSERT INTO sch_log VALUES ('49', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386920817');
INSERT INTO sch_log VALUES ('50', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386921903');
INSERT INTO sch_log VALUES ('51', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386921907');
INSERT INTO sch_log VALUES ('52', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386921909');
INSERT INTO sch_log VALUES ('53', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386921913');
INSERT INTO sch_log VALUES ('54', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386921984');
INSERT INTO sch_log VALUES ('55', '0', '重置老师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386922428');
INSERT INTO sch_log VALUES ('56', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386922635');
INSERT INTO sch_log VALUES ('57', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386922795');
INSERT INTO sch_log VALUES ('58', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386923834');
INSERT INTO sch_log VALUES ('59', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386923946');
INSERT INTO sch_log VALUES ('60', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386923987');
INSERT INTO sch_log VALUES ('61', '0', '信息分类管理：删除栏目', 'School_Admin_Column', 'del', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386923992');
INSERT INTO sch_log VALUES ('62', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386927315');
INSERT INTO sch_log VALUES ('63', '0', '添加班级', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386927498');
INSERT INTO sch_log VALUES ('64', '0', '删除班级', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1386927504');
INSERT INTO sch_log VALUES ('65', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386927550');
INSERT INTO sch_log VALUES ('66', '0', '修改管理员权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386927571');
INSERT INTO sch_log VALUES ('67', '0', '修改管理员权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386927576');
INSERT INTO sch_log VALUES ('68', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928107');
INSERT INTO sch_log VALUES ('69', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928108');
INSERT INTO sch_log VALUES ('70', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928251');
INSERT INTO sch_log VALUES ('71', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928251');
INSERT INTO sch_log VALUES ('72', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928284');
INSERT INTO sch_log VALUES ('73', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928284');
INSERT INTO sch_log VALUES ('74', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928284');
INSERT INTO sch_log VALUES ('75', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928285');
INSERT INTO sch_log VALUES ('76', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928295');
INSERT INTO sch_log VALUES ('77', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928295');
INSERT INTO sch_log VALUES ('78', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1386928317');
INSERT INTO sch_log VALUES ('79', '0', '添加班级', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387159194');
INSERT INTO sch_log VALUES ('80', '0', '添加班级', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387159348');
INSERT INTO sch_log VALUES ('81', '0', '添加班级', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387159349');
INSERT INTO sch_log VALUES ('82', '0', '班级改名', 'School_Admin_Class', 'editClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387159369');
INSERT INTO sch_log VALUES ('83', '0', '删除班级', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387163786');
INSERT INTO sch_log VALUES ('84', '0', '删除班级', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164215');
INSERT INTO sch_log VALUES ('85', '0', '删除班级', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164219');
INSERT INTO sch_log VALUES ('86', '0', '将老师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164270');
INSERT INTO sch_log VALUES ('87', '0', '删除班级', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164327');
INSERT INTO sch_log VALUES ('88', '0', '删除班级', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164333');
INSERT INTO sch_log VALUES ('89', '0', '删除班级', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164360');
INSERT INTO sch_log VALUES ('90', '0', '删除班级', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164367');
INSERT INTO sch_log VALUES ('91', '0', '添加班级', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164585');
INSERT INTO sch_log VALUES ('92', '0', '删除长江数字学校小学一年级:一三', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164591');
INSERT INTO sch_log VALUES ('93', '0', '添加长江数字学校一五班', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387164764');
INSERT INTO sch_log VALUES ('94', '0', '添加长江数字学校一六班', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387172521');
INSERT INTO sch_log VALUES ('95', '0', '班级改名', 'School_Admin_Class', 'editClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387172530');
INSERT INTO sch_log VALUES ('96', '0', '删除长江数字学校小学一年级:一五0', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387172542');
INSERT INTO sch_log VALUES ('97', '0', '重置老师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387172592');
INSERT INTO sch_log VALUES ('98', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387173778');
INSERT INTO sch_log VALUES ('99', '0', '加入到新班级', 'School_Admin_Class', 'joinNewClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387175724');
INSERT INTO sch_log VALUES ('100', '0', '加入到新班级', 'School_Admin_Class', 'joinNewClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387176605');
INSERT INTO sch_log VALUES ('101', '0', '加入到新班级', 'School_Admin_Class', 'joinNewClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387176721');
INSERT INTO sch_log VALUES ('102', '0', '将老师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387176744');
INSERT INTO sch_log VALUES ('103', '0', '将老师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387176749');
INSERT INTO sch_log VALUES ('104', '0', '将老师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387177733');
INSERT INTO sch_log VALUES ('105', '0', '将老师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387178064');
INSERT INTO sch_log VALUES ('106', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1387178924');
INSERT INTO sch_log VALUES ('107', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:27.17.50.54', '121502', 's35951247001862320095', '覃俊华', '1387178936');
INSERT INTO sch_log VALUES ('108', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387179964');
INSERT INTO sch_log VALUES ('109', '0', '重置老师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387180023');
INSERT INTO sch_log VALUES ('110', '0', '重置老师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387180750');
INSERT INTO sch_log VALUES ('111', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387181716');
INSERT INTO sch_log VALUES ('112', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387181718');
INSERT INTO sch_log VALUES ('113', '0', '重置学校邀请码', 'School_Admin_Invitation', 'reset', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387181718');
INSERT INTO sch_log VALUES ('114', '0', '重置学校邀请码', 'School_Admin_Invitation', 'reset', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387181720');
INSERT INTO sch_log VALUES ('115', '0', '重置学校邀请码', 'School_Admin_Invitation', 'reset', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387181721');
INSERT INTO sch_log VALUES ('116', '0', '将老师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387183273');
INSERT INTO sch_log VALUES ('117', '0', '加入到新班级', 'School_Admin_Class', 'joinNewClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387183311');
INSERT INTO sch_log VALUES ('118', '0', '加入到新班级', 'School_Admin_Class', 'joinNewClassPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387183416');
INSERT INTO sch_log VALUES ('119', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387242134');
INSERT INTO sch_log VALUES ('120', '0', '修改管理员权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387358194');
INSERT INTO sch_log VALUES ('121', '0', '修改管理员权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 's35951247001862320095', '覃俊华', '1387358199');
INSERT INTO sch_log VALUES ('122', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387506925');
INSERT INTO sch_log VALUES ('123', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387506955');
INSERT INTO sch_log VALUES ('124', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387506958');
INSERT INTO sch_log VALUES ('125', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387506960');
INSERT INTO sch_log VALUES ('126', '0', '修改管理员权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387787950');
INSERT INTO sch_log VALUES ('127', '0', '重置学校邀请码', 'School_Admin_Invitation', 'reset', 'IP地址:172.16.3.17', '121502', 'w35935506404531840025', '吴鹏', '1387791885');
INSERT INTO sch_log VALUES ('128', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:172.16.3.17', '121502', 'w35935506404531840025', '吴鹏', '1387791887');
INSERT INTO sch_log VALUES ('129', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:172.16.3.17', '121502', 'w35935506404531840025', '吴鹏', '1387791889');
INSERT INTO sch_log VALUES ('130', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.17', '121502', 'w35935506404531840025', '吴鹏', '1387792533');
INSERT INTO sch_log VALUES ('131', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.17', '121502', 'w35935506404531840025', '吴鹏', '1387793483');
INSERT INTO sch_log VALUES ('132', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.17', '121502', 'w35935506404531840025', '吴鹏', '1387793485');
INSERT INTO sch_log VALUES ('133', '0', '重置老师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387941930');
INSERT INTO sch_log VALUES ('134', '0', '重置老师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387942589');
INSERT INTO sch_log VALUES ('135', '0', '重置老师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387942652');
INSERT INTO sch_log VALUES ('136', '0', '重置老师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:27.17.50.54', '121502', 'w35935506404531840025', '吴鹏', '1387954303');
INSERT INTO sch_log VALUES ('137', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1387963907');
INSERT INTO sch_log VALUES ('138', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388018732');
INSERT INTO sch_log VALUES ('139', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388018734');
INSERT INTO sch_log VALUES ('140', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388019102');
INSERT INTO sch_log VALUES ('141', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388019103');
INSERT INTO sch_log VALUES ('142', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388019106');
INSERT INTO sch_log VALUES ('143', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388019125');
INSERT INTO sch_log VALUES ('144', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388019132');
INSERT INTO sch_log VALUES ('145', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388019135');
INSERT INTO sch_log VALUES ('146', '0', '删除老师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388022970');
INSERT INTO sch_log VALUES ('147', '0', '删除老师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388023001');
INSERT INTO sch_log VALUES ('148', '0', '删除老师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388023264');
INSERT INTO sch_log VALUES ('149', '0', '删除老师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388023304');
INSERT INTO sch_log VALUES ('150', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388025040');
INSERT INTO sch_log VALUES ('151', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388040956');
INSERT INTO sch_log VALUES ('152', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388041101');
INSERT INTO sch_log VALUES ('153', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388041159');
INSERT INTO sch_log VALUES ('154', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388041172');
INSERT INTO sch_log VALUES ('155', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388041182');
INSERT INTO sch_log VALUES ('156', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388041216');
INSERT INTO sch_log VALUES ('157', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388041220');
INSERT INTO sch_log VALUES ('158', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388041237');
INSERT INTO sch_log VALUES ('159', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388041460');
INSERT INTO sch_log VALUES ('160', '0', '添加学校管理员吴亚', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388042695');
INSERT INTO sch_log VALUES ('161', '0', '添加学校管理员', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388042695');
INSERT INTO sch_log VALUES ('162', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388049350');
INSERT INTO sch_log VALUES ('163', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388106761');
INSERT INTO sch_log VALUES ('165', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388114335');
INSERT INTO sch_log VALUES ('166', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388115566');
INSERT INTO sch_log VALUES ('167', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388115568');
INSERT INTO sch_log VALUES ('168', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388122261');
INSERT INTO sch_log VALUES ('169', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388124994');
INSERT INTO sch_log VALUES ('170', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388125003');
INSERT INTO sch_log VALUES ('171', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388125287');
INSERT INTO sch_log VALUES ('172', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388125290');
INSERT INTO sch_log VALUES ('173', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388125297');
INSERT INTO sch_log VALUES ('174', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388125300');
INSERT INTO sch_log VALUES ('175', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388125869');
INSERT INTO sch_log VALUES ('176', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.17', '121502', 'w35935506404531840025', '吴鹏', '1388127369');
INSERT INTO sch_log VALUES ('177', '0', '删除投票', 'School_Admin_Vote', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388127855');
INSERT INTO sch_log VALUES ('178', '0', '添加学校投票asdasd', 'School_Admin_Vote', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388127893');
INSERT INTO sch_log VALUES ('179', '0', '删除投票', 'School_Admin_Vote', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388127897');
INSERT INTO sch_log VALUES ('181', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388131750');
INSERT INTO sch_log VALUES ('182', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388131766');
INSERT INTO sch_log VALUES ('183', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388133585');
INSERT INTO sch_log VALUES ('184', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388135217');
INSERT INTO sch_log VALUES ('185', '0', '用户组：修改状态', 'School_Admin_Group', 'isok', 'IP地址:27.17.50.54', '121502', 's36607344809981090086', '张爱平', '1388137150');
INSERT INTO sch_log VALUES ('186', '0', '用户组：修改状态', 'School_Admin_Group', 'isok', 'IP地址:27.17.50.54', '121502', 's36607344809981090086', '张爱平', '1388137151');
INSERT INTO sch_log VALUES ('187', '0', '用户组：信息排序', 'School_Admin_Group', 'order', 'IP地址:27.17.50.54', '121502', 's36607344809981090086', '张爱平', '1388137153');
INSERT INTO sch_log VALUES ('188', '0', '用户组：信息排序', 'School_Admin_Group', 'order', 'IP地址:27.17.50.54', '121502', 's36607344809981090086', '张爱平', '1388137156');
INSERT INTO sch_log VALUES ('189', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388371194');
INSERT INTO sch_log VALUES ('190', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388374658');
INSERT INTO sch_log VALUES ('191', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388384758');
INSERT INTO sch_log VALUES ('192', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388384765');
INSERT INTO sch_log VALUES ('193', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388386206');
INSERT INTO sch_log VALUES ('194', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388386207');
INSERT INTO sch_log VALUES ('195', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388386208');
INSERT INTO sch_log VALUES ('196', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388386212');
INSERT INTO sch_log VALUES ('197', '0', '重置学校邀请码', 'School_Admin_Invitation', 'reset', 'IP地址:172.16.3.17', '121502', 'w36451978107373010061', '数学老师', '1388397339');
INSERT INTO sch_log VALUES ('198', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:172.16.3.17', '121502', 'w36451978107373010061', '数学老师', '1388397341');
INSERT INTO sch_log VALUES ('200', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388455854');
INSERT INTO sch_log VALUES ('201', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388455859');
INSERT INTO sch_log VALUES ('202', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388455864');
INSERT INTO sch_log VALUES ('203', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388455885');
INSERT INTO sch_log VALUES ('204', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388455997');
INSERT INTO sch_log VALUES ('205', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388456138');
INSERT INTO sch_log VALUES ('206', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388456239');
INSERT INTO sch_log VALUES ('207', '0', '重置教师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388456438');
INSERT INTO sch_log VALUES ('208', '0', '添加教师', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1388470671');
INSERT INTO sch_log VALUES ('209', '0', '添加教师', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388470857');
INSERT INTO sch_log VALUES ('210', '0', '添加教师', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388470929');
INSERT INTO sch_log VALUES ('211', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388470950');
INSERT INTO sch_log VALUES ('212', '0', '添加教师', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388471166');
INSERT INTO sch_log VALUES ('213', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388471172');
INSERT INTO sch_log VALUES ('214', '0', '添加教师', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388471380');
INSERT INTO sch_log VALUES ('215', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388471387');
INSERT INTO sch_log VALUES ('216', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388471871');
INSERT INTO sch_log VALUES ('217', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388471874');
INSERT INTO sch_log VALUES ('218', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388471876');
INSERT INTO sch_log VALUES ('219', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1388472286');
INSERT INTO sch_log VALUES ('220', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1388472288');
INSERT INTO sch_log VALUES ('221', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1388472501');
INSERT INTO sch_log VALUES ('222', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1388472503');
INSERT INTO sch_log VALUES ('223', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388472854');
INSERT INTO sch_log VALUES ('224', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388472867');
INSERT INTO sch_log VALUES ('225', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388472874');
INSERT INTO sch_log VALUES ('226', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388472881');
INSERT INTO sch_log VALUES ('227', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388472933');
INSERT INTO sch_log VALUES ('228', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388473279');
INSERT INTO sch_log VALUES ('229', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388473281');
INSERT INTO sch_log VALUES ('230', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388473816');
INSERT INTO sch_log VALUES ('231', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388473819');
INSERT INTO sch_log VALUES ('232', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388480685');
INSERT INTO sch_log VALUES ('233', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388480778');
INSERT INTO sch_log VALUES ('234', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388640826');
INSERT INTO sch_log VALUES ('235', '0', '加入到新班级', 'School_Admin_Class', 'joinNewClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388643851');
INSERT INTO sch_log VALUES ('236', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645203');
INSERT INTO sch_log VALUES ('237', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645205');
INSERT INTO sch_log VALUES ('238', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645206');
INSERT INTO sch_log VALUES ('239', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645206');
INSERT INTO sch_log VALUES ('240', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645207');
INSERT INTO sch_log VALUES ('241', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645207');
INSERT INTO sch_log VALUES ('242', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645704');
INSERT INTO sch_log VALUES ('243', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645704');
INSERT INTO sch_log VALUES ('244', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645710');
INSERT INTO sch_log VALUES ('245', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645721');
INSERT INTO sch_log VALUES ('246', '0', '修改教师所任科目', 'School_Admin_Class', 'editTeacherSubjectPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388645747');
INSERT INTO sch_log VALUES ('247', '0', '添加教师', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388645887');
INSERT INTO sch_log VALUES ('248', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646014');
INSERT INTO sch_log VALUES ('249', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646102');
INSERT INTO sch_log VALUES ('250', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646110');
INSERT INTO sch_log VALUES ('251', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646300');
INSERT INTO sch_log VALUES ('252', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646351');
INSERT INTO sch_log VALUES ('253', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646496');
INSERT INTO sch_log VALUES ('254', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646651');
INSERT INTO sch_log VALUES ('255', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646666');
INSERT INTO sch_log VALUES ('256', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646809');
INSERT INTO sch_log VALUES ('257', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646826');
INSERT INTO sch_log VALUES ('258', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646906');
INSERT INTO sch_log VALUES ('259', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388646925');
INSERT INTO sch_log VALUES ('260', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388650538');
INSERT INTO sch_log VALUES ('261', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388650548');
INSERT INTO sch_log VALUES ('262', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388652850');
INSERT INTO sch_log VALUES ('263', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388652879');
INSERT INTO sch_log VALUES ('264', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388652896');
INSERT INTO sch_log VALUES ('265', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388654698');
INSERT INTO sch_log VALUES ('266', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388727968');
INSERT INTO sch_log VALUES ('267', '0', '添加学校管理员覃仕顶七', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388973995');
INSERT INTO sch_log VALUES ('268', '0', '添加学校管理员覃仕顶七', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388973995');
INSERT INTO sch_log VALUES ('269', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.15', '121502', 'w36451978107373010061', '数学老师', '1388974059');
INSERT INTO sch_log VALUES ('270', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388974332');
INSERT INTO sch_log VALUES ('271', '0', '添加学校管理员吴亚', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388974359');
INSERT INTO sch_log VALUES ('272', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388974395');
INSERT INTO sch_log VALUES ('273', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388974428');
INSERT INTO sch_log VALUES ('274', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388974697');
INSERT INTO sch_log VALUES ('275', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388975092');
INSERT INTO sch_log VALUES ('276', '0', '添加学校管理员数学老师', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388975119');
INSERT INTO sch_log VALUES ('277', '0', '添加学校管理员数学老师', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388975120');
INSERT INTO sch_log VALUES ('278', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388975186');
INSERT INTO sch_log VALUES ('279', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388975801');
INSERT INTO sch_log VALUES ('280', '0', '添加学校管理员数学老师', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388975809');
INSERT INTO sch_log VALUES ('281', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1388976121');
INSERT INTO sch_log VALUES ('282', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976135');
INSERT INTO sch_log VALUES ('283', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1388976143');
INSERT INTO sch_log VALUES ('284', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976160');
INSERT INTO sch_log VALUES ('285', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388976421');
INSERT INTO sch_log VALUES ('286', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388976573');
INSERT INTO sch_log VALUES ('287', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1388976642');
INSERT INTO sch_log VALUES ('288', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976658');
INSERT INTO sch_log VALUES ('289', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976689');
INSERT INTO sch_log VALUES ('290', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976702');
INSERT INTO sch_log VALUES ('291', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976874');
INSERT INTO sch_log VALUES ('292', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976879');
INSERT INTO sch_log VALUES ('293', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976914');
INSERT INTO sch_log VALUES ('294', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388976918');
INSERT INTO sch_log VALUES ('295', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388977714');
INSERT INTO sch_log VALUES ('296', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388977787');
INSERT INTO sch_log VALUES ('297', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388977800');
INSERT INTO sch_log VALUES ('298', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388977996');
INSERT INTO sch_log VALUES ('299', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388978003');
INSERT INTO sch_log VALUES ('300', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388978009');
INSERT INTO sch_log VALUES ('301', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388978017');
INSERT INTO sch_log VALUES ('302', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388978023');
INSERT INTO sch_log VALUES ('303', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1388978052');
INSERT INTO sch_log VALUES ('304', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987333');
INSERT INTO sch_log VALUES ('305', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987466');
INSERT INTO sch_log VALUES ('306', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987561');
INSERT INTO sch_log VALUES ('307', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987595');
INSERT INTO sch_log VALUES ('308', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987668');
INSERT INTO sch_log VALUES ('309', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987747');
INSERT INTO sch_log VALUES ('310', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987807');
INSERT INTO sch_log VALUES ('311', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987821');
INSERT INTO sch_log VALUES ('312', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388987864');
INSERT INTO sch_log VALUES ('313', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388989352');
INSERT INTO sch_log VALUES ('314', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1388990630');
INSERT INTO sch_log VALUES ('315', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388992423');
INSERT INTO sch_log VALUES ('316', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388992453');
INSERT INTO sch_log VALUES ('317', '0', '移除教师关系', 'School_Admin_Class', 'removeTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388992757');
INSERT INTO sch_log VALUES ('318', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388992847');
INSERT INTO sch_log VALUES ('319', '0', '添加教师', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388993809');
INSERT INTO sch_log VALUES ('320', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388993819');
INSERT INTO sch_log VALUES ('321', '0', '添加教师', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388993844');
INSERT INTO sch_log VALUES ('322', '0', '移除教师关系', 'School_Admin_Class', 'removeTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388994106');
INSERT INTO sch_log VALUES ('323', '0', '移除教师关系', 'School_Admin_Class', 'removeTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388996411');
INSERT INTO sch_log VALUES ('324', '0', '添加教师michael90', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1388996441');
INSERT INTO sch_log VALUES ('325', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1389059835');
INSERT INTO sch_log VALUES ('326', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1389064725');
INSERT INTO sch_log VALUES ('327', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1389064740');
INSERT INTO sch_log VALUES ('328', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1389064889');
INSERT INTO sch_log VALUES ('329', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1389087445');
INSERT INTO sch_log VALUES ('330', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389142607');
INSERT INTO sch_log VALUES ('331', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389146496');
INSERT INTO sch_log VALUES ('332', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389318247');
INSERT INTO sch_log VALUES ('333', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339469');
INSERT INTO sch_log VALUES ('334', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339481');
INSERT INTO sch_log VALUES ('335', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339483');
INSERT INTO sch_log VALUES ('336', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339484');
INSERT INTO sch_log VALUES ('337', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339485');
INSERT INTO sch_log VALUES ('338', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339834');
INSERT INTO sch_log VALUES ('339', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339843');
INSERT INTO sch_log VALUES ('340', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339847');
INSERT INTO sch_log VALUES ('341', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339871');
INSERT INTO sch_log VALUES ('342', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339951');
INSERT INTO sch_log VALUES ('343', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339962');
INSERT INTO sch_log VALUES ('344', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339967');
INSERT INTO sch_log VALUES ('345', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339972');
INSERT INTO sch_log VALUES ('346', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389339978');
INSERT INTO sch_log VALUES ('347', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389340061');
INSERT INTO sch_log VALUES ('348', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.11', '121502', 'm36359802300862200030', '徐杰', '1389581606');
INSERT INTO sch_log VALUES ('349', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.11', '121502', 'm36359802300862200030', '徐杰', '1389581639');
INSERT INTO sch_log VALUES ('350', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.11', '121502', 'm36359802300862200030', '徐杰', '1389581664');
INSERT INTO sch_log VALUES ('351', '0', '修改教师信息', 'School_Admin_Class', 'editTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389667926');
INSERT INTO sch_log VALUES ('352', '0', '修改了部件设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1389668010');
INSERT INTO sch_log VALUES ('353', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389681910');
INSERT INTO sch_log VALUES ('355', '0', '修改了部件设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389687850');
INSERT INTO sch_log VALUES ('356', '1', '修改了部件设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1389689910');
INSERT INTO sch_log VALUES ('357', '1', '修改了班级公告设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1389861052');
INSERT INTO sch_log VALUES ('358', '1', '修改了班级公告设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1389861076');
INSERT INTO sch_log VALUES ('359', '1', '修改了班级公告设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1389861117');
INSERT INTO sch_log VALUES ('360', '1', '修改了班级公告设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1389861136');
INSERT INTO sch_log VALUES ('361', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389862243');
INSERT INTO sch_log VALUES ('362', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389927692');
INSERT INTO sch_log VALUES ('363', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389927905');
INSERT INTO sch_log VALUES ('364', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389927963');
INSERT INTO sch_log VALUES ('365', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389927970');
INSERT INTO sch_log VALUES ('366', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389927978');
INSERT INTO sch_log VALUES ('367', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928000');
INSERT INTO sch_log VALUES ('368', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928097');
INSERT INTO sch_log VALUES ('369', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928274');
INSERT INTO sch_log VALUES ('370', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928281');
INSERT INTO sch_log VALUES ('371', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928288');
INSERT INTO sch_log VALUES ('372', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928297');
INSERT INTO sch_log VALUES ('373', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928777');
INSERT INTO sch_log VALUES ('374', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928804');
INSERT INTO sch_log VALUES ('375', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928877');
INSERT INTO sch_log VALUES ('376', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928885');
INSERT INTO sch_log VALUES ('377', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928892');
INSERT INTO sch_log VALUES ('378', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389928900');
INSERT INTO sch_log VALUES ('379', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389930231');
INSERT INTO sch_log VALUES ('380', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389940435');
INSERT INTO sch_log VALUES ('381', '0', '删除长江数字学校小学一年级:一七', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389940531');
INSERT INTO sch_log VALUES ('382', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389942356');
INSERT INTO sch_log VALUES ('383', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389943028');
INSERT INTO sch_log VALUES ('384', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1389943077');
INSERT INTO sch_log VALUES ('385', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390183393');
INSERT INTO sch_log VALUES ('386', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390183511');
INSERT INTO sch_log VALUES ('387', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390183883');
INSERT INTO sch_log VALUES ('388', '0', '信息分类管理：删除栏目', 'School_Admin_Column', 'del', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390183904');
INSERT INTO sch_log VALUES ('389', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390183912');
INSERT INTO sch_log VALUES ('390', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390187068');
INSERT INTO sch_log VALUES ('391', '0', '添加学校管理员李师师', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.14', '121502', 'w36451978107373010061', '数学老师', '1390188274');
INSERT INTO sch_log VALUES ('392', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390193246');
INSERT INTO sch_log VALUES ('393', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390193319');
INSERT INTO sch_log VALUES ('394', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390193327');
INSERT INTO sch_log VALUES ('395', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390193334');
INSERT INTO sch_log VALUES ('396', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390193342');
INSERT INTO sch_log VALUES ('397', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390193876');
INSERT INTO sch_log VALUES ('398', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390193896');
INSERT INTO sch_log VALUES ('399', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390194276');
INSERT INTO sch_log VALUES ('400', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390194302');
INSERT INTO sch_log VALUES ('401', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390194403');
INSERT INTO sch_log VALUES ('402', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390195345');
INSERT INTO sch_log VALUES ('403', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390202738');
INSERT INTO sch_log VALUES ('404', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390202782');
INSERT INTO sch_log VALUES ('405', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390265399');
INSERT INTO sch_log VALUES ('406', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1390454382');
INSERT INTO sch_log VALUES ('407', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1390456913');
INSERT INTO sch_log VALUES ('408', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1390457022');
INSERT INTO sch_log VALUES ('409', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1390457262');
INSERT INTO sch_log VALUES ('410', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1390457469');
INSERT INTO sch_log VALUES ('411', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1390464886');
INSERT INTO sch_log VALUES ('412', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1390467786');
INSERT INTO sch_log VALUES ('413', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390468768');
INSERT INTO sch_log VALUES ('414', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390546520');
INSERT INTO sch_log VALUES ('415', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390546533');
INSERT INTO sch_log VALUES ('416', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390546595');
INSERT INTO sch_log VALUES ('417', '0', '重置教师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390546819');
INSERT INTO sch_log VALUES ('418', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390549075');
INSERT INTO sch_log VALUES ('419', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390549084');
INSERT INTO sch_log VALUES ('420', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390549470');
INSERT INTO sch_log VALUES ('421', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390549478');
INSERT INTO sch_log VALUES ('422', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390549496');
INSERT INTO sch_log VALUES ('423', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390549504');
INSERT INTO sch_log VALUES ('424', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390549567');
INSERT INTO sch_log VALUES ('425', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390550019');
INSERT INTO sch_log VALUES ('426', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390550402');
INSERT INTO sch_log VALUES ('427', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390550412');
INSERT INTO sch_log VALUES ('428', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390550496');
INSERT INTO sch_log VALUES ('429', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390550699');
INSERT INTO sch_log VALUES ('430', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1390550755');
INSERT INTO sch_log VALUES ('431', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1390550900');
INSERT INTO sch_log VALUES ('432', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1390550939');
INSERT INTO sch_log VALUES ('433', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1390553383');
INSERT INTO sch_log VALUES ('434', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1390555857');
INSERT INTO sch_log VALUES ('435', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1390555858');
INSERT INTO sch_log VALUES ('436', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392001695');
INSERT INTO sch_log VALUES ('437', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392017010');
INSERT INTO sch_log VALUES ('438', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392017032');
INSERT INTO sch_log VALUES ('439', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392017058');
INSERT INTO sch_log VALUES ('440', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392017103');
INSERT INTO sch_log VALUES ('441', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392017132');
INSERT INTO sch_log VALUES ('442', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392192653');
INSERT INTO sch_log VALUES ('443', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1392255117');
INSERT INTO sch_log VALUES ('444', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1392255363');
INSERT INTO sch_log VALUES ('445', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392255431');
INSERT INTO sch_log VALUES ('446', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.5', '121502', 'w36451978107373010061', '数学老师', '1392342882');
INSERT INTO sch_log VALUES ('447', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.5', '121502', 't37880655900186820006', '李师师', '1392343202');
INSERT INTO sch_log VALUES ('448', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.5', '121502', 't37880655900186820006', '李师师', '1392343352');
INSERT INTO sch_log VALUES ('449', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.5', '121502', 't37880655900186820006', '李师师', '1392343633');
INSERT INTO sch_log VALUES ('450', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392347628');
INSERT INTO sch_log VALUES ('451', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392349447');
INSERT INTO sch_log VALUES ('452', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392349452');
INSERT INTO sch_log VALUES ('453', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392349468');
INSERT INTO sch_log VALUES ('454', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392350082');
INSERT INTO sch_log VALUES ('455', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392350085');
INSERT INTO sch_log VALUES ('456', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392350106');
INSERT INTO sch_log VALUES ('457', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392350500');
INSERT INTO sch_log VALUES ('458', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392604197');
INSERT INTO sch_log VALUES ('459', '0', '添加教师dodo', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392604559');
INSERT INTO sch_log VALUES ('460', '0', '添加教师dodoedu1', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392606225');
INSERT INTO sch_log VALUES ('461', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392606243');
INSERT INTO sch_log VALUES ('462', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392606251');
INSERT INTO sch_log VALUES ('463', '0', '移除教师关系', 'School_Admin_Class', 'removeTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392606269');
INSERT INTO sch_log VALUES ('464', '0', '添加教师dodo', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392606289');
INSERT INTO sch_log VALUES ('465', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392618831');
INSERT INTO sch_log VALUES ('466', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392619649');
INSERT INTO sch_log VALUES ('467', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392685120');
INSERT INTO sch_log VALUES ('468', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392685138');
INSERT INTO sch_log VALUES ('469', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392685528');
INSERT INTO sch_log VALUES ('470', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392685589');
INSERT INTO sch_log VALUES ('471', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392685682');
INSERT INTO sch_log VALUES ('472', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392685916');
INSERT INTO sch_log VALUES ('473', '1', '修改了教师动态部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392712408');
INSERT INTO sch_log VALUES ('474', '1', '修改了活跃家长部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392713498');
INSERT INTO sch_log VALUES ('475', '1', '修改了活跃家长部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392713501');
INSERT INTO sch_log VALUES ('476', '1', '修改了班级讨论部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392713609');
INSERT INTO sch_log VALUES ('477', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392794797');
INSERT INTO sch_log VALUES ('478', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392796436');
INSERT INTO sch_log VALUES ('479', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392797962');
INSERT INTO sch_log VALUES ('480', '0', '删除长江数字小学小学一年级:1', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392867707');
INSERT INTO sch_log VALUES ('481', '0', '删除长江数字小学小学一年级:11', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392867714');
INSERT INTO sch_log VALUES ('482', '0', '删除长江数字小学小学一年级:107', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392867743');
INSERT INTO sch_log VALUES ('483', '0', '删除长江数字小学小学一年级:多多小', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392867759');
INSERT INTO sch_log VALUES ('484', '0', '删除长江数字小学小学一年级:一六', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392867765');
INSERT INTO sch_log VALUES ('485', '0', '班级改名', 'School_Admin_Class', 'editClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392867776');
INSERT INTO sch_log VALUES ('486', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392876879');
INSERT INTO sch_log VALUES ('487', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392877638');
INSERT INTO sch_log VALUES ('488', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392882059');
INSERT INTO sch_log VALUES ('489', '0', '添加长江数字学校126546', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392882206');
INSERT INTO sch_log VALUES ('490', '0', '添加长江数字学校2332232332', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392882225');
INSERT INTO sch_log VALUES ('491', '0', '添加长江数字学校56565', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392882363');
INSERT INTO sch_log VALUES ('492', '0', '删除长江数字学校小学一年级:23232', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392882794');
INSERT INTO sch_log VALUES ('493', '0', '删除长江数字学校小学一年级:2332232332', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392882799');
INSERT INTO sch_log VALUES ('494', '0', '删除长江数字学校小学一年级:126546', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392882806');
INSERT INTO sch_log VALUES ('495', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392883266');
INSERT INTO sch_log VALUES ('496', '0', '删除长江数字学校小学一年级:aaa', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392883278');
INSERT INTO sch_log VALUES ('497', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392883418');
INSERT INTO sch_log VALUES ('498', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392883665');
INSERT INTO sch_log VALUES ('499', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392884618');
INSERT INTO sch_log VALUES ('500', '0', '删除长江数字学校小学一年级:11pp112', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392884684');
INSERT INTO sch_log VALUES ('501', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392886014');
INSERT INTO sch_log VALUES ('502', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1392945031');
INSERT INTO sch_log VALUES ('503', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392953394');
INSERT INTO sch_log VALUES ('504', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392953765');
INSERT INTO sch_log VALUES ('505', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392953782');
INSERT INTO sch_log VALUES ('506', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392953842');
INSERT INTO sch_log VALUES ('507', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392954088');
INSERT INTO sch_log VALUES ('508', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392968595');
INSERT INTO sch_log VALUES ('509', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392968623');
INSERT INTO sch_log VALUES ('510', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392969531');
INSERT INTO sch_log VALUES ('511', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392969614');
INSERT INTO sch_log VALUES ('512', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392969648');
INSERT INTO sch_log VALUES ('513', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392969948');
INSERT INTO sch_log VALUES ('514', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392970029');
INSERT INTO sch_log VALUES ('515', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392970652');
INSERT INTO sch_log VALUES ('516', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392973510');
INSERT INTO sch_log VALUES ('517', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1392974270');
INSERT INTO sch_log VALUES ('518', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392974339');
INSERT INTO sch_log VALUES ('519', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1392974360');
INSERT INTO sch_log VALUES ('520', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1392974695');
INSERT INTO sch_log VALUES ('521', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1392974877');
INSERT INTO sch_log VALUES ('522', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1392974957');
INSERT INTO sch_log VALUES ('523', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1392975625');
INSERT INTO sch_log VALUES ('524', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392975878');
INSERT INTO sch_log VALUES ('525', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1392976105');
INSERT INTO sch_log VALUES ('526', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1392976231');
INSERT INTO sch_log VALUES ('527', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393033787');
INSERT INTO sch_log VALUES ('528', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393225149');
INSERT INTO sch_log VALUES ('529', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393225163');
INSERT INTO sch_log VALUES ('530', '0', '信息分类管理：删除栏目', 'School_Admin_Column', 'del', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393225170');
INSERT INTO sch_log VALUES ('531', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393225631');
INSERT INTO sch_log VALUES ('532', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393226990');
INSERT INTO sch_log VALUES ('533', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393227638');
INSERT INTO sch_log VALUES ('534', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296018');
INSERT INTO sch_log VALUES ('535', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296042');
INSERT INTO sch_log VALUES ('536', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296058');
INSERT INTO sch_log VALUES ('537', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296132');
INSERT INTO sch_log VALUES ('538', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296241');
INSERT INTO sch_log VALUES ('539', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296246');
INSERT INTO sch_log VALUES ('540', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296251');
INSERT INTO sch_log VALUES ('541', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296261');
INSERT INTO sch_log VALUES ('542', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296353');
INSERT INTO sch_log VALUES ('543', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296357');
INSERT INTO sch_log VALUES ('544', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296367');
INSERT INTO sch_log VALUES ('545', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296376');
INSERT INTO sch_log VALUES ('546', '0', '信息分类管理：删除栏目', 'School_Admin_Column', 'del', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296379');
INSERT INTO sch_log VALUES ('547', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296388');
INSERT INTO sch_log VALUES ('548', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296397');
INSERT INTO sch_log VALUES ('549', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393296401');
INSERT INTO sch_log VALUES ('550', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393298924');
INSERT INTO sch_log VALUES ('551', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393298928');
INSERT INTO sch_log VALUES ('552', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393298938');
INSERT INTO sch_log VALUES ('553', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393298959');
INSERT INTO sch_log VALUES ('554', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393298994');
INSERT INTO sch_log VALUES ('555', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393299008');
INSERT INTO sch_log VALUES ('556', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393299017');
INSERT INTO sch_log VALUES ('557', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393299058');
INSERT INTO sch_log VALUES ('558', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393299167');
INSERT INTO sch_log VALUES ('559', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393299175');
INSERT INTO sch_log VALUES ('560', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393299183');
INSERT INTO sch_log VALUES ('561', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393310333');
INSERT INTO sch_log VALUES ('562', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393314916');
INSERT INTO sch_log VALUES ('563', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393314943');
INSERT INTO sch_log VALUES ('564', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393315632');
INSERT INTO sch_log VALUES ('565', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393316125');
INSERT INTO sch_log VALUES ('566', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393317720');
INSERT INTO sch_log VALUES ('567', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320169');
INSERT INTO sch_log VALUES ('568', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320200');
INSERT INTO sch_log VALUES ('569', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320226');
INSERT INTO sch_log VALUES ('570', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320247');
INSERT INTO sch_log VALUES ('571', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320282');
INSERT INTO sch_log VALUES ('572', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320297');
INSERT INTO sch_log VALUES ('573', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320300');
INSERT INTO sch_log VALUES ('574', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320339');
INSERT INTO sch_log VALUES ('575', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320414');
INSERT INTO sch_log VALUES ('576', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393320467');
INSERT INTO sch_log VALUES ('577', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393380221');
INSERT INTO sch_log VALUES ('578', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393381152');
INSERT INTO sch_log VALUES ('579', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393381625');
INSERT INTO sch_log VALUES ('580', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393382142');
INSERT INTO sch_log VALUES ('581', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393383931');
INSERT INTO sch_log VALUES ('582', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393406381');
INSERT INTO sch_log VALUES ('583', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393406388');
INSERT INTO sch_log VALUES ('584', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393406395');
INSERT INTO sch_log VALUES ('585', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393406850');
INSERT INTO sch_log VALUES ('586', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393407752');
INSERT INTO sch_log VALUES ('587', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393463483');
INSERT INTO sch_log VALUES ('588', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393463664');
INSERT INTO sch_log VALUES ('589', '0', '添加学校管理员李师师', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393464349');
INSERT INTO sch_log VALUES ('590', '0', '添加学校管理员何小春', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393464389');
INSERT INTO sch_log VALUES ('591', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393465105');
INSERT INTO sch_log VALUES ('592', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393465116');
INSERT INTO sch_log VALUES ('593', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393465128');
INSERT INTO sch_log VALUES ('594', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393465272');
INSERT INTO sch_log VALUES ('595', '1', '修改了学校简介部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393470284');
INSERT INTO sch_log VALUES ('596', '1', '修改了学校简介部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393470288');
INSERT INTO sch_log VALUES ('597', '1', '修改了学校简介部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393470298');
INSERT INTO sch_log VALUES ('598', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393470315');
INSERT INTO sch_log VALUES ('599', '1', '修改了学校简介部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393470322');
INSERT INTO sch_log VALUES ('600', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393470332');
INSERT INTO sch_log VALUES ('601', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393481130');
INSERT INTO sch_log VALUES ('602', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393481160');
INSERT INTO sch_log VALUES ('603', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393481163');
INSERT INTO sch_log VALUES ('604', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393481164');
INSERT INTO sch_log VALUES ('605', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393481166');
INSERT INTO sch_log VALUES ('606', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393481179');
INSERT INTO sch_log VALUES ('607', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393481229');
INSERT INTO sch_log VALUES ('608', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393481320');
INSERT INTO sch_log VALUES ('609', '1', '修改了自定义博客部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393483599');
INSERT INTO sch_log VALUES ('610', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393483609');
INSERT INTO sch_log VALUES ('611', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393483694');
INSERT INTO sch_log VALUES ('612', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393483710');
INSERT INTO sch_log VALUES ('613', '1', '修改了自定义博客部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393483759');
INSERT INTO sch_log VALUES ('614', '1', '修改了自定义博客部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393483767');
INSERT INTO sch_log VALUES ('615', '1', '修改了自定义博客部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393483872');
INSERT INTO sch_log VALUES ('616', '1', '修改了自定义博客部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393483877');
INSERT INTO sch_log VALUES ('617', '1', '修改了自定义博客部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393483884');
INSERT INTO sch_log VALUES ('618', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393484088');
INSERT INTO sch_log VALUES ('619', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393484096');
INSERT INTO sch_log VALUES ('620', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393484828');
INSERT INTO sch_log VALUES ('621', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393484905');
INSERT INTO sch_log VALUES ('622', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393484918');
INSERT INTO sch_log VALUES ('623', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393484923');
INSERT INTO sch_log VALUES ('624', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393485107');
INSERT INTO sch_log VALUES ('625', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393486511');
INSERT INTO sch_log VALUES ('626', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393487432');
INSERT INTO sch_log VALUES ('627', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.15', '121502', 'w36451978107373010061', '数学老师', '1393488255');
INSERT INTO sch_log VALUES ('628', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.15', '121502', 'w36451978107373010061', '数学老师', '1393489041');
INSERT INTO sch_log VALUES ('629', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393813770');
INSERT INTO sch_log VALUES ('630', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393813794');
INSERT INTO sch_log VALUES ('631', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393813801');
INSERT INTO sch_log VALUES ('632', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393813867');
INSERT INTO sch_log VALUES ('633', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393813871');
INSERT INTO sch_log VALUES ('634', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393814283');
INSERT INTO sch_log VALUES ('635', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393814313');
INSERT INTO sch_log VALUES ('636', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393814324');
INSERT INTO sch_log VALUES ('637', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393814330');
INSERT INTO sch_log VALUES ('638', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393814392');
INSERT INTO sch_log VALUES ('639', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393814399');
INSERT INTO sch_log VALUES ('640', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393814441');
INSERT INTO sch_log VALUES ('641', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393814446');
INSERT INTO sch_log VALUES ('642', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393814455');
INSERT INTO sch_log VALUES ('643', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393814459');
INSERT INTO sch_log VALUES ('644', '1', '修改了班级相册部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393814483');
INSERT INTO sch_log VALUES ('645', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815222');
INSERT INTO sch_log VALUES ('646', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815237');
INSERT INTO sch_log VALUES ('647', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815240');
INSERT INTO sch_log VALUES ('648', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815248');
INSERT INTO sch_log VALUES ('649', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815253');
INSERT INTO sch_log VALUES ('650', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815259');
INSERT INTO sch_log VALUES ('651', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815262');
INSERT INTO sch_log VALUES ('652', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815267');
INSERT INTO sch_log VALUES ('653', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815363');
INSERT INTO sch_log VALUES ('654', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393815618');
INSERT INTO sch_log VALUES ('655', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393815724');
INSERT INTO sch_log VALUES ('656', '1', '修改了教学成果部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393815735');
INSERT INTO sch_log VALUES ('657', '1', '修改了学校公告部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393815849');
INSERT INTO sch_log VALUES ('658', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393816330');
INSERT INTO sch_log VALUES ('659', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393816352');
INSERT INTO sch_log VALUES ('660', '1', '修改了学校公告部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393816413');
INSERT INTO sch_log VALUES ('661', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393817020');
INSERT INTO sch_log VALUES ('662', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393817021');
INSERT INTO sch_log VALUES ('663', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393817021');
INSERT INTO sch_log VALUES ('664', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393817040');
INSERT INTO sch_log VALUES ('665', '0', '信息列表：删除信息', 'School_Admin_Relate', 'delAll', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393817045');
INSERT INTO sch_log VALUES ('666', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393826521');
INSERT INTO sch_log VALUES ('667', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393826551');
INSERT INTO sch_log VALUES ('668', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393826686');
INSERT INTO sch_log VALUES ('669', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393828208');
INSERT INTO sch_log VALUES ('670', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393828212');
INSERT INTO sch_log VALUES ('671', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393828215');
INSERT INTO sch_log VALUES ('672', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393914282');
INSERT INTO sch_log VALUES ('673', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393914613');
INSERT INTO sch_log VALUES ('674', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393914784');
INSERT INTO sch_log VALUES ('675', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393914791');
INSERT INTO sch_log VALUES ('676', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393914879');
INSERT INTO sch_log VALUES ('677', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393914887');
INSERT INTO sch_log VALUES ('678', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1393982427');
INSERT INTO sch_log VALUES ('679', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393983034');
INSERT INTO sch_log VALUES ('680', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1393983041');
INSERT INTO sch_log VALUES ('681', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393983865');
INSERT INTO sch_log VALUES ('682', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393983921');
INSERT INTO sch_log VALUES ('683', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393983993');
INSERT INTO sch_log VALUES ('684', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393984087');
INSERT INTO sch_log VALUES ('685', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393984810');
INSERT INTO sch_log VALUES ('686', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1393984820');
INSERT INTO sch_log VALUES ('687', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393985071');
INSERT INTO sch_log VALUES ('688', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393985159');
INSERT INTO sch_log VALUES ('689', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393985467');
INSERT INTO sch_log VALUES ('690', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393985519');
INSERT INTO sch_log VALUES ('691', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393985553');
INSERT INTO sch_log VALUES ('692', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393985801');
INSERT INTO sch_log VALUES ('693', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1393985812');
INSERT INTO sch_log VALUES ('694', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394068472');
INSERT INTO sch_log VALUES ('695', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394068563');
INSERT INTO sch_log VALUES ('696', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394069110');
INSERT INTO sch_log VALUES ('697', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394069137');
INSERT INTO sch_log VALUES ('698', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394069351');
INSERT INTO sch_log VALUES ('699', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394069431');
INSERT INTO sch_log VALUES ('700', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394070066');
INSERT INTO sch_log VALUES ('701', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1394070624');
INSERT INTO sch_log VALUES ('702', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394070719');
INSERT INTO sch_log VALUES ('703', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394073217');
INSERT INTO sch_log VALUES ('704', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394073245');
INSERT INTO sch_log VALUES ('705', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394088864');
INSERT INTO sch_log VALUES ('706', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394088875');
INSERT INTO sch_log VALUES ('707', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394091005');
INSERT INTO sch_log VALUES ('708', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394157464');
INSERT INTO sch_log VALUES ('709', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394157846');
INSERT INTO sch_log VALUES ('710', '1', '修改了学校相册部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394416997');
INSERT INTO sch_log VALUES ('711', '1', '修改了在线调查部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394417480');
INSERT INTO sch_log VALUES ('712', '1', '修改了校园论坛部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394417859');
INSERT INTO sch_log VALUES ('713', '1', '修改了校园论坛部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394417863');
INSERT INTO sch_log VALUES ('714', '1', '修改了校园论坛部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394419882');
INSERT INTO sch_log VALUES ('715', '1', '修改了校园论坛部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394419887');
INSERT INTO sch_log VALUES ('716', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394422200');
INSERT INTO sch_log VALUES ('717', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394422211');
INSERT INTO sch_log VALUES ('718', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394422216');
INSERT INTO sch_log VALUES ('719', '1', '修改了校园论坛部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394434899');
INSERT INTO sch_log VALUES ('720', '1', '修改了校园论坛部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394435065');
INSERT INTO sch_log VALUES ('721', '1', '修改了校园论坛部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394435069');
INSERT INTO sch_log VALUES ('722', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394438935');
INSERT INTO sch_log VALUES ('723', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394614890');
INSERT INTO sch_log VALUES ('724', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394615007');
INSERT INTO sch_log VALUES ('725', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394615842');
INSERT INTO sch_log VALUES ('726', '1', '修改了学生问答部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394677280');
INSERT INTO sch_log VALUES ('727', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394693739');
INSERT INTO sch_log VALUES ('728', '1', '修改了招生信息部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394693746');
INSERT INTO sch_log VALUES ('729', '1', '修改了学校公告部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394693754');
INSERT INTO sch_log VALUES ('730', '1', '修改了学校公告部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1394693799');
INSERT INTO sch_log VALUES ('731', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394694488');
INSERT INTO sch_log VALUES ('732', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394694505');
INSERT INTO sch_log VALUES ('733', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394694832');
INSERT INTO sch_log VALUES ('734', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394694918');
INSERT INTO sch_log VALUES ('735', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394695235');
INSERT INTO sch_log VALUES ('736', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394695245');
INSERT INTO sch_log VALUES ('737', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394695375');
INSERT INTO sch_log VALUES ('738', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394695422');
INSERT INTO sch_log VALUES ('739', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394695428');
INSERT INTO sch_log VALUES ('740', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1394695881');
INSERT INTO sch_log VALUES ('741', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394764701');
INSERT INTO sch_log VALUES ('742', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1394764713');
INSERT INTO sch_log VALUES ('743', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395038583');
INSERT INTO sch_log VALUES ('744', '1', '修改了教师相册部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1395283663');
INSERT INTO sch_log VALUES ('745', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395286627');
INSERT INTO sch_log VALUES ('746', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395295606');
INSERT INTO sch_log VALUES ('747', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395295607');
INSERT INTO sch_log VALUES ('748', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1395295625');
INSERT INTO sch_log VALUES ('749', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1395295848');
INSERT INTO sch_log VALUES ('750', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1395296161');
INSERT INTO sch_log VALUES ('751', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1395298207');
INSERT INTO sch_log VALUES ('752', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395367054');
INSERT INTO sch_log VALUES ('753', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395367065');
INSERT INTO sch_log VALUES ('754', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395367074');
INSERT INTO sch_log VALUES ('755', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395367080');
INSERT INTO sch_log VALUES ('756', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395367126');
INSERT INTO sch_log VALUES ('757', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395367156');
INSERT INTO sch_log VALUES ('758', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395367173');
INSERT INTO sch_log VALUES ('759', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395368413');
INSERT INTO sch_log VALUES ('760', '0', '添加长江数字学校201', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395631663');
INSERT INTO sch_log VALUES ('761', '0', '添加长江数字学校202', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395632151');
INSERT INTO sch_log VALUES ('762', '0', '删除长江数字学校小学一年级:201', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395652543');
INSERT INTO sch_log VALUES ('763', '0', '删除长江数字学校小学一年级:201', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653314');
INSERT INTO sch_log VALUES ('764', '0', '删除长江数字学校小学一年级:202', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653508');
INSERT INTO sch_log VALUES ('765', '0', '添加长江数字学校201', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653530');
INSERT INTO sch_log VALUES ('766', '0', '删除长江数字学校小学一年级:201', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653537');
INSERT INTO sch_log VALUES ('767', '0', '删除长江数字学校小学一年级:202', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653669');
INSERT INTO sch_log VALUES ('768', '0', '添加长江数字学校202', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653696');
INSERT INTO sch_log VALUES ('769', '0', '删除长江数字学校小学一年级:202', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653705');
INSERT INTO sch_log VALUES ('770', '0', '添加长江数字学校201', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653711');
INSERT INTO sch_log VALUES ('771', '0', '删除长江数字学校小学一年级:201', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395653717');
INSERT INTO sch_log VALUES ('772', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395824318');
INSERT INTO sch_log VALUES ('773', '1', '修改了学生相册部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.8', '121502', 'w36451978107373010061', '数学老师', '1395884148');
INSERT INTO sch_log VALUES ('774', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395907838');
INSERT INTO sch_log VALUES ('775', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395912040');
INSERT INTO sch_log VALUES ('776', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395912582');
INSERT INTO sch_log VALUES ('777', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1395912644');
INSERT INTO sch_log VALUES ('778', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395973794');
INSERT INTO sch_log VALUES ('779', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395974267');
INSERT INTO sch_log VALUES ('780', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395974278');
INSERT INTO sch_log VALUES ('781', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395974280');
INSERT INTO sch_log VALUES ('782', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395974308');
INSERT INTO sch_log VALUES ('783', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395974312');
INSERT INTO sch_log VALUES ('784', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395974372');
INSERT INTO sch_log VALUES ('785', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395974374');
INSERT INTO sch_log VALUES ('786', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1395974394');
INSERT INTO sch_log VALUES ('787', '0', '禁用学校邀请码', 'School_Admin_Invitation', 'disabled', 'IP地址:27.17.50.54', '121502', 'w35935506404531840025', '吴鹏', '1395995766');
INSERT INTO sch_log VALUES ('788', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1396316249');
INSERT INTO sch_log VALUES ('789', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1396403039');
INSERT INTO sch_log VALUES ('790', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1397007095');
INSERT INTO sch_log VALUES ('791', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1397007793');
INSERT INTO sch_log VALUES ('792', '0', '添加长江数字学校202', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1397176817');
INSERT INTO sch_log VALUES ('793', '0', '删除长江数字学校小学一年级:202', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1397176823');
INSERT INTO sch_log VALUES ('794', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1397195884');
INSERT INTO sch_log VALUES ('795', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1397196049');
INSERT INTO sch_log VALUES ('796', '0', '删除长江数字小学小学四年级:四（一）', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1397201328');
INSERT INTO sch_log VALUES ('797', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1397201339');
INSERT INTO sch_log VALUES ('798', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:8.35.201.52', '121502', 'w36451978107373010061', '数学老师', '1397445995');
INSERT INTO sch_log VALUES ('799', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1397712212');
INSERT INTO sch_log VALUES ('800', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1397712226');
INSERT INTO sch_log VALUES ('801', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1397712251');
INSERT INTO sch_log VALUES ('802', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1397712735');
INSERT INTO sch_log VALUES ('803', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1397712749');
INSERT INTO sch_log VALUES ('804', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1397718710');
INSERT INTO sch_log VALUES ('805', '0', '信息列表：修改状态', 'School_Admin_Relate', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1397718718');
INSERT INTO sch_log VALUES ('806', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398129715');
INSERT INTO sch_log VALUES ('807', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131350');
INSERT INTO sch_log VALUES ('808', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131353');
INSERT INTO sch_log VALUES ('809', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131355');
INSERT INTO sch_log VALUES ('810', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131366');
INSERT INTO sch_log VALUES ('811', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131369');
INSERT INTO sch_log VALUES ('812', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131392');
INSERT INTO sch_log VALUES ('813', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131394');
INSERT INTO sch_log VALUES ('814', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131397');
INSERT INTO sch_log VALUES ('815', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131399');
INSERT INTO sch_log VALUES ('816', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131401');
INSERT INTO sch_log VALUES ('817', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131405');
INSERT INTO sch_log VALUES ('818', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131782');
INSERT INTO sch_log VALUES ('819', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1398131783');
INSERT INTO sch_log VALUES ('820', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.4', '121502', 'w36451978107373010061', '数学老师', '1401242640');
INSERT INTO sch_log VALUES ('821', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:172.16.3.10', '121584', 'w36451978107373010061', '数学老师', '1403060596');
INSERT INTO sch_log VALUES ('822', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.4', '121584', 'w36451978107373010061', '数学老师', '1403507912');
INSERT INTO sch_log VALUES ('823', '0', '添加长江实验小学二一班', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.4', '121584', 'w36451978107373010061', '数学老师', '1403661333');
INSERT INTO sch_log VALUES ('824', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.4', '121584', 'w36451978107373010061', '数学老师', '1403661357');
INSERT INTO sch_log VALUES ('825', '0', '添加长江数字小学美女班', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.4', '121502', 'w36451978107373010061', '数学老师', '1403666748');
INSERT INTO sch_log VALUES ('826', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1403667026');
INSERT INTO sch_log VALUES ('827', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.4', '121502', 'w36451978107373010061', '数学老师', '1403677969');
INSERT INTO sch_log VALUES ('828', '0', '添加长江数字小学屌丝班', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.4', '121502', 'w36451978107373010061', '数学老师', '1403678294');
INSERT INTO sch_log VALUES ('829', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:172.16.3.4', '121502', 'w36451978107373010061', '数学老师', '1403678420');
INSERT INTO sch_log VALUES ('830', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.21', '121584', 'w36451978107373010061', '数学老师', '1404443575');
INSERT INTO sch_log VALUES ('831', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.21', '121584', 'w36451978107373010061', '数学老师', '1404458818');
INSERT INTO sch_log VALUES ('832', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.21', '121584', 'w36451978107373010061', '数学老师', '1404458879');
INSERT INTO sch_log VALUES ('833', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.21', '121584', 'w36451978107373010061', '数学老师', '1404458889');
INSERT INTO sch_log VALUES ('834', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1406620242');
INSERT INTO sch_log VALUES ('835', '0', '添加长江实验小学1（二）班', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.4', '121584', 'w36451978107373010061', '数学老师', '1408952373');
INSERT INTO sch_log VALUES ('836', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1409634380');
INSERT INTO sch_log VALUES ('837', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1409634463');
INSERT INTO sch_log VALUES ('838', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1409634539');
INSERT INTO sch_log VALUES ('839', '0', '添加长江实验小学一（1）班', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.4', '121584', 'w36451978107373010061', '数学老师', '1409799923');
INSERT INTO sch_log VALUES ('840', '0', '移除教师关系', 'School_Admin_Class', 'removeTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1410240972');
INSERT INTO sch_log VALUES ('841', '0', '移除教师关系', 'School_Admin_Class', 'removeTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1410241077');
INSERT INTO sch_log VALUES ('842', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1410241275');
INSERT INTO sch_log VALUES ('843', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1410513354');
INSERT INTO sch_log VALUES ('844', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1410513707');
INSERT INTO sch_log VALUES ('845', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1410513796');
INSERT INTO sch_log VALUES ('846', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1410514217');
INSERT INTO sch_log VALUES ('847', '0', '添加长江数字小学11111', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411117403');
INSERT INTO sch_log VALUES ('848', '0', '添加长江数字小学11111', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411117403');
INSERT INTO sch_log VALUES ('849', '0', '修改教师信息', 'School_Admin_Class', 'editTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411117481');
INSERT INTO sch_log VALUES ('850', '0', '修改教师信息', 'School_Admin_Class', 'editTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411117495');
INSERT INTO sch_log VALUES ('851', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411118883');
INSERT INTO sch_log VALUES ('852', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411118909');
INSERT INTO sch_log VALUES ('853', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411118915');
INSERT INTO sch_log VALUES ('854', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411118956');
INSERT INTO sch_log VALUES ('855', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411119148');
INSERT INTO sch_log VALUES ('856', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411119311');
INSERT INTO sch_log VALUES ('857', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411349163');
INSERT INTO sch_log VALUES ('858', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411350036');
INSERT INTO sch_log VALUES ('859', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411350058');
INSERT INTO sch_log VALUES ('860', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411350098');
INSERT INTO sch_log VALUES ('861', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411350437');
INSERT INTO sch_log VALUES ('862', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411350495');
INSERT INTO sch_log VALUES ('863', '0', '重置教师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411357245');
INSERT INTO sch_log VALUES ('864', '0', '重置教师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411357251');
INSERT INTO sch_log VALUES ('865', '0', '重置教师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1411357283');
INSERT INTO sch_log VALUES ('866', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.10', '121584', 'w36451978107373010061', '数学老师', '1411437967');
INSERT INTO sch_log VALUES ('867', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1411438178');
INSERT INTO sch_log VALUES ('868', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.20', '121584', 'w36451978107373010061', '数学老师', '1411438539');
INSERT INTO sch_log VALUES ('869', '1', '修改了学校公告部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:172.16.3.20', '121584', 'w36451978107373010061', '数学老师', '1411438927');
INSERT INTO sch_log VALUES ('870', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.20', '121584', 'w36451978107373010061', '数学老师', '1411439139');
INSERT INTO sch_log VALUES ('871', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.20', '121584', 'w36451978107373010061', '数学老师', '1411439290');
INSERT INTO sch_log VALUES ('872', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:172.16.3.20', '121584', 'w36451978107373010061', '数学老师', '1411439451');
INSERT INTO sch_log VALUES ('873', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:172.16.3.20', '121584', 'w36451978107373010061', '数学老师', '1411439456');
INSERT INTO sch_log VALUES ('874', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:172.16.3.20', '121584', 'w36451978107373010061', '数学老师', '1411439498');
INSERT INTO sch_log VALUES ('875', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.10', '121502', 'w36451978107373010061', '数学老师', '1411439754');
INSERT INTO sch_log VALUES ('876', '0', '添加学校管理员老师二', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1413513773');
INSERT INTO sch_log VALUES ('877', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414138166');
INSERT INTO sch_log VALUES ('878', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414138174');
INSERT INTO sch_log VALUES ('879', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414143243');
INSERT INTO sch_log VALUES ('880', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414143250');
INSERT INTO sch_log VALUES ('881', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414143255');
INSERT INTO sch_log VALUES ('882', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414143256');
INSERT INTO sch_log VALUES ('883', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414143259');
INSERT INTO sch_log VALUES ('884', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414143265');
INSERT INTO sch_log VALUES ('885', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376925');
INSERT INTO sch_log VALUES ('886', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376930');
INSERT INTO sch_log VALUES ('887', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376931');
INSERT INTO sch_log VALUES ('888', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376932');
INSERT INTO sch_log VALUES ('889', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376934');
INSERT INTO sch_log VALUES ('890', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376939');
INSERT INTO sch_log VALUES ('891', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376942');
INSERT INTO sch_log VALUES ('892', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376944');
INSERT INTO sch_log VALUES ('893', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376948');
INSERT INTO sch_log VALUES ('894', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376969');
INSERT INTO sch_log VALUES ('895', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376972');
INSERT INTO sch_log VALUES ('896', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376975');
INSERT INTO sch_log VALUES ('897', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376990');
INSERT INTO sch_log VALUES ('898', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376993');
INSERT INTO sch_log VALUES ('899', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376994');
INSERT INTO sch_log VALUES ('900', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376996');
INSERT INTO sch_log VALUES ('901', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414376999');
INSERT INTO sch_log VALUES ('902', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377001');
INSERT INTO sch_log VALUES ('903', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377003');
INSERT INTO sch_log VALUES ('904', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377006');
INSERT INTO sch_log VALUES ('905', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377009');
INSERT INTO sch_log VALUES ('906', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377013');
INSERT INTO sch_log VALUES ('907', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377271');
INSERT INTO sch_log VALUES ('908', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377275');
INSERT INTO sch_log VALUES ('909', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377277');
INSERT INTO sch_log VALUES ('910', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377280');
INSERT INTO sch_log VALUES ('911', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414377283');
INSERT INTO sch_log VALUES ('912', '0', '添加教师xinteacher1', 'School_Admin_Class', 'addTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414395889');
INSERT INTO sch_log VALUES ('913', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1414396064');
INSERT INTO sch_log VALUES ('914', '0', '重置教师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.16', '121502', 'm36359802300862200030', '徐杰', '1414999291');
INSERT INTO sch_log VALUES ('915', '0', '重置教师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1415000132');
INSERT INTO sch_log VALUES ('916', '0', '重置教师密码', 'School_Admin_Class', 'resetTeacherPasswordByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1415000138');
INSERT INTO sch_log VALUES ('917', '0', '添加学校管理员然老师', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1415934000');
INSERT INTO sch_log VALUES ('918', '0', '添加学校管理员徐师', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1415934035');
INSERT INTO sch_log VALUES ('919', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1415934446');
INSERT INTO sch_log VALUES ('920', '0', '添加学校管理员小刀刀', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1415934459');
INSERT INTO sch_log VALUES ('921', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1415934464');
INSERT INTO sch_log VALUES ('922', '0', '添加学校管理员姜琴', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.16', '121502', 'w36451978107373010061', '数学老师', '1415934745');
INSERT INTO sch_log VALUES ('923', '0', '添加长江数字小学201', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416191774');
INSERT INTO sch_log VALUES ('924', '0', '添加长江数字小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416278941');
INSERT INTO sch_log VALUES ('925', '0', '添加长江数字小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416279027');
INSERT INTO sch_log VALUES ('926', '0', '添加长江数字小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416280378');
INSERT INTO sch_log VALUES ('927', '0', '添加长江数字小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416280696');
INSERT INTO sch_log VALUES ('928', '0', '添加长江数字小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416295830');
INSERT INTO sch_log VALUES ('929', '0', '添加长江数字小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416295852');
INSERT INTO sch_log VALUES ('930', '0', '添加长江数字小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416298824');
INSERT INTO sch_log VALUES ('931', '0', '添加长江数字小学201403', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416298855');
INSERT INTO sch_log VALUES ('932', '0', '删除长江数字小学小学一年级:201402', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416298904');
INSERT INTO sch_log VALUES ('933', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416466101');
INSERT INTO sch_log VALUES ('934', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416466429');
INSERT INTO sch_log VALUES ('935', '0', '添加长江数字小学201404', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.4', '121502', 'w36451978107373010061', '数学老师', '1416467143');
INSERT INTO sch_log VALUES ('936', '0', '添加长江数字小学201405', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416467215');
INSERT INTO sch_log VALUES ('937', '0', '添加长江数字小学201404', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416469217');
INSERT INTO sch_log VALUES ('938', '0', '添加长江数字小学201404', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416469242');
INSERT INTO sch_log VALUES ('939', '0', '添加长江数字小学201404', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416469265');
INSERT INTO sch_log VALUES ('940', '0', '删除长江数字小学小学一年级:201404', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416469270');
INSERT INTO sch_log VALUES ('941', '0', '删除长江数字小学小学一年级:20141', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416469326');
INSERT INTO sch_log VALUES ('942', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416472003');
INSERT INTO sch_log VALUES ('943', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416474078');
INSERT INTO sch_log VALUES ('944', '0', '添加长江数字小学201404', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1416882363');
INSERT INTO sch_log VALUES ('945', '0', '添加长江实验小学201401', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121584', 'm36359802300862200030', '徐杰', '1416981838');
INSERT INTO sch_log VALUES ('946', '0', '添加长江实验小学201401', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121584', 'm36359802300862200030', '徐杰', '1416981848');
INSERT INTO sch_log VALUES ('947', '0', '添加长江实验小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121584', 'm36359802300862200030', '徐杰', '1416981984');
INSERT INTO sch_log VALUES ('948', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417510051');
INSERT INTO sch_log VALUES ('949', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417510053');
INSERT INTO sch_log VALUES ('950', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417510056');
INSERT INTO sch_log VALUES ('951', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417510058');
INSERT INTO sch_log VALUES ('952', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417510060');
INSERT INTO sch_log VALUES ('953', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417510067');
INSERT INTO sch_log VALUES ('954', '0', '添加长江数字小学201406', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417598477');
INSERT INTO sch_log VALUES ('955', '0', '删除长江数字小学小学一年级:201406', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417598486');
INSERT INTO sch_log VALUES ('956', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417598673');
INSERT INTO sch_log VALUES ('957', '0', '将教师移出班级', 'School_Admin_Class', 'removeTeacherByClassId', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417598695');
INSERT INTO sch_log VALUES ('958', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417598924');
INSERT INTO sch_log VALUES ('959', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417760840');
INSERT INTO sch_log VALUES ('960', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417761022');
INSERT INTO sch_log VALUES ('961', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417761117');
INSERT INTO sch_log VALUES ('962', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417761138');
INSERT INTO sch_log VALUES ('963', '0', '删除教师账号', 'School_Admin_Class', 'deleteTeacherFromSchoolByUid', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417761146');
INSERT INTO sch_log VALUES ('964', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417761299');
INSERT INTO sch_log VALUES ('965', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417761344');
INSERT INTO sch_log VALUES ('966', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417761494');
INSERT INTO sch_log VALUES ('967', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417762622');
INSERT INTO sch_log VALUES ('968', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1417762842');
INSERT INTO sch_log VALUES ('969', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1418350672');
INSERT INTO sch_log VALUES ('970', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1418350675');
INSERT INTO sch_log VALUES ('971', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1418692151');
INSERT INTO sch_log VALUES ('972', '0', '添加武汉市江岸区一元路小学201401', 'School_Admin_Class', 'addClassPost', 'IP地址:27.17.50.54', '107074', 'c40834680303311540014', '李师师', '1418711914');
INSERT INTO sch_log VALUES ('973', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '107074', 'c40834680303311540014', '李师师', '1418711938');
INSERT INTO sch_log VALUES ('974', '0', '添加武汉市江岸区一元路小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:27.17.50.54', '107074', 'c41871078700048980091', '测试', '1418712878');
INSERT INTO sch_log VALUES ('975', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '107074', 'c41871078700048980091', '测试', '1418712899');
INSERT INTO sch_log VALUES ('976', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:27.17.50.54', '107074', 'c41871078700048980091', '测试', '1418713954');
INSERT INTO sch_log VALUES ('977', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:27.17.50.54', '107074', 'c41871078700048980091', '测试', '1418714050');
INSERT INTO sch_log VALUES ('978', '0', '添加武汉市江岸区一元路小学201403', 'School_Admin_Class', 'addClassPost', 'IP地址:27.17.50.54', '107074', 'c41871078700048980091', '测试', '1418719616');
INSERT INTO sch_log VALUES ('979', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '107074', 'c41871078700048980091', '测试', '1418719651');
INSERT INTO sch_log VALUES ('980', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1418797778');
INSERT INTO sch_log VALUES ('981', '0', '添加长江数字小学201499', 'School_Admin_Class', 'addClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1418804296');
INSERT INTO sch_log VALUES ('982', '0', '删除长江数字小学小学一年级:201499', 'School_Admin_Class', 'delClass', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1418804302');
INSERT INTO sch_log VALUES ('983', '0', '添加汉川市庙头镇人和小学201401', 'School_Admin_Class', 'addClassPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418807279');
INSERT INTO sch_log VALUES ('984', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418807310');
INSERT INTO sch_log VALUES ('985', '0', '添加汉川市庙头镇人和小学201402', 'School_Admin_Class', 'addClassPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418869289');
INSERT INTO sch_log VALUES ('986', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418870724');
INSERT INTO sch_log VALUES ('987', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418870740');
INSERT INTO sch_log VALUES ('988', '0', '信息分类管理：修改栏目', 'School_Admin_Column', 'editPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418882268');
INSERT INTO sch_log VALUES ('989', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418882938');
INSERT INTO sch_log VALUES ('990', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418883101');
INSERT INTO sch_log VALUES ('991', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418883257');
INSERT INTO sch_log VALUES ('992', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418883382');
INSERT INTO sch_log VALUES ('993', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418883481');
INSERT INTO sch_log VALUES ('994', '0', '信息列表：信息排序', 'School_Admin_Relate', 'order', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418883559');
INSERT INTO sch_log VALUES ('995', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418883658');
INSERT INTO sch_log VALUES ('996', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418883806');
INSERT INTO sch_log VALUES ('997', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418883893');
INSERT INTO sch_log VALUES ('998', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '101146', 'c41880688107904950070', '李策师', '1418884064');
INSERT INTO sch_log VALUES ('999', '0', '改学号', 'School_Admin_Class', 'editClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1419230148');
INSERT INTO sch_log VALUES ('1000', '0', '改学号', 'School_Admin_Class', 'editClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1419230174');
INSERT INTO sch_log VALUES ('1001', '0', '改学号', 'School_Admin_Class', 'editClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1419230199');
INSERT INTO sch_log VALUES ('1002', '0', '添加学校管理员吴清忠', 'School_Admin_Member', 'addPost', 'IP地址:172.16.3.15', '121502', 'w36451978107373010061', '数学老师', '1419404292');
INSERT INTO sch_log VALUES ('1003', '0', '修改管理员应用权限', 'School_Admin_Member', 'setPrivPost', 'IP地址:172.16.3.15', '121502', 'w36451978107373010061', '数学老师', '1419404297');
INSERT INTO sch_log VALUES ('1004', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.15', '121502', 'w36451978107373010061', '数学老师', '1419404457');
INSERT INTO sch_log VALUES ('1005', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419907750');
INSERT INTO sch_log VALUES ('1006', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419907794');
INSERT INTO sch_log VALUES ('1007', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419907851');
INSERT INTO sch_log VALUES ('1008', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908192');
INSERT INTO sch_log VALUES ('1009', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908193');
INSERT INTO sch_log VALUES ('1010', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908200');
INSERT INTO sch_log VALUES ('1011', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908217');
INSERT INTO sch_log VALUES ('1012', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908414');
INSERT INTO sch_log VALUES ('1013', '0', '信息分类管理：修改状态', 'School_Admin_Column', 'isok', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908435');
INSERT INTO sch_log VALUES ('1014', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908521');
INSERT INTO sch_log VALUES ('1015', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908658');
INSERT INTO sch_log VALUES ('1016', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908779');
INSERT INTO sch_log VALUES ('1017', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908909');
INSERT INTO sch_log VALUES ('1018', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1419908946');
INSERT INTO sch_log VALUES ('1019', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1420356181');
INSERT INTO sch_log VALUES ('1020', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1420356183');
INSERT INTO sch_log VALUES ('1021', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1420356367');
INSERT INTO sch_log VALUES ('1022', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1420356368');
INSERT INTO sch_log VALUES ('1023', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1420356461');
INSERT INTO sch_log VALUES ('1024', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1420356466');
INSERT INTO sch_log VALUES ('1025', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1420357018');
INSERT INTO sch_log VALUES ('1026', '0', '信息分类管理：显示到导航', 'School_Admin_Column', 'menu', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1420357019');
INSERT INTO sch_log VALUES ('1027', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1420535906');
INSERT INTO sch_log VALUES ('1028', '0', '添加长江数字小学201408', 'School_Admin_Class', 'addClassPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1420610687');
INSERT INTO sch_log VALUES ('1029', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1420610847');
INSERT INTO sch_log VALUES ('1030', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '101593', 'c42061813702570950015', '测试', '1420619776');
INSERT INTO sch_log VALUES ('1031', '0', '设定班主任', 'School_Admin_Class', 'setClassHead', 'IP地址:27.17.50.54', '101593', 'c42061813702570950015', '测试', '1420619883');
INSERT INTO sch_log VALUES ('1032', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420697764');
INSERT INTO sch_log VALUES ('1033', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420697857');
INSERT INTO sch_log VALUES ('1034', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420697996');
INSERT INTO sch_log VALUES ('1035', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420699656');
INSERT INTO sch_log VALUES ('1036', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420699875');
INSERT INTO sch_log VALUES ('1037', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700159');
INSERT INTO sch_log VALUES ('1038', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700167');
INSERT INTO sch_log VALUES ('1039', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700167');
INSERT INTO sch_log VALUES ('1040', '1', '修改了友情链接部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700206');
INSERT INTO sch_log VALUES ('1041', '1', '修改了校园动态部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700217');
INSERT INTO sch_log VALUES ('1042', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700227');
INSERT INTO sch_log VALUES ('1043', '1', '修改了校园动态部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700236');
INSERT INTO sch_log VALUES ('1044', '1', '修改了校园动态部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700240');
INSERT INTO sch_log VALUES ('1045', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700912');
INSERT INTO sch_log VALUES ('1046', '1', '修改了校园动态部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420700927');
INSERT INTO sch_log VALUES ('1047', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420701060');
INSERT INTO sch_log VALUES ('1048', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420701107');
INSERT INTO sch_log VALUES ('1049', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420701952');
INSERT INTO sch_log VALUES ('1050', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420701956');
INSERT INTO sch_log VALUES ('1051', '0', '信息分类管理：增加栏目', 'School_Admin_Column', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707532');
INSERT INTO sch_log VALUES ('1052', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707543');
INSERT INTO sch_log VALUES ('1053', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707548');
INSERT INTO sch_log VALUES ('1054', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707550');
INSERT INTO sch_log VALUES ('1055', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707552');
INSERT INTO sch_log VALUES ('1056', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707554');
INSERT INTO sch_log VALUES ('1057', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707556');
INSERT INTO sch_log VALUES ('1058', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707558');
INSERT INTO sch_log VALUES ('1059', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707561');
INSERT INTO sch_log VALUES ('1060', '0', '信息分类管理：删除栏目', 'School_Admin_Column', 'del', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420707574');
INSERT INTO sch_log VALUES ('1061', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420710284');
INSERT INTO sch_log VALUES ('1062', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1420710390');
INSERT INTO sch_log VALUES ('1063', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1421044250');
INSERT INTO sch_log VALUES ('1064', '0', '导出教师清单', 'School_Admin_Class', 'exportTeacher', 'IP地址:172.16.3.6', '121584', 'w36451978107373010061', '数学老师', '1421046377');
INSERT INTO sch_log VALUES ('1065', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1421052686');
INSERT INTO sch_log VALUES ('1066', '0', '改学号', 'School_Admin_Class', 'editClassPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1421055314');
INSERT INTO sch_log VALUES ('1067', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1421222062');
INSERT INTO sch_log VALUES ('1068', '1', '修改了自定义列表部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1421222087');
INSERT INTO sch_log VALUES ('1069', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1421222257');
INSERT INTO sch_log VALUES ('1070', '1', '修改了文本区域部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1421223362');
INSERT INTO sch_log VALUES ('1071', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1421226162');
INSERT INTO sch_log VALUES ('1072', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:27.17.50.54', '117686', 'w36451978107373010061', '数学老师', '1421306194');
INSERT INTO sch_log VALUES ('1073', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.6', '121584', 'w36451978107373010061', '数学老师', '1421654549');
INSERT INTO sch_log VALUES ('1074', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1421654856');
INSERT INTO sch_log VALUES ('1075', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1421655089');
INSERT INTO sch_log VALUES ('1076', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1421655116');
INSERT INTO sch_log VALUES ('1077', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1421655149');
INSERT INTO sch_log VALUES ('1078', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.10', '121502', 'm36359802300862200030', '徐杰', '1421718213');
INSERT INTO sch_log VALUES ('1079', '0', '信息分类管理：栏目排序', 'School_Admin_Column', 'order', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421746654');
INSERT INTO sch_log VALUES ('1080', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421746742');
INSERT INTO sch_log VALUES ('1081', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421746891');
INSERT INTO sch_log VALUES ('1082', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421746914');
INSERT INTO sch_log VALUES ('1083', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421747882');
INSERT INTO sch_log VALUES ('1084', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421747922');
INSERT INTO sch_log VALUES ('1085', '1', '修改了学校简介部件的设置信息', 'School_Home', 'saveWidget', 'IP地址:27.17.50.54', '121502', 'w36451978107373010061', '数学老师', '1421825506');
INSERT INTO sch_log VALUES ('1086', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421914060');
INSERT INTO sch_log VALUES ('1087', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915094');
INSERT INTO sch_log VALUES ('1088', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915098');
INSERT INTO sch_log VALUES ('1089', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915101');
INSERT INTO sch_log VALUES ('1090', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915105');
INSERT INTO sch_log VALUES ('1091', '0', '信息列表：删除信息', 'School_Admin_Relate', 'del', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915112');
INSERT INTO sch_log VALUES ('1092', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915175');
INSERT INTO sch_log VALUES ('1093', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915179');
INSERT INTO sch_log VALUES ('1094', '0', '信息列表：增加信息', 'School_Admin_Relate', 'addPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915295');
INSERT INTO sch_log VALUES ('1095', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915302');
INSERT INTO sch_log VALUES ('1096', '0', '信息列表：编辑信息', 'School_Admin_Relate', 'editPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421915307');
INSERT INTO sch_log VALUES ('1097', '1', '定制了主页界面', 'School_Home', 'designPost', 'IP地址:172.16.3.19', '121502', 'w36451978107373010061', '数学老师', '1421979250');
INSERT INTO sch_log VALUES ('1098', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1422511602');
INSERT INTO sch_log VALUES ('1099', '0', '批量导入教师', 'School_Admin_Class', 'importTeacherPost', 'IP地址:27.17.50.54', '121584', 'w36451978107373010061', '数学老师', '1422512032');
INSERT INTO sch_log VALUES ('1100', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1423037104');
INSERT INTO sch_log VALUES ('1101', '0', '修改学校基本信息', 'School_Admin_School', 'editPost', 'IP地址:172.16.3.20', '121502', 'w36451978107373010061', '数学老师', '1423037109');
INSERT INTO sch_log VALUES ('1102', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.13', '121502', 'w36451978107373010061', '数学老师', '1423183662');
INSERT INTO sch_log VALUES ('1103', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.13', '121502', 'w36451978107373010061', '数学老师', '1423191952');
INSERT INTO sch_log VALUES ('1104', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.5', '121502', 'w36451978107373010061', '数学老师', '1423192495');
INSERT INTO sch_log VALUES ('1105', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.5', '121502', 'w36451978107373010061', '数学老师', '1423192561');
INSERT INTO sch_log VALUES ('1106', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.5', '121502', 'w36451978107373010061', '数学老师', '1423192685');
INSERT INTO sch_log VALUES ('1107', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.13', '121502', 'w36451978107373010061', '数学老师', '1423471454');
INSERT INTO sch_log VALUES ('1108', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.13', '121502', 'w36451978107373010061', '数学老师', '1423471901');
INSERT INTO sch_log VALUES ('1109', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.13', '121502', 'w36451978107373010061', '数学老师', '1423472079');
INSERT INTO sch_log VALUES ('1110', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.13', '121502', 'w36451978107373010061', '数学老师', '1423472341');
INSERT INTO sch_log VALUES ('1111', '0', '删除学校管理员申请', 'School_Admin_Apply', 'del', 'IP地址:172.16.3.13', '121502', 'w36451978107373010061', '数学老师', '1423472380');
INSERT INTO sch_log VALUES ('1112', '0', '删除学校管理员', 'School_Admin_Member', 'del', 'IP地址:172.16.3.13', '121502', 'w36451978107373010061', '数学老师', '1423472471');

-- ----------------------------
-- Table structure for `sys_group`
-- ----------------------------
DROP TABLE IF EXISTS `sys_group`;
CREATE TABLE `sys_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `group_pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级用户组',
  `group_title` varchar(50) NOT NULL DEFAULT '' COMMENT '用户组名',
  `group_description` varchar(250) NOT NULL DEFAULT '' COMMENT '用户组描述',
  `group_module_list` varchar(100) NOT NULL DEFAULT '' COMMENT '模块列表',
  `group_gd` int(11) NOT NULL DEFAULT '0' COMMENT '固定',
  `group_isok` int(11) NOT NULL DEFAULT '0' COMMENT '是否有效',
  `group_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `group_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `xk` char(10) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='系统组';

-- ----------------------------
-- Records of sys_group
-- ----------------------------
INSERT INTO sys_group VALUES ('1', '0', '0', '系统管理员', '拥有最高权限', '', '1', '1', '1', '1382948368', 'sm');
INSERT INTO sys_group VALUES ('2', '0', '0', '参观者', '只有查看的功能', '', '1', '1', '2', '1382589377', 'sm');
INSERT INTO sys_group VALUES ('3', '0', '0', '课程老师', '课题组人员', '', '1', '1', '4', '1382948359', 'sm');
INSERT INTO sys_group VALUES ('4', '0', '0', '学生', '只能登录前台', '', '1', '1', '3', '1392951252', 'sm');

-- ----------------------------
-- Table structure for `sys_log`
-- ----------------------------
DROP TABLE IF EXISTS `sys_log`;
CREATE TABLE `sys_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `log_title` varchar(250) NOT NULL DEFAULT '' COMMENT '日志标题',
  `log_module_id` int(11) NOT NULL DEFAULT '0' COMMENT '模块ID',
  `log_module_controller` varchar(50) NOT NULL DEFAULT '' COMMENT '模块控制器',
  `log_module_action` varchar(50) NOT NULL DEFAULT '' COMMENT '模块操作',
  `log_user_uid` varchar(30) NOT NULL DEFAULT '' COMMENT '学籍ID',
  `log_isok` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `log_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `log_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `xk` char(10) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统日志表';

-- ----------------------------
-- Records of sys_log
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_module`
-- ----------------------------
DROP TABLE IF EXISTS `sys_module`;
CREATE TABLE `sys_module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `module_pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级模块',
  `module_type` int(11) NOT NULL DEFAULT '0' COMMENT '模块类型',
  `module_title` varchar(50) NOT NULL DEFAULT '' COMMENT '模块名称',
  `module_controller` varchar(150) NOT NULL DEFAULT '' COMMENT '控制器',
  `module_action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作',
  `module_url` varchar(50) NOT NULL DEFAULT '' COMMENT '自定义URL地址',
  `module_node` varchar(250) NOT NULL DEFAULT '' COMMENT '权限节点',
  `module_icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标风格',
  `module_isok` int(11) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `module_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `module_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `xk` char(10) DEFAULT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8 COMMENT='系统模块';

-- ----------------------------
-- Records of sys_module
-- ----------------------------
INSERT INTO sys_module VALUES ('2', '3', '1', '模块管理', 'Modules_Admin_Controllers_Module', 'indexAction', '', 'add,edit,del', 'menu-module', '1', '4', '1381484219', 'sm');
INSERT INTO sys_module VALUES ('3', '0', '1', '系统管理', ' ', ' ', '', '', 'icon_dataStatisticsGray', '1', '11', '1377850143', 'sm');
INSERT INTO sys_module VALUES ('4', '3', '1', '用户管理', 'Modules_Admin_Controllers_User', 'indexAction', '', '', 'menu-user', '1', '4', '1381396521', 'sm');
INSERT INTO sys_module VALUES ('5', '3', '1', '用户组管理', 'Modules_Admin_Controllers_UserGroup', 'indexAction', '', 'add,edit,del', 'menu-group', '1', '7', '1381484234', 'sm');
INSERT INTO sys_module VALUES ('129', '0', '1', '运营管理', 'log', 'tee', '', '', '', '0', '140', '1394779171', 'sm');
INSERT INTO sys_module VALUES ('130', '129', '1', '日志', 'log', '', '', '', '', '1', '131', '1394779206', 'sm');
INSERT INTO sys_module VALUES ('131', '129', '1', '报错', 'error', '', '', '', '', '1', '130', '1394779229', 'sm');
INSERT INTO sys_module VALUES ('132', '129', '1', '附件', 'attach', '', '', '', '', '1', '132', '1394779243', 'sm');
INSERT INTO sys_module VALUES ('156', '0', '1', '基础管理', 'Modules_Admin_Controllers_Cms', 'index', '', '', 'icon_infoManageGray', '1', '1', '0', 'XK');
INSERT INTO sys_module VALUES ('157', '156', '1', '基础分类管理', 'Modules_Admin_Controllers_Cate', 'indexAction', '', '', '', '1', '0', '0', 'XK');
INSERT INTO sys_module VALUES ('228', '156', '1', '内容管理', 'Modules_Admin_Controllers_Cms', 'indexAction', '', '', '', '1', '156', '0', 'XK');
INSERT INTO sys_module VALUES ('229', '233', '1', '标准资源管理', 'Modules_Admin_Controllers_Resource', 'indexAction', '', '', '', '1', '157', '0', 'XK');
INSERT INTO sys_module VALUES ('232', '234', '1', '资源统计', 'Modules_Admin_Controllers_Statis', 'indexAction', '', '', '', '1', '160', '0', 'XK');
INSERT INTO sys_module VALUES ('233', '0', '1', '资源管理', 'resource', 'index', '', '', '', '1', '2', '0', 'XK');
INSERT INTO sys_module VALUES ('234', '0', '1', '统计管理', 'Statis', 'index', '', '', '', '1', '3', '0', 'XK');
INSERT INTO sys_module VALUES ('236', '234', '1', '教师上传资源统计', 'Modules_Admin_Controllers_UserStatis', 'indexAction', '', '', '', '1', '0', '0', 'XK');
INSERT INTO sys_module VALUES ('238', '156', '1', 'cms栏目管理', 'Modules_Admin_Controllers_CmsColumn', 'indexAction', '', '', '', '1', '0', '0', 'XK');

-- ----------------------------
-- Table structure for `sys_purview`
-- ----------------------------
DROP TABLE IF EXISTS `sys_purview`;
CREATE TABLE `sys_purview` (
  `purview_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `purview_group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组',
  `purview_type` int(11) NOT NULL DEFAULT '0' COMMENT '权限类型',
  `purview_module_id` int(11) NOT NULL DEFAULT '0' COMMENT '模块ID',
  `purview_node` varchar(100) NOT NULL DEFAULT '' COMMENT '权限节点',
  PRIMARY KEY (`purview_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1241 DEFAULT CHARSET=utf8 COMMENT='组权限';

-- ----------------------------
-- Records of sys_purview
-- ----------------------------
INSERT INTO sys_purview VALUES ('26', '3', '0', '5', 'run');
INSERT INTO sys_purview VALUES ('1019', '132', '0', '203', '');
INSERT INTO sys_purview VALUES ('1020', '132', '0', '204', '');
INSERT INTO sys_purview VALUES ('1021', '132', '0', '209', '');
INSERT INTO sys_purview VALUES ('1022', '132', '0', '210', '');
INSERT INTO sys_purview VALUES ('1023', '132', '0', '211', '');
INSERT INTO sys_purview VALUES ('1024', '132', '0', '212', '');
INSERT INTO sys_purview VALUES ('1025', '132', '0', '226', '');
INSERT INTO sys_purview VALUES ('1026', '132', '0', '205', '');
INSERT INTO sys_purview VALUES ('1027', '132', '0', '206', '');
INSERT INTO sys_purview VALUES ('1028', '132', '0', '207', '');
INSERT INTO sys_purview VALUES ('1029', '132', '0', '208', '');
INSERT INTO sys_purview VALUES ('1030', '132', '0', '196', '');
INSERT INTO sys_purview VALUES ('1031', '132', '0', '195', '');
INSERT INTO sys_purview VALUES ('1032', '132', '0', '197', '');
INSERT INTO sys_purview VALUES ('1033', '132', '0', '198', '');
INSERT INTO sys_purview VALUES ('1034', '132', '0', '227', '');
INSERT INTO sys_purview VALUES ('1228', '1', '0', '156', '');
INSERT INTO sys_purview VALUES ('1229', '1', '0', '157', '');
INSERT INTO sys_purview VALUES ('1230', '1', '0', '238', '');
INSERT INTO sys_purview VALUES ('1231', '1', '0', '228', '');
INSERT INTO sys_purview VALUES ('1232', '1', '0', '233', '');
INSERT INTO sys_purview VALUES ('1233', '1', '0', '229', '');
INSERT INTO sys_purview VALUES ('1234', '1', '0', '234', '');
INSERT INTO sys_purview VALUES ('1235', '1', '0', '236', '');
INSERT INTO sys_purview VALUES ('1236', '1', '0', '232', '');
INSERT INTO sys_purview VALUES ('1237', '1', '0', '3', '');
INSERT INTO sys_purview VALUES ('1238', '1', '0', '2', '');
INSERT INTO sys_purview VALUES ('1239', '1', '0', '4', '');
INSERT INTO sys_purview VALUES ('1240', '1', '0', '5', '');

-- ----------------------------
-- Table structure for `sys_user`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(50) NOT NULL DEFAULT '' COMMENT '用户密码',
  `user_realname` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `user_group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组',
  `user_value` int(11) NOT NULL DEFAULT '0' COMMENT '学分',
  `user_star` int(11) NOT NULL DEFAULT '0' COMMENT '星星',
  `user_uid` varchar(30) NOT NULL DEFAULT '' COMMENT '学籍ID',
  `user_avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '用户头象',
  `user_school_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校ID',
  `user_school_name` varchar(50) NOT NULL DEFAULT '' COMMENT '学校名称',
  `user_gd` int(1) NOT NULL DEFAULT '0',
  `user_isok` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `user_order` int(11) NOT NULL DEFAULT '0',
  `user_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `xk` char(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `用户-用户组关联` (`user_group_id`),
  KEY `uid` (`user_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统管理用户表';

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO sys_user VALUES ('1', 'admin', '123456', ' 游龙', '1', '0', '0', 'm36359802300862200030', '', '0', '', '0', '1', '0', '1378429535', 'sm');

-- ----------------------------
-- Function structure for `genCmsColumnPidPath`
-- ----------------------------
DROP FUNCTION IF EXISTS `genCmsColumnPidPath`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `genCmsColumnPidPath`(`id_one` int) RETURNS char(100) CHARSET utf8
    READS SQL DATA
BEGIN
	DECLARE sTemp char (100);
	DECLARE sTempChd char (100);
	SET sTemp=null;
	SET sTempChd=cast(id_one AS CHAR);
	WHILE sTempChd is not null DO
		IF sTemp is not null THEN
			SET sTemp = concat(sTempChd,',',sTemp);
		END IF;
		IF sTemp is null THEN
			SET sTemp=sTempChd;
		END IF;
		SELECT
			GROUP_CONCAT(pid) INTO sTempChd
		FROM
			cms_column
		WHERE
			FIND_IN_SET(id,sTempChd);
	END WHILE;
	RETURN sTemp;
END
;;
DELIMITER ;

-- ----------------------------
-- Function structure for `genCusPidPath`
-- ----------------------------
DROP FUNCTION IF EXISTS `genCusPidPath`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `genCusPidPath`(`id_one` int) RETURNS char(100) CHARSET utf8
    READS SQL DATA
BEGIN
	DECLARE sTemp char (100);
	DECLARE sTempChd char (100);
	SET sTemp=null;
	SET sTempChd=cast(id_one AS CHAR);
	WHILE sTempChd is not null DO
		IF sTemp is not null THEN
			SET sTemp = concat(sTempChd,',',sTemp);
		END IF;
		IF sTemp is null THEN
			SET sTemp=sTempChd;
		END IF;
		SELECT
			GROUP_CONCAT(pid) INTO sTempChd
		FROM
			cus_cate
		WHERE
			FIND_IN_SET(id,sTempChd);
	END WHILE;
	RETURN sTemp;
END
;;
DELIMITER ;
