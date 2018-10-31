

$(function () {
    $('.submit').click(function () {
        var user=$('.adminname').val();
        var pwd=$('.password').val();
        $.post('?s=admin/Login/data',{adminname:user,password:hex_md5(pwd)},function (data) {
            if(data.type==1){
                window.location.href="?s=admin/Page"
            }else if(data.type==0){
                layer.msg(data.Prompt);
            }
        },"json");
    })
});
