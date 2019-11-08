<?php
namespace app\gateway\behavior;

use think\Hook;

class RegistryLoginHook
{
    /*
     * 登录钩子注册
     * */
    public function run(&$params)
    {
        $this->registry('login_before', ['LoginPassword']);
        $this->registry('login', ['LoginLock']);
        //$this->registry('login_after', ['LoginLog']);
    }
    protected function registry($hookName, $hook)
    {
        foreach ($hook as $item) {
            Hook::add($hookName, "app\\gateway\\behavior\\$item");
        }
    }
}