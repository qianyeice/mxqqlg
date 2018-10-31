<?php

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Category;


class Commodity extends adminController
{
    public function index()
    {
        return view('index');
    }

    public function post_data(){
           $data = new Category();
           if (input('type') == 1) {
               $data = $data->category(input('id'),true);
           } else {
               $data = $data->category(input('id'));
           }
           return $data;
    }
    public function post_choose_data(){
        $data = new Category();
        $id=input('id')?input('id'):0;
        if($id==0){
            $data=$data->brothers($id);
        }else{

            $data=$data->category($id,1);
        }
       return $data;
    }
    public function post_choose_update(){
          $data=new Category();
          $data=$data->cateUpdate(input('id'),input('name'),input('parent_id'),input('type'));
       return $data;
    }

}