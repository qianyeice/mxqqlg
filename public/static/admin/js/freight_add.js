/**
 * Created by DELL on 2018/5/7.
 */
$(function(){

//    全选

$("#check-all").click(function(){

    if($(this).attr("checked")){

        $("input:checkbox").attr("checked","checked");

    }else{

        $("input:checkbox").removeAttr("checked");
    }
});
});

function editing(id) {
    window.location.href = '?s=admin/freight_template_add/index?id=' + id;
}

function removes(id) {
    layer.confirm('你是否确定删除？', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.post('?s=admin/freight/deletes', {'id': id}, function (data) {
                if (data.type == 1) {
                    layer.alert(data.lang, {icon: 6, title: "提示"});
                    location_s();
                } else {
                    layer.alert(data.lang);
                    location_s();
                }
            })
        }
    );
}

function location_s() {
    setInterval(function () {
        window.location.href = '?s=admin/freight/index'
    }, 2000)
}

function is_deletes() {
    layer.confirm('你是否确定删除？', {
        btn: ['确认', '取消'] //按钮
    }, function () {
        $i = 0;
        $array = Array();
        $.each($('input:checkbox'), function () {
            $input_lenght = $('input:checkbox').length;
            $This_input = $('input[type=checkbox]:checked').length;
            if (this.checked) {
                $array.push($(this).val());
                if ($array.length == $This_input) {
                    // $This_input：当前选中个数
                    // $array：当前选中的id
                    add_database($This_input, $array);
                }
            } else {
                $i++;
                if ($i == $input_lenght) {
                    layer.msg('请选择');
                    location_s();
                }
            }
        });
    });
}

function add_database($lenghts, $array) {
    $.post('?s=admin/freight/batch_delete', {'lenghts': $lenghts, 'array': $array}, function (data) {
        if (data.type == 1) {
            layer.alert(data.lang, {icon: 6, title: "提示"});
            location_s();
        } else {
            layer.alert(data.lang);
            location_s();
        }
    })
}

