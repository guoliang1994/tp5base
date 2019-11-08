<?php
namespace app\home\validate;

use think\Validate;

class User extends Validate
{
    protected $rule =   [
        'nickname'  => 'require',
    ];
    protected $message  =   [
        'nickname.require' => '{"code": -1,"msg":"必须传昵称"}',
    ];
    public $scene = [

    ];
}