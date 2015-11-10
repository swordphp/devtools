<?php

class index_ctrl extends base_ctrl{
    public function __construct(){
        parent::__construct();
    }
    public function init($input){
        $this->tpl->display("index.tpl");
    }
}