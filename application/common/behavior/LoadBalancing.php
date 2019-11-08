<?php
namespace app\common\behavior;

use think\Config;

class LoadBalancing
{
    # 分布式负载均衡部署，Cache，Session均采用Redis作为缓存驱动，单机采用文件缓存。
    # 搭建高可用的负载均衡环境
    public function run(&$params)
    {
        $ha = Config::get("high_availability");
        if (!empty($ha)) {
            Config::set(
                array(
                    'cache' => [
                        'type'   => 'redis',
                        'prefix' => 'cache_',
                        'timeout' => 3,
                        'expire' => (24-date("H"))*3600,
                        'host' =>  $ha["vip"],
                        'port' => 6379
                    ],
                    'session'                => [
                        'id'             => '',
                        'var_session_id' => '',
                        'prefix'         => 'session_',
                        'type'           => 'redis',
                        'timeout' => 3,
                        'auto_start'     => true,
                        'host' => $ha["vip"],
                        'port' => 6379
                    ],
                )
            );
        }
    }
}