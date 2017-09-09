<?php
//命名空间
namespace houdunwang\core;

class Controller
{
    //private定义类的属性和方法，只能在类的内部使用
    //赋给$url一个地址具体路径
    //定义跳转地址属性
    private $url = "window.history.back()";

    /**
     * 提示消息
     * @param $message      消息内容
     */
    //public在类的内部、子类、外部都可以使用
    //设定一个提示器
    public function message($message){
        //引入加载publie/view/message.php文件
        //消息提示的模板文件
        include "./view/message.php";
        exit;
    }

    /**
     * 跳转
     * @param string $url   跳转地址
     *
     * @return $this
     */
    //public可在内部、子类、外部使用
    //设定一个跳转器
    public function setRedirect($url=''){
        //empty检测字符串是否为空
        //if判断$url里是否为空的处理方法
        if (empty($url)){
            //window.history.back()返回到上一个页面
            $this->url = "window.history.back()";
        }else{
            //location.href='$url'前往指定的页面
            $this->url = "location.href='$url'";
        }
        //跳转到首页面
        return $this;
    }
}