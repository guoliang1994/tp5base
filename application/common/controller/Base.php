<?php
namespace app\common\controller;

use think\Controller;
use think\Request;
use think\Db;

abstract class Base extends Controller
{
    protected  $controllerName;
    protected  $model;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $request = Request::instance();
        $controllerName = $request->controller();
        $this->controllerName = $controllerName;
        $this->model = Db::name($controllerName);
    }
    /*
     * 增删改查的界面返回
     * */
    public function vCreate()
    {
        $id = $this->request->request("id");
        $url = url("{$this->controllerName}/create");
        if (!empty($id)) {
            $url = url("{$this->controllerName}/update");
        }
        $this->assign('url', $url);
        return $this->fetch();
    }
    public function vRetrieve()
    {
        return $this->fetch();
    }
    public function vUpdate()
    {
        return $this->fetch();
    }
    public function vRead()
    {
        return $this->fetch();
    }
}