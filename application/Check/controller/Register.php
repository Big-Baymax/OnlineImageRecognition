<?php
/**
 * Created by PhpStorm.
 * User: 76492
 * Date: 2017/9/24
 * Time: 14:09
 */
namespace app\check\controller;
use think\Request;
use think\Controller;
use think\Validate;
use think\Session;
use app\check\model\User;
use app\check\model\UserEmailcode;

class Register extends Controller
{
    public function RegisterUser()
    {
        $result = array('status' => false, 'msg' => "");

        $all = Request::instance()->post();

        //$user = new User();
        $rule = [
            'email'  => 'require|email',
            'password'   => 'require|min:6',
            'repassword' => 'require|min:6|confirm:password',
            'emailcode'  => 'require|number|max:5|min:5|emailcode|timeout',
            'agree' =>'require|accepted',
        ];
        $msg = [
            'email.require' => '邮箱是必填的',
            'password.require'  => '密码不得为空',
            'password.min'  => '密码不得少于6位',
            'email.email'  => '邮箱格式错误',
            'repassword.require' => '确认密码不得为空',
            'repassword.min' => '确认密码不得少于6位',
            'repassword.confirm' => '确认密码跟密码不一样',
            'emailcode.require' => '邮箱验证码是必填的',
            'emailcode.min'  => '邮箱验证码不得小于5位',
            'emailcode.max'  => '邮箱验证码不得大于5位',
            'emailcode.timeout'  => '邮箱验证码过期了！',
            'emailcode.emailcode'  => '邮箱验证码错误！',
            'agree.accepted' => '请同意服务协议',
            'agree.require' => '请同意服务协议',

        ];
        $validate = new Validate($rule, $msg);
        $msg = $validate->check($all);
        //匹配规则，如果有问题则返回输出信息
        if(!$msg){
            $result['status'] = 0;
            $result['msg'] = $validate->getError();
            return json($result);
        }
        $user = User::get(['email' => $all['email']]);
        if($user){
            $result['status'] = 0;
            $result['msg'] = '邮箱号已注册，可以直接登录或者找回密码！';
            return json($result);
        }
        $register_time = date('Y-m-d H:i:s');
        $user = User::create([
            'name'  =>  '未填写',
            'email' =>  $all['email'],
            'pwd' =>  authcode($all['password'],'mysys'),
            'openid' => authcode($all['email'],'irp'),
            'time' => $register_time,
            'status' => "1",
        ]);

        if($user){
            $result['status'] = 1;
            $result['msg'] = '注册成功！';
            return json($result);
        }else{
            $result['status'] = 0;
            $result['msg'] = '注册失败！';
            return json($result);
        }

        //SendMail('764929841@qq.com',"亲爱的用户",'注册验证码','你的验证码为：83588，有效期5分钟！','你的验证码为：83588，有效期5分钟！','图像识别系统');
        //return '用户注册';

    }

    public function GetEamil(){
        $result   = array('status' => false, 'msg' => "");
        $all = Request::instance()->post();

        //判断Session是否过期了，过期了重新获取
        $key = authcode('mysys','mysys');
        $secode = Session::get($key, '');

        //判断是否是同一个号重复获取，防止暴力获取
        if($secode != null && $secode['email'] == $all['email']){
            // session 5分钟 过期
            if (time() - $secode['verify_time'] > 300) {
                Session::delete($key, '');
            }else{
                $result['status'] = 0;
                $result['msg'] = '不好意思，您的验证码5分钟内有效，请勿一直获取哦！';
                return json($result);
            }
        }

        $rule = [
            'email'  => 'require|email',
            'code' => 'require|number|max:4|min:4|captcha'
        ];
        $msg = [
            'email.require' => '邮箱是必填的',
            'code.number'   => '图形验证码必须是为数字',
            'code.require' => '图形验证码是必填的',
            'code.min'  => '图形验证码不得小于4位',
            'code.max'  => '图形验证码不得大于4位',
            'code.captcha'  => '图形验证码错误！',
            'email.email'  => '邮箱格式错误',
        ];
        $validate = new Validate($rule, $msg);
        $msg = $validate->check($all);

        //匹配规则，如果有问题则返回输出信息
        if(!$msg){
            $result['status'] = 0;
            $result['msg'] = $validate->getError();
            return json($result);
        }else{
            $code = GetRand('1234567890',5,'mysys',$all['email']);
            $status = SendMail($all['email'],"尊敬的用户",'注册验证码','【Newing图像是识别系统】<br>您好！<br>您的验证码为：'.$code.'，有效期5分钟，过期请重新获取！','你的验证码为：'.$code.'，有效期5分钟，过期请重新获取！','Newing图像是识别系统');
            //$status = SendMail($all['email'],"尊敬的用户",'【Newing图像是识别系统】','！您的验证码为：【'.$code.'】，有效期5分钟！请勿泄漏此信息！','您好！您的验证码为：【'.$code.'】，有效期5分钟！请勿泄漏此信息！','Newing');

            $register_time = date('Y-m-d H:i:s');
            UserEmailcode::create([
                'code'  =>  $code,
                'email' =>  $all['email'],
                'result' => $status?1:0,
                'time' => $register_time,
                'ip' => Request::instance()->ip()
            ]);

           if($status){
               return json(array('status' => 1, 'msg' => "发送成功"));
           }else{
               return json(array('status' => 0, 'msg' => "发送失败，请检查邮箱地址"));
           }

        }

    }
}