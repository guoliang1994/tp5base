<?php
namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule =   [
        'id'  => 'require',
        'title'  => 'require',
        'classification_id'  => 'require',
        'content'  => 'require',
    ];

    protected $message  =   [
        'id.require' => '{"code": -1, "field":"id", "msg":"id不能为空"}',
        'title.require' => '{"code": -1, "field":"title", "msg":"标题不能为空"}',
        'classification_id.require' => '{"code": -1, "field":"classification_id", "msg":"请选择文章分类"}',
    ];
    public $scene = [
        'create' => ['title','classification_id', 'content'],
        'update' => ['id','title','classification_id', 'content'],
        'read' => ['id'],
        'delete' => ['id']
    ];
}