<?php
/**
 * 助手函数
 */

/**
 * 定义常量判断是否为post请求
 */
define ('IS_POST',$_SERVER['REQUEST_METHOD']=='POST'?true:false);

/**
 * 检测请求是否为ajax请求
 */
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest'){
	//是异步请求
	define ('IS_AJAX',true);
}else{
	define ('IS_AJAX',false);
}

if(!function_exists ('dd')){
	/**
	 * 打印函数
	 */
	function dd($var){
		echo '<pre style="background: #ccc;padding: 8px;border-radius: 5px">';
		//print_r打印函数，不显示数据类型
		//print_r不能打印null，boolen
		if(is_null ($var)){
			var_dump ($var);
		}elseif(is_bool ($var)){
			var_dump ($var);
		}else{
			print_r ($var) ;
		}
		echo '</pre>';
		exit;
	}
}

if (!function_exists('p'))
{
    /**
     * 打印函数
     */
    function p($var){
        echo '<pre style="background: #ccc;padding: 8px;border-radius: 5px">';
        //print_r打印函数，不显示数据类型
        //print_r不能打印null，boolen
        if(is_null ($var)){
            var_dump ($var);
        }elseif(is_bool ($var)){
            var_dump ($var);
        }else{
            print_r ($var) ;
        }
        echo '</pre>';
    }
}

if (!function_exists('c'))
{
    /**
     * 读取配置项的C函数
     */
    function c($var){
        //转成数组
        $info = explode('.',$var);
        $data = include "../system/config/".$info[0].".php";
        return isset($data[$info[1]])?$data[$info[1]]:null;
    }
}

if(!function_exists ('u')){
    /**
     * 跳转的u函数
     * //?s=模块/控制器/方法
     */
    function u($url,$args = []){
        //p($args);
        //dd(http_build_query ($args));
        //http_build_query将数组['aid'=1,'bid'=2]变成 aid=1&bid=2
        $args = http_build_query ($args);
        $info = explode ('.',$url);
        //dd($info);
        if(count ($info)==2){
            return "index.php?s=".MODULE."/{$info[0]}/{$info[1]}" . "&{$args}";
        }
        if(count ($info)==1){
            return "index.php?s=".MODULE."/".CONTROLLER."/{$info[0]}". "&{$args}";
        }
        return "index.php?s={$info[0]}/{$info[1]}/{$info[2]}". "&{$args}";
    }
}

