$(function () {
    //商品分类的启用及关闭
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
    //商品分类的启用及关闭
    //商品分类的删除
    $('.delete').click(function () {
        var id = $(this).attr('data-id');
        layer.confirm($(this).attr('data-confirm'), {
            title: '提示',
            btn: ['确定', '取消'] //按钮
        }, function () {

            $.post($url, {'id': id, 'close': 2}, function (data) {
                if (data.data == 1) {
                    var win = window.location.href;
                    layer.msg('删除成功!');
                    window.location.href = win.substring(0, win.indexOf('&'))
                } else {
                    layer.msg('删除失败!');

                }
            });
        }, function () {
            layer.msg('已取消!');
        });
    });
    //商品分类的删除
    $url = href('post_open_close');
    $('.layui-layer-title').css({
        'background': '#427fb7',
        'color': '#fff',
    })
    $('.tree-ind-status').click(function () {
        var kk = $(this).parents().eq(2);
        var child = $('div[data-tree-parent-id=' + kk.attr('data-tree-id') + ']');
        if ($(this).hasClass('close')) {
            $(this).removeClass('close');
            $(this).addClass('open');
            if (child.length == 0) {
                var data_id = kk.attr('data-id');
                $.post(href('nextData'), {'id': data_id}, function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var children = kk.clone(true);
                        children.attr('data-tree-parent-id', children.attr('data-tree-id'));
                        var data_tree_parent_id = children.attr('data-tree-parent-id');
                        var obj = data[i];
                        children.attr('data-tree-id', data_tree_parent_id + '-' + (i + 1));
                        children.attr('data-id', obj.id);
                        var first = children.children().eq(0);
                        var two = children.children().eq(1);
                        var three = children.children().eq(2);
                        var four = children.children().eq(3);
                        first = first.children().children().eq(0);
                        two.children().attr('data-id', obj.id);
                        first.eq(0).next().children('input').eq(0).attr('value', obj.id);
                        first.eq(0).next().children('input').eq(0).attr('data-id', obj.id);
                        if (obj.children == 1) {
                            first.eq(0).removeAttr('class');
                            if (two.children().children().eq(0).hasClass('tree-input-status')) {
                                two.children().children().eq(0).remove()
                            }
                            two.children().children().eq(0).before('<span class="tree-input-status no"></span>')
                        } else {
                            first.eq(0).attr('class', 'tree-ind-status close');
                            if (!two.children().children().eq(0).hasClass('tree-input-status')) {
                                two.children().children().eq(0).before('<span class="tree-input-status can"></span>')
                                two.children().eq(0).addClass('tree-one')
                            }
                        }
                        first.eq(0).attr('data-id', obj.id);
                        first.eq(0).attr('data-level', obj.id);
                        two.children().children('div').children('input').eq(0).attr('value', obj.name);
                        two.children().children('div').children('input').eq(0).attr('data-id', obj.id);

                        two.children().children('a').eq(0).attr('href', '?s=admin/commodity/index&id=' + obj.id + '&type=1');
                        first.attr('data-level', obj.id);
                        first.attr('data-id', obj.id);
                        if (obj.status == 1) {
                            three.children().eq(0).attr('class', 'ico_up_rack');
                            three.children().eq(0).attr('title', '点击取消推荐');
                        } else {
                            three.children().eq(0).attr('class', 'ico_up_rack cancel');
                            three.children().eq(0).attr('title', '点击推荐')
                        }
                        three.children().eq(0).attr('data-id', obj.id);
                        four.children().children().eq(0).attr('href', '?s=admin/commodity/index&id=' + obj.id + '&type=0');
                        four.children().children().eq(1).attr('data-id', obj.id);
                        kk.after(children)
                    }
                });
            } else {
                child.removeClass('choose_hidden');
            }
        } else if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).addClass('close');
            var num = child.attr('data-tree-parent-id');
            var nextAll=child.nextAll();
            for(var i=0;i<nextAll.length;i++){
                var next=nextAll.eq(i);
                if(next.attr('data-tree-parent-id').indexOf(num)!=-1){
                    next.addClass('choose_hidden');
                   var kkk= next.children().eq(0).children().children().eq(0);
                    if(kkk.hasClass('open')){
                       kkk.removeClass('open');
                       kkk.addClass('close')
                    }

                }else {
                    break;
                }
            }
            child.addClass('choose_hidden')
          var childClass=  child.children().eq(0).children().children().eq(0)
            childClass.removeClass('open');
            childClass.addClass('close');
        }
    });

});