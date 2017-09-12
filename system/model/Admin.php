<?php
//命名空间
namespace system\model;

use houdunwang\model\Model;

class Admin extends Model
{
    /**
     * 登录
     */
    //public类的内部、外部、子类都可以使用
    //这里是设定了一个登录方法
    public function login($data)
    {
        //将用户输入的信息分别赋给它们
        $admin_username = $data['admin_username'];
        $admin_password = $data['admin_password'];
        $captcha = $data['captcha'];
        //数据验证
        //return ['code'=>0,'msg'=>'请输入用户名']
        //code 标识成功还是失败的标识 1代表成功，0代表失败
        //msg 提示消息
        //对用户名、密码、验证码进行设置，为空时不能通过并返回登录页面
        if (!trim($admin_username))return['code'=>0,'msg'=>'请输入用户名'];
        if (!$admin_password)return['code'=>0,'msg'=>'请输入密码'];
        if (!trim($captcha))return['code'=>0,'msg'=>'请输入验证码'];
        //对比用户名密码是否正确
        //根据用户提交的username在数据库进行查找
        $userlnfo = $this->where("adminUser='{$admin_username}'")->getAll();
        //dd($userlnfo);
        //如果找不到数据，就是说明当前用户名不存在
        if (!$userlnfo) return['code'=>0,'msg'=>'用户名不存在'];
        //走到这里说明$userlnfo一定有数据
        //对比密码
        $userlnfo = $userlnfo->toArray();
        //if判断比对密码是否正确
        if (!password_verify($admin_password,$userlnfo[0]['adminPwd']))return['code'=>0,'msg'=>'密码不正确'];
        //可以走到这里说明账号密码都正确了
        //if判断比对验证码是否正确
        if (strtolower($captcha)!=strtolower($_SESSION['phrase']))return['code'=>0,'msg'=>'验证码不正确'];
        //将用户登录的信息储存到session中
        $_SESSION['admin_id'] = $userlnfo[0]['adminId'];
        $_SESSION['admin_username'] = $userlnfo[0]['adminUser'];
        //返回成功标识和成功的提示信息
        return ['code'=>1,'msg'=>'登录成功'];
    }

    /**
     * 修改密码
     */
    //public类的内部、外部、子类都可以使用
    //这里设定一个修改密码的方法
    public function edit($data)
    {
        //dd($data);die;
        //获取id
        $id=$data["admin_id"];
        //用户名
        $username=$data["username"];
        //新密码
        $password=$data["password"];
        //再次确认新密码
        $pwd=$data["pwd"];
        //旧密码
        $oldpwd = $data["oldpassword"];
        //验证码
        //$captcha = $data["captcha"];
        //判断是否输入了用户名
        if (!trim($username)) return ["code" => 0, "msg" => "请输入用户名"];
        //查找密码
        $info=$this->find($id)->toArray();
        //dd($info);die;
        //判断旧密码
        if (!password_verify($oldpwd, $info["adminPwd"])) return ["code" => 0, "msg" => "旧密码不正确"];
        //判断是否输入了密码
        if (!$password) return ["code" => 0, "msg" => "请输入密码"];
        //判断是否输入了确认密码
        if (!$pwd) return ["code" => 0, "msg" => "请输入确认密码"];
        //判断是否输入了验证码
        //if (!trim($captcha)) return ["code" => 0, "msg" => "请输入验证码"];
        //判断两次密码是否一致
        if($data["password"]!=$data["pwd"]) return ["code"=>0,"msg"=>"两次密码不一样"];
        //比对验证码，用户输入的验证码是否正确
        //if ($captcha!= strtolower($_SESSION["phrase"])) return ["code" => 0, "msg" => "验证码不正确"];
        //重组数据
        //dd($this->findAll()->toArray());die;
        $info=[
            "adminUser"=>$username,
            "adminPwd"=>password_hash($password,PASSWORD_DEFAULT),
        ];
        //执行修改
        $res=$this->where("adminId={$id}")->update($info);
        //判断影响条数
        if($res){
            return ["code" => 1, "msg" => "修改成功"];
        }
    }

    /**
     * 删除
     */
    //public类的内部、外部、子类都可以使用
    //这里设定了一个删除方法
    public function destory()
    {
        //销毁session数据
        session_unset();
        //删除session文件
        session_destroy();
        return ["code"=>1,"msg"=>"退出成功"];
    }

}