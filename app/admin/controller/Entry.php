<?php

namespace app\admin\controller;

use houdunwang\view\View;
use system\model\Admin;

class Entry extends Common
{
    public function index()
    {
        //机子模板文件
        return View::make();
    }

    /**
     * 修改密码
     */
    public function changePass()
    {
        //判断是否提交
        if(IS_POST){
            //执行修改方法
            $res= (new Admin())->changePass($_POST);
            //判断错误码
            if($res["code"]){
                //成功
                $this->setRedirect(u("entry.index"))->message($res["msg"]);
            }else{
                //失败
                $this->message($res["msg"]);
            }
        }
        return View::make();
    }

    /**
     * 退出
     */
    public function destory()
    {
        $res = (new Admin())->destory();
        if ($res["code"]){
            $this->setRedirect(u("login.index"))->message($res["msg"]);
        }else{
            $this->message($res["msg"]);
        }
    }
}