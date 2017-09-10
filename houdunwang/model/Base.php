<?php
//命名空间
namespace houdunwang\model;

use PDO;
use PDOException;
use Exception;

class Base
{
    //protected定义类的属性和方法，在类的内部、子类使用
    //声明操作数据表
    protected $table;

    //private定义类的属性和方法，在类的内部使用
    //用来储存连接数据库的状态
    private static $pdo = null;

    //private定义类的属性和方法，在类的内部使用
    //用来存放$where的语句
    private $where = '';

    //private定义类的属性和方法，在类的内部使用
    //用来存放查询结构的数据
    private $data;

    //private定义类的属性和方法，在类的内部使用
    //用来获取指定字段
    private $field = '';

    //public在类的内部、外部、子类都可以使用
    //设定一个方法
    public function __construct($class)
    {
        //is_null检测变量是否为 NULL
        //if判断$pdo这个静态变量是否为NULL
        if (is_null(self::$pdo)){
            //connect用于建立和指定文件的连接
            //执行文件间的连接
            $this->connect();
        }
        //explode()使用一个字符串分割另一个字符串，并返回由字符串组成的数组
        //设定文件类型的设置
        $info = explode('\\',$class);
        //strtolower是把字符串转换为小写
        //将设置好的文件的类型赋给$this->table
        $this->table = strtolower($info[2]);
    }

