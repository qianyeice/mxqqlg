/**
 * 选项卡跳转页面，按钮变色
 * @constructor
 */
function GetRequest() {
    var url = location.search;
    var  theRequest = new Object();
    var  theRequest1= new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = (strs[i].split("=")[1]);
        }
    }
    $('.jump').each(function () {
        var ff=$(this).attr("href")
        strs1 = ff.split("&");
        for (var i = 0; i < strs1.length; i++) {
            theRequest1[strs1[i].split("=")[0]] = (strs1[i].split("=")[1]);
        }
        if(theRequest.type==theRequest1.type){
            $(this).addClass('current')
        }
    })
}
