/**
 * Created by DELL on 2018/5/5.
 */
$(document).ready(function () {
    $(".ico_up_rack").click(function () {
        $(".ico_up_rack").toggleClass("cancel");
    });
});

$('document').ready(function () {
    var index = $(".cliadd").html();
    var num=1;
    var xias = $(".newzhi").html();
    $("#addbut").click(function () {
//            var num = $("div.key-item div.sku_lists").size();
//            var num=new Date().getTime();
        num++
        var re = new RegExp('id1', "g");

        var i=num;
        var new_item  = index.replace(re, 'id'+i);
        //console.log(new_item);

//            var mon = 'popedit'+i;
//            //console.log(mon);
//            $("#popedit1").attr("id",mon);
//console.log(i);
//            var mens = new RegExp('ids1',"g");
//            var stes = xias.replace(mens,'ids'+i);

//            $("#mon").click(function () {
//                console.log(mon);
//                layer.open({
//                    type:2,
//                    title: '回复',
//                    //shadeClose: true,
//                    skin: 'layui-layer-lan',
//                    shade: 0.7,
//                    area: ['681px', '430px'],
//                    fixed: false, //不固定
//                    maxmin: true,
//                    content: 'http://api.mxqqlg.com/index.php?s=admin/Commoditytypetck/index',
//                    success: function(layero, index){
//                        var body = layer.getChildFrame('body', index);
//                        var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
//
//                        body.find('.playdis').val();
//                        //console.log(ids);
//                        //console.log(iframeWin);
//
//                    }
//                });
//            });

        $(".cliadd").append(new_item);
    });
    var xxx = $(".tr").eq(1).attr("idid");
    console.log(xxx);

    $(".cliadd").on("change",".kuang",function () {
        var a=$(this).val();
        var xiabiao=$(this).parent().parents(".tr").index();
        console.log(xiabiao);
//            $().val(xiaobiao);
        if(a=='2'){
            $(".dinra").eq(xiabiao).addClass("hidden");
            $(".putin").eq(xiabiao).removeClass("hidden");
            $(".strings").eq(xiabiao).html('');
        }else {
            $(".putin").eq(xiabiao).addClass("hidden");
            $(".dinra").eq(xiabiao).removeClass("hidden");
        }
    });
});



$(".newzhi").click(function () {

    layer.open({
        type:2,
        title: '回复',
        //shadeClose: true,
        skin: 'layui-layer-lan',
        shade: 0.7,
        area: ['681px', '430px'],
        fixed: false, //不固定
        maxmin: true,
        content: '?s=admin/Commoditytypetck/index',
//                    success: function(layero, index){
//                        var body = layer.getChildFrame('body', index);
//                        var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
//
//                        body.find('.playdis').val();
//                        //console.log(ids);
//                        //console.log(iframeWin);
//
//                    }
    });
});

$(document).ready(function () {
    $("#submit").click(function () {

        var id = $("input[name='id']").val();
        var name = $("input[name='name']").val();
        var status = $("input[name='status']:checked").val();
        var text = $("input[name='typeson[name]']").val();
           // console.log(id);
           // console.log(name);
           // console.log(status);

        var checkid = [];
        $("input[name='text']:checked").each(function (e) {
            checkid[e] = $(this).val();
        });
        var chek = checkid.join(",");
//            console.log(chek);
        var lower = [];
        var low = document.getElementsByClassName('.cliadd');
        var lenggth = low.length;
        $.ajax({
            type:"post",
            url:"?s=admin/Commoditytypesetting/save_ajax",
            data:{id:id,name:name,status:status,spec_id:chek,text:text},
            success:function (data) {
                alert('成功');
                window.location.href="?s=admin/commoditytype/init";
            },
            error:function (data) {
                alert('失败');
            }
        });
    });
});
