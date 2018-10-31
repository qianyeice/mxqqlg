$(function () {
    var $jg = getQueryString('page') ? getQueryString('page') : 0;
    var $element = document.getElementById('current');
    //page参数
    var input = document.getElementById('current_input').innerHtml = parseInt($jg);

    //页数显示
    var $node = document.createTextNode(input + 1);
    $element.appendChild($node);
    for(var i =4 ; i>=1;i--){
        $($element).after('<li class="pageListbottom" style="margin-left:5px;cursor:pointer">'+(input+1+i)+'</li>');
    }
    var pa = document.getElementsByClassName('pageListbottom');
    $(pa).click(function () {
        var html = $(this).html();
        var str = window.location.href.replace(/\&page=[0-9]*/, '&page='+html);
        window.location.href= str;
    })

//上一页下一页
    function sxfy(sx) {
        var str = document.getElementById('current_input').innerHtml ;
        var limit = $('#limit').val();
        //下一页
        if (sx) {
            //判断是否有足够的数据
            if (Math.ceil($count / limit) >= (str +2)) {
                str = 1 + str;
                if (!/\&page=[0-9]*/.test(window.location.href)) {
                    $str = window.location.href + '&page=' + str;
                } else {
                    $str = window.location.href.replace(/\&page=[0-9]*/, '&page=' + str);
                }
                if (!/\&limit=[0-9]*/.test(window.location.href)) {
                    $str += '&limit=' + limit;
                } else {
                    $str.replace(/\&limit=[0-9]*/, '&limit=' + limit);
                }
            } else {
                alert('已经是最后一页了')
            }
            //上一页
        } else {
            if (str && str != 0) {
                str = Number(str);
                $str = window.location.href.replace(/\&page=[0-9]*/, '&page=' + (str - 1));
            } else {
                alert('已经是第一页了')

            }
        }
        window.location.href = $str;
    }
    //首页 末页
    function first_end($true) {
        var win = window.location.href;
        var limit = $('#limit').val();

        if ($true) {
            if (win.indexOf('&page') != -1) {
                win = win.replace(/\&page=[0-9]*/, '&page=0');
            } else {
                alert('已经是第一页了!');
            }
        } else {
            if (win.indexOf('&page') != -1) {
                win = win.replace(/\&page=[0-9]*/, '&page=' + (Math.ceil($count / limit) - 1));
            } else {
                win += '&page=' + (Math.ceil($count / limit) - 1);
            }
        }
        if (win.indexOf('&limit') == -1) {
            win = win + '&limit=' + limit;
        } else {

            win = win.replace(/\&limit=[0-9]*/, '&limit=' + limit);
        }
        window.location.href = win;
    }

//下一页
    $('.default-next').click(function () {
        sxfy(true)
    });

//shang一页
    $('.default-prev').click(function () {
        sxfy()
    });

//首页
    $('.default-start').click(function () {
        first_end(true)
    });

//末页
    $('.default-end').click(function () {
        first_end()
    });

    //设置显示条数
    var numZ = /^\+?[1-9][0-9]*$/;
    $('#limit').keyup(function () {
        var limit = $(this).val();
        if (limit != null || limit != '') {
            if (!numZ.test(limit)) {
                layer.msg('非法数据!请重新输入!')
            } else {
                if (limit != $limit) {
                    win = window.location.href;

                    if (numZ.test(limit)) {
                        if (win.indexOf('&') != -1) {
                            win = win.substring(0, win.indexOf('&'));
                        }
                        win = win + '&limit=' + limit;
                    }
                    $(this).blur(function () {
                        window.location.href = win;
                    });
                    $(document).keyup(function (event) {
                        if (event.keyCode == 13) {
                            window.location.href = win;
                        }
                    });
                }

            }
        } else {
            layer.msg('显示条数不能为空!')
        }
    });

});