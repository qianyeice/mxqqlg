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
$(".li_delete").click(function(){
    cont=$(this).attr("li_id");
    layer.confirm('是否确认删除选中的商品？', {
        btn: ['确定','取消'] //按钮
    }, function() {
        $.ajax({
            type: "post",
            dataType: "json",
            url: "?s=admin/Productall/delet",
            data: {
                id: cont
            },
            success: function () {
                window.location.href = "?s=admin/Productall/index";
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
$(".mnumber").click(function(){
    arr=[];
    var i=-1;
    $("input:checkbox[name='id']:checked").each(function() { // 遍历name=id的多选框
        i++;
        arr[i]= $(this).val();  // 每一个被选中项的值
    });
    con=arr.join(",");
    layer.confirm('是否确认删除选中的商品？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.ajax({
            type:"post",
            dataType:"json",
            url:"?s=admin/Productall/delet",
            data:{
                id:con
            },
            success:function(){
                window.location.href="?s=admin/Productall/index";
            }
        })
    }, function(){
        layer.closeAll();
    });
});

$(function(){

    $("#fend").click(function(){
        $("#fenlie").removeClass('hidden');
    });
});
