<?php

/**
 * 配置smarty的函数
 *
 * @param [type] $smartyobj [description]
 */
function set_smarty($smartyobj,$smartyconfig){
    if(!empty($smartyconfig)) {
        foreach($smartyconfig as $key=>$val) {
            $smartyobj->$key = $val;
        }
    } else {
        return false;
    }
    return true;
}