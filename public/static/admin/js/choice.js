$(function () {
    $('.clean').click(function () {
        $.post('?s=admin/Page/clean',{d:null},function (data) {
            if(data.type==1){
                layer.msg(data.Prompt);
                setTimeout(function () {
                    window.location.href="?s=admin/Login";
                },500)
            }else if(data.type==0){
                layer.msg(data.Prompt);
                setTimeout(function () {
                    window.location.href="?s=admin/Login";
                },500)
            }
        },'json')
    })
});