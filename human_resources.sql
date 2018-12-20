-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: 2018-12-20 15:42:18
-- 服务器版本： 5.7.21
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `human_resources`
--

-- --------------------------------------------------------

--
-- 表的结构 `feedback`
--

CREATE TABLE `feedback` (
  `department` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `confirm` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '未审核'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- 表的结构 `holiday`
--

CREATE TABLE `holiday` (
  `name` varchar(100) NOT NULL COMMENT '姓名',
  `department` varchar(100) DEFAULT NULL COMMENT '部门',
  `initdate` date NOT NULL COMMENT '参与工作时间',
  `indate` date DEFAULT NULL COMMENT '入司时间',
  `Companyage` int(11) NOT NULL DEFAULT '0' COMMENT '公司工龄',
  `Totalage` int(11) NOT NULL DEFAULT '0' COMMENT '社会工龄',
  `Totalday` int(11) DEFAULT '0' COMMENT '可休假总天数',
  `Lastyear` int(11) DEFAULT '0' COMMENT '今年可休假总天数',
  `Thisyear` int(11) DEFAULT '0' COMMENT '上一年可休假总天数',
  `Bonus` int(11) DEFAULT '0' COMMENT '荣誉休假总天数',
  `Used` int(11) DEFAULT '0' COMMENT '已休假天数',
  `Rest` int(11) DEFAULT '0' COMMENT '未休假天数',
  `initflag` int(1) NOT NULL DEFAULT '0' COMMENT '初始化标志，1为已初始化，0为未初始化',
  `Jan` int(11) NOT NULL DEFAULT '0' COMMENT '一月休假已天数',
  `Feb` int(11) NOT NULL DEFAULT '0' COMMENT '二月休假已天数',
  `Mar` int(11) NOT NULL DEFAULT '0' COMMENT '三月休假已天数',
  `Apr` int(11) NOT NULL DEFAULT '0' COMMENT '四月休假已天数',
  `May` int(11) NOT NULL DEFAULT '0' COMMENT '五月休假已天数',
  `Jun` int(11) NOT NULL DEFAULT '0' COMMENT '六月休假已天数',
  `Jul` int(11) NOT NULL DEFAULT '0' COMMENT '七月休假已天数',
  `Aug` int(11) NOT NULL DEFAULT '0' COMMENT '八月休假已天数',
  `Sep` int(11) NOT NULL DEFAULT '0' COMMENT '九月休假已天数',
  `Oct` int(11) NOT NULL DEFAULT '0' COMMENT '十月休假已天数',
  `Nov` int(11) DEFAULT '0' COMMENT '十一月休假已天数',
  `Dece` int(11) NOT NULL DEFAULT '0' COMMENT '十二月休假已天数',
  `user_id` varchar(18) NOT NULL COMMENT '身份证号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 表的结构 `holiday_doc`
--

CREATE TABLE `holiday_doc` (
  `number` varchar(12) DEFAULT NULL,
  `doc_name` varchar(50) NOT NULL,
  `doc_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `holiday_users`
--

CREATE TABLE `holiday_users` (
  `user_id` varchar(20) NOT NULL COMMENT '身份证号',
  `username` varchar(6) NOT NULL COMMENT '姓名',
  `password` varchar(255) NOT NULL COMMENT '初始值为身份证后六位',
  `permission` int(11) NOT NULL COMMENT '1是部门负责人，2是综合管理，3是员工'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 表的结构 `log_action`
--

CREATE TABLE `log_action` (
  `log_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `username` varchar(10) NOT NULL,
  `login_ip` varchar(50) NOT NULL,
  `staff_action` varchar(50) NOT NULL,
  `action_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

CREATE TABLE `notice` (
  `pubtime` datetime NOT NULL COMMENT '公告发布时间',
  `username` varchar(255) NOT NULL COMMENT '发布公告人姓名',
  `title` varchar(255) NOT NULL COMMENT '公告标题',
  `content` varchar(2550) NOT NULL COMMENT '公告内容',
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 表的结构 `plan`
--

CREATE TABLE `plan` (
  `user_id` varchar(18) NOT NULL COMMENT '身份证号',
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `department` varchar(255) NOT NULL COMMENT '员工所在的部门',
  `Thisyear` int(11) NOT NULL DEFAULT '0' COMMENT '今年的年假数目',
  `Lastyear` int(11) NOT NULL DEFAULT '0' COMMENT '上一年的年假数目',
  `Bonus` int(11) NOT NULL DEFAULT '0' COMMENT '荣誉休假数目',
  `Totalday` int(11) NOT NULL DEFAULT '0' COMMENT '总的休假数目',
  `firstquater` int(11) NOT NULL DEFAULT '0' COMMENT '第一季度计划休假数',
  `secondquater` int(11) NOT NULL DEFAULT '0' COMMENT '第二季度计划休假数',
  `thirdquater` int(11) NOT NULL DEFAULT '0' COMMENT '第三季度计划休假数',
  `fourthquater` int(11) NOT NULL DEFAULT '0' COMMENT '第四季度计划休假数',
  `submit_tag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '标记该用户是否提交过计划，重新提交需要综管员重新给权限，true是已提交，false是未提交'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `submit`
--

CREATE TABLE `submit` (
  `department` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '未提交'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `super_user`
--

CREATE TABLE `super_user` (
  `user_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permission` varchar(255) NOT NULL COMMENT '有三类工资，年假，绩效'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `super_user`
--

INSERT INTO `super_user` (`user_id`, `password`, `permission`) VALUES
('lyjw', '71b7b337e2987e91fec8e799fe2841ef', '工资'),
('lyjh', 'adab7b701f23bb82014c8506d3dc784e', '休假');

-- --------------------------------------------------------

--
-- 表的结构 `wage`
--

CREATE TABLE `wage` (
  `number` varchar(4) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `user_id` varchar(18) DEFAULT NULL,
  `name` varchar(18) DEFAULT NULL,
  `content1` varchar(12) DEFAULT NULL,
  `content2` varchar(12) DEFAULT NULL,
  `content3` varchar(18) DEFAULT NULL,
  `content4` varchar(12) DEFAULT NULL,
  `content5` varchar(12) DEFAULT NULL,
  `content6` varchar(12) DEFAULT NULL,
  `content7` varchar(12) DEFAULT NULL,
  `content8` varchar(12) DEFAULT NULL,
  `content9` varchar(12) DEFAULT NULL,
  `content10` varchar(12) DEFAULT NULL,
  `content11` varchar(12) DEFAULT NULL,
  `content12` varchar(12) DEFAULT NULL,
  `content13` varchar(12) DEFAULT NULL,
  `content14` varchar(12) DEFAULT NULL,
  `content15` varchar(12) DEFAULT NULL,
  `content16` varchar(12) DEFAULT NULL,
  `content17` varchar(12) DEFAULT NULL,
  `content18` varchar(12) DEFAULT NULL,
  `content19` varchar(12) DEFAULT NULL,
  `content20` varchar(12) DEFAULT NULL,
  `content21` varchar(12) DEFAULT NULL,
  `content22` varchar(12) DEFAULT NULL,
  `content23` varchar(12) DEFAULT NULL,
  `content24` varchar(12) DEFAULT NULL,
  `content25` varchar(12) DEFAULT NULL,
  `content26` varchar(12) DEFAULT NULL,
  `content27` varchar(12) DEFAULT NULL,
  `content28` varchar(12) DEFAULT NULL,
  `content29` varchar(12) DEFAULT NULL,
  `content30` varchar(12) DEFAULT NULL,
  `content31` varchar(12) DEFAULT NULL,
  `content32` varchar(12) DEFAULT NULL,
  `content33` varchar(12) DEFAULT NULL,
  `content34` varchar(12) DEFAULT NULL,
  `content35` varchar(12) DEFAULT NULL,
  `content36` varchar(12) DEFAULT NULL,
  `content37` varchar(12) DEFAULT NULL,
  `content38` varchar(12) DEFAULT NULL,
  `content39` varchar(12) DEFAULT NULL,
  `content40` varchar(12) DEFAULT NULL,
  `content41` varchar(12) DEFAULT NULL,
  `content42` varchar(12) DEFAULT NULL,
  `content43` varchar(12) DEFAULT NULL,
  `content44` varchar(12) DEFAULT NULL,
  `content45` varchar(12) DEFAULT NULL,
  `content46` varchar(12) DEFAULT NULL,
  `content47` varchar(12) DEFAULT NULL,
  `content48` varchar(12) DEFAULT NULL,
  `content49` varchar(12) DEFAULT NULL,
  `content50` varchar(12) DEFAULT NULL,
  `content51` varchar(12) DEFAULT NULL,
  `content52` varchar(12) DEFAULT NULL,
  `content53` varchar(12) DEFAULT NULL,
  `content54` varchar(12) DEFAULT NULL,
  `content55` varchar(12) DEFAULT NULL,
  `content56` varchar(12) DEFAULT NULL,
  `content57` varchar(12) DEFAULT NULL,
  `content58` varchar(12) DEFAULT NULL,
  `content59` varchar(12) DEFAULT NULL,
  `content60` varchar(12) DEFAULT NULL,
  `content61` varchar(12) DEFAULT NULL,
  `content62` varchar(12) DEFAULT NULL,
  `content63` varchar(12) DEFAULT NULL,
  `content64` varchar(12) DEFAULT NULL,
  `content65` varchar(12) DEFAULT NULL,
  `content66` varchar(12) DEFAULT NULL,
  `content67` varchar(12) DEFAULT NULL,
  `content68` varchar(12) DEFAULT NULL,
  `content69` varchar(12) DEFAULT NULL,
  `content70` varchar(12) DEFAULT NULL,
  `content71` varchar(12) DEFAULT NULL,
  `content72` varchar(12) DEFAULT NULL,
  `content73` varchar(12) DEFAULT NULL,
  `content74` varchar(12) DEFAULT NULL,
  `content75` varchar(12) DEFAULT NULL,
  `content76` varchar(12) DEFAULT NULL,
  `content77` varchar(12) DEFAULT NULL,
  `content78` varchar(12) DEFAULT NULL,
  `content79` varchar(12) DEFAULT NULL,
  `content80` varchar(12) DEFAULT NULL,
  `content81` varchar(12) DEFAULT NULL,
  `content82` varchar(12) DEFAULT NULL,
  `content83` varchar(12) DEFAULT NULL,
  `content84` varchar(12) DEFAULT NULL,
  `content85` varchar(12) DEFAULT NULL,
  `content86` varchar(12) DEFAULT NULL,
  `content87` varchar(12) DEFAULT NULL,
  `content88` varchar(12) DEFAULT NULL,
  `content89` varchar(12) DEFAULT NULL,
  `content90` varchar(12) DEFAULT NULL,
  `content91` varchar(12) DEFAULT NULL,
  `content92` varchar(12) DEFAULT NULL,
  `content93` varchar(12) DEFAULT NULL,
  `content94` varchar(12) DEFAULT NULL,
  `content95` varchar(12) DEFAULT NULL,
  `content96` varchar(12) DEFAULT NULL,
  `content97` varchar(12) DEFAULT NULL,
  `content98` varchar(12) DEFAULT NULL,
  `content99` varchar(12) DEFAULT NULL,
  `content100` varchar(12) DEFAULT NULL,
  `content101` varchar(12) DEFAULT NULL,
  `content102` varchar(12) DEFAULT NULL,
  `content103` varchar(12) DEFAULT NULL,
  `content104` varchar(12) DEFAULT NULL,
  `content105` varchar(12) DEFAULT NULL,
  `content106` varchar(12) DEFAULT NULL,
  `content107` varchar(12) DEFAULT NULL,
  `content108` varchar(12) DEFAULT NULL,
  `content109` varchar(12) DEFAULT NULL,
  `content110` varchar(12) DEFAULT NULL,
  `content111` varchar(12) DEFAULT NULL,
  `content112` varchar(12) DEFAULT NULL,
  `content113` varchar(12) DEFAULT NULL,
  `content114` varchar(12) DEFAULT NULL,
  `content115` varchar(12) DEFAULT NULL,
  `content116` varchar(12) DEFAULT NULL,
  `content117` varchar(12) DEFAULT NULL,
  `content118` varchar(12) DEFAULT NULL,
  `content119` varchar(12) DEFAULT NULL,
  `content120` varchar(12) DEFAULT NULL,
  `content121` varchar(12) DEFAULT NULL,
  `content122` varchar(12) DEFAULT NULL,
  `content123` varchar(12) DEFAULT NULL,
  `content124` varchar(12) DEFAULT NULL,
  `content125` varchar(12) DEFAULT NULL,
  `content126` varchar(12) DEFAULT NULL,
  `content127` varchar(12) DEFAULT NULL,
  `content128` varchar(12) DEFAULT NULL,
  `content129` varchar(12) DEFAULT NULL,
  `content130` varchar(12) DEFAULT NULL,
  `content131` varchar(12) DEFAULT NULL,
  `content132` varchar(12) DEFAULT NULL,
  `content133` varchar(12) DEFAULT NULL,
  `content134` varchar(12) DEFAULT NULL,
  `content135` varchar(12) DEFAULT NULL,
  `content136` varchar(12) DEFAULT NULL,
  `content137` varchar(12) DEFAULT NULL,
  `content138` varchar(12) DEFAULT NULL,
  `content139` varchar(12) DEFAULT NULL,
  `content140` varchar(12) DEFAULT NULL,
  `content141` varchar(12) DEFAULT NULL,
  `content142` varchar(12) DEFAULT NULL,
  `content143` varchar(12) DEFAULT NULL,
  `content144` varchar(12) DEFAULT NULL,
  `content145` varchar(12) DEFAULT NULL,
  `content146` varchar(12) DEFAULT NULL,
  `content147` varchar(12) DEFAULT NULL,
  `content148` varchar(12) DEFAULT NULL,
  `content149` varchar(12) DEFAULT NULL,
  `content150` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wage_attr`
--

CREATE TABLE `wage_attr` (
  `attr_name1` varchar(50) DEFAULT NULL,
  `attr_name2` varchar(50) DEFAULT NULL,
  `attr_name3` varchar(50) DEFAULT NULL,
  `attr_name4` varchar(50) DEFAULT NULL,
  `attr_name5` varchar(50) DEFAULT NULL,
  `attr_name6` varchar(50) DEFAULT NULL,
  `attr_name7` varchar(50) DEFAULT NULL,
  `attr_name8` varchar(50) DEFAULT NULL,
  `attr_name9` varchar(50) DEFAULT NULL,
  `attr_name10` varchar(50) DEFAULT NULL,
  `attr_name11` varchar(50) DEFAULT NULL,
  `attr_name12` varchar(50) DEFAULT NULL,
  `attr_name13` varchar(50) DEFAULT NULL,
  `attr_name14` varchar(50) DEFAULT NULL,
  `attr_name15` varchar(50) DEFAULT NULL,
  `attr_name16` varchar(50) DEFAULT NULL,
  `attr_name17` varchar(50) DEFAULT NULL,
  `attr_name18` varchar(50) DEFAULT NULL,
  `attr_name19` varchar(50) DEFAULT NULL,
  `attr_name20` varchar(50) DEFAULT NULL,
  `attr_name21` varchar(50) DEFAULT NULL,
  `attr_name22` varchar(50) DEFAULT NULL,
  `attr_name23` varchar(50) DEFAULT NULL,
  `attr_name24` varchar(50) DEFAULT NULL,
  `attr_name25` varchar(50) DEFAULT NULL,
  `attr_name26` varchar(50) DEFAULT NULL,
  `attr_name27` varchar(50) DEFAULT NULL,
  `attr_name28` varchar(50) DEFAULT NULL,
  `attr_name29` varchar(50) DEFAULT NULL,
  `attr_name30` varchar(50) DEFAULT NULL,
  `attr_name31` varchar(50) DEFAULT NULL,
  `attr_name32` varchar(50) DEFAULT NULL,
  `attr_name33` varchar(50) DEFAULT NULL,
  `attr_name34` varchar(50) DEFAULT NULL,
  `attr_name35` varchar(50) DEFAULT NULL,
  `attr_name36` varchar(50) DEFAULT NULL,
  `attr_name37` varchar(50) DEFAULT NULL,
  `attr_name38` varchar(50) DEFAULT NULL,
  `attr_name39` varchar(50) DEFAULT NULL,
  `attr_name40` varchar(50) DEFAULT NULL,
  `attr_name41` varchar(50) DEFAULT NULL,
  `attr_name42` varchar(50) DEFAULT NULL,
  `attr_name43` varchar(50) DEFAULT NULL,
  `attr_name44` varchar(50) DEFAULT NULL,
  `attr_name45` varchar(50) DEFAULT NULL,
  `attr_name46` varchar(50) DEFAULT NULL,
  `attr_name47` varchar(50) DEFAULT NULL,
  `attr_name48` varchar(50) DEFAULT NULL,
  `attr_name49` varchar(50) DEFAULT NULL,
  `attr_name50` varchar(50) DEFAULT NULL,
  `attr_name51` varchar(50) DEFAULT NULL,
  `attr_name52` varchar(50) DEFAULT NULL,
  `attr_name53` varchar(50) DEFAULT NULL,
  `attr_name54` varchar(50) DEFAULT NULL,
  `attr_name55` varchar(50) DEFAULT NULL,
  `attr_name56` varchar(50) DEFAULT NULL,
  `attr_name57` varchar(50) DEFAULT NULL,
  `attr_name58` varchar(50) DEFAULT NULL,
  `attr_name59` varchar(50) DEFAULT NULL,
  `attr_name60` varchar(50) DEFAULT NULL,
  `attr_name61` varchar(50) DEFAULT NULL,
  `attr_name62` varchar(50) DEFAULT NULL,
  `attr_name63` varchar(50) DEFAULT NULL,
  `attr_name64` varchar(50) DEFAULT NULL,
  `attr_name65` varchar(50) DEFAULT NULL,
  `attr_name66` varchar(50) DEFAULT NULL,
  `attr_name67` varchar(50) DEFAULT NULL,
  `attr_name68` varchar(50) DEFAULT NULL,
  `attr_name69` varchar(50) DEFAULT NULL,
  `attr_name70` varchar(50) DEFAULT NULL,
  `attr_name71` varchar(50) DEFAULT NULL,
  `attr_name72` varchar(50) DEFAULT NULL,
  `attr_name73` varchar(50) DEFAULT NULL,
  `attr_name74` varchar(50) DEFAULT NULL,
  `attr_name75` varchar(50) DEFAULT NULL,
  `attr_name76` varchar(50) DEFAULT NULL,
  `attr_name77` varchar(50) DEFAULT NULL,
  `attr_name78` varchar(50) DEFAULT NULL,
  `attr_name79` varchar(50) DEFAULT NULL,
  `attr_name80` varchar(50) DEFAULT NULL,
  `attr_name81` varchar(50) DEFAULT NULL,
  `attr_name82` varchar(50) DEFAULT NULL,
  `attr_name83` varchar(50) DEFAULT NULL,
  `attr_name84` varchar(50) DEFAULT NULL,
  `attr_name85` varchar(50) DEFAULT NULL,
  `attr_name86` varchar(50) DEFAULT NULL,
  `attr_name87` varchar(50) DEFAULT NULL,
  `attr_name88` varchar(50) DEFAULT NULL,
  `attr_name89` varchar(50) DEFAULT NULL,
  `attr_name90` varchar(50) DEFAULT NULL,
  `attr_name91` varchar(50) DEFAULT NULL,
  `attr_name92` varchar(50) DEFAULT NULL,
  `attr_name93` varchar(50) DEFAULT NULL,
  `attr_name94` varchar(50) DEFAULT NULL,
  `attr_name95` varchar(50) DEFAULT NULL,
  `attr_name96` varchar(50) DEFAULT NULL,
  `attr_name97` varchar(50) DEFAULT NULL,
  `attr_name98` varchar(50) DEFAULT NULL,
  `attr_name99` varchar(50) DEFAULT NULL,
  `attr_name100` varchar(50) DEFAULT NULL,
  `attr_name101` varchar(50) DEFAULT NULL,
  `attr_name102` varchar(50) DEFAULT NULL,
  `attr_name103` varchar(50) DEFAULT NULL,
  `attr_name104` varchar(50) DEFAULT NULL,
  `attr_name105` varchar(50) DEFAULT NULL,
  `attr_name106` varchar(50) DEFAULT NULL,
  `attr_name107` varchar(50) DEFAULT NULL,
  `attr_name108` varchar(50) DEFAULT NULL,
  `attr_name109` varchar(50) DEFAULT NULL,
  `attr_name110` varchar(50) DEFAULT NULL,
  `attr_name111` varchar(50) DEFAULT NULL,
  `attr_name112` varchar(50) DEFAULT NULL,
  `attr_name113` varchar(50) DEFAULT NULL,
  `attr_name114` varchar(50) DEFAULT NULL,
  `attr_name115` varchar(50) DEFAULT NULL,
  `attr_name116` varchar(50) DEFAULT NULL,
  `attr_name117` varchar(50) DEFAULT NULL,
  `attr_name118` varchar(50) DEFAULT NULL,
  `attr_name119` varchar(50) DEFAULT NULL,
  `attr_name120` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `wage_attr`
--

INSERT INTO `wage_attr` (`attr_name1`, `attr_name2`, `attr_name3`, `attr_name4`, `attr_name5`, `attr_name6`, `attr_name7`, `attr_name8`, `attr_name9`, `attr_name10`, `attr_name11`, `attr_name12`, `attr_name13`, `attr_name14`, `attr_name15`, `attr_name16`, `attr_name17`, `attr_name18`, `attr_name19`, `attr_name20`, `attr_name21`, `attr_name22`, `attr_name23`, `attr_name24`, `attr_name25`, `attr_name26`, `attr_name27`, `attr_name28`, `attr_name29`, `attr_name30`, `attr_name31`, `attr_name32`, `attr_name33`, `attr_name34`, `attr_name35`, `attr_name36`, `attr_name37`, `attr_name38`, `attr_name39`, `attr_name40`, `attr_name41`, `attr_name42`, `attr_name43`, `attr_name44`, `attr_name45`, `attr_name46`, `attr_name47`, `attr_name48`, `attr_name49`, `attr_name50`, `attr_name51`, `attr_name52`, `attr_name53`, `attr_name54`, `attr_name55`, `attr_name56`, `attr_name57`, `attr_name58`, `attr_name59`, `attr_name60`, `attr_name61`, `attr_name62`, `attr_name63`, `attr_name64`, `attr_name65`, `attr_name66`, `attr_name67`, `attr_name68`, `attr_name69`, `attr_name70`, `attr_name71`, `attr_name72`, `attr_name73`, `attr_name74`, `attr_name75`, `attr_name76`, `attr_name77`, `attr_name78`, `attr_name79`, `attr_name80`, `attr_name81`, `attr_name82`, `attr_name83`, `attr_name84`, `attr_name85`, `attr_name86`, `attr_name87`, `attr_name88`, `attr_name89`, `attr_name90`, `attr_name91`, `attr_name92`, `attr_name93`, `attr_name94`, `attr_name95`, `attr_name96`, `attr_name97`, `attr_name98`, `attr_name99`, `attr_name100`, `attr_name101`, `attr_name102`, `attr_name103`, `attr_name104`, `attr_name105`, `attr_name106`, `attr_name107`, `attr_name108`, `attr_name109`, `attr_name110`, `attr_name111`, `attr_name112`, `attr_name113`, `attr_name114`, `attr_name115`, `attr_name116`, `attr_name117`, `attr_name118`, `attr_name119`, `attr_name120`) VALUES
('序号', '区分公司/部门', '身份证', '姓名', '参考绩效奖金结算率', '工资小计', '岗位工资', '综合补贴', '骨干/后备人才津贴', '信访津贴/压力津贴', '生活补贴\n(内退退休)', '午餐补贴/油费补贴', '住房消费/大学生租房津贴', '加班工资\n(含夜班补贴、岗位工资考勤清算）', '过节费', '补发工资或奖金', '考勤扣款', '专业津贴', '岗位津贴（地方）/10%底薪', '年终双薪', '新春慰问金', '儿童节费', '月度绩效工资小计', '职级补贴/业务津贴', '上月绩效工资结算（含考勤结算）', '提成', '月度绩效工资标准', '省核专项奖励小计', '品牌运营创新工作坊奖励', '分公司专项奖励小计', '020奖励', '百日奋战奖励', '完美项目奖励', '复用人员上门交付奖励', '岗位空缺奖励', '红九月迎新奖励', '红九月专项奖励', '提成奖励', '沃之声广播站补贴', '省公司通报实名违规扣罚', '担保违约扣罚', '其他小计', '教育经费小计', '内部培训师津贴', '福利费小计', '独生子女费', '子女托儿补助费', '女工保健', '降温费', '当月月应收合计', '基本养老保险个人缴费', '医疗保险个人缴费', '失业保险个人缴费', '住房公积个人缴费', '年金个人缴费', '补缴年金个人缴费', '个人所得税', '工会费', '过节费前期单独预发', '其他代缴补扣\n(补缴保险、公积金等)', '扣款小计', '职级薪档', '实发', '本月工资差异说明', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `wage_doc`
--

CREATE TABLE `wage_doc` (
  `number` datetime NOT NULL,
  `doc_name` varchar(300) DEFAULT NULL,
  `doc_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `wage_doc`
--

INSERT INTO `wage_doc` (`number`, `doc_name`, `doc_path`) VALUES
('2018-12-20 09:47:11', '关于印发《公众营服公司家庭互联网团队薪酬正文》', 'uploads/关于印发《公众营服公司家庭互联网团队薪酬正文》.pdf'),
('2018-12-20 09:47:19', '关于印发《公众营服公司传统社会渠道团队及正文》', 'uploads/关于印发《公众营服公司传统社会渠道团队及正文》.pdf');

-- --------------------------------------------------------

--
-- 表的结构 `wage_tag`
--

CREATE TABLE `wage_tag` (
  `name` varchar(12) DEFAULT NULL,
  `user_id` varchar(18) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dept` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `indate` date DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `proof_tag` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wage_total`
--

CREATE TABLE `wage_total` (
  `total` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `wage_total`
--

INSERT INTO `wage_total` (`total`) VALUES
(64);

-- --------------------------------------------------------

--
-- 表的结构 `wage_users`
--

CREATE TABLE `wage_users` (
  `user_id` varchar(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT '初始值为身份证后六位',
  `permission` int(11) NOT NULL COMMENT '1是部门负责人，3是员工 '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`department`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `holiday_doc`
--
ALTER TABLE `holiday_doc`
  ADD PRIMARY KEY (`doc_name`);

--
-- Indexes for table `log_action`
--
ALTER TABLE `log_action`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `submit`
--
ALTER TABLE `submit`
  ADD PRIMARY KEY (`department`);

--
-- Indexes for table `super_user`
--
ALTER TABLE `super_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wage_doc`
--
ALTER TABLE `wage_doc`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `wage_tag`
--
ALTER TABLE `wage_tag`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `log_action`
--
ALTER TABLE `log_action`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
