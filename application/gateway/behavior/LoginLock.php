<?php
namespace app\gateway\behavior;

use think\Cache;
use exception\LoginException;
use think\Request;

class LoginLock
{
    public function run(&$user)
    {
        $input = Request::instance();
        $input = $input->request();
        $times = (int)Cache::get($input['account']);
        $lockTime = 30;
        if (empty($user) && $times < 5) {
            Cache::set($input['account'], $times+1, $lockTime);
        }
        if ($times == 5) {
            throw new LoginException('{"code": -1,"msg":"密码连续输入错误5次，接口封禁30s"}');
        }
    }
}