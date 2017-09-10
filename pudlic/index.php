<?php
/**
 * 设置的单一入口文件
 */
//加载composerd的autoload.php文件
require_once "../vendor/autoload.php";
//设置调用run的方法
\houdunwang\core\Boot::run();