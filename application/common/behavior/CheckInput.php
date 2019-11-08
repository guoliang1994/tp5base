<?php
namespace app\common\behavior;

use think\Request;
use think\Response;
use think\Loader;

class CheckInput
{
    public function run(&$params)
    {
        $request = Request::instance();
        $requestPayload = json_decode($request->getInput(), 'true');
        $input = $request->request();
        // 适配vue-admin post数据时候发送的request payload
        if (is_array($requestPayload)) {
            $input = array_merge($input, $requestPayload);
            $request->request($input);
        }
        try{
            $validate = Loader::validate($request->controller());
            if (isset($validate->scene[$request->action()])) {
                $result = $validate->scene($request->action())->check($input);
                if (false === $result) {
                    Response::create(json_decode($validate->getError()), 'json')->send();
                    exit;
                }
            }
        } catch (\Exception $exception) {
            // 不处理Validate找不到这个异常。
        }
    }
}