<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
//header("Access-Control-Allow-Credentials: true");
use think\Hook;
//header("Access-Control-Allow-Origin:*");
Hook::import(require APP_PATH . '/tags.php');
function sendSms(Array $mobileList, $msg)
{
    foreach ($mobileList as $mobile) {
        $post_data = array();
        $post_data['userid'] = 9956;
        $post_data['account'] = 'yqyd';
        $post_data['password'] = 'yqyd654321';
        $post_data['content'] = "【安顺水文】". $msg;
        $post_data['mobile'] =  $mobile;
        $post_data['sendtime'] = '';
        $url='http://123.57.51.191:8888/sms.aspx?action=send';
        $o='';
        foreach ($post_data as $k=>$v)
        {
            $o.="$k=".urlencode($v).'&';
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
        $result = curl_exec($ch);
        preg_match("/Success/i", $result, $match);
        if (empty($match)) {
            echo $mobile.":msg send error".json_encode($result)."\r\n";
            \think\Log::write("短信发送失败".json_encode($result), "error");
        } else {
            echo $mobile.":msg send successful！\r\n";
        }
    }
}
function getOpenid($code)
{
    $appid = "wxed0465f974c666fe";
    $apps = "9fe415fc1a770e4d7b05443f3e8050e5";
//    $appid = "wx3ad95ebd43abba4b";
//    $apps = "db789ca9be696ef4fdf525a48bdd7af5";
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$apps}&js_code={$code}&grant_type=authorization_code";
    $result = json_decode(file_get_contents($url), true);
    return @$result['openid'];
}
