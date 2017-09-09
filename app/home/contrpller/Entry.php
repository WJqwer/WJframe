<?php
//命名空间
namespace app\home\contrpller;

use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;
use system\model\Article;

class Entry extends Controller
{
    //publis在类的内部、子类、外部都可以使用
    //设定一个普通的载入方法
    public function index()
    {
        //将方法赋值到$row里
        $row= Article::find(1);
//        dd($row);
//        $test = 'houdunwang';
//        return View::with(compact('test'))->make();
    }

    //publis在类的内部、子类、外部都可以使用
    public function add()
    {
        echo 'add';
    }
}