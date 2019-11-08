<?php
namespace app\home\model;

use think\Db;
use think\Model;
use think\Request;

class GameUser extends Model
{
    protected $dateFormat = false;
    public function __construct($data = [])
    {
        parent::__construct($data);
    }
}