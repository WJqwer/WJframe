<?php

namespace houdunwang\view;

class Base
{
    //protected是定义类的属性和方法，在类的内部和子类可以使用
    //创建一个数据库用来存放数据
    protected $date = [];
    //存放模板路径
    protected $file;
    //public在类的内部、外部、子类都可以使用
    //分配变量
    public function with($var){
        $this->data = $var;
        return $this;
    }

    //public在类的内部、外部、子类都可以使用
    //显示模板
    public function make(){
        //dd(MODULE);//home
        //dd(CONTROLLER);//Entry
        //dd(ACTION);//index
        //include "../app/home/view/entry/index.php";
        $this->file = "../app/".MODULE."/view".strtolower(CONTROLLER)."/".ACTION.".".c('view.suffix');
        return $this;
    }

    /**
     * 当echo输出对象的时候触发
     * @return string
     */
    //public在类的内部、外部、子类都可以使用
    public function _toString(){
        extract($this->data);
        include $this->file;
        return'';
    }
}