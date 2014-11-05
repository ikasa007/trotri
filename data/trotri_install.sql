USE `trotri`;

DROP TABLE IF EXISTS `tr_builder_types`;
CREATE TABLE `tr_builder_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等',
  `form_type` varchar(100) NOT NULL DEFAULT '' COMMENT '表单类型名，HTML：text、password、button、radio等；用户自定义：ckeditor、datetime等',
  `field_type` varchar(100) NOT NULL DEFAULT '' COMMENT '表字段类型，INT、VARCHAR、CHAR、TEXT等',
  `category` enum('text','option','button') NOT NULL DEFAULT 'text' COMMENT '所属分类，text：文本类、option：选项类、button：按钮类',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`type_id`),
  KEY `type_name` (`type_name`),
  KEY `form_type` (`form_type`),
  KEY `field_type` (`field_type`),
  KEY `category` (`category`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段类型表';

INSERT INTO `tr_builder_types` VALUES (1, '单行文本(VARCHAR)', 'text', 'VARCHAR', 'text', 1);
INSERT INTO `tr_builder_types` VALUES (2, '单行文本(INT)', 'text', 'INT', 'text', 2);
INSERT INTO `tr_builder_types` VALUES (3, '密码', 'password', 'CHAR', 'text', 3);
INSERT INTO `tr_builder_types` VALUES (4, '开关选项卡', 'switch', 'ENUM', 'option', 4);
INSERT INTO `tr_builder_types` VALUES (5, '单选', 'radio', 'ENUM', 'option', 5);
INSERT INTO `tr_builder_types` VALUES (6, '多选', 'checkbox', 'VARCHAR', 'option', 6);
INSERT INTO `tr_builder_types` VALUES (7, '单选下拉框', 'select', 'INT', 'option', 7);
INSERT INTO `tr_builder_types` VALUES (8, '隐藏文本框(VARCHAR)', 'hidden', 'VARCHAR', 'text', 8);
INSERT INTO `tr_builder_types` VALUES (9, '隐藏文本框(INT)', 'hidden', 'INT', 'text', 9);
INSERT INTO `tr_builder_types` VALUES (10, '多行文本', 'textarea', 'TEXT', 'text', 10);
INSERT INTO `tr_builder_types` VALUES (11, '上传文件', 'file', 'VARCHAR', 'text', 11);

DROP TABLE IF EXISTS `tr_builders`;
CREATE TABLE `tr_builders` (
  `builder_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `builder_name` varchar(100) NOT NULL DEFAULT '' COMMENT '生成代码名',
  `tbl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '表名',
  `tbl_profile` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否生成扩展表',
  `tbl_engine` enum('MyISAM','InnoDB') NOT NULL DEFAULT 'InnoDB' COMMENT '表引擎',
  `tbl_charset` enum('utf8','gbk','gb2312') NOT NULL DEFAULT 'utf8' COMMENT '表编码',
  `tbl_comment` varchar(200) NOT NULL DEFAULT '' COMMENT '表描述',
  `srv_type` enum('dynamic','normal') NOT NULL DEFAULT 'normal' COMMENT '代码类型，自动构建代码和SQL：dynamic、普通：normal',
  `srv_name` varchar(100) NOT NULL DEFAULT '' COMMENT '业务名',
  `app_name` varchar(100) NOT NULL DEFAULT '' COMMENT '应用名',
  `mod_name` varchar(100) NOT NULL DEFAULT '' COMMENT '模块名',
  `cls_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类名',
  `ctrl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '控制器名',
  `fk_column` varchar(100) NOT NULL DEFAULT '' COMMENT '外联其他表的字段名',
  `act_index_name` varchar(100) NOT NULL DEFAULT 'index' COMMENT '行动名-数据列表',
  `act_view_name` varchar(100) NOT NULL DEFAULT 'view' COMMENT '行动名-数据详情',
  `act_create_name` varchar(100) NOT NULL DEFAULT 'create' COMMENT '行动名-新增数据',
  `act_modify_name` varchar(100) NOT NULL DEFAULT 'modify' COMMENT '行动名-编辑数据',
  `act_remove_name` varchar(100) NOT NULL DEFAULT 'remove' COMMENT '行动名-删除数据',
  `index_row_btns` varchar(100) NOT NULL DEFAULT 'pencil|trash' COMMENT '数据列表每行操作Btn，编辑：pencil、移至回收站：trash、彻底删除：remove',
  `description` text COMMENT '描述',
  `author_name` varchar(100) NOT NULL DEFAULT '' COMMENT '作者姓名，代码注释用',
  `author_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '作者邮箱，代码注释用',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`builder_id`),
  KEY `builder_name` (`builder_name`),
  KEY `tbl_name` (`tbl_name`),
  KEY `tbl_profile` (`tbl_profile`),
  KEY `tbl_engine` (`tbl_engine`),
  KEY `tbl_charset` (`tbl_charset`),
  KEY `srv_type` (`srv_type`),
  KEY `srv_name` (`srv_name`),
  KEY `app_mod_ctrl` (`app_name`,`mod_name`,`ctrl_name`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='生成代码表';

DROP TABLE IF EXISTS `tr_builder_field_groups`;
CREATE TABLE `tr_builder_field_groups` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `prompt` varchar(100) NOT NULL DEFAULT '' COMMENT '提示',
  `builder_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '生成代码ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `description` text COMMENT '描述',
  PRIMARY KEY (`group_id`),
  KEY `group_name` (`group_name`),
  KEY `builder_id` (`builder_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段组表';

INSERT INTO `tr_builder_field_groups` VALUES (1, 'main', '主要信息', 0, 1, '默认');

DROP TABLE IF EXISTS `tr_builder_fields`;
CREATE TABLE `tr_builder_fields` (
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `field_name` varchar(100) NOT NULL DEFAULT '' COMMENT '字段名',
  `column_length` varchar(200) NOT NULL DEFAULT '0' COMMENT 'DB字段长度或用|分隔开的Enum值',
  `column_auto_increment` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否自动递增',
  `column_unsigned` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否无符号',
  `column_comment` varchar(200) NOT NULL DEFAULT '' COMMENT 'DB字段描述',
  `builder_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '生成代码ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '表单字段组ID',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '字段类型ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `html_label` varchar(100) NOT NULL DEFAULT '' COMMENT 'HTML：Table和Form显示名',
  `form_prompt` varchar(200) NOT NULL DEFAULT '' COMMENT '表单提示',
  `form_required` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '表单是否必填',
  `form_modifiable` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '编辑表单中允许输入',
  `index_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否在列表中展示',
  `index_sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在列表中排序',
  `form_create_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否在新增表单中展示',
  `form_create_sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在新增表单中排序',
  `form_modify_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否在编辑表单中展示',
  `form_modify_sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在编辑表单中排序',
  `form_search_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否在查询表单中展示',
  `form_search_sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在查询表单中排序',
  PRIMARY KEY (`field_id`),
  KEY `field_name` (`field_name`),
  KEY `builder_id` (`builder_id`),
  KEY `group_id` (`group_id`),
  KEY `type_id` (`type_id`),
  KEY `sort` (`sort`),
  KEY `index_sort` (`index_sort`),
  KEY `form_create_sort` (`form_create_sort`),
  KEY `form_modify_sort` (`form_modify_sort`),
  KEY `form_search_sort` (`form_search_sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段表';

DROP TABLE IF EXISTS `tr_builder_field_validators`;
CREATE TABLE `tr_builder_field_validators` (
  `validator_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `validator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '验证类名',
  `field_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '表单字段ID',
  `options` varchar(100) NOT NULL DEFAULT '' COMMENT '验证时对比值，可以是布尔类型、整型、字符型、数组序列化',
  `option_category` enum('boolean','integer','string','array') NOT NULL DEFAULT 'boolean' COMMENT '验证时对比值类型',
  `message` varchar(100) NOT NULL DEFAULT '' COMMENT '出错提示消息',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `when` enum('all','create','modify') NOT NULL DEFAULT 'all' COMMENT '验证环境，任意时候验证、只在新增数据时验证、只在编辑数据时验证',
  PRIMARY KEY (`validator_id`),
  KEY `validator_name` (`validator_name`),
  KEY `field_id` (`field_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段验证表';

DROP TABLE IF EXISTS `tr_system_logwf_ym`;
CREATE TABLE `tr_system_logwf_ym` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_WARNING' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按月存Warning、Err等日志';

DROP TABLE IF EXISTS `tr_system_log_ymd`;
CREATE TABLE `tr_system_log_ymd` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_NOTICE' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按天存Notice、Info等日志';

DROP TABLE IF EXISTS `tr_system_options`;
CREATE TABLE `tr_system_options` (
  `option_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `option_key` varchar(64) NOT NULL DEFAULT '' COMMENT '配置Key',
  `option_value` longtext COMMENT '配置Value',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `uk_option_key` (`option_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点配置表';

INSERT INTO `tr_system_options` VALUES ('1', 'site_name', '我的网站');
INSERT INTO `tr_system_options` VALUES ('2', 'site_url', 'http://www.trotri.com');
INSERT INTO `tr_system_options` VALUES ('3', 'meta_title', '我的网站');
INSERT INTO `tr_system_options` VALUES ('4', 'meta_keywords', '我的网站,trotri,tfc,cms');
INSERT INTO `tr_system_options` VALUES ('5', 'meta_description', 'Trotri-PHP开发框架');
INSERT INTO `tr_system_options` VALUES ('6', 'powerby', 'Powered by Trotri! 1.0');
INSERT INTO `tr_system_options` VALUES ('7', 'stat_code', '');
INSERT INTO `tr_system_options` VALUES ('8', 'url_rewrite', 'n');
INSERT INTO `tr_system_options` VALUES ('9', 'close_register', 'n');
INSERT INTO `tr_system_options` VALUES ('10', 'close_register_reason', '冗余字段，暂时用不到。');
INSERT INTO `tr_system_options` VALUES ('11', 'show_register_service_item', 'y');
INSERT INTO `tr_system_options` VALUES ('12', 'register_service_item', '冗余字段，暂时用不到。');
INSERT INTO `tr_system_options` VALUES ('13', 'thumb_width', '1');
INSERT INTO `tr_system_options` VALUES ('14', 'thumb_height', '1');
INSERT INTO `tr_system_options` VALUES ('15', 'water_mark_type', 'none');
INSERT INTO `tr_system_options` VALUES ('16', 'water_mark_imgdir', '冗余字段，暂时用不到。');
INSERT INTO `tr_system_options` VALUES ('17', 'water_mark_text', '冗余字段，暂时用不到。');
INSERT INTO `tr_system_options` VALUES ('18', 'water_mark_position', '9');
INSERT INTO `tr_system_options` VALUES ('19', 'water_mark_pct', '0');
INSERT INTO `tr_system_options` VALUES ('20', 'smtp_host', '');
INSERT INTO `tr_system_options` VALUES ('21', 'smtp_port', '25');
INSERT INTO `tr_system_options` VALUES ('22', 'smtp_username', '');
INSERT INTO `tr_system_options` VALUES ('23', 'smtp_password', '');
INSERT INTO `tr_system_options` VALUES ('24', 'smtp_frommail', '');
INSERT INTO `tr_system_options` VALUES ('25', 'list_rows_posts', '10');
INSERT INTO `tr_system_options` VALUES ('26', 'list_rows_post_comments', '5');
INSERT INTO `tr_system_options` VALUES ('27', 'list_rows_users', '10');

DROP TABLE IF EXISTS `tr_menu_types`;
CREATE TABLE `tr_menu_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类型名',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '类型Key',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `uk_type_key` (`type_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单类型表';

INSERT INTO `tr_menu_types` VALUES ('1', '主导航', 'mainnav', '');

DROP TABLE IF EXISTS `tr_menus`;
CREATE TABLE `tr_menus` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `menu_pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父菜单ID',
  `menu_name` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单名',
  `menu_url` varchar(1024) NOT NULL DEFAULT '' COMMENT '菜单链接',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '所属类型Key',
  `picture` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  `allow_unregistered` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否允许非会员访问',
  `is_hide` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `attr_target` varchar(100) NOT NULL DEFAULT '' COMMENT 'Target属性，如：_blank、_self、_parent、_top等',
  `attr_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Title属性',
  `attr_rel` varchar(100) NOT NULL DEFAULT '' COMMENT 'Rel属性，如：alternate、stylesheet、start、next、prev等',
  `attr_class` varchar(100) NOT NULL DEFAULT '' COMMENT 'CSS-class名',
  `attr_style` varchar(255) NOT NULL DEFAULT '' COMMENT 'CSS-style属性',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  PRIMARY KEY (`menu_id`),
  KEY `key_pid` (`type_key`,`menu_pid`,`sort`),
  KEY `key_pid_allow` (`type_key`,`menu_pid`,`allow_unregistered`,`sort`),
  KEY `menu_name` (`menu_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

INSERT INTO `tr_menus` VALUES ('1', '0', '首页', 'index.php', 'mainnav', '', '', '', 'y', 'n', '1', '', '', '', 'blog-nav-item', '', '2014-11-05 13:53:02', '2014-11-05 13:56:31');
INSERT INTO `tr_menus` VALUES ('2', '0', '文档', 'index.php?r=posts/show/index&catid=1', 'mainnav', '', '', '', 'y', 'n', '2', '', '', '', 'blog-nav-item', '', '2014-11-05 13:54:04', '2014-11-05 13:56:37');
INSERT INTO `tr_menus` VALUES ('3', '0', '专题', 'index.php?r=topic/show/index', 'mainnav', '', '', '', 'y', 'n', '3', '_blank', '', '', 'blog-nav-item', '', '2014-11-05 13:54:47', '2014-11-05 14:02:45');

DROP TABLE IF EXISTS `tr_user_amcas`;
CREATE TABLE `tr_user_amcas` (
  `amca_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `amca_name` varchar(100) NOT NULL DEFAULT '' COMMENT '事件名',
  `amca_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `prompt` varchar(100) NOT NULL DEFAULT '' COMMENT '提示',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `category` enum('app','mod','ctrl','act') NOT NULL DEFAULT 'act' COMMENT '类型，app：应用、mod：模块、ctrl：控制器、act：行动',
  PRIMARY KEY (`amca_id`),
  UNIQUE KEY `uk_pid_name` (`amca_pid`,`amca_name`),
  KEY `amca_name` (`amca_name`),
  KEY `sort` (`sort`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户可访问的事件表';

INSERT INTO `tr_user_amcas` VALUES ('1', 'administrator', '0', '后端管理', '0', 'app');
INSERT INTO `tr_user_amcas` VALUES ('2', 'system', '1', '站点管理', '1', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('3', 'users', '1', '用户管理', '2', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('4', 'builder', '1', '生成代码管理', '3', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('5', 'posts', '1', '文档管理', '4', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('6', 'menus', '1', '菜单管理', '5', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('7', 'topic', '1', '专题管理', '6', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('8', 'advert', '1', '广告管理', '7', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('9', 'options', '2', '站点配置', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('10', 'pictures', '2', '图片管理', '1', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('11', 'site', '2', '系统管理', '2', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('12', 'tools', '2', '工具管理', '3', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('13', 'account', '3', '用户账户管理', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('14', 'amcas', '3', '用户可访问的事件', '1', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('15', 'groups', '3', '用户组', '2', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('16', 'users', '3', '用户管理', '3', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('17', 'builders', '4', '生成代码', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('18', 'fields', '4', '表单字段', '1', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('19', 'groups', '4', '字段组', '2', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('20', 'tblnames', '4', '数据库表管理', '3', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('21', 'types', '4', '表单字段类型', '4', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('22', 'validators', '4', '表单字段验证', '5', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('23', 'categories', '5', '类别管理', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('24', 'comments', '5', '文档评论', '1', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('25', 'modules', '5', '模型管理', '2', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('26', 'posts', '5', '文档管理', '3', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('27', 'menus', '6', '菜单管理', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('28', 'types', '6', '菜单类型', '1', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('29', 'topic', '7', '专题管理', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('30', 'adverts', '8', '广告管理', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('31', 'types', '8', '广告位置', '1', 'ctrl');

DROP TABLE IF EXISTS `tr_user_groups`;
CREATE TABLE `tr_user_groups` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `group_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `permission` text COMMENT '权限设置，可访问的事件，由应用-模块-控制器-行动组合',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `uk_group_name` (`group_name`),
  KEY `group_pid` (`group_pid`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户分组表';

INSERT INTO `tr_user_groups` VALUES ('1', 'Public', '0', '0', '', '公开组，未登录用户拥有该权限');
INSERT INTO `tr_user_groups` VALUES ('2', 'Guest', '1', '1', null, '普通会员');
INSERT INTO `tr_user_groups` VALUES ('3', 'Manager', '1', '2', null, '普通管理员');
INSERT INTO `tr_user_groups` VALUES ('4', 'Registered', '1', '3', 'YToxOntzOjEzOiJhZG1pbmlzdHJhdG9yIjthOjE6e3M6NToicG9zdHMiO2E6MTp7czo1OiJwb3N0cyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O319fX0=', '记名作者');
INSERT INTO `tr_user_groups` VALUES ('5', 'Super Users', '1', '4', null, '超级会员');
INSERT INTO `tr_user_groups` VALUES ('6', 'Administrator', '3', '1', 'YToxOntzOjEzOiJhZG1pbmlzdHJhdG9yIjthOjc6e3M6Njoic3lzdGVtIjthOjQ6e3M6Nzoib3B0aW9ucyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjg6InBpY3R1cmVzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NDoic2l0ZSI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjU6InRvb2xzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fX1zOjU6InVzZXJzIjthOjQ6e3M6NzoiYWNjb3VudCI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjU6ImFtY2FzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NjoiZ3JvdXBzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NToidXNlcnMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9fXM6NzoiYnVpbGRlciI7YTo2OntzOjg6ImJ1aWxkZXJzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NjoiZmllbGRzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NjoiZ3JvdXBzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6ODoidGJsbmFtZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9czo1OiJ0eXBlcyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjEwOiJ2YWxpZGF0b3JzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fX1zOjU6InBvc3RzIjthOjQ6e3M6MTA6ImNhdGVnb3JpZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9czo4OiJjb21tZW50cyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjc6Im1vZHVsZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9czo1OiJwb3N0cyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O319czo1OiJtZW51cyI7YToyOntzOjU6Im1lbnVzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NToidHlwZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9fXM6NToidG9waWMiO2E6MTp7czo1OiJ0b3BpYyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O319czo2OiJhZHZlcnQiO2E6Mjp7czo3OiJhZHZlcnRzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NToidHlwZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9fX19', '超级管理员');
INSERT INTO `tr_user_groups` VALUES ('7', 'Author', '4', '1', null, '普通作者');
INSERT INTO `tr_user_groups` VALUES ('8', 'Editor', '7', '1', null, '高级作者');
INSERT INTO `tr_user_groups` VALUES ('9', 'Publisher', '8', '1', null, '出版者');

DROP TABLE IF EXISTS `tr_users`;
CREATE TABLE `tr_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `login_name` varchar(100) NOT NULL DEFAULT '' COMMENT '登录名：邮箱|用户名|手机号',
  `login_type` enum('mail','name','phone') NOT NULL DEFAULT 'mail' COMMENT '通过登录名自动识别登录方式，mail：邮箱、name：用户名(不能是纯数字、不能包含@符)、phone：手机号(11位数字)',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '随机附加混淆码',
  `user_name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱，可用来找回密码',
  `user_phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号，可用来找回密码',
  `dt_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '注册时间',
  `dt_last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次登录时间',
  `dt_last_repwd` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次更新密码时间',
  `ip_registered` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册IP',
  `ip_last_login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录IP',
  `ip_last_repwd` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新密码IP',
  `login_count` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '总登录次数',
  `repwd_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '总更新密码次数',
  `valid_mail` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否已验证邮箱',
  `valid_phone` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否已验证手机号',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uk_login_name` (`login_name`),
  KEY `login_type` (`login_type`),
  KEY `user_name` (`user_name`),
  KEY `user_mail` (`user_mail`),
  KEY `user_phone` (`user_phone`),
  KEY `valid_mail` (`valid_mail`),
  KEY `valid_phone` (`valid_phone`),
  KEY `forbidden` (`forbidden`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户主表';

INSERT INTO `tr_users` VALUES ('1', 'administrator', 'name', '6d3f4f0d7f7ef593061de299599dcf17', 'UUeGTJ', 'administrator', '', '', '2014-11-05 11:39:30', '2014-11-05 11:39:30', '0000-00-00 00:00:00', '0', '0', '0', '0', '0', 'n', 'n', 'n', 'n');

DROP TABLE IF EXISTS `tr_user_profile`;
CREATE TABLE `tr_user_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `profile_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `profile_key` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展Key',
  `profile_value` longtext COMMENT '扩展Value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_id_key` (`profile_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户扩展表';

DROP TABLE IF EXISTS `tr_user_usergroups_map`;
CREATE TABLE `tr_user_usergroups_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '用户组ID',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户和用户组关联表';

INSERT INTO `tr_user_usergroups_map` VALUES ('1', '6');

DROP TABLE IF EXISTS `tr_post_modules`;
CREATE TABLE `tr_post_modules` (
  `module_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模型名称',
  `fields` text COMMENT '文档扩展字段',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`module_id`),
  KEY `module_name` (`module_name`),
  KEY `forbidden` (`forbidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档模型表';

INSERT INTO `tr_post_modules` VALUES (1, '文档模型', '_source|文档来源', 'n', '');
INSERT INTO `tr_post_modules` VALUES (2, '图集模型', '_source|图片来源\n_width|图片宽\n_height|图片高', 'n', '');
INSERT INTO `tr_post_modules` VALUES (3, '文件模型', '_os|运行环境\n_type|文件类型|如：.exe、.zip、.rar等\n_size|文件大小|如：3MB、100KB等', 'n', '');

DROP TABLE IF EXISTS `tr_post_categories`;
CREATE TABLE `tr_post_categories` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `category_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父类别ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `meta_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `meta_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `meta_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `tpl_home` varchar(100) NOT NULL DEFAULT '' COMMENT '封页模板名',
  `tpl_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板名',
  `tpl_view` varchar(100) NOT NULL DEFAULT '' COMMENT '文档模板名',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '15' COMMENT '排序',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `uk_pid_name` (`category_pid`,`category_name`),
  KEY `category_pid` (`category_pid`,`sort`),
  KEY `alias` (`alias`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档类别表';

INSERT INTO `tr_post_categories` VALUES ('1', '0', '文档类别', '', '文档', 'trotri,文档', '文档', 'home', 'index', 'view', '1', '');

DROP TABLE IF EXISTS `tr_posts`;
CREATE TABLE `tr_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '文档标题',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `content` longtext COMMENT '文档内容',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '内容关键字',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '内容摘要',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类别ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名',
  `module_id` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '模型ID',
  `password` char(20) NOT NULL DEFAULT '' COMMENT '访问密码',
  `picture` varchar(255) NOT NULL DEFAULT '' COMMENT '主图地址',
  `is_head` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否头条',
  `is_recommend` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否推荐',
  `is_jump` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否跳转',
  `jump_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_published` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：草稿或待审核',
  `dt_publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始发表时间',
  `dt_publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束发表时间，0000-00-00 00:00:00：永不过期',
  `comment_status` enum('publish','draft','forbidden') NOT NULL DEFAULT 'publish' COMMENT '评论设置，publish：开放浏览、draft：审核后展示、forbidden：禁止评论',
  `allow_other_modify` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否允许其他人编辑',
  `hits` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `praise_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '赞美次数',
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评论次数',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `creator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '创建人',
  `last_modifier_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑人ID',
  `last_modifier_name` varchar(100) NOT NULL DEFAULT '' COMMENT '上次编辑人',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `ip_created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建IP',
  `ip_last_modified` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑IP',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`post_id`),
  KEY `pub_category_sort` (`trash`,`is_published`,`category_id`,`sort`),
  KEY `pub_creator_sort` (`trash`,`is_published`,`creator_id`,`sort`),
  KEY `pub_head_sort` (`trash`,`is_published`,`is_head`,`sort`),
  KEY `pub_recommend_sort` (`trash`,`is_published`,`is_recommend`,`sort`),
  KEY `pub_hits` (`trash`,`is_published`,`hits`),
  KEY `pub_praise` (`trash`,`is_published`,`praise_count`),
  KEY `pub_comment` (`trash`,`is_published`,`comment_count`),
  KEY `title` (`title`),
  KEY `alias` (`alias`),
  KEY `sort` (`sort`),
  KEY `category_id` (`category_id`),
  KEY `module_id` (`module_id`),
  KEY `is_head` (`is_head`),
  KEY `is_recommend` (`is_recommend`),
  KEY `is_published` (`is_published`),
  KEY `dt_publish_up` (`dt_publish_up`),
  KEY `dt_publish_down` (`dt_publish_down`),
  KEY `hits` (`hits`),
  KEY `praise_count` (`praise_count`),
  KEY `comment_count` (`comment_count`),
  KEY `creator_id` (`creator_id`),
  KEY `last_modifier_id` (`last_modifier_id`),
  KEY `dt_created` (`dt_created`),
  KEY `dt_last_modified` (`dt_last_modified`),
  KEY `ip_created` (`ip_created`),
  KEY `ip_last_modified` (`ip_last_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档管理表';

INSERT INTO `tr_posts` VALUES ('1', '示例一', '', '示例一-内容 ...... 示例一-内容 ...... 示例一-内容 ......', '示例一-关键字', '示例一-描述', '1', '1', '文档类别', '1', '', '/GitHub/trotri/data/u/imgs/posts_example.jpg', 'y', 'y', 'n', '', 'y', '2014-11-05 14:23:39', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'sys-example', '1', 'sys-example', '2014-11-05 14:24:32', '2014-11-05 14:36:25', '2130706433', '2130706433', 'n');
INSERT INTO `tr_posts` VALUES ('2', '示例二', '', '示例二-内容 ...... 示例二-内容 ...... 示例二-内容 ......', '示例二-关键字', '示例二-描述', '2', '1', '文档类别', '1', '', '/GitHub/trotri/data/u/imgs/posts_example.jpg', 'y', 'y', 'n', '', 'y', '2014-11-05 14:24:35', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'sys-example', '1', 'sys-example', '2014-11-05 14:24:53', '2014-11-05 14:25:46', '2130706433', '2130706433', 'n');
INSERT INTO `tr_posts` VALUES ('3', '示例三', '', '示例三-内容 ...... 示例三-内容 ...... 示例三-内容 ......', '示例三-关键字', '示例三-描述', '3', '1', '文档类别', '1', '', '/GitHub/trotri/data/u/imgs/posts_example.jpg', 'y', 'y', 'n', '', 'y', '2014-11-05 14:24:55', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'sys-example', '1', 'sys-example', '2014-11-05 14:25:09', '2014-11-05 14:25:46', '2130706433', '2130706433', 'n');
INSERT INTO `tr_posts` VALUES ('4', '示例四', '', '示例四-内容 ...... 示例四-内容 ...... 示例四-内容 ......', '示例四-关键字', '示例四-描述', '4', '1', '文档类别', '1', '', '/GitHub/trotri/data/u/imgs/posts_example.jpg', 'y', 'y', 'n', '', 'y', '2014-11-05 14:25:11', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'sys-example', '1', 'sys-example', '2014-11-05 14:25:23', '2014-11-05 14:25:47', '2130706433', '2130706433', 'n');

DROP TABLE IF EXISTS `tr_post_profile`;
CREATE TABLE `tr_post_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `profile_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `profile_key` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展Key',
  `profile_value` longtext COMMENT '扩展Value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_id_key` (`profile_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档扩展表';

DROP TABLE IF EXISTS `tr_post_comments`;
CREATE TABLE `tr_post_comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `comment_pid` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '父评论ID',
  `post_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `content` text COMMENT '评论内容',
  `author_name` varchar(100) NOT NULL DEFAULT '' COMMENT '评论作者名',
  `author_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '评论作者邮箱',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '评论作者网址',
  `is_published` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：待审核',
  `good_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '好评次数',
  `bad_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '差评次数',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `creator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '创建人登录名',
  `last_modifier_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑人ID',
  `last_modifier_name` varchar(100) NOT NULL DEFAULT '' COMMENT '上次编辑人登录名',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `ip_created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建IP',
  `ip_last_modified` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑IP',
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `creator_id` (`creator_id`),
  KEY `ip_created` (`ip_created`),
  KEY `good_count` (`good_count`),
  KEY `pub_post_dtlm` (`is_published`,`post_id`,`comment_pid`,`dt_last_modified`),
  KEY `pub_post_good` (`is_published`,`post_id`,`comment_pid`,`good_count`),
  KEY `pub_creator_dtlm` (`is_published`,`creator_id`,`comment_pid`,`dt_last_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档评论表';

DROP TABLE IF EXISTS `tr_advert_types`;
CREATE TABLE `tr_advert_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '位置名',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '位置Key',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '示例图片',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `uk_type_key` (`type_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告位置表';

INSERT INTO `tr_advert_types` VALUES ('1', '首页幻灯片广告', 'mainslide', 'navbar', '');
INSERT INTO `tr_advert_types` VALUES ('2', '公告', 'notice', 'notice', '');
INSERT INTO `tr_advert_types` VALUES ('3', '友情链接', 'friendlinks', 'block', '');

DROP TABLE IF EXISTS `tr_adverts`;
CREATE TABLE `tr_adverts` (
  `advert_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `advert_name` varchar(255) NOT NULL DEFAULT '' COMMENT '广告名',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '位置Key',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  `is_published` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：草稿',
  `dt_publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始发表时间',
  `dt_publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束发表时间，0000-00-00 00:00:00：永不过期',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `show_type` enum('code','text','image','flash') NOT NULL DEFAULT 'image' COMMENT '展现方式，code：代码、text：文字、image：图片、flash：Flash',
  `show_code` text COMMENT '展现代码',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文字内容',
  `advert_url` varchar(1024) NOT NULL DEFAULT '' COMMENT '广告链接',
  `advert_src` varchar(255) NOT NULL DEFAULT '' COMMENT '图片|Flash链接',
  `advert_src2` varchar(255) NOT NULL DEFAULT '' COMMENT '辅图链接',
  `attr_alt` varchar(255) NOT NULL DEFAULT '' COMMENT '图片替换文字',
  `attr_width` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '图片|Flash-宽度，单位：px',
  `attr_height` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '图片|Flash-高度，单位：px',
  `attr_fontsize` varchar(100) NOT NULL DEFAULT '' COMMENT '文字大小，单位：pt、px、em',
  `attr_target` varchar(100) NOT NULL DEFAULT '_blank' COMMENT 'Target属性，如：_blank、_self、_parent、_top等',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`advert_id`),
  KEY `key_sort` (`type_key`,`sort`),
  KEY `key_pub_sort` (`type_key`,`is_published`,`sort`),
  KEY `advert_name` (`advert_name`),
  KEY `advert_url` (`advert_url`),
  KEY `advert_src` (`advert_src`),
  KEY `dt_publish_up` (`dt_publish_up`),
  KEY `dt_publish_down` (`dt_publish_down`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告表';

INSERT INTO `tr_adverts` VALUES ('1', 'first', 'mainslide', '', 'y', '2014-11-05 14:05:50', '0000-00-00 00:00:00', '1', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"/GitHub/trotri/data/u/adverts/first.jpg\" alt=\"first\" /></a>', '', '#', '/GitHub/trotri/data/u/adverts/first.jpg', '', 'first', '0', '0', '', '_blank', '2014-11-05 14:07:00');
INSERT INTO `tr_adverts` VALUES ('2', 'second', 'mainslide', '', 'y', '2014-11-05 14:07:02', '0000-00-00 00:00:00', '2', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"/GitHub/trotri/data/u/adverts/second.jpg\" alt=\"second\" /></a>', '', '#', '/GitHub/trotri/data/u/adverts/second.jpg', '', 'second', '0', '0', '', '_blank', '2014-11-05 14:07:30');
INSERT INTO `tr_adverts` VALUES ('3', 'third', 'mainslide', '', 'y', '2014-11-05 14:07:31', '0000-00-00 00:00:00', '3', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"/GitHub/trotri/data/u/adverts/third.jpg\" alt=\"third\" /></a>', '', '#', '/GitHub/trotri/data/u/adverts/third.jpg', '', 'third', '0', '0', '', '_blank', '2014-11-05 14:07:54');
INSERT INTO `tr_adverts` VALUES ('4', '网站公告', 'notice', '', 'y', '2014-11-05 14:08:42', '0000-00-00 00:00:00', '1', 'code', '网站公告 ...... 网站公告 ...... 网站公告 ...... 网站公告 ...... 网站公告 ...... 网站公告 ...... ', '', '', '', '', '', '0', '0', '', '_blank', '2014-11-05 14:09:13');
INSERT INTO `tr_adverts` VALUES ('5', 'GitHub', 'friendlinks', '', 'y', '2014-11-05 14:30:11', '0000-00-00 00:00:00', '1', 'text', '<a target=\"_blank\" href=\"http://www.github.com/\">GitHub</a>', 'GitHub', 'http://www.github.com/', '', '', '', '0', '0', '', '_blank', '2014-11-05 14:30:41');
INSERT INTO `tr_adverts` VALUES ('6', 'Bootcss', 'friendlinks', '', 'y', '2014-11-05 14:30:43', '0000-00-00 00:00:00', '2', 'text', '<a target=\"_blank\" href=\"http://www.bootcss.com/\">Bootstrap</a>', 'Bootstrap', 'http://www.bootcss.com/', '', '', '', '0', '0', '', '_blank', '2014-11-05 14:31:14');
INSERT INTO `tr_adverts` VALUES ('7', 'Trotri', 'friendlinks', '', 'y', '2014-11-05 14:31:17', '0000-00-00 00:00:00', '3', 'text', '<a target=\"_blank\" href=\"http://www.trotri.com/\">Trotri</a>', 'Trotri', 'http://www.trotri.com/', '', '', '', '0', '0', '', '_blank', '2014-11-05 14:31:37');

DROP TABLE IF EXISTS `tr_topic`;
CREATE TABLE `tr_topic` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `topic_name` varchar(255) NOT NULL DEFAULT '' COMMENT '专题名',
  `topic_key` varchar(24) NOT NULL DEFAULT '' COMMENT '专题Key',
  `cover` varchar(255) NOT NULL DEFAULT '' COMMENT '封面大图',
  `meta_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `meta_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `meta_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `html_style` longtext COMMENT '页面Style标签中内容',
  `html_script` longtext COMMENT '页面Script标签中内容',
  `html_head` longtext COMMENT '页面Head标签中内容',
  `html_body` longtext COMMENT '页面Body标签中内容',
  `is_published` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否发表，y：开放浏览、n：草稿',
  `use_header` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '使用公共的页头',
  `use_footer` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '使用公共的页脚',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`topic_id`),
  UNIQUE KEY `uk_topic_key` (`topic_key`),
  KEY `topic_name` (`topic_name`),
  KEY `pub_sort` (`is_published`,`sort`),
  KEY `dt_created` (`dt_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专题表';

INSERT INTO `tr_topic` VALUES ('1', '示例', 'example', '/GitHub/trotri/data/u/imgs/topic_example.jpg', '示例', '示例,专题', '示例专题', '', '', '', '<div class=\"container\">\r\n  <div class=\"blog-header\"></div>\r\n  <div class=\"row\">\r\n示例专题 ...... 示例专题 ...... 示例专题 ...... 示例专题 ...... 示例专题 ...... 示例专题 ......\r\n  </div><!-- /.row -->\r\n</div><!-- /.container -->', 'y', 'y', 'y', '1', '2014-11-05 14:17:44');