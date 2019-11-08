<?php
namespace app\common\model;

class CommonProblem extends Base
{
    protected $dateFormat=false;
    public function __construct($data = [])
    {
        if(!empty($data)) {
        }
        parent::__construct($data);
    }
    // 获取器
    public function getContentAttr($content)
    {
        return preg_replace("/\r\n/", "", $content);
    }
}