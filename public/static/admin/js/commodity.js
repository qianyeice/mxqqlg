$(function () {
    var id = getQueryString('id') ? getQueryString('id') : 0;
    var cateData = '';
    var type = '';
    var name = '';
    var par = '';
    //商品分类详细信息
    if (id) {
       var type= getType();
        $.post(href('post_data'), {'id': id, 'type': type}, function (data) {
            cateData = data[0];
            for (var i = 0; i < cateData.length; i++) {
                var array = [];
                for (var l in cateData[i]) {
                    array.push(cateData[i][l]);
                }
                for (var k = 0; k < array[0].length; k++) {
                    if (array[0][k]['id'] == id) {
                        if (type == 0) {
                            name = array[0][k]['name'];
                            par = array[0][k]['parent_id'];
                            $('#category_name').attr('value', array[0][k]['name']);
                            $('input[name=id]').attr('value', array[0][k]['id']);
                            $('input[type="hidden"][name="parent_id"]').attr('value', array[0][k]['parent_id']);
                        } else {
                            $('input[type="hidden"][name="parent_id"]').attr('value', array[0][k]['id']);
                        }
                        break;
                    }
                }
            }
            if (data[1] == '') {
                $('#choosecat').attr('value', '顶级分类');
            } else {
                $('#choosecat').attr('value', '顶级分类:' + data[1]);
            }
            ;
        });
    }



});