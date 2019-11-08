<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule =   [
        'id' => 'require|number',
        'account'  => 'require',
        'password'  => 'require',
        'name'  => 'require',
        'type'  => 'require',
    ];

    protected $message  =   [
        'id.require' => '{"code":  -1, "field":"id", "msg":"id参数不能为空"}',
        'id.number' => '{"code":  -1, "field":"id", "msg":"id只能为数字"}',
        'account.require' => '{"code":  -1, "field":"id", "msg":"账号不能为空"}',
        'password.require' => '{"code":  -1, "field":"password", "msg":"密码不能为空"}',
        'name.require' => '{"code":  -1, "field":"name", "msg":"姓名不能为空"}',
        'type.require' => '{"code": -1, "field":"type", "msg":"用户类型不能为空"}',
    ];
    public $scene = [
        'create' => ['name', 'type'],
        'update' => ['id', 'name', 'type'],
        'read' => ['id'],
        'delete' => ['id']
    ];
}