<?php
//命名空间
namespace system\model;

use houdunwang\model\Model;

class Grade extends Model
{
    /**
     * 添加内容
     * @param $data
     * @return array
     */
    //public类的内部、外部、子类都可以使用
    //这里是设定一个添加内容的方法
    public function add($data)
    {
        //echo 1;exit;
        //dd($data);exit;
        //设置判断班级名不能为空
        if (!trim($data['gname']))return['code'=>0,'msg'=>'班级名称不能为空'];
        $gradeData = $this->where("gname='{$data['gname']}'")->getAll();
        //设置判断班级不能重复
        if ($gradeData)return['code'=>0,'msg'=>'班级已经存在，请勿重复添加'];
        $this->insert($data);
        //添加成功的提示
        return['code'=>1,'msg'=>'添加成功'];
    }

    /**
     * 添加内容设置
     */
    //public类的内部、外部、子类都可以使用
    //这里是设定了一个添加内容的设置
    public function edit($gid,$data)
    {
        //echo 1;exit;
        //dd($gid); exit;
        //验证数据不能为空
        if (!trim($data['gname']))return['code'=>0,'msg'=>'班级名称不能为空'];
        //设置班级不能重复
        $gradeData = $this->where("gname='{$data['gname']}' and gid!={$gid}")->getAll();
        if ($gradeData)return['code'=>0,'msg'=>'班级已经存在'];
        //执行更新
        $res=$this->where("gid={$gid}")->update($data);
        //if判断内容
        if ($res){
            //当内容没有时就会提示更新成功
            return['code'=>1,'msg'=>'更新成功'];
        }
        //当内容存在时就会提示数据未更新
        return['code'=>0,'msg'=>'数据未更新'];
    }
}