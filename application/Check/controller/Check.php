<?php
/**
 * Created by PhpStorm.
 * User: 76492
 * Date: 2017/9/24
 * Time: 14:21
 */
namespace app\check\controller;
use think\Controller;
use app\check\model\User;
use think\Request;
use app\Admin\model\AdminUser;
use think\Validate;
use think\Session;
use think\Cookie;

class Check extends Controller
{

    public function login()
    {
        return $this->fetch('guest@check/login');
//        $this->validate($data,[
//            'captcha|验证码'=>'require|captcha'
//        ]);
        $user = User::all();
        return json($user);
    }
    public function register()
    {
        return $this->fetch('guest@check/register');
    }
    public function fpwd()
    {
        return $this->fetch('guest@check/fpwd');
    }

    /**
     * @param email pwd code
     * 客户登陆验证
     */
    public function login_check()
    {
        //$user = User::all();  session(array('name'=>'session_id','expire'=>3600));
        //$all =  input('param.');
        $all = Request::instance()->post();

//        $all['email'] = '764929841@qq.com';
//        $all['password'] = 'xiaobin';
        $result   = array('status' => false, 'msg' => "");
        $login_info = array('ip'=> "", "login_time"=> "");
        $all_info = array();
        $rule = [
            'email'  => 'require|email',
            'password'   => 'require',
            'code' => 'require|number|max:4|min:4|captcha'
        ];
        $msg = [
            'email.require' => '邮箱是必填的',
            'password.require'  => '密码不得为空',
            'code.number'   => '验证码必须是为数字',
            'code.require' => '验证码是必填的',
            'code.min'  => '验证码不得小于4位',
            'code.max'  => '验证码不得大于4位',
            'code.captcha'  => '验证码错误！',
            'email.email'  => '邮箱格式错误',
        ];
        $validate = new Validate($rule, $msg);
        $msg = $validate->check($all);

        //匹配规则，如果有问题则返回输出信息
        if(!$msg){
            $result['status'] = 0;
            $result['msg'] = $validate->getError();
            return json($result);
        }

        //获取数据库信息判断
        $user = User::get(['email' => $all['email'],'pwd' => authcode($all['password'],'mysys'),'status' => 1]);
        $info = User::get(['email' => $all['email']]);


        //判断密码是否正确
        if($user){
            if($info ->avatar){
                $avatar = $info ->avatar;
            }else{
                $avatar = 'logo.png';
            }
            Session::set('avatar_user' , $avatar);
            Session::set('user_id' , $info ->uid);
            //判断是否有记住密码，记住的话cookie保存一周
            if(isset($all['remember'])){
                $session_id = session_id();
                //作用域为根目录
                Cookie::set('PHPSESSID',$session_id,['expire'=>7*24*3600]);
                //作用域为user下面
                //setcookie('Newing_sessionid',$session_id,time()+7*24*3600);
            }

            //判断login_info是否已经有了有的话获取没的话跳过
            if($info -> login_info ){
                $all_info = json_decode($info -> login_info,true);
            }
            //session(array('name'=>'user_id','expire'=>8));
            $result['status'] = 1;
            $result['msg'] = '登录成功！';
            $login_info['ip'] = Request::instance()->ip();
            $login_info['login_time'] = date('Y-m-d H:i:s');
            array_push($all_info,$login_info);
            $info -> login_count +=1;
            $info -> login_info = json_encode($all_info);
            $info -> login_time = date('Y-m-d H:i:s');
            $info -> save();
            return json($result);
        }else{
            $result['status'] = 0;
            $result['msg'] = '用户名或密码错误！';
            return json($result);
        }
    }

    /**
     * @param email pwd code
     * 客户注销
     */
    public function logout(){
        Session::delete('user_id');
        if(!Session::get('user_id')){
            $result['status'] = 1;
            $result['msg'] = '注销成功！';
            return json($result);
        }else{
            $result['status'] = 0;
            $result['msg'] = '注销失败！';
            return json($result);
        }
    }
    /**
     * @param uid array
     * 管理员登陆接口
     */
    public function login_admin_check()
    {
        $all = Request::instance()->post();
        $result   = array('status' => false, 'msg' => "");
        $login_info = array('ip'=> "", "login_time"=> "");
        $all_info = array();
        $rule = [
            'login_name'  => 'require',
            'pwd'   => 'require',

        ];
        $msg = [
            'login_name.require' => '用户名是必填的',
            'pwd.require'  => '密码不得为空',
        ];

        $validate = new Validate($rule, $msg);
        $msg = $validate->check($all);

        //匹配规则，如果有问题则返回输出信息
        if(!$msg){
            $result['status'] = 0;
            $result['msg'] = $validate->getError();
            return json($result);
        }
        //获取数据库信息判断
        $user = AdminUser::get(['login_name' => $all['login_name'],'pwd' => authcode($all['pwd'],'mysys'),'status' => 1]);
        $info = AdminUser::get(['login_name' => $all['login_name']]);

        //$info = User::get(['email' => $all['email']]);
        if($user){
            if($info ->avatar){
                $avatar = $info ->avatar;
            }else{
                $avatar = 'logo.png';
            }
            Session::set('avatar_admin' , $avatar);
            Session::set('admin_id' , $info ->uid);
            Session::set('admin_name' , $info ->name);

            //判断login_info是否已经有了有的话获取没的话跳过
            if($info['login_info']){
                $all_info = json_decode($info -> login_info,true);
            }

            $result['status'] = 1;
            $result['msg'] = '登录成功！';
            $login_info['ip'] = Request::instance()->ip();
            $login_info['login_time'] = date('Y-m-d H:i:s');
            array_push($all_info,$login_info);
            $info -> login_count +=1;
            $info -> login_info = json_encode($all_info);
            $info -> login_time = date('Y-m-d H:i:s');
            $info -> save();
            return json($result);
        }else{
            $result['status'] = 0;
            $result['msg'] = '用户名或密码错误！';
            return json($result);
        }
    }

    /**
     * @param email pwd code
     * 管理员注销
     */
    public function logout_admin(){
        Session::delete('admin_id');
        if(!Session::get('admin_id')){
            $result['status'] = 1;
            $result['msg'] = '注销成功！';
            return json($result);
        }else{
            $result['status'] = 0;
            $result['msg'] = '注销失败！';
            return json($result);
        }
    }

}