<?php
include(WEB_ROOT.'common/qrcode/phpqrcode.php');
class qrcode_ctrl extends base_ctrl{
    public $imagedir;
    public $res;
    public function __construct(){

    }
    public function init(){
        $content = isset($_GET['content'])?$_GET['content']:'';
        if($content == ''){
            $content = "lbsopn qrcode";
        }
        $errorCorrectionLevel = "H";
        $matrixPointSize = "4";
        QRcode::png($content, false, $errorCorrectionLevel, $matrixPointSize);
        exit;
    }
}