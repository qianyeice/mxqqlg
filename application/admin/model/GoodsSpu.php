<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 18:12
 */

namespace app\admin\model;


use qiniuSdk\qiniuSdk;
use think\Db;
use think\Model;

class GoodsSpu extends Model
{
    function ace()
    {
        $data = $this->field('type')->select();

        return $data;
    }

    function imag($id)
    {
        $data = $this->where('id', $id)->find();

        return $data;
    }

    public function conten_img($cont_img)
    {
        $qiniu = new qiniuSdk();
        if (!empty($cont_img["spu"]["cont_img"][0])) {
            $p = null;
            for ($i = 0; $i < count($cont_img["spu"]["cont_img"]); $i++) {
                $name = 'goods/spu/cont_img/' . md5(time());
                $file = $cont_img["spu"]["cont_img"][$i];
                $data = $qiniu->q_upload($name, $file);
                $log = 'http://p5od7vvyw.bkt.clouddn.com/' . $name;
                $p .= "<p><img src=".$log." title=" . md5(time()) . "/></p>";
            }

            $cont_p = $cont_img["editorValue"] . $p . "<p><br/></p>";
        } else {
            $cont_p = '';
        }
        return $cont_p;
    }

    /*
    ��Ʒͼ���ϴ� �����༭

*/
    public function imga_add($img, $cont_img, $skp = null)
    {

//        //����ƷͼƬ
        $img_add = array();
        $qiniu = new qiniuSdk();
        if (!empty($img['spu']["tmp_name"]["file"])) {
            $name = 'goods/spu/' . md5($img['spu']["name"]["file"] . time());
            $file = $img['spu']["tmp_name"]["file"];
            $data = $qiniu->q_upload($name, $file);
            $log = 'http://p5od7vvyw.bkt.clouddn.com/' . $data['key'];
            $img_add['spu'] = $log;
        } elseif (isset($skp['spu']["thumb"])) {
            $img_add['spu'] = $skp['spu']["thumb"];
        }
//        ���ͼƬ
        if (!empty($img['sku']["tmp_name"]["file"])) {
            for ($i = 0; $i < count($img['sku']["tmp_name"]["file"]); $i++) {

                $name = 'goods/sku/' . md5(time());
                $file = $img['sku']["tmp_name"]["file"][$i];
                $data = $qiniu->q_upload($name, $file);
                $log = 'http://p5od7vvyw.bkt.clouddn.com/' . $name;
                $img_add['sku'][] = $log;
            }
        }elseif(isset($skp['sku'])){
            if (!empty($img['sku']["tmp_name"]["file"])) {
                for ($i = 0; $i < count($img['sku']["tmp_name"]["file"]); $i++) {
                    $img_add['sku'][] = $skp['sku'][$i]["thumb"];
                }
            }
        }


//        ����ͼƬ

        if (!empty($cont_img)) {
            $p = null;
            for ($i = 0; $i < count($cont_img); $i++) {
                $name = 'goods/spu/cont_img/' . md5(time());
                $file = $cont_img[$i];
                $data = $qiniu->q_upload($name, $file);
                $log = 'http://p5od7vvyw.bkt.clouddn.com/' . $name;
                $p .= '<p><img src=".$log." title=" . md5(time()) . "/><input type="hidden" name="spu[cont_img][]" value="$log"></p>';
            }
            $img_add['spu_cont_img'] = $p . "<p><br/></p>";
        }
//        ��ƵͼƬ
        if (!empty($img["video_img"]["tmp_name"])) {
            $name = 'goods/spu/video_img/' . md5(time());
            $file = $img["video_img"]["tmp_name"];
            $data = $qiniu->q_upload($name, $file);
            $log = 'http://p5od7vvyw.bkt.clouddn.com/' . $data['key'];
            $img_add['video_img'] = $log;
        } else {
            $img_add['video_img'] = $skp['spu']['video_img'];
        }

        return $img_add;
    }


