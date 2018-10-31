/**
 * Created by DELL on 2018/5/2.
 */


$(function(){
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
    //点击全选中
    $("#check-all").click(function(){

        if($(this).attr("checked")){

            $("input:checkbox").attr("checked","checked");

        }else{

            $("input:checkbox").removeAttr("checked");
        }
    });

    //选中的用户进行删除操作
    $("#delet").click(function(){

        arr=[];
        var i=-1;
        $("input:checkbox[name='id']:checked").each(function() { // 遍历name=id的多选框
            i++;
            arr[i]= $(this).val();  // 每一个被选中项的值
        });
        con=arr.join(",");
        if(con==""){
            layer.msg("请先选择删除对象！")
        }else{
        layer.confirm('是否确认删除选中的用户？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type:"post",
                dataType:"json",
                url:"?s=admin/Brand/cutall",
                data:{
                    idd:con
                },
                success:function(){
                    window.location.href="?s=admin/Brand/index";
                }
            })
        }, function(){
            layer.closeAll();
        });
        }
    });

});


function cut(id) {
    layer.open({
        content: '确定删除？'
        ,btn: ['确定', '取消']
        ,area: ['250px', '180px']
        ,yes: function(index, layero){
            //按钮【按钮一】的回调
            $.post('?s=admin/brand/cut',{id:id},function (data) {
                layer.msg(data,function () {
                    window.location.reload();
                },1000);
            })
        }});
}
