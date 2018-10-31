$(function () {

    //商品类型选中操作
    $("#check-all").click(function () {
        var check=$("#check-all").prop("checked");
        if(check==true){
            $(".li_vo_id").prop({checked:true});
        }else{
            $(".li_vo_id").prop({checked:false});
        }
    });
    //选中的用户进行删除操作
    $(".mnumber").click(function(){
        arr=[];
        var i=-1;
        $("input:checkbox[name='id']:checked").each(function() { // 遍历name=id的多选框
            i++;
            arr[i]= $(this).val();  // 每一个被选中项的值
        });
        con=arr.join(",");
        layer.confirm('是否确认删除选中的用户？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type:"post",
                dataType:"json",
                url:"?s=admin/Commoditytype/Post_close",
                data:{
                    idd:con
                },
                success:function(){
                    layer.msg('删除成功!');
                    window.location.reload();
                }
            })
        }, function(){
            layer.closeAll();
        });
    });

    //商品类型开启关闭操作提示
    $("#show-tip").click(function (){
        var open=$(this).attr("data-open");
        if(open=="true"){
            $("#show-tip").html("开启操作提示");
            $("#show-tip").attr("data-open","false");
            $("#prompt").css("display","none");
        }else{
            $("#show-tip").html("关闭操作提示");
            $("#show-tip").attr("data-open","true");
            $("#prompt").css("display","block");
        }
    });

    //商品类型的启用及关闭
    $url = "?s=admin/Commoditytype/Post_open_close";

    $('.ico_up_rack').click(function () {
        var id = $(this).attr('data-id');
        var close = 0;
        if (!$(this).hasClass('cancel')) {
            close = 0;
        } else {
            close = 1
        }
        $.post($url, {'id': id, 'close': close}, function (data) {
            if (data.data == 1) {
                var element = $('a[data-id$="' + data.id + '"]');
                if (data.type == 0) {
                    element.addClass('cancel');
                } else {
                    element.removeClass('cancel');
                }
            }
        });
    });

    //商品类型的删除
    $('.delete').click(function () {
        var id= $(this).attr('data-id');
        layer.confirm($(this).attr('data-confirm'), {
            title:'提示',
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.post($url,{'id':id,'close':2},function (data) {
                if(data.data==1){
                    var win=window.location.href;
                    layer.msg('删除成功!');
                    window.location.href=win.substring(0,win.indexOf('&'))
                }else {
                    layer.msg('删除失败!');

                }
            });
        }, function () {
            layer.msg('已取消!');
        });
    });

});