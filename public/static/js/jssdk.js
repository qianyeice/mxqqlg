/**
 * Created by xyn on 2018/3/14.
 */


document.write("<script type='text/javascript' src='static/js/jquery-1.8.2.min.js'></script>");

$(document).ready(function(){
    var weiXinApi = {



        weixin: function () {
            $.post('http://api.mxqqlg.com/?s=api/Wxjssdk/weixin', function (data) {
                wx.config({
                    debug: true,//false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                    appId: data.appId, // 必填，公众号的唯一标识
                    timestamp: data.timestamp, // 必填，生成签名的时间戳
                    nonceStr: data.nonceStr, // 必填，生成签名的随机串
                    signature: data.signature,// 必填，签名
                    jsApiList: [
                        'scanQRCode'
                    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2。详见：<a rel="nofollow" href="http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html" target="_blank">http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html</a>
                });
            }, 'json')
        }, sdk: function () {

            weiXinApi.weixin();
            wx.ready(function () {
            });
        }, saoyisao: function () {
            weiXinApi.weixin();
            weiXinApi.weixin();
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                    location.href = result;
                }
            });
        }
    };
    //扫一扫
    $(".ma").on("tap", function () {
        weiXinApi.saoyisao();
    });








// /*
    $("#scanQrcode").on("click", function () {

        wx.scanQRCode({
            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) {
                var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                location.href = result;
            }
        });
    });
//  */
//
// /*
//  * 分享到朋友圈接口
//  * 杜世豪
//  * time：3-20 13：49
//  */
    wx.onMenuShareTimeline({
        title: '梦想全球乐购', // 分享标题
        link: 'm.mxqqlg.com', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: '', // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
            alert('分享成功')
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
            alert('分享失败')
        }
    });

    wx.onMenuShareAppMessage({
        title: '嘻嘻', // 分享标题
        desc: '棒棒的', // 分享描述
        link: 'm.mxqqlg.com', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: '', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () {
// 用户确认分享后执行的回调函数
            alert('分享成功啦')
        },
        cancel: function () {
// 用户取消分享后执行的回调函数
        }
    })


    wx.error(function (res) {
        alert(res.errMsg);
    })

});


