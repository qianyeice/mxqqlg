/**
 * Created by 酷炫的勇哥 on 2018/3/19.
 */


$(function () {
    uploadFileEvent();
    function uploadFileEvent() {
        var sub = $('.submit');
        sub.click(function (e) {
            var datas = new FormData($('.file')[0]);
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '?s=admin/Qiniu/index',//请求地址
                cache: false,
                data: datas,
                processData: false, //特别注意这个属性不能省
                contentType: false, //特别注意这个属性不能省
                dataType: 'json',
                success: function (res) {
                    alert(res.msg);
                    if (res.status == 1){
                        $('.msg')[0].reset();//上传成功时，重置form表单
                    }
                }
            })
        })
    }
});