<?php
//命名空间
namespace houdunwang\view;

class Base
{
    //protected定义类的属性和方法，在类的内部、子类使用
    //设定了一个存放数据
    protected $data = [];
    //protected定义类的属性和方法，在类的内部、子类使用
    //设定了一个存放模板路径
    protected $file;

    /**
     * 分配变量
     * @param $var
     * @return $this
     */
    //public类的内部、外部、子类都可以使用
    //设定一个方法
    public function with($var=[])
    {
        //dd($var);
        //接受并储存变量
        $this->data = $var;
        //返回一个对象
        return $this;
    }

    /**
     * 显示模板
     * @return $this
     */
    //public类的内部、外部、子类都可以使用
    //设定一个显示模板方法
    public function make()
    {
        //这个是将模板页面赋给$this->file,也就是组合路径
        $this->file = "../app/".MODULE."/view/".strtolower(CONTROLLER)."/".ACTION.".php";
        //返回一个对象
        return $this;
    }

    /**
     * 当echo 输出对象的时候出发
     * @return string
     */
    //public类的内部、外部、子类都可以使用
    //设定一个转变方法
    public function __toString()
    {
        //extract()是从数组中把变量导入到当前的符号表中
        //把键名转变为变量名
        //把键值转变为变量值
        extract($this->data);
        //模板的加载
        include $this->file;
        //必须要返回字符串不然方法报错不能使用
        return'';
    }
}