<?php
namespace app\file\controller;

use think\Controller;
use think\Db;

Class File extends Controller
{
    public function upload()
    {
        $files = request()->file('file');
        $info = $files->rule('date')->move(ROOT_PATH . 'public/upload');
        $filePath = "https://".$_SERVER['HTTP_HOST']."/upload/".date("Ymd")."/".$info->getFilename();
        if($info){
            $mMedia = Db::name("media");
            $mMedia->insert(['path' => $filePath, 'create_time' => date("Y-m-d H:i:s")]);
            return json(['code' => 1, 'msg' => '上传成功', 'file_path' => $filePath]);
        }else{
            return json(['code' => -1, 'msg' => $files->getError()]);
        }
    }
    public function wangEditorUpload()
    {
        try{
            $files = request()->file('image');
            $info = $files->rule('uniqid')->move(ROOT_PATH . 'public/upload');
            if($info){
                return json(['errno' => 0, 'msg' => '上传成功', 'data' => ["https://".$_SERVER['HTTP_HOST']."/upload/".$info->getFilename()]]);
            }else{
                return json(['errno' => -1, 'msg' => $files->getError()]);
            }
        } catch (\Exception $e) {
            return json(['errno' => -1, 'msg' => '上传失败'.$e->getMessage()]);
        }
    }
    public function download()
    {
        $input = $this->request->request();
        $filePath = ROOT_PATH . 'public' . DS . 'uploads/file'.DS.$input['file_name'];
        if(file_exists($filePath)){
            header("Content-type:application/octet-stream");
            $filename = basename($filePath);
            header("Content-Disposition:attachment;filename = ".$filename);
            header("Accept-ranges:bytes");
            header("Accept-length:".filesize($filePath));
            readfile($filePath);
        }else{
            echo "<script>alert('文件不存在')</script>";
        }
    }
}