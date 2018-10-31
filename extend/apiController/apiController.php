<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 13:44
 */
namespace apiController;
use think\Controller;
use think\Db;
class apiController extends Controller{
     public function _initialize(){
//         $url=$_SERVER['SERVER_NAME'];
//         if(cache($url)){
////             cache($url,null);
//         }else{
//             $this->error('没有Token');
//         }
     }
    /**
     * api调用日志
     * @param $parameter : 调用api返回的参数
     * @param $type 数据状态值
     * @param $explainName 状态说明名字
     * @param $afferent_parameter 传入参数
     * 2018-03-21 14:03:37
     * 冯云祥
     * return  1/0
     */
    public function apiJournal($type,$explainName,$parameter,$afferent_parameter='无'){
        $url=request()->module().'/'.request()->controller().'/'.request()->action();
        $time=time();
        $data=array();
        $data['url']=$url;
        $data['time']=$time;
        $data['data']=$afferent_parameter;
        if(is_array($parameter)){
            $data['parameter']="{type:".$type.','."explain:".$explainName.','.'data:'.json_encode($parameter);
        }else{
            $data['parameter']="{type:".$type.','."explain:".$explainName.','.'data:'.$parameter;
        }

        $ri=Db::name('api_journal')->insert($data);

        return $ri;
    }




    /**
     * 数据返回格式处理
     * time：18-3-23 12:02
     * author:大宝宝
     * @param $type 数据状态值
     * @param $explainName 状态说明名字
     * @param string $data 成功返回的数据包
     * @return array 返回组合后的返回数据
     */
    public function apiReturn($type,$explainName,$data=''){
        //状态判断
        if($type == 1){
            return  $this->successReturn($data);
        }else{
            return $this->errorRetrun($explainName);
        }
    }

    /**
     * 成功数据返回格式处理
     * time：18-3-23 12:02
     * author:大宝宝
     * @param $data 成功返回的数据包
     * @return array 返回整合后的数据array
     */
    protected function successReturn($data){
        return $array=array(
            'type'=>1,
            'explain'=>lang("success"),
            'data'=>$data
        );
    }

    /**
     * 失败数据返回格式处理
     * time：18-3-23 12:02
     * author:大宝宝
     * @param $explainName 错误说明语言包名字
     * @return array 返回整合后的数据array
     */
    protected function errorRetrun($explainName){
        return $array=array(
            'type'=>0,
            'explain'=>lang($explainName),
            'data'=>''
        );
    }


}