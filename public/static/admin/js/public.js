function choose($obj,$id) {
    var o = new Object();
    o.obj = $obj;
    o.cateId=$id;
    //打开分类选择弹窗
    $('#choose-class').click(function () {
        getType();
        //判断添加类型 1为添加下级分类:父级分类已确定!
        if (type == 1) {
            layer.msg('添加下级分类模式自动确定添加分类的上一层级!');
        } else {
            $('#choose').removeClass('choose_hidden');
            var id = getQueryString('id') ? getQueryString('id') : 0;
            initPost(id, 1);
            $('.cateId').live('click', function () {
                if (!$(this).siblings().hasClass('cate_choose')) {
                    if ($(this).hasClass('cate_choose')) {
                        layer.msg('请勿重复选择!');
                    } else {
                        initPost($(this).attr('data-id'), 2)
                    }
                } else if ($(this).siblings().hasClass('cate_choose')) {
                    initPost($(this).attr('data-id'), 2)
                }
            });
        }
    });
//关闭分类选择弹窗
    $('button[i="close"]').click(function () {
        close()
    });

//关闭窗口
    function close() {
        $('#choose').addClass('choose_hidden');
    }

//确定操作并返回分类列表
    $('#sure_choose').click(function () {
        var cateName = $('#category_name').val();
        var cateId = $('input[name="id"]').val();
        var parentId = $('input[name="parent_id"]').val();
       var type= getType();
        if ($.trim(cateName) == '') {
            layer_prompt('分类名不能为空');
        } else {
            if (name == cateName && par == parentId) {
                layer_prompt('该分类未做修改');
            }
            if (cateId == '') {
                cateId = 0;
            }
            $.post(href('post_choose_update'), {'id': cateId, 'name': cateName, 'parent_id': parentId, 'type': type}, function (data) {
                layer_prompt(data['data']);
            });
        }
    });

//确认分类层级
    $('#okbtn').click(function () {
        var id = $('#data-id').attr('data-id');
        o.cateId.attr('value', id);
        o.obj.attr('value', $('#data-id').text());
        close()
    });
//退出层级选择
    $('#closebtn').click(function () {
        close()
    });

//获取url的type值赋予type
    var type= getType();


//layer提示层封装
    function layer_prompt($prompt) {
        layer.confirm($prompt + '!继续操作?', {
            title: false,
            closeBtn: 0,
            btn: ['继续', '退出'] //按钮
        }, function () {
            layer.msg('继续操作!', {icon: 1});
        }, function () {
            layer.msg('退出中!', {icon: 2, time: 1000, shade: [0.8, '#393D49']}, function () {
                window.history.go(-1)
            });
        });
    }

//向后台请求分类数据
    function initPost(id, type) {
        $.post('?s=admin/Commodity/post_choose_data', {'id': id, 'type': type}, function (data) {
            var chooseName = '';
            var choose = '';
            var html = '';
            $('.child').html('');
            if (typeof data[1] == 'string') {
                chooseName = data[0];
                choose = data[1];
                var arrays = [];
                var parentId = [];
                for (var i = 0; i < chooseName.length; i++) {
                    var array = [];
                    for (var l in chooseName[i]) {
                        array.push(chooseName[i][l]);
                    }
                    if (typeof array[1] == 'number') {
                        arrays.push(array[0]);
                        parentId.push(array[1])
                    } else {
                        arrays.push(array);
                    }
                }

                $('.border').eq(0).html('<a href="javascript:" data-id="0" class="focus  cateId"> 顶级分类 </a>');
                for (var i = 0; i < arrays.length; i++) {
                    for (var k = 0; k < arrays[i].length; k++) {
                        if (id == arrays[i][k]['id'] || arrays[i][k]['id'] == parentId[i]) {
                            html += '<a href="javascript:" class="focus cateId  cate_choose " data-id="' + arrays[i][k]['id'] + '"  >' + arrays[i][k]['name'] + '</a>';
                        } else {
                            html += '<a href="javascript:" class="cateId  " data-id="' + arrays[i][k]['id'] + '" >' + arrays[i][k]['name'] + '</a>';
                        }
                    }
                    $('.border').eq(i + 1).html(html);
                    html = '';

                }

            } else {
                for (var i = 0; i < data.length; i++) {
                    html += '<a href="javascript:" class="cateId  " data-id="' + data[i]['id'] + '" >' + data[i]['name'] + '</a>';
                }
                $('.child').eq(0).html(html);

            }
            var chooseString = '顶级分类:';
            var chooseArray = choose.split('>>');
            var String = '';
            for (var i = 0; i < chooseArray.length; i++) {
                if (i != chooseArray.length - 1) {
                    String += chooseArray[i] + '>>';
                } else {
                    String += chooseArray[i];
                }
            }
            $('#data-id').html(chooseString + String);
            $('#data-id').attr('data-id', id);
        });
    }


}
//获取url值
function getQueryString(name) {

    var result = window.location.search.match(new RegExp("[\?\&]" + name + "=([^\&]+)", "i"));

    if (result == null || result.length < 1) {
        return '';
    }
    return result[1];
}
//获取url的type值赋予type
function getType() {
    var type = getQueryString('type') ? getQueryString('type').indexOf('.')==-1?getQueryString('type'):getQueryString('type').substring(0, getQueryString('type').indexOf('.')):2;
    return type;
}
function href($url) {

    var win=window.location.href;
    win=win.substring(0,win.indexOf('index'))+$url;
    return  win;
}