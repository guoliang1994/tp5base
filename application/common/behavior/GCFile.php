<?php
namespace app\common\behavior;

use think\Cache;
use think\Db;
use think\Response;

class GCFile
{
    /*
     * 垃圾文件清除行为类
     * 1.处理了上传文件，但是不提交表单生成的垃圾文件
     * 2.处理了用户选择照片，然后又修改照片，形成的垃圾文件
     * 3.处理了富文本编辑器上传，不保存文章产生的垃圾文件
     * 4.用户保存数据后，删除资源后，相应的资源删除
     * 5.用户修改数据，删除相应资源后，相应的资源删除
     * */
    public function run(&$params)
    {
        $mMedia = Db::name('media');
        $r = request()->request();
        preg_match_all('/http[s].*?.(jpg|png|jpeg|gif)/miu', print_r($r, true), $match);
        switch ($params[1]) {
            case 'delete':
                $mMedia->whereIn('path', $match[0])->update(['is_use' => 0]);
                break;
            case 'create':
                $mMedia->whereIn('path', $match[0])->update(['is_use' => 1]);
                break;
            case 'update':
                $updateToken =input("update_token");
                $rawData = Cache::get($updateToken); // 获取原始数据，用于对比
                if(empty($updateToken)) {
                    $backData = ['code' => -1, 'msg' => '缺少update_token参数'];
                    Response::create($backData, 'json')->send();
                    exit;
                }
                if (!empty($rawData)) {
                    preg_match_all('/http[s].*?.(jpg|png|jpeg|gif)/miu', print_r($rawData, true), $rawDataMatch);
                    $delete = array_diff($match[0], $rawDataMatch[0]); // 数组求差,得到删掉的数据
                    $mMedia->whereIn('path', $delete)->update(['is_use' => 0]);
                }
                break;
            default:
                break;
        }
        $this->gc();
    }
    protected function gc(){
        $mMedia = Db::name('media');
        $gc = rand(1, 200);
        if ($gc == 38) {
            $deleteFile = $mMedia
                ->where('is_use', 'eq', 0)
                ->where('create_time',"lt", date("Y-m-d H:i:s", strtotime("-3 days")))
                ->select();
            preg_match_all('/upload.*?.(jpg|png|jpeg|gif|mp4)/miu', print_r($deleteFile, true), $match);
            if (!empty($match[0])) {
                foreach ($match[0] as $item) {
                    @unlink($item);
                }
            }
            $mMedia->whereIn('id', array_column($deleteFile, 'id'))->delete();
        }
    }
}