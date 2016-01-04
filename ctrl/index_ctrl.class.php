<?php

class index_ctrl extends base_ctrl{
    public function __construct(){
        parent::__construct();
    }
    public function init($input){
        phpinfo();
        $this->tpl->display("index.tpl");
    }
}