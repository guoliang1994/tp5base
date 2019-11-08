<?php
namespace app\common\validate;

use think\Validate;

class Address extends Validate
{
    protected $rule =   [
        'id'  => 'require',
        'name'  => 'require',
        'mobile'  => 'require|length:11',
    ];

    protected $message  =   [
        'id.require' => '{"code": 0, "field":"type", "msg":"ID不能为空"}',
        'name.require' => '{"code": 0, "field":"type_code", "msg":"地址不能为空"}',
        'mobile.require' => '{"code": 0, "field":"place", "msg":"手机号不能为空"}',
        'mobile.length' => '{"code": 0, "field":"place", "msg":"无效的手机号"}',
    ];
    public $scene = [
        'create' => ['mobile', 'name'],
        'update' => ['id','mobile', 'name'],
        'read' => ['id'],
        'delete' => ['id'],
    ];
}