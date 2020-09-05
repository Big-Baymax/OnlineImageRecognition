<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 发送邮件方法
 * @param string $to：接收者邮箱地址
 * @param string $title：邮件的标题
 * @param string $content：邮件内容
 * @return boolean  true:发送成功 false:发送失败
 */
use PHPMailer\PHPMailer\PHPMailer;
use think\Session;
use think\Validate;
use think\config;
use think\Db;

//实现自动识别根目录，在一级二级下都可以访问到
$root = strstr($_SERVER["SCRIPT_NAME"],'/index.php',true);
//获取配置参数
$list = Db::table('irp_setting')->order('uid','DESC')->limit(1)->select();

// 设置配置参数
$config = [
    'view_replace_str'       => [
        '_ROOT_'=> $root,
        '_CSS_'=> $root.'/static/css',
        '_JS_'=> $root.'/static/js',
        '_IMG_'=> $root.'/static/img',
        '_URL_'=> $root,
        '_TITLE_'=> $list[0]['title'],
        '_KEY_'=> $list[0]['key'],
        '_DES_'=> $list[0]['description'],
        '_COPYRIGHT_'=> $list[0]['copyright'],
        '_COPYRIGHTURL_'=> $list[0]['copyright_url'],
        '_ICP_'=> $list[0]['icp'],
        '_ICPURL_'=> $list[0]['icp_url'],
        '_POLICE_'=> $list[0]['police'],
        '_POLICEURL_'=> $list[0]['police_url'],
    ],
];
Config::set($config);

//自定义验证函数
Validate::extend('emailcode', function ($value) {
    $key = authcode('codeimg','mysys');
    $secode = Session::get($key, '');

      //验证是否正确，超时处理
    if (time() - $secode['verify_time'] > 300) {
        if (authcode($value,'mysys') == $secode['verify_code']) {
            //这里不能删除session，防止下面的判断失效了
            //Session::delete($key, '');
            return true;
        }
    }else{
        if (authcode($value,'mysys') == $secode['verify_code']) {
            //Session::delete($key, '');
            return true;
        }
    }
    return false;
});
Validate::extend('timeout', function () {
    $key = authcode('codeimg','mysys');
    $secode = Session::get($key, '');
    //echo $secode['verify_time'];
    // session 5分钟 过期
    if (time() - $secode['verify_time'] > 300) {
        //var_dump(time() - $secode['verify_time']);
        Session::delete($key, '');
        return false;
    }else{
        //验证过后就删除
        Session::delete($key, '');
    }
    return true;
});

/* 加密验证码 */
function authcode($str,$keystr)
{
    $key = substr(md5($keystr), 5, 8);
    $str = substr(md5($str), 8, 10);
    return md5($key . $str);
}

function GetRand($str,$length,$Key,$email){
    is_null($str)? '1234567890':$str;
    for ($i = 0; $i < $length; $i++) {
        $code[$i] = $str[mt_rand(0, strlen($str) - 1)];
    }
    $recode = strtoupper(implode('', $code));

    // 保存随机数
    $key                   = authcode('codeimg',$Key);
    $code                  = authcode($recode,$Key);
    $secode                = [];
    $secode['verify_code'] = $code; // 把校验码保存到session
    $secode['verify_time'] = time(); // 验证码创建时间
    $secode['email'] = $email; // 验证码是来自那个号的
    Session::set($key , $secode, '');
    return $recode;
}

//获取随机key码
function RandCode($str,$keystr)
{
    $start = rand(1,30);
    $key = substr(md5($keystr), $start, 10);
    $str = substr(md5($str), $start, 10);
    return md5($key . $str);
}

function SendMail($to,$toname,$title,$body,$altbody,$myname){
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'irpsys@163.com';                 // SMTP username
        $mail->Password = 'irpsys123456';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('irpsys@163.com', $myname);//发件人地址，名称
        $mail->addAddress($to, $toname);     // 收件人地址，名称
        $mail->addReplyTo('irpsys@163.com', $myname); //抄送一封信

        $mail->isHTML(true);                                  // 发送一个html格式的邮件
        $mail->Subject = $title;               //发送邮件标题
        $mail->Body    = $body; //发送邮件内容
        $mail->AltBody = $altbody;//备用显示，不支持HTML的时候显示

        $status =  $mail->send();
        if($status) {
            return true;
        }else{
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

/**
 * 压缩文件(zip格式)
 *
 * @param $save_path(文件保存路劲) string,$file_array(文件路径) array
 * return $result array
 */
function tozip($fiex,$save_path,$file_array){
    $error_table = array();
    $zip = new \ZipArchive();
    $zipname=date('YmdHis',time());
    $zip_path = $save_path.$fiex.$zipname.'.zip';
    $zip_name = $fiex.$zipname.'.zip';
    if (!file_exists($zip_path)){
        $zip->open($zip_path,\ZipArchive::CREATE);//创建一个空的zip文件
        for ($i=0;$i<count($file_array);$i++){
            $result = $zip->addFile($save_path.$file_array[$i],$file_array[$i]);
            if(!$result){
                array_push($error_table,$file_array[$i]);
            }
        }
        $zip->close();
        if(sizeof($error_table)){
            return array('status' => false, 'msg' => $error_table);
        }else{
            return array('status' => true, 'msg' => $zip_name);
        }
    }
}

/**
 * 输出文件(zip格式)
 *
 * @param $file_path(文件路径) string $name(下载文件名)
 * return $filename file || false (文件不存在！)
 */
function echo_file($file_path,$name){
    $con = Config::get('view_replace_str');
    //检查文件是否存在
    if (file_exists($file_path)){
        //打开文件
        $file = fopen($file_path,"r");
        //返回的文件类型
        Header("Content-type: application/octet-stream");
        //按照字节大小返回
        Header("Accept-Ranges: bytes");
        //返回文件的大小
        Header("Accept-Length: ".filesize($file_path));
        //这里对客户端的弹出对话框，对应的文件名
        Header("Content-Disposition: attachment; filename=".$con['_TITLE_'].$name.".zip");
        //修改之前，一次性将数据传输给客户端
        //echo fread($file, filesize($file_path));

        //修改之后，一次只传输1024个字节的数据给客户端
        //向客户端回送数据
        $buffer=1024;//
        //判断文件是否读完
        while (!feof($file)) {
            //将文件读入内存
            $file_data=fread($file,$buffer);
            //每次向客户端回送1024个字节的数据
            echo $file_data;
        }
        fclose($file);
        return true;
    }else {
        return false;
    }
}