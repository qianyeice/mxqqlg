//关闭提示操作：

$("#show-tip").click(function(){
    num=$(this).html();
    if(num=="关闭操作提示"){
        $(".tips-txt").css("display","none");
        $(this).html("打开操作提示")
    }else{
        $(".tips-txt").css("display","block");
        $(this).html("关闭操作提示")
    }

});
//单项删除
$(".delete").click(function(){
    cont=$(this).attr("idd");
    layer.confirm('是否确认永久删除选中的商品？', {
        btn: ['确定','取消'] //按钮
    }, function() {
        $.ajax({
            type: "post",
            dataType: "json",
            url: "?s=admin/Productrecycle/delet",
            data: {
                id: cont
            },
            success: function () {
                window.location.href = "?s=admin/Productrecycle/index";
            }
        })
    })
});

//全选
$("#check-all").click(function(){

    if($(this).attr("checked")){

        $("input:checkbox").attr("checked","checked");

    }else{

        $("input:checkbox").removeAttr("checked");
    }
});

//选中的用户进行删除操作
$(".number").click(function(){
    arr=[];
    var i=-1;
    $("input:checkbox[name='id']:checked").each(function() { // 遍历name=id的多选框
        i++;
        arr[i]= $(this).val();  // 每一个被选中项的值
    });
    con=arr.join(",");
    if(con==""){
        layer.msg("请先选择删除对象！")
    }else {
        layer.confirm('是否确认永久删除选中的用户？', {
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "?s=admin/Productrecycle/delet",
                data: {
                    id: con
                },
                success: function () {
                    window.location.href = "?s=admin/Productrecycle/index";
                }
            })
        }, function () {
            layer.closeAll();
        });
    }
});

$(function(){
    $(".live").click(function(){
        count=$(this).attr("idd")
        layer.confirm('是否确认恢复改商品？', {
            btn: ['确定','取消'] //按钮
        }, function() {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "?s=admin/Productrecycle/live",
                data: {
                    id: count
                },
                success:function(){
                    window.location.href="?s=admin/Productrecycle/index";
                }
            })
        })
    })
});
