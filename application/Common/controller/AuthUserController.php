<?php
/*
 * @thinkphp3.2.2  auth认证   php5.3以上
 * @Created on 2015/08/18
 * @Author  夏日不热(老屁)   757891022@qq.com
 * @如果需要公共控制器，就不要继承AuthController，直接继承Controller
 */
namespace app\Common\Controller;
use think\Controller;
use think\Session;
use think\Auth;
use app\Common\model\News;
use Think\Model;

//权限认证
class AuthUserController extends Controller {
	protected function _initialize(){
        $user = model('User');
        $id = Session::get('user_id');
        if(!session('user_id')){
            $this->error('未登录或者登陆过期，即将跳转到登录页面','../login');
        }else{
            $info = $user -> where('uid',$id) -> select();
            $news_count = News::hasWhere('comments',['status'=>0,'user_id'=>$id,])->count();
            $this->assign('user_name',$info[0]['name']);
            $this->assign('integral',$info[0]['integral']);
            $this->assign('news_count',$news_count);
        }

	}
}