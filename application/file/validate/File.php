<?php
namespace app\file\validate;

use think\Validate;

class File extends Validate
{
    protected $rule =   [
        'login_name'  => 'require',
        'password'   => 'require',
    ];
    protected $message  =   [
        'login_name.require' => '{"code": 10100,"msg":"用户名不能为空"}',
        'password.require' => '{"code": 10101,"msg":"密码不能为空"}',
    ];
    public $scene = [
        'login' => ['login_name', 'password'],
    ];
}