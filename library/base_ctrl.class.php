<?php
include(WEB_ROOT.'common/smarty/Smarty.class.php');
class base_ctrl{
    public static $tpl;
    public function __construct(){
        $this->tpl = new Smarty();
        $smarty_config = include(WEB_ROOT."configs/smarty.config.php");
        set_smarty($this->tpl,$smarty_config);
    }
    public function __call($function,$args){
        exit("Action >$function< not found ");
    }
}