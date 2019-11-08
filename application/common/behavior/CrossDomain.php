<?php
namespace app\common\behavior;

class CrossDomain
{
    public function run(&$params)
    {
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("Access-Control-Allow-Origin:*");
            header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Cookie, token, x-token");
            header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');
            die(10000);
        }
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin: *'); // *代表允许任何网址请求
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin, token'); // 设置允许自定义请求头的字段
    }
}