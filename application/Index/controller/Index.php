<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        $uid = Session::get('user_id');
        if($uid){
            $user = model('User');
            $detail = $user -> where('uid',$uid) -> select();
            $this->assign('name',$detail[0]['name']);
        }else{
            $this->assign('name',null);
        }
        return $this->fetch('guest@index/index');
    }
    public function hello($id)
    {
        return $id;

    }
}
