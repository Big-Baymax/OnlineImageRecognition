<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

//系统后台路由
Route::get('admin/login',function(){
    return view('Admin/login');
});

//Route::get('admin/user',function(){
//
//    return view('Admin/user/user');
//});

//Route::get('admin/admin',function(){
//    return view('Admin/administrators/admin');
//});

////邮箱列表
//Route::get('admin/emailcode',function(){
//
//    return view('Admin/user/emailcode');
//});


return [

    //头像编辑
    'admin/avatar_edit' =>['admin/AvatarManage/admin_avatar',['method' => 'post,get']],

    //后台模板页面渲染路由
    'admin/' =>['admin/ViewManage/admin_index',['method' => 'post,get']],
    'admin/index' =>['admin/ViewManage/admin_index',['method' => 'post,get']],
    'admin/index_con' =>['admin/ViewManage/admin_index_con',['method' => 'post,get']],
    'admin/form_avatar' =>['admin/ViewManage/avatar_index',['method' => 'post,get']],

    //后台登陆
    'admin/admin/login' =>['check/check/login_admin_check',['method' => 'post,get']],
    'admin/admin/logout_admin' =>['check/check/logout_admin',['method' => 'post,get']],

    //后台列表
    'admin/user_list' =>['admin/UserManage/user_list',['method' => 'post,get']],
    'admin/emailcode_list' =>['admin/emailcode/emailcode_list',['method' => 'post,get']],


    'admin/admin_list' =>['admin/AdminUserManage/admin_list',['method' => 'post,get']],
    'admin/user' =>['admin/ViewManage/user_manage_view',['method' => 'post,get']],
    'admin/admin' =>['admin/ViewManage/admin_manage_view',['method' => 'post,get']],
    'admin/emailcode' =>['admin/ViewManage/emailcode_view',['method' => 'post,get']],

    //后台用户操作记录（增、删、改、禁用、重置）
    'admin/user/add' =>['admin/UserManage/add_user',['method' => 'post,get']],
    'admin/user/del' =>['admin/UserManage/del_user',['method' => 'post,get']],
    'admin/user/defriend' =>['admin/UserManage/defriend_user',['method' => 'post,get']],
    'admin/user/reset' =>['admin/UserManage/reset_user',['method' => 'post,get']],
    'admin/user/edit/:id' =>['admin/UserManage/edit_user',['method' => 'post,get']],
    'admin/user/loginlist/:id' =>['admin/UserManage/login_list',['method' => 'post,get']],

    //后台管理员操作记录（增、删、改、禁用、重置）
    'admin/admin/add' =>['admin/AdminUserManage/add_admin',['method' => 'post,get']],
    'admin/admin/del' =>['admin/AdminUserManage/del_admin',['method' => 'post,get']],
    'admin/admin/defriend' =>['admin/AdminUserManage/defriend_admin',['method' => 'post,get']],
    'admin/admin/reset' =>['admin/AdminUserManage/reset_admin',['method' => 'post,get']],
    'admin/admin/edit/:id' =>['admin/AdminUserManage/edit_admin',['method' => 'post,get'],['id'=>'\d+']],
    'admin/admin/loginlist/:id' =>['admin/AdminUserManage/login_list',['method' => 'post,get'],['id'=>'\d+']],

    //后台用户接口管理
    'admin/interface/manage'=>['admin/ViewManage/interface_manage',['method' => 'post,get']],
    'admin/interface/log/:id'=>['admin/ViewManage/interface_log',['method' => 'post,get'],['id'=>'\d+']],
    'admin/interface/interface_list'=>['admin/InterfaceManage/interface_list',['method' => 'post,get']],
    'admin/interface/del'=>['admin/InterfaceManage/interface_del',['method' => 'post,get']],
    'admin/interface/adopt'=>['admin/InterfaceManage/interface_adopt',['method' => 'post,get']],
    'admin/interface/no_adopt'=>['admin/InterfaceManage/interface_no_adopt',['method' => 'post,get']],
    'admin/interface/add'=>['admin/InterfaceManage/interface_add',['method' => 'post,get']],
    'admin/interface/reset'=>['admin/InterfaceManage/interface_reset',['method' => 'post,get']],

    //后台系统配置
    'admin/system/news' => ['admin/ViewManage/news_index',['method' => 'post,get']],
    'admin/system/news_list' => ['admin/NewsManage/news_list',['method' => 'post,get']],
    'admin/system/news_del' => ['admin/NewsManage/news_del',['method' => 'post,get']],
    'admin/system/news_add' => ['admin/NewsManage/news_add',['method' => 'post,get']],
    'admin/system/news_edit/:id' => ['admin/NewsManage/news_edit',['method' => 'post,get'],['id'=>'\d+']],
    'admin/system/setting' => ['admin/ViewManage/setting_index',['method' => 'post,get']],
    'admin/system/backup' => ['admin/ViewManage/backup_index',['method' => 'post,get']],
    'admin/system/setting/save' => ['admin/SystemManage/save_setting',['method' => 'post,get']],
    'admin/system/tables/backup' => ['admin/BackupManage/backup_tables',['method' => 'post,get']],
    'admin/system/tables/reset' => ['admin/BackupManage/reset_tables',['method' => 'post,get']],
    'admin/system/tables/optimize' => ['admin/BackupManage/optimize_tables',['method' => 'post,get']],
    'admin/system/tables/repair' => ['admin/BackupManage/repair_tables',['method' => 'post,get']],
    'admin/system/tables/del' => ['admin/BackupManage/del_backup',['method' => 'post,get']],
    'admin/system/tables/download' => ['admin/BackupManage/download_backup',['method' => 'post,get']],
    'admin/system/tables/download/file/:file' => ['admin/BackupManage/download_file',['method' => 'post,get']],

    //后台分组权限管理
    'admin/group' => ['admin/ViewManage/group',['method' => 'post,get']],
    'admin/admin/group_list' => ['admin/GroupManage/group_list',['method' => 'post,get']],
    'admin/admin/group_add' => ['admin/GroupManage/group_add',['method' => 'post,get']],
    'admin/admin/group_edit/:id' => ['admin/GroupManage/group_edit',['method' => 'post,get'],['id'=>'\d+']],
    'admin/admin/group_del' => ['admin/GroupManage/group_del',['method' => 'post,get']],
    'admin/admin/group_defriend' => ['admin/GroupManage/group_defriend',['method' => 'post,get']],

    //后台规则管理
    'admin/group_rule' => ['admin/ViewManage/group_rule',['method' => 'post,get']],
    'admin/admin/group_rule_list' => ['admin/GroupRuleManage/GroupRule_list',['method' => 'post,get']],
    'admin/admin/group_rule_edit/:id' => ['admin/GroupRuleManage/GroupRule_edit',['method' => 'post,get'],['id'=>'\d+']],
    'admin/admin/group_rule_del' => ['admin/GroupRuleManage/GroupRule_del',['method' => 'post,get']],
    'admin/admin/group_rule_add' => ['admin/GroupRuleManage/GroupRule_add',['method' => 'post,get']],
    'admin/admin/group_rule_defriend' => ['admin/GroupRuleManage/GroupRule_defriend',['method' => 'post,get']],

    //后台成员管理
    'admin/access_list/:id' => ['admin/GroupAcessManage/Access_list',['method' => 'post,get'],['id'=>'\d+']],
    'admin/admin/access_add' => ['admin/GroupAcessManage/Access_add',['method' => 'post,get']],
    'admin/admin/access_del' => ['admin/GroupAcessManage/Access_del',['method' => 'post,get']],


    //后台信箱
    'admin/message/receive/:id' => ['admin/ViewManage/message_receive',['method' => 'post,get'],['id'=>'\d+']],
    'admin/message/reply/:id' => ['admin/ViewManage/message_reply',['method' => 'post,get'],['id'=>'\d+']],
    'admin/message/detail/:type/:id' => ['admin/ViewManage/message_detail',['method' => 'post,get'],['id'=>'\d+','type'=>'\d+']],
    'admin/message/download/:id' => ['admin/MessageManage/download_img_message',['method' => 'post,get'],['id'=>'\d+']],
    'admin/message/write/:id' => ['admin/ViewManage/write_message',['method' => 'post,get'],['id'=>'\d+']],
    'admin/message/send' => ['admin/MessageManage/send_message',['method' => 'post,get']],
    'admin/message/draft' => ['admin/MessageManage/draft_message',['method' => 'post,get']],
    'admin/message/view' => ['admin/MessageManage/view_message',['method' => 'post,get']],
    'admin/message/important' => ['admin/MessageManage/important_message',['method' => 'post,get']],
    'admin/message/del' => ['admin/MessageManage/del_message',['method' => 'post,get']],
    'admin/message/trash' => ['admin/MessageManage/trash_message',['method' => 'post,get']],
    'admin/message/recovery' => ['admin/MessageManage/recovery_message',['method' => 'post,get']],


    //系统主页
    'index' =>['index/index/index',['method' => 'post,get']],

    //前台登陆
    'user/login'   => ['check/check/login_check',['method' => 'post,get']],
    'user/logout'   => ['check/check/logout',['method' => 'post,get']],

    //登录注册找回密码路由
    'login'   => 'check/check/login',
    'register'   => 'check/check/register',
    'fpwd'   => 'check/check/fpwd',

    //渲染找回密码输入框路由
    'f' =>['check/fpwd/f',['method' => 'post,get']],
    'registeruser' =>['check/register/RegisterUser',['method' => 'post,get']],
    'geteamil' =>['check/register/GetEamil',['method' => 'post,get']],

    //修改密码
    'checkpwd' =>['check/fpwd/CheckPwd',['method' => 'post,get']],
    'updatepwd' =>['check/fpwd/UpdataPwd',['method' => 'post,get']],

    //用户界面
    'user/index' =>['user/ViewManage/user_index',['method' => 'post,get']],
    'user/avatar/edit' =>['user/ViewManage/user_avatar',['method' => 'post,get']],
    'user/info/edit' =>['user/ViewManage/user_info',['method' => 'post,get']],
    'user/password/edit' =>['user/ViewManage/user_password',['method' => 'post,get']],
    'user/sign' =>['user/UserManage/sign',['method' => 'post,get']],
    'user/news' =>['user/ViewManage/user_news',['method' => 'post,get']],
    'user/view_news' =>['user/UserManage/view_news',['method' => 'post,get']],
    'user/logininfo' =>['user/ViewManage/login_list',['method' => 'post,get']],
    'user/interface' =>['user/ViewManage/interface_list',['method' => 'post,get']],
    'user/interface_submit/submit' =>['user/InterManage/interface_submit',['method' => 'post,get']],
    'user/interface_submit/reset' =>['user/InterManage/interface_reset',['method' => 'post,get']],
    'user/introduce_file' =>['user/ViewManage/introduce_file',['method' => 'post,get']],
    'user/interface/scenario' =>['user/ViewManage/interface_scenario',['method' => 'post,get']],

    //接口情况路由
    'user/interface/submit' =>['user/ViewManage/interface_submit',['method' => 'post,get']],
    'user/interface/log' =>['user/ViewManage/interface_log',['method' => 'post,get']],
    'user/interface/key' =>['user/ViewManage/interface_key',['method' => 'post,get']],
    'user/interface/count' =>['user/ViewManage/interface_count',['method' => 'post,get']],

    //体验路由
    'user/interface/example/fast' =>['user/ViewManage/example_fast',['method' => 'post,get']],
    'user/interface/example/fast_video' =>['user/ViewManage/example_fast_video',['method' => 'post,get']],
    'user/interface/example/face_video' =>['user/ViewManage/example_face_video',['method' => 'post,get']],
    'user/interface/example/face_pic' =>['user/ViewManage/example_face_pic',['method' => 'post,get']],
    'user/interface/example/color_pic' =>['user/ViewManage/example_color_pic',['method' => 'post,get']],
    'user/interface/example/color_video' =>['user/ViewManage/example_color_video',['method' => 'post,get']],
    'user/interface/example/text' =>['user/ViewManage/example_text',['method' => 'post,get']],
    'user/interface/example/qrcode' =>['user/ViewManage/example_qrcode',['method' => 'post,get']],

    //用户操做接口
    'user/avatar/upload' =>['user/UserManage/avatar',['method' => 'post,get']],
    'user/info/upload' =>['user/UserManage/user_info',['method' => 'post,get']],
    'user/password/upload' =>['user/UserManage/user_password',['method' => 'post,get']],
    'user/experience/apply' =>['user/ViewManage/user_edit',['method' => 'post,get']],
    'user/use/apply' =>['user/ViewManage/user_edit',['method' => 'post,get']],

    //接口路由
    'faces' =>['Nozzle/FacesInterface/index',['method' => 'post,get']],
    'picture' =>['Nozzle/PictureInterface/index',['method' => 'post,get']],
    'text' =>['Nozzle/TextInterface/index',['method' => 'post,get']],

    //接口使用记录路由
    'user/interface/log/:id' =>['admin/InterfaceLogManage/log_list',['method' => 'post,get'],['id'=>'\d+']],

    //统计范文次数的路由
    'visit/' =>['user/VisitManage/index',['method' => 'post,get']],

    //留言接口
    'message' =>['user/MessageManage/index',['method' => 'post,get']]


];

