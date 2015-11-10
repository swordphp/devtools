//util
var Util = (function(){
    return {
        /*
         * data:
         *   url:
         *   type: post | get, //默认post
         *   data: {
         *       file: file,
         *       fieldName:field
         *   },
         *   progress: fn,
         *   success: fn,
         *   error: fn
         * */
        uploadFile: function (data) {
            if(!data || !data.url || !data.data){
                throw "uploadFile error";
            }
            var formData = new FormData(),
                tmpData = data.data;

            for(var d in tmpData) {
                if(tmpData.hasOwnProperty(d)) {
                    formData.append(d, tmpData[d]);
                }
            }

            var xhr = new XMLHttpRequest();
            var type = data.type ? data.type : "POST";
            xhr.open(type, data.url);
            data.start && (xhr.addEventListener("loadstart", data.start));
            data.progress && (xhr.upload.addEventListener("progress", data.progress));
            (data.success || data.error )&& (xhr.addEventListener("load", function() {
                if( this.status === 200 ){
                    if(data.success) {
                        var res = JSON.parse(this.responseText);
                        data.success.call(this, res);
                    }
                } else {
                    data.error && data.error.call(this);
                }

            }));
            data.error && (xhr.addEventListener("error", data.error));
            xhr.send(formData);
        }
    }
})();

//拖拽区域
(function(){
    $("#dzone").on("click", function(e){
        $("#file").trigger("click");
    });

    $("#dzone").on("dragover", function(e) {
        e.preventDefault();
    });
    $("#dzone").on("drop", function(e) {
        e.preventDefault();
        app.appendFiles(e.originalEvent.dataTransfer.files);
    });
    //文件控件
    $("#file").on("change", function(e){
        var files = this.files;
        app.appendFiles(files);
    });
})();

//app
var app = (function(){
    var $items = $("#items"),
        maps = {};

    function Item(data) {
        this.id = data.id;
        this.originLocalFile = data.file;
        this.stack = [];
        this.curPlayIndex = 0;
    }

    Item.prototype = {
        init: function(){
            var me = this,
                $tpl = $($("#itemTpl").html());
            $tpl.prop("id", me.id);
            me.$me = $tpl;
            $items.append($tpl);
        },
        setData: function(data) {
            var me = this,
                $me = me.$me;
            data.name && ($me.find(".name").html(data.name));
            data.time && ($me.find(".time").html(data.time));
            data.before && ($me.find(".before").html(data.before));
            data.after && ($me.find(".after").html(data.after));
            data.shrink && ($me.find(".shrink").html(data.shrink));
        },
        wait: function() {
            var $me = this.$me;
            $me.addClass("waiting");
            $me.find(".compare .right img").prop("src", "../images/loading.jpg");
        },
        next: function() {

        },
        prev: function() {

        }
    }

    function attachEvents(){

    }
    return {
        start: function(){

        },
        appendFiles: function(files) {
            var i = 0,
                len = files.length;
            for(i = 0; i < len; i++) {
                var data = {
                    id: "item" + (new Date().getTime()),
                    file: files[i]
                };
                var tmp = maps[data.time] = new Item(data);
                tmp.init();
            }
        }
    }
})();

app.start();