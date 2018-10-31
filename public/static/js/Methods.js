/**
 * Created by Administrator on 2018/7/17.
 */

var am=new Object();
//1个人中心用户数据
am.geren=function (data,fun) {
    if(typeof data.ueserid=='undefined'){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('http://api.mxqqlg.com/?s=api/Membercore/memberCenter',{id:data.ueserid},function (data) {
        fun(data)
    },'json')

};
//2删除购物车
am.carts=function (data,fun) {
    if(typeof data.id=='undefined'){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:data.id},function (data) {
        fun(data)
    },'json')
};

//3首页所有商品
am.commodity=function (data,fun) {

    mui.post('http://api.mxqqlg.com/?s=api/Commodity/syAllCommodity',{},function (data) {
        fun(data)
    },'json')
};

//4首页限时抢购
am.rushs=function (data,fun) {
    mui.post('',{},function (data) {
        fun(data)
    },'json')
};

//6新人商城
am.malls=function (data,fun) {
    if(typeof data.member_id=='undefined'){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:data.member_id},function (data) {
        fun(data)
    },'json')
};


//8加入购物车
am.shoppings=function (data,fun) {
    if(typeof (data.sku_id=='undefined'&&data.huodong_id=='undefined'&&data.member_id=='undefined'&&data.shuliang=='undefined')){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:[data.sku_id,data.huodong_id,data.member_id,data.shuliang]},function (data) {
        fun(data)
    },'json')
};

//10新人商城数据列表
am.lists=function (data,fun) {
    mui.post('',{},function (data) {
        fun(data)
    },'json')
};

//12登录
am.signs=function (data,fun) {
    if(typeof data.phone=='undefined'){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:data.phone},function (data) {
        fun(data)
    },'json')
};

//14商品评论
am.comments=function (data,fun) {
    if(typeof data.spu_id=='undefined'){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:data.spu_id},function (data) {
        fun(data)
    },'json')
};

//16限时抢购的商品列表
am.commoditys=function (data,fun) {
    if(typeof data.id=='undefined'){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:data.id},function (data) {
        fun(data)
    },'json')
};

//20更多商品列表
am.mores=function (data,fun) {
    if(typeof data.id=='undefined'){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:data.id},function (data) {
        fun(data)
    },'json')
};

//22 订单支付
am.payments=function (data,fun) {
    if(typeof (data.sn=='undefined'&&data.coupon=='undefined'&&data.money=='undefined'&&data.dreammonry=='undefined'&&data.zhanghumoney=='undefined')){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:[data.sn,data.coupon,data.money,data.dreammonry,data.zhanghumoney]},function (data) {
        fun(data)
    },'json')
};

// 24 随机红包
am.reds=function (data,fun) {
    if(typeof data.member_id=='undefined'){
        fun({type:'0',data:'数据未接收到'});
        return false
    }
    mui.post('',{id:data.member_id},function (data) {
        fun(data)
    },'json')
};



// 首页现金红包5
am.CashBonus=function (data,fun) {
    if(typeof data.member_id=='undefined'){
        fun({type:'0',data:'数据未接收到'})
        return false
    }
    mui.post('http://api.mxqqlg.com/?s=api/Redenvelope/syCashRe',{id:data.member_id},function (data) {
        fun(data)
    },'json')
};
//首页轮播图7
am.Broadcast =function (data,fun) {
    mui.post('http://api.mxqqlg.com/?s=api/Img/syLunbo',{},function (data) {
        fun(data)
    },'json')
};
//首页公告9
am.Notice=function (data,fun) {
    mui.post('http://api.mxqqlg.com/?s=api/Shouye/syTongzhi',{},function (data) {
        fun(data)
    },'json')
};
//首页活动11
am.activity=function (data,fun) {
    mui.post('http://api.mxqqlg.com/?s=api/Shouye/syActivity',{},function (data) {
        fun(data)
    },'json')
};
// 商品详情13
am.details=function (data,fun) {
    if(typeof data.spu_id=='undefined'){
        fun({type:'0',data:'数据未接收到'})
        return false
    }
    mui.post('http://api.mxqqlg.com/?s=api/Commodity/commodityDetails',{id:data.spu_id},function (data) {
        fun(data)
    },'json')
};
// 首页导航15
am.Navigation=function (data,fun) {
    mui.post('http://api.mxqqlg.com/?s=api/Shouye/syNav',{},function (data) {
        fun(data)
    },'json')
};
// 购物车数据17
am.Shopcar=function (data,fun) {
    if(typeof data.member_id=='undefined'){
        fun({type:'0',data:'数据未接收到'})
        return false
    }
    mui.post('http://api.mxqqlg.com/?s=api/Shopcart/shopCarData',{id:data.member_id},function (data) {
        fun(data)
    },'json')
};





