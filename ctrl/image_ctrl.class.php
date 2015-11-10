<?php
include(LIB_DIR."fileupload.class.php");
include(LIB_DIR."resobj.class.php");
class image_ctrl extends base_ctrl{
    public $imagedir;
    public $res;
    public function __construct(){
        parent::__construct();
        $this->imagedir = WEB_ROOT."/imagetmp/".date("ymd")."/";
        $this->imagebaseurl = HOST_NAME."/imagetmp/".date("ymd")."/";
        $this->res = new resobjobj();
    }
    public function init($input){
        $this->tpl->display("index.tpl");
    }
    /**
     * 上传图片的方法
     * @return [type] [description]
     */
    public function upload(){
        $up = new fileupload;
            //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
            $up -> set("path", $this->imagedir);
            $up -> set("maxsize", 2000000);
            $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
            $up -> set("israndname", true);
            //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
            if($up -> upload("pic")) {

                $data['imagename'] = $up->getoriginname();
                $data['imageid'] = $up->getFileName();
                $data['imageurl'] = $this->imagebaseurl.$data['imageid'];
                $this->res->setdata($data);
                $this->res->echores();
            } else {
                //获取上传失败以后的错误提示
                $this->res->seterr("4001",$up->getErrorMsg());
                $this->res->echores();
                ///Users/baidu/data/devtools/imagetmp
            }
    }
    /**
     * 压缩图片的方法
     * @return [type] [description]
     */
    public function compress(){
        $imagefrom =$this->imagedir.$filename = $_GET['imageid'];
        $beforeinfo = getimagesize($imagefrom);
        $rinfo['beforeinfo']['imagename'] = $_GET['imagename'];
        $rinfo['beforeinfo']['imageid'] = $_GET['imageid'];
        $rinfo['beforeinfo']['imagesize'] = round(filesize($imagefrom)/1000,1)."kb";
        $rinfo['beforeinfo']['imageurl'] = $this->imagebaseurl.$_GET['imageid'];
        //处理前的基础信息
        $imagetype = $beforeinfo['mime'];
        $imageext = array_pop(explode("/",$imagetype));
        $newfilename = $this->randname($imageext);
        $imageto = $this->imagedir.$newfilename;
        $res = shell_exec("pngquant $imagefrom -o $imageto --speed 1 --quality 85-95");

        $rinfo['afterinfo']['imageid'] = $newfilename;
        $rinfo['afterinfo']['imagename'] = isset($_GET['imagename'])?$_GET['imagename']:$newfilename;
        $rinfo['afterinfo']['imageurl'] = $this->imagebaseurl.$newfilename;
        $rinfo['afterinfo']['imagesize'] = round(filesize($imageto)/1000,1)."kb";
        //处理后的信息
        $this->res->setdata($rinfo);
        $this->res->echores();
    }
    /**
     * 下载图片
     * @param  [type] $iamgeid   [description]
     * @param  [type] $imagename [description]
     * @return [type]            [description]
     */
    public function download($iamgeid='', $imagename=''){
        $imageid = isset($_GET['imageid'])?$_GET['imageid']:'';
        $imagename = isset($_GET['imagename'])?$_GET['imagename']:'';
        if($imageid == ''||$imagename == '') {
            exit("参数不合法");
        }
        $imageinfo = getimagesize($this->imagedir.$imageid);
        $imagetype = $imageinfo['mime'];
        $imageext = array_pop(explode("/",$imagetype));
        $filesize = filesize($this->imagedir.$imageid);
        header("Content-type:image/png");
        header("Accept-Ranges:bytes");
        header("Accept-Length:$filesize");
        header("Content-Disposition:attachment;filename=$imagename");
        readfile($this->imagedir.$imageid);
        return ;
    }
    public function delimage(){
        $imageids = $_GET['imageids'];
        $needdel = explode(",",$imageids);
        if(!empty($needdel)) {
            $total =0;
            foreach($needdel as $imageid) {
                $res = @unlink($this->imagedir.$imageid);
                if($res) {
                    $total +=1;
                }
            }
        }
        $res['deltotal'] = $total;
        $this->res->setdata($res);
        $this->res->echores();
    }
    /**
     * 生成随机名称的方法
     * @return [type] [description]
     */
    private function randname($imagetype){
        return strtolower(md5(time())).".$imagetype";
    }
}