<?php
//命名空间
namespace houdunwang\model;

use PDO;
use PDOException;
use Exception;

class Base
{
    //private定义类的属性和方法，在类的内部使用
    //这里是设定一个静态变量
    private static $pdo = null;
    //操作数据表名
    private $table;
    //public在类的内部、外部、子类都可以使用
    //设定一个普通的方法
    public function __construct($class)
    {
        //is_null检测变量是否为 NULL
        //if判断$pdo这个静态变量是否为NULL
        if (is_null(self::$pdo)){
            //connect用于建立和指定文件的连接
            self::connect();
        }
        //strtolower是把字符串转换为小写
        //ltrim是移除字符串左侧的空白字符
        //strrchr查找字符在指定字符串中从左面开始的最后一次出现的位置
        //设定文件类型的设置
        $info = strtolower(ltrim(strrchr($class,'\\'),'\\'));
        //将设置好的文件的类型赋给它们
        $this->table = $info;
    }

    /**
     * 链接数据库
     * @throws Exception    抛出异常错误
     */
    //private定义类的属性和方法，只能在类的内部使用
    //设定一个静态的方法
    private static function connect()
    {
        try{
//             c('database.driver');
            //设定的变量名
            $dsn = c('database.driver').":host=".c('database.host').";dbname=".c('database.dbname');
            $user = c('database.user');
            $password = c('database.password');
            //实例化对象名、参数、方法
            self::$pdo = new PDO($dsn,$user,$password);
            //设置字符集
            self::$pdo->query("set names utf8");
            //设置错误属性
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $a){
            throw new Exception($a->getMessage());
        }
    }

    //public类的内部、外部、子类都可以使用
    //是定义一个方法
    public function find ($id)
    {
        //现获取主键，获取等前操作数据表的主键到底是谁
        $pk = $this->getPk();
        //将设置好的主键赋给$aql
        $sql = "select * from {$this->table} where {$pk} = {$id}";
//        dd($sql);die;
        //执行查询
        $data = $this->query($sql);
        //跳出这个循环并对它进行实例化设置
        return current($data);
    }

    /**
     * 获取数据表主键到底是id还是aid或cid
     */
    //public类的内部、外部、子类都可以使用
    //设定一个方法
    public function getPk()
    {
        //查看表结果
        $sql = "desc ".$this->table;
        //将这个结果传个$data
        $data = $this->query($sql);
        //设置一个空的盒子
        $pk = '';
        foreach ($data as $v){
            //if判断它们是否相同
            if ($v['Key']=='PRI'){
                $pk = $v['Field'];
                //break是跳出这个循环
                break;
            }
        }
        //返回到原文件里
        return $pk;
    }

    /**
     * 执行有结果集的查询
     */
    //public类的内部、外部、子类都可以使用
    public function query($sql){
        try{
            $res = self::$pdo->query($sql);
            //去除结果集
            $row = $res->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        }catch(PDOException $a){
            throw new Exception($a->getMessage());
        }

    }
}