<?php
namespace app\common\validate;

use think\Validate;

class Appointment extends Validate
{
    protected $rule =   [
        'id' => 'require',
        'openid'  => 'require',
        'name'  => 'require',
        'mobile'  => 'number|length:11',
        'address'  => 'require',
        'area'  => 'require',
        'type'  => 'require',
    ];

    protected $message  =   [
        'id.require' => '{"code": -1, "field":"id", "msg":"id不能为空"}',
        'openid.require'  => '{"code": -1, "field":"id", "msg":"openid不能为空"}',
        'name.require' => '{"code": -1, "field":"name", "msg":"用户名称不能为空"}',
        'mobile.number' => '{"code": -1, "field":"mobile", "msg":"手机号格式不正确"}',
        'mobile.length' => '{"code": -1, "field":"mobile", "msg":"手机号格式不正确"}',
        'area.require' => '{"code": -1, "field":"area", "msg":"房间面积不能为空"}',
        'address.require' => '{"code": -1, "field":"address", "msg":"地址不能为空"}',
        'type.require' => '{"code": -1, "field":"type", "msg":"预约类型不能为空"}',
    ];
    public $scene = [
        'create' => ['openid', 'name', 'mobile', 'address', 'area', 'type'],
        'update' => ['id','openid', 'name', 'mobile', 'address', 'area', 'type'],
        'read' => ['id'],
        'delete' => ['id']
    ];
}