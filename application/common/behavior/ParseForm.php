<?php
namespace app\common\behavior;

use crypto\Aes;
use crypto\Rsa;
use think\Config;
use think\Request;

class ParseForm
{
    # 加密的参数解密存放到超全局变量 $_REQUEST
    public function run(&$params)
    {
        $request = Request::instance();
        $input = $request->request();
        if (in_array($request->action(),Config::get("security"))) {
            $rsa = new Rsa();
            $aseKey = $rsa->decrypt($input['aseKey']);
            $aes = new AES("aes-256-cbc", $aseKey, 0, $input['iv']);
            $plaintext = $aes->decrypt($input['ciphertext']);
            parse_str($plaintext,$input); # 解析参数
            $_REQUEST = $input;
        }
    }
}