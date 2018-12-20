CREATE TABLE `log_action` (
  `log_id` int(11) NOT NULL auto_increment,
  `user_id` varchar(20) NOT NULL,
  `username` varchar(10) NOT NULL,
  `login_ip` varchar(50) NOT NULL,
  `staff_action` varchar(50) NOT NULL,
  `action_time` DATE NOT NULL,
  PRIMARY KEY  (`log_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;