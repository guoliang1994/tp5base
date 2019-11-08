<?php
namespace app\common\controller;

use think\Session;
use think\Db;

class SingleTableCrud extends Base implements ResourceInterface
{
    public function create()
    {
        $request = $this->request;
        $input = $request->request();
        if(isset($input['id'])) {
            # 解决validate unique 新增成功后，传入新增的id，还能新增。
            unset($input['id']);
        }
        $id = $this->model->strict(false)->insertGetId($input);
        $this->model->commit();
        $backData = ['code' => 1, 'msg' => '新增成功', 'id' => $id];
        return json($backData);
    }
    public function update()
    {
        $request = $this->request;
        $input = $request->request();
        $this->model->strict(false)->where('id','eq', $input['id'])->update($input);
        $this->model->commit();
        $backData = ['code' => 1, 'msg' => '更新成功'];
        return json($backData);
    }
    public function read()
    {
        $id = input("id");
        $data = $this->model->find($id);
        $backData = ['code' => '1', 'msg' => '获取数据成功', 'data' => $data];
        return json($backData);
    }
    public function delete()
    {
        $ids = input("id");
        # 使用逗号分隔可实现批量删除
        $this->model->whereIn('id', $ids)->delete();
        $this->model->commit();
        $backData = ['code' => 1, 'msg' => '删除成功'];
        return json($backData);
    }
    public function retrieve()
    {
        $limit = input('limit') ?: 20;
        $data = $this->model->paginate($limit)->toArray();
        return json(['code' => 1,  'msg' => '获取数据成功', 'data' => $data['data'], 'count' => $data['total']]);
    }
    # 记录系统操作日志
    public function eventLog($method, $method_zh, $object)
    {
        $eventLog = Db::name('event_log');
        $loginUser = Session::get("user_info");
        $data['uid'] = $loginUser['id'];
        $data['username'] = $loginUser['name'] . "/" .$loginUser['account'];
        /*    $data['group_id'] = session('gp_id');
            $data['group_name'] = session('gp_title');*/
        $data['date_time'] = date("Y-m-d H:i:s");
        $data['method'] = $method;
        $data['method_zh'] = $method_zh;
        $data['object'] = json_encode($object);
        $data['ip'] = request()->ip();
        $eventLog->insert($data);
    }
}