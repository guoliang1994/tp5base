<?php
namespace app\gateway\behavior;

use user_agent\UserAgent;
use think\Db;

class LoginLog
{
    /*记录登录日志*/
    public function run(&$user)
    {
        $userAgent = new UserAgent();
        $data = array(
            'system' => $userAgent::system(),
            'system_version' => $userAgent::systemVersion(),
            'browser' => $userAgent::browser(),
            'browser_version' => $userAgent::browserVersion(),
            'browser_core' => $userAgent::browserCore(),
            'language' => $userAgent::language(),
            'device_type' => $userAgent::deviceType(),
            'login_ip' => request()->ip(),
            'login_name' => $user['username'],
            'datetime' => date("Y-m-d H:i:s"),
        );
        Db::name('user_loginlog')->insert($data);
    }
}