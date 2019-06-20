CREATE TABLE `plan_seven` (
  `user_id` varchar(18) NOT NULL COMMENT '身份证号',
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `department` varchar(255) NOT NULL COMMENT '员工所在的部门',
  `Thisyear` int(11) NOT NULL DEFAULT '0' COMMENT '今年的年假数目',
  `Lastyear` int(11) NOT NULL DEFAULT '0' COMMENT '上一年的年假数目',
  `Bonus` int(11) NOT NULL DEFAULT '0' COMMENT '荣誉休假数目',
  `Totalday` int(11) NOT NULL DEFAULT '0' COMMENT '总的休假数目',
  `Jun` int(11) NOT NULL DEFAULT '0' COMMENT '六月休假已天数',
  `Jul` int(11) NOT NULL DEFAULT '0' COMMENT '七月休假已天数',
  `Aug` int(11) NOT NULL DEFAULT '0' COMMENT '八月休假已天数',
  `Sep` int(11) NOT NULL DEFAULT '0' COMMENT '九月休假已天数',
  `Oct` int(11) NOT NULL DEFAULT '0' COMMENT '十月休假已天数',
  `Nov` int(11) NOT NULL DEFAULT '0' COMMENT '十一月休假已天数',
  `Dece` int(11) NOT NULL DEFAULT '0' COMMENT '十二月休假已天数',
  `submit_tag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '标记该用户是否提交过计划，重新提交需要综管员重新给权限，true是已提交，false是未提交'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;