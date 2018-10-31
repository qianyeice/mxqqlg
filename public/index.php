<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
date_default_timezone_set('PRC');
// [ 应用入口文件 ]
//ini_set('session.save_handler', 'redis');
//ini_set('session.save_path', 'tcp://119.27.171.174:6379');
session_start();
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('THINK_PATH', __DIR__."/../" );
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
