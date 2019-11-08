<?php
namespace app\gateway\validate;

use think\Validate;

class Guard extends Validate
{
    protected $rule =   [
        'account'  => 'require',
        'password'  => 'require',
    ];

    protected $message  =   [
        'account.require' => '{"code": -1, "field":"account", "msg":"账号不能为空"}',
        'password.require' => '{"code": -1, "field":"password", "msg":"密码不能为空"}',
    ];
    public $scene = [
        'login' => ['account','password'],
    ];
}