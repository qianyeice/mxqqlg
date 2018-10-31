/**
 * Created by DELL on 2018/5/9.
 */
$(function () {
    var array = [];
    //all单选框
    $('#check-all').live('click', function () {
        var judge = document.getElementById("check-all").checked;
        if (judge) {
            for (var i = 1; i < $(':checkbox').length; i++) {
                $(':checkbox')[i].checked = true;
                array[i] = $(':checkbox').eq(i).val();
            }
        } else {
            for (var i = 1; i < $(':checkbox').length; i++) {
                $(':checkbox')[i].checked = false;
            }
        }
    });

    //all删除
    $('[data-message]').live('click', function () {
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
            layer.confirm('是否确认删除选中的用户？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "?s=admin/Configuration/adelete",
                    data: {
                        id: con
                    },
                    success: function () {
                        layer.msg("删除成功！",function(){
                            window.location.reload();
                        })
                    }
                })
            }, function () {
                layer.closeAll();
            });
        }
    });

    //单选删除
    for (var i = 0; i < $('.adelete').length; i++) {
        $('.adelete').eq(i).click(function () {
            var id = $(this).attr('data-dj');
            var cyan = confirm($(this).attr('data-confirm'));
            if (cyan) {
                $.post('/?s=admin/Configuration/adelete', {id: id}, function (data) {
                    if (data>0) {
                        layer.msg("删除成功！",function(){
                            window.location.reload();
                        })
                    }
                })
            }
        })
    }
})
