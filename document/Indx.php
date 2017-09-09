<?php

class IndxController
{
    //public类里内部、外部、子类都可以使用
    //设定一个方法
    public function index(){
        //输出静态的类方法
        echo get_called_class();
    }
}

class Son extends IndxController{

}
//实例化Son赋给index
(new Son())->index();