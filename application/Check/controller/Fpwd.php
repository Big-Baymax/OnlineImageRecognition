<?php
/**
 * Created by PhpStorm.
 * User: 76492
 * Date: 2017/9/30
 * Time: 17:04
 */
namespace app\check\controller;
use think\Controller;
use think\Request;
use think\Validate;
use app\check\model\User;
use think\Session;

class Fpwd extends Controller
{
    public function f(){
        return $this->fetch('check/f');
    }
    public function UpdataPwd(){
        $result = array('status' => false, 'msg' => "");
        $all = Request::instance()->post();
        $check_result = Session::get("fpwd", '');
        $user = new User;

        if($all['npwd'] != $all['rnpwd']){
            $result['status'] = 0;
            $result['msg'] = '两次输入密码不一样！';
            return json($result);
        }

        //判断session是否存在
        if($check_result){
            //判断session是否过期（操作是否超时）
            if (time() - $check_result['verify_time'] > 600) {
                Session::delete("fpwd", '');
                $result['status'] = 0;
                $result['msg'] = '操作超时了！';
                return json($result);
            }else{
                if($check_result['check_code'] == true){
                    $user_list = $user ->where('email',$check_result['email']) -> update([
                        'pwd' => authcode($all['npwd'],'mysys'),
                        'update_time' => date('Y-m-d H:i:s'),
                    ]);
                    if($user_list){
                        $result['status'] = 1;
                        $result['msg'] = '密码已经修改';
                        return json($result);
                    }else{
                        $result['status'] = 0;
                        $result['msg'] = '修改失败！';
                        return json($result);
                    }
                }else{
                    $result['status'] = 0;
                    $result['msg'] = '你还未验证过邮箱号！';
                    return json($result);
                }
            }
        }

        //$user = User::get(['email' => $all['email']]);
        return json($check_result);
    }
    public function CheckPwd(){
        $result = array('status' => false, 'msg' => "");
        $all = Request::instance()->post();
        $rule = [
            'emailcode'  => 'require|number|max:5|min:5|emailcode|timeout',
        ];
        $msg = [
            'emailcode.require' => '邮箱验证码是必填的',
            'emailcode.number' => '邮箱验证码是纯数字的',
            'emailcode.min'  => '邮箱验证码不得小于5位',
            'emailcode.max'  => '邮箱验证码不得大于5位',
            'emailcode.timeout'  => '邮箱验证码过期了！',
            'emailcode.emailcode'  => '邮箱验证码错误！',
        ];
        $validate = new Validate($rule, $msg);
        $msg = $validate->check($all);
        //匹配规则，如果有问题则返回输出信息
        if(!$msg){
            $result['status'] = 0;
            $result['msg'] = $validate->getError();
            return json($result);
        }else{
            $secode                = [];
            $secode['check_code'] = true; // 把校验结果保存到session
            $secode['verify_time'] = time(); // 校验时间
            $secode['email'] = $all['email']; // 校验来自那个号的
            Session::set("fpwd" , $secode, '');
            $result['status'] = 1;
            $result['msg'] = "邮箱验证码没错";
            return json($result);
        }

    }
}