    /*   goods_spu ���

    */
    public function spu_add($spu, $sku, $img)
    {
        $add = array();
        $add_sku = array();
        $add['name'] = $spu['spu']['name'];                                       //��Ʒ��
        $add['sn'] = $sku['sn'][0];                                              //��Ʒ����
        $add['catid'] = $spu['spu']['catid'];                                     //��Ʒ����
        $add['brand_id'] = $spu['spu']['barnd'];                                  //Ʒ��
        $add['content'] = isset($img['spu_cont_img']) ? $img['spu_cont_img'] : '';                                                  //����
        $add['shop_price'] = isset($sku['shop_price'][0]) ? $sku['shop_price'][0] : '';                       //���ۼ�
        $add['market_price'] = isset($spu['spu']['markprice']) ? $spu['spu']['markprice'] : '';                                    //�г���
        //     $add['imgs'] ='';                                 //ͼ���ֲ�
        $add['thumb'] = isset($img['spu']) ? $img['spu'] : '';                                             //����ͼ
        $add['video_img'] = isset($img['video_img']) ? $img['video_img'] : '';;                                          //��ƵͼƬ
        $add['video'] = $spu['video'];                                              //��Ƶ
        $add['status'] = $spu['spu']['status'];                                      //״̬
        $add['delivery_template_id'] = $spu['spu']['deli'];                        //�˷�ģ��id
        $add['type'] = isset($sku['stur'][0]) ? $sku['stur'][0] : '';                                             //��Ʒר��
        $add['Sales_volume'] = $spu['spu']['sales'];                               //������
        $add['is_special'] = $spu['spu']['special'];                                              //������Ʒ
        $add['notice'] = $spu['spu']['warn_number'];                                              //��澯�������
        $add['weight'] = $spu['spu']['weight'];                                              //����
        $add['volume'] = $spu['spu']['volume'];                                              //���
        $add['detail'] = $spu['spu']['content'];                                              //����
        $add['sort'] = $spu['spu']['sort'];                                              //����
        $add['video_show'] = isset($spu['video_show']) ? $spu['video_show'] : '';
        $this->insert($add);
        $spu_id = $this->getLastInsID();
        if (!empty($cont_img)) {
            for ($i = 0; $i < count($sku['name']); $i++) {
                $add_sku['spu_id'] = $spu_id;
                $add_sku['commodity_type'] = $sku['stur'][$i];
                $add_sku['sku_name'] = $sku['name'][$i];
                $add_sku['sn'] = $sku['sn'][$i];
                $add_sku['thumb'] = isset($img['sku'][$i]) ? $img['sku'][$i] : '';                        //���ͼƬ
                $add_sku['number'] = $sku['number'][$i];
                $add_sku['market_price'] = $sku['markprice'][$i];
                $add_sku['shop_price'] = $sku['shoujia'][$i];
                $add_sku['up_time'] = time();
                $add_sku['weight'] = $sku['weight'][$i];
                $add_sku['volume'] = $sku['volume'][$i];
                $add_sku['fencheng'] = $sku['fencheng'][$i];
                $add_sku['dijia'] = $sku['dijia'][$i];
                Db::name('goods_sku')->insert($add_sku);
            }
        }
    }

