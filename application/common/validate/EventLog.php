<?php
namespace app\common\validate;

use think\Validate;

class EventLog extends Validate
{
    protected $rule =   [
        'type'  => 'require',
        'place'  => 'require',
        'number'  => 'require',
    ];

    protected $message  =   [

        'id.require' => '{"code": 0, "field":"id", "msg":"id不能为空"}',
        'id.number' => '{"code": 0, "field":"id", "msg":"id只能为数字"}',
    ];
    public $scene = [
        'account' => [''],
        'info' => ['id'],
    ];
}