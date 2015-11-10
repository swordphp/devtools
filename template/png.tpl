<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tiny your Pngs.</title>
    <link rel="stylesheet" href="static/css/normalize.css"/>
    <link rel="stylesheet" href="static/css/font-awesome-4.4.0/css/font-awesome.css">
    <link rel="stylesheet" href="static/css/main.css"/>
</head>
<body>
    <input id="file" type="file" accept="image/png" multiple hidden>
    <div class="title">
        <h3>
            PNG图片压缩，不影响视觉效果！
        </h3>
    </div>
    <div class="main">
        <div class="dzone" id="dzone">
            <p class="p1">
                <i class="fa fa-upload"></i>拖放图片至此 或 点击添加图片
            </p>
            <p class="p2">
                只支持上传PNG格式 最多一次20张 每张5M以下
            </p>
        </div>

        <ul class="items" id="items">
            <li class="item">
                <div class="line">
                    <div class="left">
                        <span class="name">mobile.png</span>
                        <span class="time little gray">4次</span>
                    </div>
                    <div class="mid">
                        <span class="before little gray">900k</span>
                        <div class="process">
                            <div class="bar"></div>
                        </div>
                        <span class="after little gray">100k</span>
                        <span class="shrink little gray">-45%</span>
                    </div>

                    <div class="right little">
                        <i class="fa fa-backward"></i>
                        <i class="fa fa-forward"></i>
                        <a class="fa fa-download"></a>
                        <i class="fa fa-eye"></i>
                    </div>
                </div>

                <div class="compare">
                    <div class="left">
                        <h4>原图</h4>
                        <div class="img-wrapper">
                            <img src="images/bear.jpg" />
                        </div>
                    </div>
                    <div class="right">
                        <h4>压缩之后的图</h4>
                        <div class="img-wrapper">
                            <img src="images/loading.jpg" />
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <script type="template" id="itemTpl">
        <li class="item">
            <div class="line">
                <div class="left">
                    <span class="name">mobile.png</span>
                    <span class="time little gray">4次</span>
                </div>
                <div class="mid">
                    <span class="before little gray">900k</span>
                    <div class="process">
                        <div class="bar"></div>
                    </div>
                    <span class="after little gray">100k</span>
                    <span class="shrink little gray">-45%</span>
                </div>

                <div class="right little">
                    <i class="fa fa-backward"></i>
                    <i class="fa fa-forward"></i>
                    <i class="fa fa-download"></i>
                    <i class="fa fa-eye"></i>
                </div>
            </div>

            <div class="compare">
                <div class="left">
                    <h4>原图</h4>
                    <div class="img-wrapper">
                        <img src="images/bear.jpg" />
                    </div>
                </div>
                <div class="right">
                    <h4>压缩之后的图</h4>
                    <div class="img-wrapper">
                        <img src="images/bear.jpg" />
                    </div>
                </div>
            </div>
        </li>
    </script>
    <script src="static/js/jquery-2.1.4.js"></script>
    <script src="static/js/main.js"></script>
    <script>
        Array.prototype.forEach.call(document.querySelectorAll(".compare .img-wrapper"),function(e, i){
            e.addEventListener("scroll", function(e){
                var t = this.scrollTop,
                    l = this.scrollLeft,
                    p = this.parentElement,
                    other = p.nextElementSibling ? p.nextElementSibling : p.previousElementSibling,
                    s = other.querySelector(".img-wrapper");
                s.scrollTop = t;
                s.scrollLeft = l;
            });
        })
    </script>
</body>
</html>