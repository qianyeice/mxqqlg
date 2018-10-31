$(function () {
    close()
})
/**
 * 取消关闭窗口
 */
function close() {
    $('#closebtn').click(function () {
        parent.layer.close(index)
    })
}
/**
 * 单修改状态
 * @paramurl
 */
function modify() {
    var index=parent.layer.getFrameIndex(window.name)
    $('#okbtn').click(function () {
        var status=$("input[type='radio']:checked").val();
        var text =$("#textarea").val();
        var id=$('#refund_id').val();

        $.ajax({
            type:"post",
            url:"?s=admin/Retreating/ajax_handle",
            data:{'type':status,'text':text,'id':id},
            success:function(data){
                if(data.type==1 || data.type==2){
                    layer.alert(data.lang, {icon: 5, title: "提示"});
                    refresh(index)
                }else {
                    layer.alert(data.lang);
                    refresh(index)
                }
            },
            error:function(){
                alert("操作失败");
            }
        });

        //if(status==1){
        //    $.post('?s=admin/Retreating/ajax_handle',{'type':status,'text':text,'id':id},function (data) {
        //        if(data.type==1){
        //            layer.alert(data.lang, {icon: 5, title: "提示"});
        //            refresh(index)
        //        }else {
        //            layer.alert(data.lang);
        //            refresh(index)
        //        }
        //    })
        //}else{
        //    layer.alert('没更改');
        //}
    })
}
/**
 * 确认状态
 * @paramid需要id
 * @paramurl传递路径
 */
function confirm(ten,url) {
    $('#okbtn').click(function () {
           ten.msg=$('#msgg').val()
        $.post(url,ten,function (data) {
            if(data.type==1){
               layer.alert("成功");
               refresh(index)
            }else {
               layer.alert("请检查网络");
               refresh(index)
            }
        })
    })
}
/**
 * f封装弹出窗口
 * @param spot 点击ID
 * @param url 路径
 */
function wicket(spot,url,width,height) {
    $('#'+spot).click(function () {
        layer.open({
            type: 2,
            area: [width+'px', +height+'px'],
            fixed: false, //不固定
            maxmin: true,
            content: url
        });
    })
}
/**
 * 删除提醒
 * @param id 删除ID
 * @param url 路径
 */
function del(id,url) {
    layer.confirm('你是否确定删除？', {
        btn: ['确认','取消'] //按钮
    }, function(){
        $.post(url,{'id':id},function (data) {
            console.log(data);
            if(data.type==1){
                layer.alert(data.lang, {icon: 5, title: "提示"});
                refresh(index)
            }else {
                layer.alert(data.lang);
                refresh(index)
            }
        })
    }, function(){
        layer.msg('也可以这样', {
            time: 20000, //20s后自动关闭
            btn: ['明白了', '知道了']
        });
    });
}

/**
 * 关闭窗口，刷新父级页面
 * @param index
 */
function refresh(index) {
    setTimeout(function () {
        parent.layer.close(index)
        window.parent.location.reload();
    },2000)
}



