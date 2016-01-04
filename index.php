<?php
/**
 * 首页,控制器和action控制
 *
 *
 */
define("WEB_ROOT",dirname(__FILE__)."/");//定义根目录
define("LIB_DIR",WEB_ROOT."library/");
define("HOST_NAME","http://".$_SERVER['HTTP_HOST']);
date_default_timezone_set("Asia/chongqing");
include_once(WEB_ROOT.'library/base_ctrl.class.php');//包含基础控制器

include_once(WEB_ROOT.'library/func.lib.php');//包含函数库
define("DEFAULT_CTRL","index");
define("DEFAULT_ACTION","init");
//处理路由信息
$route_info = empty(array_keys($_GET))?array(""):array_keys($_GET);//处理路由信息
//兼容非rewrite规则
if(in_array("c",$route_info)) {
    $route_info[0] = $_GET['c'];
}
if(in_array("a",$route_info)) {
    $route_info[0] .= "/".$_GET['a'];
}
//兼容非rewrite规则
if($route_info != '') {
    unset($_GET[$route_info[0]]);
    $route_info = explode("/",trim($route_info[0],"/"));

    @define("CTRL",$route_info[0] == ''?DEFAULT_CTRL:$route_info[0]);//定义控制器
    @define("ACTION",$route_info[1] == ''?DEFAULT_ACTION:$route_info[1]);//定义action
} else {
    @define("CTRL",DEFAULT_CTRL);//定义控制器
    @define("ACTION",DEFAULT_ACTION);//定义action
}
//处理路由信息结束
final  class Index {
    public static $ctrl;
    /**
     * 开始方法
     * @return [type] [description]
     */
    public static function  start(){
        $request_args = array_merge($_POST,$_GET);
        $loadctrl = self::includectrl(CTRL);
        call_user_func_array(array(self::$ctrl, ACTION), array($request_args));
    }
    /**
     * 引入控制器文件
     * @param  [str] $ctrl 控制器名称字符串
     * @return [type]       [description]
     */
    private static  function includectrl($ctrl){
        $class_name = $ctrl."_ctrl";
        $filename = WEB_ROOT."ctrl/$class_name.class.php";
        include($filename);
        if(class_exists($class_name)) {
            self::$ctrl = new $class_name;
        } else {
            exit("Controller class $class_name not found!");
        }
        return true;
    }
}
Index::start();

