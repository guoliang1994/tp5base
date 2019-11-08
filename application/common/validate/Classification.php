<?php
namespace app\common\validate;

use think\Validate;

class Classification extends Validate
{
    protected $rule =   [
        'id'  => 'require',
        'name'  => 'require|unique'
    ];
    protected $message  =   [
        'id.require' => '{"code": -1, "field":"id", "msg":"id不能为空"}',
        'name.require' => '{"code": -1, "field":"id", "msg":"分类名称不能为空"}',
        'name.unique' => '{"code": -1, "field":"id", "msg":"分类名称已存在"}',
    ];
    public $scene = [
        'create' => ['name'],
        'update' => ['id', 'name'],
        'delete' => ['id'],
        'read' => ['id']
    ];
}