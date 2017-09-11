<?php

namespace app\admin\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Admin;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Login extends Controller
{
    /**
     * 登录管理登录页面
     */
    public function index()
    {
        if (IS_POST){
            //先生成一个加密之后的密码，手动写入数据库中
//            dd(password_hash('admin88',PASSWORD_DEFAULT));
            //测试连接数据库是否成功并以数组形式打开
//            $res = Admin::find(1)->toArray();
//            dd($res);
            //测试c函数读取配置顶
//            dd(c('database.host'));
            //测试u函数
//            dd(u('admin.entry.index'));//index.php?s=admin/entry/index
//            dd(u('entry.index'));//index.php?s=admin/{info[0]}/index
//            dd(u('index'));//index.php?s=admin/login/index
            if (IS_POST){
                //调用自己mode执行登录功能
                $res = (new Admin())->login($_POST);
                //接受模型返回的数据
//                dd($res);
                //根据$res结果给模板页面进行响应（提示）
                if ($res['code']){
                    //成功
                    //u（'模板.控制器.方法'）
                    //如果没有写模板，默认当前控制器
                    //$this->setRedirect ('?s=admin/entry/index')->message ($res['msg']);
                    $this->setRedirect(u('entry.index'))->message($res['msg']);
                }else{
                    //失败
                    $this->setRedirect()->message($res['msg']);
                }
            }
        }
        return View::make();
    }

    /**
     * 加载验证码
     */
    //public类的内部、外部、子类都可以使用
    //这里设定了一个验证码方法
    public function captcha()
    {
        header('Content-type: image/jpeg');
        $phraseBuilder = new PhraseBuilder(4);
        $builder = new CaptchaBuilder(null,$phraseBuilder);
        $builder->build ();
        //将验证码存入到session
        $_SESSION['phrase'] = $builder->getPhrase();
        $builder->output ();
    }

    /**
     * 修改密码
     */
    public function edit()
    {
        //判断是否提交
        if(IS_POST){
            //执行修改方法
            $res= (new Admin())->edit($_POST);
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