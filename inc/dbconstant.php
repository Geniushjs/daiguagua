<?php
//--------------服务器配置型的常量--------------
//define('DEBUG',false);
define('DEBUG',true);

//MYSQL的相关参数定义
//设为数据库服务器IP
define('MYSQLSERVER','localhost');
//设为数据库用户名
define('MYSQLUSER','daigua');
//设为数据库用户密码
define('MYSQLPWD','daigua@aliyun');
//设为数据库名
define('MYSQLDATABASE','daigua');
define('MYSQLDSN','mysql://' . MYSQLUSER . ':' . MYSQLPWD . '@' . MYSQLSERVER. '/' . MYSQLDATABASE);
define('DATABASEDSN',MYSQLDSN);
