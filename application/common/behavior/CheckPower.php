<?php
namespace app\common\behavior;

use think\Session;
use think\Request;
use think\Response;
use upc\User;

class CheckPower
{
    public function run(&$params)
    {
        $r = Request::instance();
        $userId = Session::get('user_info.id');
        $user = new User($userId);
        $module = $r->module();
        $controller =  strtolower($r->controller());
        $action =  $r->action();
        $allowModule = array('home'); # 放行的模块
        $allowController = array('guard', 'main'); # 放行的控制器
        $allowAction = array('login','getuserinfo','updateuserinfo'); # 放行的方法
        if (
            !$user->isHavePower("{$module}/{$controller}/{$action}")
            && !in_array($module, $allowModule)
            && !in_array($controller, $allowController)
            && !in_array($action, $allowAction)
            && $userId !== 1 //超级管理员不判断权限
        ) {
            $backData = ['code' => -1 , 'msg' => '没有访问权限'];
            Response::create($backData, 'json')->send();
            exit;
        }
    }
}