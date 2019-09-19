<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;

    //只读字段
    protected $readonly = ['email'];


    //登录校验
    public function login($data){
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('login')->check($data)){
            return $validate->getError();
        }
        $result = $this ->where($data)->find();
        if($result){
            //判断用户是否可用
            if($result['status']!=1){
                return '此账号被禁用！！';
            }
            //1表示有这个用户即是用户密码正确了
            return 1;
        }else{
            return '用户名或者密码错误！！';
        }
    }

    //注册账户
    public function register($data)
    {
        $validate=new \app\common\validate\Admin();
        if(!$validate->scene('register')->check($data)){
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return '注册失败！！';
        }
    }
}
