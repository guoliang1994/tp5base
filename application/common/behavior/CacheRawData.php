<?php
namespace app\common\behavior;

use think\Cache;
use think\Request;

class CacheRawData
{
    public function run(&$params)
    {
        $request = Request::instance();
        $data= $params->getData();
        if ($request->action() === 'read' && !empty($data)) {
            $updateToken = uniqid("raw_data");
            Cache::set($updateToken, $data, 3*24*3600);
            $params->data(array_merge(['update_token' => $updateToken], $data));
        }
    }
}