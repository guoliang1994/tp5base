<?php
namespace app\common\behavior;

use think\Response;
use think\Session;

class CheckLogin
{
    public function run(&$params)
    {
        $controllerName = request()->controller();
        $actionName = request()->action();
        $moduleName = request()->module();
        $allowModule = array('home'); # 放行的模块
        $allowController = array('guard'); # 放行的控制器
        $allowAction = array('login'); # 放行的方法
        $token = request()->request('token');
        if (!empty($token)) {
            session_id($token);
            session_start();
        }
        $userInfo = Session::get('user_info');
        if (empty($userInfo)
            && !in_array($moduleName, $allowModule)
            && !in_array($actionName, $allowAction)
            && !in_array($controllerName, $allowController)
        ) {
            $backData = ['code' => -1 , 'msg' => '未登陆'];
            Response::create($backData, 'json')->send();
            exit;
        }
    }
}