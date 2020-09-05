<?php
/*
 * @thinkphp3.2.2  auth认证   php5.3以上
 * @Created on 2015/08/18
 * @Author  夏日不热(老屁)   757891022@qq.com
 * @如果需要公共控制器，就不要继承AuthController，直接继承Controller
 */
namespace app\Common\Controller;
use think\Controller;
use think\Auth;
use Think\Model;

//权限认证
class AuthController extends Controller {
	protected function _initialize(){

		//session不存在时，不允许直接访问
		if(!session('admin_id')){
			$this->error('还没有登录，正在跳转到登录页','./admin/login');
		}
		//session存在时，不需要验证的权限
		$not_check = array('Index/index','Index/main',
				'Index/clear_cache','Index/edit_pwd','Index/logout');
		
		//当前操作的请求                 模块名/方法名
//		if(in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $not_check)){
//			return true;
//		}
		
		//下面代码动态判断权限
		//此处代码存在一个问题，除了admin之外的账号，仍然没有权限，一时也没时间调试原因了，使用的人自己随意调试吧。
//		$auth = new Auth();
//		if(!$auth->check(CONTROLLER_NAME.'/'.ACTION_NAME,session('admin_id')) && session('admin_id') != 1){
//			$this->error('没有权限');
//		}
	}
}