    /**
     *链接数据库
     *@throws Exception    抛出异常错误
     */
    //private定义类的属性和方法，只能在类的内部使用
    //设定一个只能在内部使用的静态的方法
    private static function connect()
    {
        try{
            //设定的变量名
            $dsn = "mysql:host=localhost;dbname=c86";
            $user = "root";
            $password = "root";
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

    /**
     *统计数据
     */
    //public类的内部、外部、子类都可以使用
    //设定一个统计数据的方法
    public function count()
    {
        $sql = "select count(*) as total from {$this->table} {$this->where}";
        //执行aql语句
        $data = $this->query($sql);
        return $data[0]['total'];
    }

    /**
     * 获取制定字段
     */
    //public类的内部、外部、子类都可以使用
    //设定一个获取制定字段的方法
    public function field($field)
    {
        //这里是将$field赋给$this->field
        $this->field = $field;
        //返回对象
        return $this;
    }

    /**
     * 执行数据写入
     */
    //public类的内部、外部、子类都可以使用
    //设定一个执行数据写入方法
    public function insert($data)
    {
        //存储字段名
        $fields = '';
        //存储字段值
        $values = '';
        //$data就相同于$k => $v数组
        foreach ($data as $k => $v){
            //将$k赋给$fields
            $fields.= $k.',';
            //is_int判断变量类型是否为整数类型
            //if判断字段值是否有引号和去逗号
            if (is_int($v)){
                $values.= $v.',';
            }else{
                $values.= "'$v'".',';
            }
        }
        //rtrim（）移除字符串右侧的空白字符或其他预定义字符
        $fields = rtrim($fields.',');
        $values = rtrim($values.',');
        //将的字段名、字段值写入赋给$sql
        $sql = "insert into {$this->table} ({$fields}) values ({$values})";
        //exec调用并执行
        //这里就是执行$sql
        return $this->exec($sql);
    }

    /**
     * 执行更新数据
     */
    //public类的内部、外部、子类都可以使用
    //设定一个执行更新数据的方法
    public function update(array $data)
    {
        //empty是判断字符串是否为空
        //如果没有指定where条件不允许更新数据
        if (empty($this->where))
            return false;
        //存储字段名
        $fields = '';
        //is_int判断变量类型是否为整数类型
        //if判断字段值是否有引号和去逗号
        foreach ($data as $k => $v){
            if (is_int($v)){
                $fields.="$k=$v".',';
            }else{
                $fields.="$k='$v'".',';
            }
        }
        //rtrim（）移除字符串右侧的空白字符或其他预定义字符
        $fields = rtrim($fields,',');
        //将的字段名、字段值写入赋给$sql
        $sql = "update {$this->table} set {$fields} {$this->where}";
        //exec调用并执行
        //这里就是执行$sql
        return $this->exec($sql);
    }

    /**
     * 删除数据
     */
    //public类的内部、外部、子类都可以使用
    //设定一个删除数据方法
    public function dastory($pk = '')
    {
        if (empty($this->where) || empty($pk)){
            //如果没有指定where条件不允许更新数据
            if (empty($this->where)){
                //获取主键
                $priKey = $this->getPriKey();
                //这个时候说明没有where条件
                //那么把destory传入参数作为where条件
                $this->where("{$priKey}={$pk}");
            }
            //将它们写入传给$aql
            $aql = "delete from {$this->table} {$this->where}";
            //执行sql语句
            return $this->exec($aql);
        }else{
            return false;
        }
    }

    /**
     * 获取所有数据
     */
    //public类的内部、外部、子类都可以使用
    //设定一个获取所有数据的方法
    public function getAll()
    {
        $field = $this->field ? :'*';
        //组合查询所有数据的sql语句
        $sql = "select {$field} from {$this->table} {$this->where}";
        //调用自定义的query查询
        $data = $this->query ( $sql );
        if (!empty($data)){
            $this->data = $data;
            return $this;
        }
        return [];
    }

    /**
     *根据主键查找一条数据
     */
    //public类的内部、外部、子类都可以使用
    //设定一个根据主键查找一条数据的方法
    public function find($pk)
    {
        //获取当前操作数据表的主键
        $priKey = $this->getPriKey();
        //$sql = "select * from 表 where 主键=$pk";
        //组合where语句,调用where方法
        //为了把sql中where条件语句存储到where属性中
        //dd($pk);die;
        $this->where ( "$priKey={$pk}" );
        $field = $this->field ? : '*';
        $sql = "select {$field} from {$this->table} {$this->where}";
        //调用我们自定义的query方法执行sql语句
        $data = $this->query($sql);
        if (!empty($data)){
            $this->data = current($data);
            return $this;
        }
        return $this;
        return [];
    }

    /**
     * 将对象转为数组
     */
    //public类的内部、外部、子类都可以使用
    //设定一个将对象转为数组的方法
    public function toArray()
    {
        if ($this->data){
            return $this->data;
        }
        return [];
    }

    /**
     * sql查询语句中where条件
     */
    //public类的内部、外部、子类都可以使用
    //设定一个sql查询语句中where条件方法
    public function where($where)
    {
        //$this->where = "where sex='女' and age>20";
        $this->where = "where {$where}";
        return $this;
    }

    /**
     * 获取主键
     */
    //public类的内部、外部、子类都可以使用
    //设定一个获取主键方法
    public function getPriKey()
    {
        //组合sql语句，为了查看表结构
        //为了在里面呢找主键
        $sql = "desc ".$this->table;
        //调用自定义的query方法进行查询
        $dara = $this->query($sql);
        //设定一个空字符串用来存储主键
        $priKey = '';
        foreach ($dara as $v){
             if ($v['Key'] =='PRI'){
                 //说明是主键
                 $priKey = $v['Field'];
                 break;
             }
        }
        return $priKey;
    }

    /**
     * 执行查询
     */
    //public类的内部、外部、子类都可以使用
    //设定一个执行查询方法
    public function query($sql)
    {
        try{
            //调用pdoquery
            $res = self::$pdo->query($sql);
            return $res->fetchAll(PDO::FETCH_ASSOC);
            }catch ( PDOException $a ) {
            throw new Exception( $a->getMessage () );
        }
    }

    /**
     * 执行没有结果集的sql
     */
    //public类的内部、外部、子类都可以使用
    //设定一个执行没有结果集的sql的方法
    public function exec($sql)
    {
        try{
            $res = self::$pdo->exec($sql);
            //如果是添加的话，获取返回的自增主键值
            if ($lastlnsertld = self::$pdo->lastlnsertld ()){
                //说明有返回的自增id
                return$lastlnsertld;
            }
            return $res;
        }catch ( PDOException $a ) {
            throw new Exception( $a->getMessage () );
        }
    }
}