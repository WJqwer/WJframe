<?php
/**
 * 单一入口文件
 */
//加载composer的autoload.php文件
require_once "../vendor/autoload.php";
//调用静态run方法
\houdunwang\core\Boot::run();