-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:3306
-- 生成日期： 2019-02-25 15:12:17
-- 服务器版本： 5.7.23
-- PHP 版本： 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `human_resources`
--


CREATE TABLE `hr_content` (
  `id` int(10) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `gender` varchar(5) DEFAULT NULL,
  `native` varchar(20) DEFAULT NULL,
  `minzu` varchar(10) DEFAULT NULL,
  `birth` varchar(20) DEFAULT NULL,
  `marry` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `dept` varchar(50) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `post_inner` varchar(20) DEFAULT NULL,
  `post_outer` varchar(20) DEFAULT NULL,
  `post_major` varchar(20) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  `party_post` varchar(50) DEFAULT NULL,
  `position_series` varchar(20) DEFAULT NULL,
  `position_name` varchar(20) DEFAULT NULL,
  `salary_level` varchar(10) DEFAULT NULL,
  `position_adjust_time` varchar(20) DEFAULT NULL,
  `salary_adjust_time` varchar(20) DEFAULT NULL,
  `indate` varchar(20) DEFAULT NULL,
  `companydate` varchar(20) DEFAULT NULL,
  `totalage` varchar(10) DEFAULT NULL,
  `companyage` varchar(10) DEFAULT NULL,
  `probation_end` varchar(20) DEFAULT NULL,
  `service_mode` varchar(10) DEFAULT NULL,
  `sign_company` varchar(30) DEFAULT NULL,
  `sign_start` varchar(20) DEFAULT NULL,
  `sign_end` varchar(20) DEFAULT NULL,
  `political_orientation` varchar(10) DEFAULT NULL,
  `in_party_date` varchar(20) DEFAULT NULL,
  `pro_name` varchar(20) DEFAULT NULL,
  `pro_level` varchar(20) DEFAULT NULL,
  `qualification_name` varchar(30) DEFAULT NULL,
  `qualification_level` varchar(30) DEFAULT NULL,
  `company_level` varchar(10) DEFAULT NULL,
  `employment_term` varchar(30) DEFAULT NULL,
  `highest_qualification` varchar(10) DEFAULT NULL,
  `highest_degree` varchar(10) DEFAULT NULL,
  `education_qualification` varchar(10) DEFAULT NULL,
  `education_school` varchar(50) DEFAULT NULL,
  `education_major` varchar(30) DEFAULT NULL,
  `education_date` varchar(20) DEFAULT NULL,
  `education_degree` varchar(10) DEFAULT NULL,
  `education_post_qualification` varchar(10) DEFAULT NULL,
  `education_post_school` varchar(50) DEFAULT NULL,
  `education_post_major` varchar(30) DEFAULT NULL,
  `education_post_date` varchar(20) DEFAULT NULL,
  `education_post_degree` varchar(10) DEFAULT NULL,
  `elite` varchar(30) DEFAULT NULL,
  `company_elite` varchar(30) DEFAULT NULL,
  `professor` varchar(20) DEFAULT NULL,
  `access2006` varchar(10) DEFAULT NULL,
  `access2007` varchar(10) DEFAULT NULL,
  `access2008` varchar(10) DEFAULT NULL,
  `access2009` varchar(10) DEFAULT NULL,
  `access2010` varchar(10) DEFAULT NULL,
  `access2011` varchar(10) DEFAULT NULL,
  `access2012` varchar(10) DEFAULT NULL,
  `access2013` varchar(10) DEFAULT NULL,
  `access2014` varchar(10) DEFAULT NULL,
  `access2015` varchar(10) DEFAULT NULL,
  `access2016` varchar(10) DEFAULT NULL,
  `access2017` varchar(10) DEFAULT NULL,
  `access2018` varchar(10) DEFAULT NULL,
  `access2019` varchar(10) DEFAULT NULL,
  `access2020` varchar(10) DEFAULT NULL,
  `access2021` varchar(10) DEFAULT NULL,
  `access2022` varchar(10) DEFAULT NULL,
  `access2023` varchar(10) DEFAULT NULL,
  `access2024` varchar(10) DEFAULT NULL,
  `access2025` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- 表的结构 `all_user`
--

CREATE TABLE `all_user` (
  `id` int(11) NOT NULL,
  `id_num` int(11) NOT NULL,
  `pwd` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `mobile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `department`
--

CREATE TABLE `department` (
  `dept_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `feedback`
--

CREATE TABLE `feedback` (
  `department` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `feedback_status` varchar(255) NOT NULL DEFAULT '未审核',
  `submit_status` varchar(255) NOT NULL DEFAULT '未提交',
  `confirm_status` varchar(255) NOT NULL DEFAULT '不同意'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `func`
--

CREATE TABLE `func` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '已关闭',
  `func_type` varchar(10) NOT NULL
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
  `number` datetime DEFAULT NULL,
  `doc_name` varchar(50) NOT NULL,
  `doc_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

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
-- 表的结构 `manager`
--

CREATE TABLE `manager` (
  `user_id` varchar(18) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dept` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

CREATE TABLE `notice` (
  `pubtime` datetime NOT NULL COMMENT '公告发布时间',
  `username` varchar(255) NOT NULL COMMENT '发布公告人姓名',
  `title` varchar(255) NOT NULL COMMENT '公告标题',
  `content` varchar(3000) NOT NULL COMMENT '公告内容',
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
-- 表的结构 `proof_record`
--

CREATE TABLE `proof_record` (
  `id` int(11) NOT NULL,
  `applicant` varchar(100) NOT NULL,
  `apply_type` varchar(100) NOT NULL,
  `submit_status` varchar(100) NOT NULL,
  `feedback_status` varchar(100) NOT NULL
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

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `user_id` varchar(20) NOT NULL COMMENT '身份证号',
  `username` varchar(6) NOT NULL COMMENT '姓名',
  `password` varchar(255) NOT NULL COMMENT '初始值为身份证后六位',
  `permission` int(11) NOT NULL COMMENT '1是综管，2是部门负责人，3是员工'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `content150` varchar(12) DEFAULT NULL,
  `date_tag` varchar(20) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wage_apply`
--

CREATE TABLE `wage_apply` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `submit_time` datetime NOT NULL,
  `feedback_time` datetime NOT NULL,
  `submit_status` varchar(50) NOT NULL DEFAULT '未提交',
  `feedback_status` varchar(50) DEFAULT '未审核'
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
  `attr_name120` varchar(50) DEFAULT NULL,
  `date_tag` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wage_doc`
--

CREATE TABLE `wage_doc` (
  `number` datetime NOT NULL,
  `doc_name` varchar(300) DEFAULT NULL,
  `doc_path` varchar(100) DEFAULT NULL,
  `doc_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wage_notice`
--

CREATE TABLE `wage_notice` (
  `date_tag` varchar(20) NOT NULL,
  `content` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wage_sp`
--

CREATE TABLE `wage_sp` (
  `user_id` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `attr1` float NOT NULL DEFAULT '0',
  `attr2` float NOT NULL DEFAULT '0',
  `attr3` float NOT NULL DEFAULT '0',
  `attr4` float NOT NULL DEFAULT '0',
  `attr5` float NOT NULL DEFAULT '0',
  `date_tag` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wage_sp_attr`
--

CREATE TABLE `wage_sp_attr` (
  `attr1` varchar(50) DEFAULT NULL,
  `attr2` varchar(50) DEFAULT NULL,
  `attr3` varchar(50) DEFAULT NULL,
  `attr4` varchar(50) DEFAULT NULL,
  `attr5` varchar(50) DEFAULT NULL,
  `attr6` varchar(50) DEFAULT NULL,
  `attr7` varchar(50) DEFAULT NULL,
  `attr8` varchar(50) DEFAULT NULL,
  `attr9` varchar(50) DEFAULT NULL,
  `attr10` varchar(50) DEFAULT NULL,
  `attr11` varchar(50) DEFAULT NULL,
  `attr12` varchar(50) DEFAULT NULL,
  `attr13` varchar(50) DEFAULT NULL,
  `attr14` varchar(50) DEFAULT NULL,
  `attr15` varchar(50) DEFAULT NULL,
  `attr16` varchar(50) DEFAULT NULL,
  `attr17` varchar(50) DEFAULT NULL,
  `attr18` varchar(50) DEFAULT NULL,
  `attr19` varchar(50) DEFAULT NULL,
  `attr20` varchar(50) DEFAULT NULL,
  `attr21` varchar(50) NOT NULL,
  `attr22` varchar(50) NOT NULL,
  `date_tag` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wage_tag`
--

CREATE TABLE `wage_tag` (
  `name` varchar(12) DEFAULT NULL,
  `user_id` varchar(18) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dept` varchar(50) DEFAULT NULL,
  `office` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `marry` varchar(50) DEFAULT NULL,
  `child` varchar(50) DEFAULT NULL,
  `highest_qualification` varchar(50) DEFAULT NULL,
  `highest_degree` varchar(50) DEFAULT NULL,
  `ft_highest_qualification` varchar(50) DEFAULT NULL,
  `ft_highest_degree` varchar(50) DEFAULT NULL,
  `service_mode` varchar(50) DEFAULT NULL,
  `indate` date DEFAULT NULL,
  `proof_tag` varchar(50) DEFAULT NULL,
  `qian3` varchar(10) NOT NULL,
  `qian2` varchar(10) NOT NULL,
  `qian1` varchar(10) NOT NULL,
  `wage_level` varchar(10) NOT NULL,
  `wage_adjust_stamp` date NOT NULL,
  `level_adjust_stamp` date NOT NULL,
  `accumulation` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `all_user`
--
ALTER TABLE `all_user`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`department`);

--
-- 表的索引 `func`
--
ALTER TABLE `func`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`user_id`);

--
-- 表的索引 `holiday_doc`
--
ALTER TABLE `holiday_doc`
  ADD PRIMARY KEY (`doc_name`);

--
-- 表的索引 `log_action`
--
ALTER TABLE `log_action`
  ADD PRIMARY KEY (`log_id`);

--
-- 表的索引 `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`user_id`,`dept`);

--
-- 表的索引 `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`user_id`);

--
-- 表的索引 `super_user`
--
ALTER TABLE `super_user`
  ADD PRIMARY KEY (`user_id`);

--
-- 表的索引 `wage_apply`
--
ALTER TABLE `wage_apply`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wage_attr`
--
ALTER TABLE `wage_attr`
  ADD PRIMARY KEY (`date_tag`);

--
-- 表的索引 `wage_doc`
--
ALTER TABLE `wage_doc`
  ADD PRIMARY KEY (`number`);

--
-- 表的索引 `wage_sp`
--
ALTER TABLE `wage_sp`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `all_user`
--
ALTER TABLE `all_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `log_action`
--
ALTER TABLE `log_action`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `wage_apply`
--
ALTER TABLE `wage_apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
