<?php
//命名空间
namespace app\admin\controller;

use houdunwang\view\View;
use system\model\Grade as GradeModel;

class Grade extends Common
{
    /**
     * 班级列表
     */
    //public类的内部、外部、子类都可以使用
    //这里是设定了一个班级列表
    public function index()
    {
        //$url = u('add',['gid'=>1,'aid'=>2]);
        //$url = u('add');
        //index.php?s = admin/grade/add&gid = 1
        //dd($url);
        $model = GradeModel::order("gid desc")->getAll();
        $data = $model?$model->toArray():[];
        //$data = [1,2,3];
        //dd(compact('data'));
        return View::make()->with(compact('data'));
    }

    /**
     *班级添加
     */
    //public类的内部、外部、子类都可以使用
    //这里设定一个添加班级的方法
    public function add()
    {
        if (IS_POST){
            //实例化一个类，调用一个方法
            $res = (new GradeModel())->add($_POST);
            if ($res['code']){
                $this->setRedirect(u('index'))->message($res['msg']);
            }else{
                $this->setRedirect()->message($res['msg']);
            }
        }
        return View::make();
    }

    /**
     * 编辑内容
     */
    //public类的内部、外部、子类都可以使用
    //这里是设定一个编辑内容的方法
    public function edit()
    {
        //echo 1;exit;
        //接受get的参数
        $gid = $_GET['gid'];
        //dd($gid);die;
        if (IS_POST){
            //实例化一个类，调用一个方法
            $res = (new GradeModel())->edit($gid,$_POST);
            if ($res['code']){
                $this->setRedirect(u('index'))->message($res['msg']);
            }else{
                $this->setRedirect()->message($res['msg']);
            }
        }
        //获取旧数据
        $oldData = GradeModel::find($gid)->toArray();
        //dd($oldData);
        return View::make()->with(compact('oldData'));
    }

    /**
     * 删除内容
     */
    //public类的内部、外部、子类都可以使用
    //这里是设置了一个删除内容的方法
    public function del()
    {
        //接受get参数
        $gid = $_GET['gid'];
        //destory是破坏物体的一部分
        //这里是删除此主键里的所有内容
        GradeModel::destory($gid);
        //删除成功的提示
        $this->setRedirect(u('index'))->message('删除成功');
    }
}