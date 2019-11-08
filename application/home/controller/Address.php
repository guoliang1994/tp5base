<?php
namespace app\home\controller;

use think\Controller;
use \app\common\model\Address as mAddress;

class Address extends Controller
{
    public function retrieve()
    {

        $input = $this->request->request();
        if (isset($input['parent_id'])) {
            $where = ['parent_id' => $input['parent_id']];
        } else{
            $where = ['parent_id' => 0];
        }
        $mAddress = new mAddress();
        $data = $mAddress->where($where)->select();
        return json(['code' => 1, 'data' => $data]);
    }
}