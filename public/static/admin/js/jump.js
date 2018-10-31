$(function () {
    //页数更改
    $jg = getQueryString('page') ? getQueryString('page') : 0;
    $('.current').eq(0).html($jg);
    //获取url值

//上一页下一页
    function sxfy(sx) {
        var str = getQueryString('page');
        //下一页
        if (sx) {
            if (str) {
                //判断是否有足够的数据
                if (Math.ceil(count / 10) >= Number(str) + 2) {
                    str = 1 + Number(str);
                    $str = window.location.href.replace(/\&page=[0-9]*/, '&page=' + str);
                } else {
                    layer.msg('已经是最后一页了');
                }
            } else {
                if (Math.ceil(count / 10) < 2) {
                    layer.msg('已经是最后一页了');
                } else {
                    $str = window.location.href + '&page=' + 1
                }
            }
            //上一页
        } else {
            if (str && str != 0) {
                str = Number(str) - 1;
                $str = window.location.href.replace(/\&page=[0-9]*/, '&page=' + str);
            } else {
                layer.msg('已经是第一页了');
            }
        }
        window.location.href = $str;
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
        window.location.href = '?s=' + getQueryString('s') + '&page=0'
    });

//末页
    $('.default-end').click(function () {
        $p = Math.ceil(count / 10);
        window.location.href = '?s=' + getQueryString('s') + '&page=' + ($p - 1)
    });
});