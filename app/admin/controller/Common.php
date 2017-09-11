<?php

namespace app\admin\controller;

use houdunwang\core\Controller;

class Common extends Controller
{
    public function __construct()
    {
        //isset是检测变量是否设置
        //$_SESSION是用来调用和读取的
        if (!isset($_SESSION['admin_id'])){
            //header()函数向客户端发送原始的HTTP报头
            //跳转到登录页面
            header('location:?s=admin/login/index');
            exit;
        }
    }
}