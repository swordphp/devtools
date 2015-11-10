<?php
/**
 *
 */
class resobjobj{
    private $result;
    public function __construct(){
        $this->result = array(
            "errno"=>'0',
            "errmsg"=>'Success',
            "data"=>array(),
            );
    }
    /**
     * 设置错误号和错误消息
     * @return [type] [description]
     */
    public function seterr($errno,$errmsg){
        $this->seterrno($errno);
        $this->seterrmsg($errmsg);
        return true;
    }
    /**
     * 设置错误消息
     * @return [type] [description]
     */
    public function seterrmsg($errmsg){
        $this->result['errmsg'] = $errmsg;
        return true;
    }
    /**
     * 设置错误号
     * @return [type] [description]
     */
    public function seterrno($errno){
        $this->result['errno'] = $errno;
        return true;
    }
    /**
     * 输出JSON结果
     * @return [type] [description]
     */
    public function echores(){
        header('Content-type: application/json');
        echo json_encode($this->result);
    }
    /**
     * 获取结果数组
     * @return [type] [description]
     */
    public function getres(){

    }
    public function setdata($data){
        $this->result['data'] = $data;
        return true;
    }
}