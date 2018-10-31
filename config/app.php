<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [

    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 默认输出类型
    'default_return_type'    => 'json',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,

    // 默认模块名
    'default_module'         => 'index',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,

    // 视图输出字符串内容替换
    'view_replace_str'       => [],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => Env::get('think_path') . 'tpl/dispatch_jump.tpl',
    'dispatch_error_tmpl'    => Env::get('think_path') . 'tpl/dispatch_jump.tpl',

    // 异常页面的模板文件
    'exception_tmpl'         => Env::get('think_path') . 'tpl/think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'         => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    //微信的appid和appsecret   梦想全球乐购9
//    当前使用
    'app'=>[
        'appid'=>'wxfd32690848c7a3e4',//微信appid
        'appsecret'=>'8a67880be9ab07c46e07b8a2f0cee1ef',//微信appsecret
        'mchid'=>'1507962261',//商户号
        'key'=>'mxqqlgmxqqlgmxqqlgmxqqlgmxqqlg11',//密钥
    ],
    //微信的appid和appsecret   正式
//    'weixinz'=>[
//        'appid'=>'wx8befa78d953ba6ce',
//        'appsecret'=>'48209a58fa029a7a2bcb053e5f2e0ad8',
//        'key'=>'K6oVhW3lJymOi065NGSyCjlAtKaRkOVd',
//        'mchid'=>'1490991462',
//        'key_path'=>'',//证书秘钥存放路径
//        'cert_path'=>'',//证书存放路径
//        'auto'=>'auto',//消息自动回复缓存名
//        'follow'=>'follow',//关注回复缓存名
//        'bankurl'=>'https://api.mch.weixin.qq.com/mmpaysptrans/pay_bank',
//        'changeurl'=>'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers',
//    ],
// 全球乐购9 公共好和商户账号
    'weixinz'=>[
        //微信appid
        'appid'=>'wxdfd709a2cef6667f',
        // 微信秘钥
        'appsecret'=>'4172d6499ee404fec1212bb9b7d3449b',
        // 商户key
        'key'=>'1a1a1a1a1a1a1a1a1a1a1a1a1a1a1a1a',
        // 商户账号
        'mchid'=>'1445603202',
        'key_path'=>'',//证书秘钥存放路径
        'cert_path'=>'',//证书存放路径
        'auto'=>'auto',//消息自动回复缓存名
        'follow'=>'follow',//关注回复缓存名
        'bankurl'=>'https://api.mch.weixin.qq.com/mmpaysptrans/pay_bank',
        'changeurl'=>'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers',
        //消息模板配置id
        'template_id'=>array(
            'fxdz'=>'0wjEBnEw6frkrenf2bkJ5Lln_kct3EE-4lM5QI8mZj8',//返现到账通知
            'ddzf'=>'BRlpedfl9fuy3yxJzjoR9j4zKO81WjPwmFFH8DKbxgY',//订单支付成功
            'yjtx'=>'S-qaGwIT8pXgcg-LGYfzkB6kmsRK50cS1_41mYkoQGM',//佣金提醒
            'jfdz'=>'hdwvzh9jMaypUfK5_8mzwSK4pD2CS_pCryOZfK3qxb4',//积分到账通知
        )
    ],
//    'weixin'=>[
//        'appid'=>'wxdfd709a2cef6667f',
//        'appsecret'=>'4172d6499ee404fec1212bb9b7d3449b',
//        'auto'=>'auto',//消息自动回复缓存名
//        'follow'=>'follow',//关注回复缓存名
//        'mchid'=>'1445603202',//商户号
//    ],
    'qiNiuSdk'=>[
        'accessKey'=>'HzB2zCQjhZ74FNIFNY8spKB2-E81F9pZBD552LGc',
        'secretKey'=>'Dn9NpkLCddYMOzHqBQbld5clvir8yYpOPrTMl2bn',
    ],
//    今天开始的时间戳
    'start_time'=> mktime(0,0,0,date('m'),date('d'),date('Y')),
//    今天结束的时间戳
    'end_time'=>mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1,
//    邮箱正则
    'email'=>"/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",
//    电话正则
   'phone' =>"/^1[34578]\d{9}$/",
    //阿里云短信AccessKeyId和AccessKeySecret,模板
//    'aliyun'=>[
//        'AccessKeyId'=>'LTAIivenkjwjgoQJ',
//        'AccessKeySecret'=>'7bhmLeUt5w0s2mTV2CbvbgdFS6HNXt',
//        'Template'=>'SMS_126570043',
//        'Sign'=>'谢岸霖'
//    ],
    'aliyun'=>[
        'AccessKeyId'=>'LTAIqFGWSFTqj2Wv',
        'AccessKeySecret'=>'CqyhRtgnrmPhBG43fm1yPv0iwv66Pe',
        'Template'=>'SMS_105975108',
        'Sign'=>'梦想全球乐购'
    ],
    //微信零钱支付地址
    "weChatPayUrl"=>"https://api.mch.weixin.qq.com/pay/unifiedorder",
    //微信银行卡支付地址
    "weChatPayBankUrl"=>"https://api.mch.weixin.qq.com/mmpaysptrans/pay_bank",
    //支付回调地址
    "notify_url"=>"http://www.baidu.com",

];
