/**
 * Created by DELL on 2018/4/25.
 */

$(function () {
    //点击全选中
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
        layer.confirm('是否确认删除选中的用户？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type:"post",
                dataType:"json",
                url:"?s=admin/Initiator/delet",
                data:{
                    idd:con
                },
                success:function(){
                    window.location.href="?s=admin/Initiator/index";
                }
            })
        }, function(){
            layer.closeAll();
        });
    });


    //发起人搜索查询功能
   $(".bg-sub").click(function(){

        $content=$('.hd-input').val();
        $(".bg-sub").attr("href","?s=admin/Initiator/select&content="+$content);

    });

    //员工搜索查询功能
    $(".mxstaff").click(function(){

        $conten=$('.hd-input').val();
        $(".mxstaff").attr("href","?s=admin/Staff/select&conten="+$conten);

    });
//合伙人搜索查询功能
    $(".mxsubb").click(function(){

        $conten=$('.hd-input').val();
        $(".mxsubb").attr("href","?s=admin/Partner/select&conten="+$conten);

    });

    //授权通过申请
    $(".impower").click(function(){
        idd=$(this).attr("idd");
        layer.confirm('是否确认通过该申请？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type:"post",
                dataType:"json",
                url:'?s=admin/Initiator/imxiu',
                data:{
                    id:idd
                },
                success:function(){
                }
            });
        }, function(){
            layer.closeAll();
        });
    });

    //添加操作
    $('.yin').click(function () {
        layer.open({
            type: 2,
            title: '修改用户的信息',
            shadeClose: true,
            shade: 0.7,
            maxmin: true, //开启最大化最小化按钮
            area: ['300px', '250px'],
            content: '?s=admin/Initiator/updata',

        });

    })
    //修改
    $('.xiugai').click(function () {

       layer.open({
            type: 2,
            title: '修改用户的信息',
            shadeClose: true,
            shade: 0.7,
            maxmin: true, //开启最大化最小化按钮
            area: ['300px', '170px'],
            content: '?s=admin/Initiator/update&id='+$(this).attr("idd"),

        });
    })
})


$(function () {
    //删除
    $('.shanchu').click(function () {
        nu=$(this).attr("id");
        layer.open({
            type: 1,
            title: '是否确认删除该用户',
            shadeClose: true,
            shade: 0.7,
            maxmin: true, //开启最大化最小化按钮
            area: ['300px', '150px'],
            content: '<button class="usert layui-btn layui-btn-normal" style="margin:30px;margin-left:60px;" id='+nu+'>确认</button> ' +
            '<button class="userf layui-btn" style="background-color:grey;">取消</button>',
        });
    });

    //删除中的确认操作

    $(document).on("click",".usert",function(){
        number=$(this).attr("id");
        $.ajax({
            type:"post",
            dataType:"json",
            url:'?s=admin/Initiator/delete',
            data:{
                id:number
            },
            success:function(){
                window.parent.location.reload();
            }
        })
    });

    //删除中的取消操作
    $(document).on("click",".userf",function(){
        layer.closeAll();
    })


//授权功能中用户进行通过操作
$(".thnumber").click(function(){
    arr=[];
    var i=-1;
    $("input:checkbox[name='id']:checked").each(function() { // 遍历name=id的多选框
        i++;
        arr[i]= $(this).val();  // 每一个被选中项的值
    });
    con=arr.join(",");

    layer.confirm('是否确认通过选中用户的申请？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.ajax({
            type:"post",
            dataType:"json",
            url:'?s=admin/Initiator/imxiu',
            data:{
                id:con
            },
            success:function(){
                window.location.reload();
            }
        });
    }, function(){
        layer.closeAll();
    });
});


$(".qhnumber").click(function(){
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
            url:"?s=admin/Partner/delet",
            data:{
                idd:con
            },
            success:function(){
                window.location.href="?s=admin/Partner/index";
            }
        })
    }, function(){
        layer.closeAll();
    });
});

$(".rhnumber").click(function(){
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
            url:"?s=admin/Staff/delet",
            data:{
                idd:con
            },
            success:function(){
                window.location.href="?s=admin/Staff/index";
            }
        })
    }, function(){
        layer.closeAll();
    });
});
});