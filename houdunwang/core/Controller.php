<?php
//命名空间
namespace houdunwang\core;

class Controller
{
    //private定义类的方法和属性，在类的内部使用
    //window.history.back()意思是返回当前页面的上一页
    //这里是将这个方法赋给$url只能在它的内部使用
    private $url = "window.history.back()";

    /**
     * 提示消息
     * @param $message		消息内容
     */
    //public类的内部、外部、子类都可以使用
    //这里是设定了一个消息提示方法
    public function message($message)
    {
        //加载public/view/message.php文件
        //这里引入的是消息提示的模板文件
        include "./view/message.php";
        exit;
    }

    /**
     * 跳转
     * @param string $url	跳转地址
     *
     * @return $this
     */
    //public类的内部.外部.子类都可以使用
    //这里是设定了一个跳转方法
    public function setRedirect($url = '')
    {
        //empty（）的意思是判断变量是否为空
        //这里if判断$url这个变量是否为空值
        if (empty($url)){
            //如果$url这个变量为空时就返回当前页面的上一页
            $this->url = "window.history.back()";
        }else{
            //如果$url这个变量有值时就还显示当前页面
            $this->url = "location.href='$url'";
        }
        //返回对象
        return $this;
    }
}