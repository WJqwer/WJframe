<?php
//命名空间
namespace app\home\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Article;

class Entry extends Controller
{
    public function index()
    {
       dd( Article::find(1)->toArray());
        $text = "flkdjglk";
        return View::with(compact('text'))->make();
    }

    public function add()
    {

    }
}