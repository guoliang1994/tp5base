<?php
namespace app\file\controller;

use think\Controller;

Class Help extends Controller
{
    public function _empty()
    {
        $html =  $this->fetch();
        return json(array('code' => 1, 'msg' => "获取成功", 'html' => $html));
    }
}
