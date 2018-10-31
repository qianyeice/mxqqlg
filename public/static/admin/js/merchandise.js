$(".delet").click(function() {
    con=$(this).attr("name");
    layer.confirm('是否确认删除该主图？', {
        btn: ['确定', '取消'] //按钮
    }, function () {
        $.ajax({
            type: "post",
            dataType: "json",
            url: "?s=admin/Merchandiseatlas/delet",
            data: {
                id: con
            },
            success: function () {
                window.location.reload();
            }
        })
    }, function () {
        layer.closeAll();
    });
});
$(".dele").click(function(){
    con=$(this).attr("name");
    arr=$(this).attr('idd');
    layer.confirm('是否确认删除该规格图片？', {
        btn: ['确定', '取消'] //按钮
    }, function () {
        $.ajax({
            type: "post",
            dataType: "json",
            url: "?s=admin/Merchandiseatlas/dele",
            data: {
                id: con,
                idd:arr
            },
            success: function () {
                window.location.reload();
            }
        })
    }, function () {
        layer.closeAll();
    });
});
$(".guige").click(function(){
    if($(".xian").css("display")=="none"){
        $(this).css("background-color","#52E0F3");
        $(".xian").css("display","block")
    }else{
        $(this).css("background-color","white");
        $(".xian").css("display","none")
    }

});
$(".file").change(function(){
    var objUrl = getObjectURL(this.files[0]);//临时路径
    if (objUrl)
    {
        $(".img0").last().attr("src", objUrl);
        $(".tu").removeClass("hide");

        var merch = $(".tu").html();
//            $(".tuu").append('<div class="box hide tu" id="'+'WU_FILE_0'+'">'+merch+'</div>');
        var aa=[];
        var img = $(".img0").length-1;
        for(var i=0;i<=img-1;i++){
            aa.push(img[i].src);
        }
    }
}) ;

$(".mfile").change(function(){
    var objUrl = getObjectURL(this.files[0]);//临时路径
    var photo=$(this).attr("idd");
    var pot=".pp-"+photo;
    photo=".p-"+photo;
    var phot=$(this).attr("itt");
    phot=".p-"+phot;
    if (objUrl)
    {
        $(pot).attr("src", objUrl);
        $(phot).removeClass("hide");
        var merch = $(phot).html();
        $(photo).append('<div class="box hide " id="'+'WU_FILE_0'+'">'+merch+'</div>');

        var aa=[];
        var img = $(pot).length-1;
        for(var i=0;i<=img-1;i++){
            aa.push(img[i].src);
        }

    }
}) ;
//建立一個可存取到該file的url
function getObjectURL(file)
{
    var url = null ;
    if (window.createObjectURL!=undefined)
    { // basic
        url = window.createObjectURL(file) ;
    }
    else if (window.URL!=undefined)
    {
        // mozilla(firefox)
        url = window.URL.createObjectURL(file) ;
    }
    else if (window.webkitURL!=undefined) {
        // webkit or chrome
        url = window.webkitURL.createObjectURL(file) ;
    }
    return url ;
}