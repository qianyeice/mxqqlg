/*微信素材管理JS*/
$(function () {
    var count = 1;
    var localJson = [];
    var active = 1;
    var mid = 0;
    if ($id!=''){
        var type = 1;//默认 1图文消息 2 表示文本消息 3 图片消息 4 视频消息
        type=$type
    }else {
        var type = 1;//默认 1图文消息 2 表示文本消息 3 图片消息 4 视频消息
    }
//主素材数组
    var first=[];
//添加对象，title标题，pic图片，url路径，desc编辑
    first= {title:"",pic:"",url:"",desc:"",file:""};

    if ($id!=''){
        $.post('?s=admin/Materialadd/yibu',{id:$id},function (data) {
            $("ul.tab li.active").removeClass("active");
            var act=document.getElementById('act'+$type).getAttribute('class')
            acr=act.concat('active')
            document.getElementById('act'+$type).setAttribute('class',acr)
            var index = $type-1;
            $(".msg-wrapper div.msg").hide();
            $(".msg-wrapper div.msg").eq(index).show();
            $arr=eval(data);
            if ($arr===undefined){

            }else {
                first['title']=$arr[0]['title'];
                first['url']=$arr[0]['url'];
                first['desc']=$arr[0]['desc'];
                first['file']=$arr[0]['file'];
                $('#title').val($arr[0]['title']);
                $('#url').val($arr[0]['url'])
                $('#desc').val($arr[0]['desc'])
                $("#msgitem1").find(".msg-img").html('<img src="'+first.file+'"/>');
//            $arr['0']='null'

                for (var nn=1;nn<$arr.length;nn++){
                    var num=nn+1;
                    //检查对象是否存在
                    if($("#msgitem"+num).length == 0){
                        var i= num-1;
//                    console.log(i)
                        if(!localJson[i]){
                            localJson[i] = {title:"",pic:"",url:"",desc:"",file:""};
                        }
                        localJson[i]={title:"",pic:"",url:"",desc:"",file:""}
                        localJson[i]['title']=$arr[i]['title']
                        localJson[i]['pic']=$arr[i]['pic']
                        localJson[i]['url']=$arr[i]['url']
                        localJson[i]['desc']=$arr[i]['desc']
                        localJson[i]['file']=$arr[i]['file']
                        var msgItem = '<li id="msgitem'+num+'" class="msg-item">'
                            +'<div class="msg-img"><i class="msg-img-bg">缩略图</i></div>'
                            +'<div class="msg-title"><span>标题</span></div>'
                            +'<div class="msg-handle">'
                            +'<a href="javascript:void(0);" class="edit icon-pencil" item="'+num+'"> 编辑</a>'
                            +'<a href="javascript:void(0);" class="delete icon-trash-o" item="'+num+'"> 删除</a>'
                            +'</div>'
                            +'</li>';
                        $("#msgadd").before(msgItem);
                        count = nn+1;
                    }
                    $("#msgitem"+num).find(".msg-title span").html(localJson[i]['title']);
                    $("#msgitem"+num).find(".msg-img").html('<img src="'+localJson[i]['file']+'"/>');
//                console.log(localJson[i])
                }

                // console.log($arr)
            }

        })
    }


    $(function(){
        $(document).click(function(){
            // alert('emotionBox')
            $(".emotionBox").hide();
        });
        $(".emotion").click(function(){
            alert('emotion');
            $(".emotionBox").show();
            return false;
        });
        $(".emotionBox .emotions_item span").click(function(){
            // console.log( $(".emotionBox .emotions_item span"))
            var emo = $(this).attr("data-title");
            $("#msg-text").insertContent(emo);
        });
        //选项卡
        $("ul.tab li").click(function(){
            $("ul.tab li.active").removeClass("active");
            type = $(this).attr("ty");
            $(this).addClass("active");
            // alert(type)
            // console.log($(this))
            var index = type-1;
            $(".msg-wrapper div.msg").hide();
            $(".msg-wrapper div.msg").eq(index).show();
            // console.log($(".msg-wrapper div.msg").eq(index))
        });
        //鼠标移动事件添加class名字
        $("#msg-content").on("mouseover","li",function(){
            // console.log($(this))
            $(this).addClass("item-active");
        });
        //鼠标移除事件移除class名字
        $("#msg-content").on("mouseout","li",function(){
            // console.log(123)
            $(this).removeClass("item-active");
        });
        //点击添加
        $("#msgadd").click(function(){
            // console.log(123)
            createItem(count+1);
        });
        //编辑器标题变动时实时更新数据
        $("#title").bind('input propertychange',function(){
            var num = active-1;
            $("#msgitem"+active).find(".msg-title span").html($(this).val());
            if (localJson[num]===undefined){
                first.title=$(this).val();
            }else {
                localJson[num].title = $(this).val();
            }
        });
        //编辑器链接变动，失去焦点时更新数据
        $("#url").blur(function(){
            var num = active-1;
            if (localJson[num]===undefined){
                first.url=$(this).val();
            }else {
                localJson[num].url = $(this).val();
            }

        });
        //编辑器描述变动，失去焦点时更新数据
        $("#desc").blur(function(){
            var num = active-1;
            if (localJson[num]===undefined){
                first.desc=$(this).val();
            }else {
                localJson[num].desc = $(this).val();
            }
        });
        //设置视频的类型
        function checkFileExturl(ext) {
            if (!ext.match(/.3gp|.rmvb|.flv|.wmv|.avi|.mkv|.mp4|.mp3|.wav|.swf/i)) {
                return false;
            }
            return true;
        }
        //设置图片的类型
        function checkFileExt(ext) {
            if (!ext.match(/.jpg|.gif|.png|.bmp/i)) {
                return false;
            }
            return true;
        }
        //图片更新
        $("#file").bind('input propertychange',function(){
            var tupian=document.getElementById('file')
            // console.log(tupian.files[0])
            var val=tupian.value
            //获取文件的后缀
            var fileExt = val.substring(val.lastIndexOf(".")).toLowerCase();
            // alert('你选择的文件大小' + (tupian.files[0].size / (1024*1024)).toFixed(1) + "mb");
            //图片大小
            var tusize=(tupian.files[0].size / (1024*1024)).toFixed(1)
            //判断图片的类型
            if (!checkFileExt(fileExt)) {
                alert("您上传的文件不是图片,请重新上传！");
                tupian.value = "";
                return;
            }else {
                //判断图片的大小
                if (tusize>2){
                    alert('你选择的文件太大有' + (tupian.files[0].size / (1024*1024)).toFixed(1) + "mb"+"请小于2mb");
                    tupian.value = "";
                }else {
                    var blob = URL.createObjectURL(tupian.files[0])
                    var num = active-1;
                    if (localJson[num]===undefined){
                        first.pic=blob
                        first.file=tupian.files[0]
                        $("#msgitem"+active).find(".msg-img").html('<img src="'+first.pic+'"/>');
                        // console.log(first)
                    }else {
                        localJson[num].pic = blob
                        localJson[num].file = tupian.files[0]
                        $("#msgitem"+active).find(".msg-img").html('<img src="'+localJson[num].pic+'"/>');
                        // console.log(localJson[num].file)
                    }
                }
            }
        });
        $("#picpic").bind('input propertychange',function(){
            var tupian=document.getElementById('picpic')
            var val=tupian.value
            //获取文件的后缀
            var fileExt = val.substring(val.lastIndexOf(".")).toLowerCase();
            // alert('你选择的文件大小' + (tupian.files[0].size / (1024*1024)).toFixed(1) + "mb");
            //图片大小
            var tusize=(tupian.files[0].size / (1024*1024)).toFixed(1)
            //判断图片的类型
            if (!checkFileExt(fileExt)) {
                alert("您上传的文件不是图片,请重新上传！");
                tupian.value = "";
                return;
            }else {
                //判断图片的大小
                if (tusize>2){
                    alert('你选择的文件太大有' + (tupian.files[0].size / (1024*1024)).toFixed(1) + "mb"+"请小于2mb");
                    tupian.value = "";
                }else {
                    var blob = URL.createObjectURL(tupian.files[0])
                    var num = active-1;
                    $("#msgImage").attr('src',blob);
                }
            }
        });
        //监控页面关闭事件，关闭的时候保存离线数据
        // $(window).unload(function() {
        //     //取得当前页面的内容
        //     var content = JSON.stringify(localJson);
        //     var testid = mid;
        //     if(content != '[]' || content != ''){
        //         content = content.replace(",null", "");
        //         //保存到离线缓存
        //         //如果是新增，保存到weixin
        //         window.localStorage.id = testid;
        //         if(mid == 0){
        //             window.localStorage.weixin = content;
        //         }
        //     }
        // });
        //编辑指定消息
        $("#msg-content").on("click",".edit",function(){
            $(this).addClass("test");
            var act = $(this).attr("item");
            active = act;
            var top = 0;
            if(act > 1){
                var index;
                index = $("#msgitem"+act).index();
                // console.log($("#msgitem"+act))
                top = (index-1)*81 + 180;
                $("#editor-desc").hide();
                $("#upload .tips").html("(小图建议200px*200px)");
            }else{
                $("#editor-desc").show();
                $("#upload .tips").html("(大图建议900px*500px)");
            }
            var i = act-1;
            //清空编辑器
            $("#url").val("");
            $("#desc").val("");
            //标题title
            if (localJson[i]===undefined){
                if(first.title){
                    $('#title').val(first.title)
                }else {
                    $('#title').val('')
                }
            } else  if(localJson[i].title){
                $("#title").val(localJson[i].title);
            }else{
                $("#title").val("")       }
            // 路径url
            if (localJson[i]===undefined){
                if(first.url){
                    $('#url').val(first.url)
                }else {
                    $('#url').val('')
                }
            } else  if(localJson[i].url){
                $("#url").val(localJson[i].url);
            }else{
                $("#url").val("");
            }
            //图片pic
            // if (localJson[i]===undefined){
            //     if(first.pic){
            //         $("#pic").html('<img src="'+first.pic+'" width="100px" />');
            //     }else {
            //         $("#pic").html("");
            //     }
            // } else  if(localJson[i].pic){
            //     $("#pic").html('<img src="'+localJson[i].pic+'" width="100px" />');
            // }else{
            //     $("#pic").html("");
            // }
            //编辑desc
            if (localJson[i]===undefined){
                if(first.desc){
                    $('#desc').val(first.desc)
                }else {
                    $('#desc').val('')
                }
            } else  if(localJson[i].desc){
                $("#desc").val(localJson[i].desc);
            }else{
                $("#desc").val("");
            }
            $(".edit_wrap").css("margin-top",top);
        })
        //删除指定消息
        $("#msg-content").on("click",".delete",function(){
            var act = $(this).attr("item");
            var i = act-1;
            count = count-1;
            localJson[i] = null;
            // delete localJson[i];
            $(this).parents(".msg-item").remove();
            if(act == active){
                // console.log(localJson)
                $("#editor-desc").show();
                $("#upload .tips").html("(大图建议900px*500px)");
                $(".edit_wrap").css("margin-top",0);
                if (localJson[0]==undefined){
                    $("#title").val(first.title);
                    $("#url").val(first.url);
                    $("#pic").html('<img src="'+first.pic+'" width="100px" />');
                    $("#desc").val(first.desc);
                }else {
                    $("#title").val(localJson[0].title);
                    $("#url").val(localJson[0].url);
                    $("#pic").html('<img src="'+localJson[0].pic+'" width="100px" />');
                    $("#desc").val(localJson[0].desc);
                }
            }
            //如果被删除消息在当前焦点元素上方，则重新计算编辑器焦点位置
            if(act<active){
                var index = active;
                index = $("#msgitem"+index).index();
                var top = 0;
                top = (index-1)*81 + 180;
                $(".edit_wrap").css("margin-top",top);
            }
            var len=localJson.length-1
            // console.log(len)
        })
        //绑定素材提交按钮
        $(".formbtn").click(function(){
            //$(this).next("input[type=file]").click();
            var xhr = new XMLHttpRequest();
            var formData = new FormData;
            //素材名称
            var title = $("#mat_title").val();
            //默认 1图文消息 2 表示文本消息 3 图片消息 4 视频消息
            var ty = type;
            //文本消息内容
            var msgtext = $("#msg-text").val();
            //图片路径
            var imgtext = $("#picpic");
            var hh=imgtext.val()
            // 图片的后缀
            var imghh = hh.substring(hh.lastIndexOf(".")).toLowerCase();
            //视屏标题
            var videoTitle = $("#video_title").val();
            //视屏描述
            var videoDesc = $("#video_desc").val();
            //视屏路径
            var videoUrl = $("#vidvid");
            var urllu=videoUrl.val()
            //视频后缀
            var urlurl=urllu.substring(urllu.lastIndexOf(".")).toLowerCase();
            //取得当前页面的内容
            var content = JSON.stringify(localJson);
            content = content.replace(",null", "");
            //第一个数组first
            var one=JSON.stringify(first);
            one=one.replace(",null","");
            // console.log(first['file'])
            //  var url = $(this).attr('url');
            if (title==''){
                alert('素材不能为空')
            }else {
                if (ty==1){
                    if (first['file']==''){
                        alert('封面没有图片')
                    }else {
                        for ($i=1;$i<localJson.length;$i++){
                            if (localJson[$i]===null){

                            } else {
                                if (localJson[$i]['file']==''){
                                    alert('第'+$i+'收缩图没有图片')
                                    return
                                }
                            }
                        }
                        imgtext=''
                        videoUrl=''
                        // $.post('?s=admin/materialadd/url',{title:title,type:ty,msgtext:msgtext,json:content,one:one,imgtext:imgtext,videotitle:videoTitle,videodesc:videoDesc,videourl:videoUrl},function(data){
                        //
                        // })
                        //素材名称
                        formData.append("title",title)
                        //传过去的状态
                        formData.append("type",ty)
                        //文本消息内容 2
                        formData.append("msgtext",msgtext)
                        //取得当前页面的内容的图片临时路径
                        // console.log(localJson)
                        for (var i=1;i<localJson.length;i++){
                            if (localJson[i]===null){
                                formData.append("file["+i+"]",'')
                            } else{
                                if (typeof localJson[i]['file']=="object"){
                                    formData.append("file["+i+"]",localJson[i]['file'])
                                }else {
                                    formData.append("file["+i+"]",localJson[i]['file'])
                                }

                            }
                        }
                        //取得当前页面的内容
                        formData.append('json',content)
                        //第一个数组first
                        formData.append("one",one)
                        //第一个数组first的临时路径
                        formData.append("fileone",first['file'])
                        // console.log(first['file'])
                        //图片路径
                        formData.append("imgtext",imgtext)
                        //视屏标题
                        formData.append("videotitle",videoTitle)
                        //视屏描述
                        formData.append("videodesc",videoDesc)
                        //视屏路径
                        formData.append("videourl",videoUrl)
                        if ($id!=''){
                            formData.append("id",$id)
                            xhr.open('POST', '?s=admin/materialadd/xiu');
                            xhr.send(formData);
                            xhr.onreadystatechange=function(){
                                if(xhr.readyState==4){
                                    if(xhr.status==200){
                                        $data=xhr. responseText
                                        if ($data==1){
                                            layui.use('layer', function(){
                                                var layer = layui.layer;
                                                layer.msg('修改成功');
                                                window.history.go(-1)
                                                // window.parent.location.href='?s=admin/Wechat/index';
                                                // parent.location.reload();
                                            });
                                        }
                                    }
                                }
                            }
                        }else {
                            xhr.open('POST', '?s=admin/materialadd/url');
                            xhr.send(formData);
                            xhr.onreadystatechange=function(){
                                if(xhr.readyState==4){
                                    if(xhr.status==200){
                                        $data=xhr. responseText
                                        if ($data==1){
                                            layui.use('layer', function(){
                                                var layer = layui.layer;
                                                layer.msg('添加成功');
                                                window.history.go(-1)
                                                // window.parent.location.href='?s=admin/Wechat/index';
                                                // parent.location.reload();
                                            });
                                        }
                                    }
                                }
                            }
                        }

                    }
                }else if (ty==2){
                    if (msgtext==''){
                        alert('文本消息不能为空')
                    }else {
                        imgtext=''
                        videoUrl=''
                        if ($id!=''){
                            $.post('?s=admin/materialadd/xiu',{id:$id,title:title,type:ty,msgtext:msgtext,json:content,one:one,videotitle:videoTitle,videodesc:videoDesc},function(data){
                                if (data==1){
                                    layui.use('layer', function(){
                                        var layer = layui.layer;
                                        layer.msg('修改成功');
                                        // parent.location.reload();
                                        window.history.go(-1)
                                        // window.location.href='?s=admin/Wechat/index';
                                    });
                                }
                            })
                        }else {
                            $.post('?s=admin/materialadd/url',{title:title,type:ty,msgtext:msgtext,json:content,one:one,videotitle:videoTitle,videodesc:videoDesc},function(data){
                                if (data==1){
                                    layui.use('layer', function(){
                                        var layer = layui.layer;
                                        layer.msg('添加成功');
                                        // parent.location.reload();
                                        window.history.go(-1)
                                        // window.location.href='?s=admin/Wechat/index';
                                    });
                                }
                            })
                        }

                    }
                }else if (ty==3){
                    if (imgtext[0].files[0]===undefined){
                        alert('图片信息不能为空')
                    }else if(!checkFileExt(imghh)){
                        alert("您上传的文件不是图片,请重新上传！");
                        imgtext.value = "";
                        return;
                    }else {
                        var imgdaxiao=(imgtext[0].files[0].size / (1024*1024)).toFixed(1);
                        if (imgdaxiao>2){
                            alert('你选择的文件太大有' + (imgtext[0].files[0].size / (1024*1024)).toFixed(1) + "mb"+"请小于2mb");
                            imgtext.value = "";
                        }else {
                            // var imgtext=URL.createObjectURL(imgtext[0].files[0]);
                            var imgtext=imgtext[0].files[0]
                            videoUrl=''
                            //素材名称
                            formData.append("title",title)
                            //传过去的状态
                            formData.append("type",ty)
                            //文本消息内容 2
                            formData.append("msgtext",msgtext)
                            //取得当前页面的内容
                            formData.append('json',content)
                            //第一个数组first
                            formData.append("one",one)
                            //图片路径
                            formData.append("imgtext",imgtext)
                            //视屏标题
                            formData.append("videotitle",videoTitle)
                            //视屏描述
                            formData.append("videodesc",videoDesc)
                            //视屏路径
                            formData.append("videourl",videoUrl)
                            if ($id!=''){
                                formData.append("id",$id)
                                xhr.open('POST', '?s=admin/materialadd/xiu');
                                xhr.send(formData);
                                xhr.onreadystatechange=function(){
                                    if(xhr.readyState==4){
                                        if(xhr.status==200){
                                            $data=xhr. responseText
                                            if ($data==1){
                                                layui.use('layer', function(){
                                                    var layer = layui.layer;
                                                    layer.msg('修改成功');
                                                    window.history.go(-1)
                                                    // window.parent.location.href='?s=admin/Wechat/index';
                                                    // parent.location.reload();
                                                });
                                            }
                                        }
                                    }
                                }
                            }else {
                                xhr.open('POST', '?s=admin/materialadd/url');
                                xhr.send(formData);
                                xhr.onreadystatechange=function(){
                                    if(xhr.readyState==4){
                                        if(xhr.status==200){
                                            $data=xhr. responseText
                                            if ($data==1){
                                                layui.use('layer', function(){
                                                    var layer = layui.layer;
                                                    layer.msg('添加成功');
                                                    window.history.go(-1)
                                                    // window.parent.location.href='?s=admin/Wechat/index';
                                                    // parent.location.reload();
                                                });
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else if (ty==4){
                    if (videoTitle==''){
                        alert('视频题目不能为空')
                    }else if(videoUrl[0].files[0]===undefined){
                        alert('视频信息不能为空')
                    }else if(videoDesc==''){
                        alert('视频描述不能为空')
                    }else if (!checkFileExturl(urlurl)){
                        alert("您上传的文件不是视频,请重新上传！");
                        videoUrl.value = "";
                        return;
                    }else {
                        var urlvid=(videoUrl[0].files[0].size/(1024*1024)).toFixed(1);
                        if (urlvid>10){
                            alert('你选择的文件太大有' + (videoUrl[0].files[0].size/(1024*1024)).toFixed(1) + "mb"+"请小于2mb");
                            videoUrl.value = "";
                        }else {
                            var videoUrl=videoUrl[0].files[0]
                            imgtext=''
                            // $.post('?s=admin/materialadd/url',{title:title,type:ty,msgtext:msgtext,json:content,one:one,imgtext:imgtext,videotitle:videoTitle,videodesc:videoDesc,videourl:videoUrl},function(data){
                            //
                            // })
                            //素材名称
                            formData.append("title",title)
                            //传过去的状态
                            formData.append("type",ty)
                            //文本消息内容 2
                            formData.append("msgtext",msgtext)
                            //取得当前页面的内容
                            formData.append('json',content)
                            //第一个数组first
                            formData.append("one",one)
                            //图片路径
                            formData.append("imgtext",imgtext)
                            //视屏标题
                            formData.append("videotitle",videoTitle)
                            //视屏描述
                            formData.append("videodesc",videoDesc)
                            //视屏路径
                            formData.append("videourl",videoUrl)
                            xhr.open('POST', '?s=admin/materialadd/url');
                            if ($id!=''){
                                formData.append("id",$id)
                                xhr.open('POST', '?s=admin/materialadd/xiu');
                                xhr.send(formData);
                                xhr.onreadystatechange=function(){
                                    if(xhr.readyState==4){
                                        if(xhr.status==200){
                                            $data=xhr. responseText
                                            if ($data==1){
                                                layui.use('layer', function(){
                                                    var layer = layui.layer;
                                                    layer.msg('修改成功');
                                                    window.history.go(-1)
                                                    // window.parent.location.href='?s=admin/Wechat/index';
                                                    // parent.location.reload();
                                                });
                                            }
                                        }
                                    }
                                }
                            }else {
                                xhr.open('POST', '?s=admin/materialadd/url');
                                xhr.send(formData);
                                xhr.onreadystatechange=function(){
                                    if(xhr.readyState==4){
                                        if(xhr.status==200){
                                            $data=xhr. responseText
                                            if ($data==1){
                                                layui.use('layer', function(){
                                                    var layer = layui.layer;
                                                    layer.msg('添加成功');
                                                    window.history.go(-1)
                                                    // window.parent.location.href='?s=admin/Wechat/index';
                                                    // parent.location.reload();
                                                });
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        });

        /*向焦点位置添加内容*/
        // $.fn.insertContent = function(myValue, t) {
        //
        //     var $t = $(this)[0];
        //
        //     if (document.selection) { //ie
        //         this.focus();
        //         var sel = document.selection.createRange();
        //         sel.text = myValue;
        //         this.focus();
        //         sel.moveStart('character', -l);
        //         var wee = sel.text.length;
        //         if (arguments.length == 2) {
        //             var l = $t.value.length;
        //             sel.moveEnd("character", wee + t);
        //             t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length);
        //
        //             sel.select();
        //         }
        //     } else if ($t.selectionStart || $t.selectionStart == '0') {
        //         var startPos = $t.selectionStart;
        //
        //         var endPos = $t.selectionEnd;
        //         var scrollTop = $t.scrollTop;
        //         $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
        //         this.focus();
        //         $t.selectionStart = startPos + myValue.length;
        //         $t.selectionEnd = startPos + myValue.length;
        //         $t.scrollTop = scrollTop;
        //         if (arguments.length == 2) {
        //
        //             $t.setSelectionRange(startPos - t, $t.selectionEnd + t);
        //             this.focus();
        //         }
        //     }
        //     else {
        //         this.value += myValue;
        //         this.focus();
        //     }
        // };
    });
//
// //初始化图文素材
// function init(obj,act,id,t){
//     type = t;
//     console.log(type);
//     mid = id;
//     for(var i=0;i<obj.length;i++){
//         var num = i+1;
//         //localJson[i] = {title:"",pic:"",url:"",desc:""};
//         localJson[i] = obj[i];
//         if(localJson[i]!=null){
//             //检查元素是否存在
//             createItem(num);
//             if(obj[i].title){
//                 $("#msgitem"+num).find(".msg-title span").html(obj[i].title);
//             }else{
//                 $("#msgitem"+num).find(".msg-title span").html("标题");
//             }
//             if(obj[i].pic){
//                 $("#msgitem"+num).find(".msg-img").append('<img src="'+obj[i].pic+'"/>');
//             }
//             if(num==active){//焦点在哪一张
//                 var top = 0;
//                 active = act;
//                 if(num > 1){
//                     top = (num-2)*81 + 180;
//                 }
//                 $(".edit_wrap").css("margin-top",top);
//                 $("#title").val(obj[i].title);
//                 if(obj[i].pic){
//                     $("#pic").append('<img src="'+obj[i].pic+'" width="100px" />')
//                 }
//                 $("#url").val(obj[i].url);
//                 $("#desc").val(obj[i].desc);
//             }
//         }
//     }
// }

//创建新编辑项
    function createItem(num){
        //检查是否超过10条数据
        if($(".msg-item").length < 10){
            //检查对象是否存在
            if($("#msgitem"+num).length == 0){
                var i= num-1;
                console.log(i)
                if(!localJson[i]){
                    localJson[i] = {title:"",pic:"",url:"",desc:"",file:""};
                }
                var msgItem = '<li id="msgitem'+num+'" class="msg-item">'
                    +'<div class="msg-img"><i class="msg-img-bg">缩略图</i></div>'
                    +'<div class="msg-title"><span>标题</span></div>'
                    +'<div class="msg-handle">'
                    +'<a href="javascript:void(0);" class="edit icon-pencil" item="'+num+'"> 编辑</a>'
                    +'<a href="javascript:void(0);" class="delete icon-trash-o" item="'+num+'"> 删除</a>'
                    +'</div>'
                    +'</li>';
                $("#msgadd").before(msgItem);
                count = count+1;
            }
        }else{
            alert("最多允许添加10条");
        }
    }

// $(function () {
//     $('#tijiao').click(function () {
//        if ($('#mat_title').val()!=''){
//
//        }else {
//             alert('素材不能为空')
//        }
//     })

    // })

})