    public function up($spu, $sku, $img)
    {

        $add = array();
        $add_sku = array();
        $add['name'] = $spu['spu']['name'];                                       //��Ʒ��
        if (!empty($sku['sn'])) {
            $add['sn'] = $sku['sn'][0];                                              //��Ʒ����
        };
        $add['catid'] = $spu['spu']['catid'];                                     //��Ʒ����
        $add['brand_id'] = $spu['spu']['barnd'];                                  //Ʒ��
        $add['content'] =$spu['editorValue']. isset($img['spu_cont_img']) ? $img['spu_cont_img'] : '';                                                  //����
        $add['shop_price'] = isset($sku['shop_price'][0]) ? $sku['shop_price'][0] : '';                       //���ۼ�
        $add['market_price'] = isset($spu['spu']['markprice']) ? $spu['spu']['markprice'] : '';                                    //�г���
        //     $add['imgs'] ='';                                 //ͼ���ֲ�
        $add['thumb'] = isset($img['spu']) ? $img['spu'] : '';                                             //����ͼ
        $add['video_img'] = isset($img['video_img']) ? $img['video_img'] : '';;                                          //��ƵͼƬ
        $add['video'] = $spu['video'];                                              //��Ƶ
        $add['status'] = $spu['spu']['status'];                                      //״̬
        $add['delivery_template_id'] = $spu['spu']['deli'];                        //�˷�ģ��id
        $add['type'] = isset($sku['stur'][0]) ? $sku['stur'][0] : '';                                             //��Ʒר��
        $add['Sales_volume'] = $spu['spu']['sales'];                               //������
        $add['is_special'] = $spu['spu']['special'];                                              //������Ʒ
        $add['notice'] = $spu['spu']['warn_number'];                                              //��澯�������
        $add['weight'] = $spu['spu']['weight'];                                              //����
        $add['volume'] = $spu['spu']['volume'];                                              //���
        $add['detail'] = $spu['spu']['content'];                                              //����
        $add['sort'] = $spu['spu']['sort'];                                              //����
        $add['video_show'] = isset($spu['video_show']) ? $spu['video_show'] : '';
        $this->where(['id' => $spu['idd']])->update($add);
        if (!empty($sku['name'])) {
            for ($i = 0; $i < count($sku['name']); $i++) {
                if (!empty($sku['id'][$i])) {
                    $add_sku['spu_id'] = $spu['idd'];
                    $add_sku['commodity_type'] = $sku['stur'][$i];
                    $add_sku['sku_name'] = $sku['name'][$i];
                    $add_sku['sn'] = $sku['sn'][$i];
                    $add_sku['thumb'] = isset($img['sku'][$i]) ? $img['sku'][$i] : '';                        //���ͼƬ
                    $add_sku['number'] = $sku['number'][$i];
                    $add_sku['market_price'] = $sku['markprice'][$i];
                    $add_sku['shop_price'] = $sku['shoujia'][$i];
                    $add_sku['up_time'] = time();
                    $add_sku['weight'] = $sku['weight'][$i];
                    $add_sku['volume'] = $sku['volume'][$i];
                    $add_sku['fencheng'] = $sku['fencheng'][$i];
                    $add_sku['dijia'] = $sku['dijia'][$i];
                    Db::name('goods_sku')->where(['id' => $sku['id'][$i]])->update($add_sku);
                } else {
                    $add_sku['spu_id'] = $spu['idd'];
                    $add_sku['commodity_type'] = $sku['stur'][$i];
                    $add_sku['sku_name'] = $sku['name'][$i];
                    $add_sku['sn'] = $sku['sn'][$i];
                    $add_sku['thumb'] = isset($img['sku'][$i]) ? $img['sku'][$i] : '';                        //���ͼƬ
                    $add_sku['number'] = $sku['number'][$i];
                    $add_sku['market_price'] = $sku['markprice'][$i];
                    $add_sku['shop_price'] = $sku['shoujia'][$i];
                    $add_sku['up_time'] = time();
                    $add_sku['weight'] = $sku['weight'][$i];
                    $add_sku['volume'] = $sku['volume'][$i];
                    $add_sku['fencheng'] = $sku['fencheng'][$i];
                    $add_sku['dijia'] = $sku['dijia'][$i];
                    Db::name('goods_sku')->insert($add_sku);
                }
            }
        }
    }

    public function updel($img, $pos, $skp)
    {
        $conten_img = $this->conten_img($pos);

        $img_add['spu_cont_img'] = $conten_img;
        $w = $this->imga_add($img, null, $skp);
        $w['spu_cont_img'] = $img_add['spu_cont_img'];
        $up = $this->up($pos, $pos['sku'], $w);
    }

    /*   goods_sku ɾ��
    */
    public function dele($id)
    {
        if (is_array($id)) {
            $data=[];
            for ($i = 0; $i < count($id); $i++) {
                if (is_numeric($id[$i])) {
                    $data[] = $id[$i];
                }
            }
            $whe = implode(',', $data);
            if(!empty($whe)){
                $s = Db::name('goods_sku')->where('id','in',$whe)->delete();
            }
        }

    }

}