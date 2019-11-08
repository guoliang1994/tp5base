<?php
namespace app\common\validate;

use think\Validate;

class Game extends Validate
{
    protected $rule =   [
        'game_id'  => 'require',
        'start_time'  => 'require',
        'end_time'  => 'require',
        'name'  => 'require',
        'play_time'  => 'require',
        'cover_img'  => 'require',
    ];

    protected $message  =   [
        'game_id.require' => '{"code": -1, "field":"id", "msg":"id不能为空"}',
        'start_time.require' => '{"code": -1, "field":"type_code", "msg":"开始时间不能为空"}',
        'end_time.require' => '{"code": -1, "field":"type_code", "msg":"结束时间不能为空"}',
        'name.require' => '{"code": -1, "field":"type_code", "msg":"游戏名称不能为空"}',
        'play_time.require' => '{"code": -1, "field":"type_code", "msg":"游戏时间不能为空"}',
        'cover_img.require' => '{"code": -1, "field":"type_code", "msg":"请上传封面图片"}',
    ];
    public $scene = [
        'create' => ['start_time','end_time', 'name', 'play_time', 'cover_img'],
        'update' => ['id','start_time','end_time', 'name', 'play_time', 'cover_img'],
    ];
}