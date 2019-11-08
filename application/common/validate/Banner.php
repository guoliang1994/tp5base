<?php
namespace app\common\validate;

use think\Validate;

class Banner extends Validate
{
    protected $rule =   [
        'id'  => 'require',
        'img'  => 'url',
    ];

    protected $message  =   [
        'id.require' => '{"code": -1, "field":"id", "msg":"id不能为空"}',
        'img.url' => '{"code": -1, "field":"img", "msg":"请上传图片"}',
    ];
    public $scene = [
        'create' => ['img'],
        'update' => ['id', 'img'],
    ];
}