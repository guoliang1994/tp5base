<?php
namespace app\gateway\controller;

use think\Controller;
use think\Db;
use think\Hook;
use think\Session;
use exception\LoginException;
use upc\Power;
use upc\User;

class Guard extends Controller
{
    public function login()
    {
        try{
            Hook::exec('app\\gateway\\behavior\\RegistryLoginHook'); # 注册登录钩子
            Hook::listen("login_before"); # 登录之前
            $mUser = DB::name('user');
            $input = $this->request->request();
            $userInfo = $mUser
                ->where(['account' => $input['account'], 'password' => $input['password']])->find();
            Hook::listen("login", $userInfo); #登录中
            if (!empty($userInfo)) {
                Hook::listen("login_after", $userInfo); # 登录成功后
                Session::set('user_info', $userInfo);
                return json(['code' => 1,  'data' => ['token' =>session_id()],'msg' => '登录成功', 'session_id' => session_id()]);
            } else {
                return json(['code' => -1, 'msg' => '用户名或者密码错误']);
            }
        } catch (LoginException $exception){
            return json(json_decode($exception->getMessage()));
        } catch (\Exception $exception) {
            return json(['code' => -1, 'msg' => '登录失败'.$exception->getMessage()]);
        }
    }
    public function logout()
    {
        Session::clear();
        return json(['code' => 1, 'msg' => '登出成功']);
    }
    public function vLogin()
    {
        return $this->fetch();
    }
    public function updateUserInfo()
    {
        $input = $this->request->request();
        $userId = Session::get("user_info.id");
        $input['id'] = $userId;
        $mUser = new \app\common\model\User();
        $mUser->allowField(true)->save($input, ['id' => $userId]);
        Session::set('user_info', $input);
        return json(['code' => 1, 'msg' => "更新成功"]);
    }
    public function getUserInfo()
    {
        $user = Session::get('user_info');
        $user['roles'] = ['admin'];
        return json(['code' => 1, 'data' => $user]);
        $power = new User($user['id']);
        $power = $power->getPower();
        $allow = array_column($power['allow'], 'power');
        $deny = array_column($power['deny'], 'power');
        if ($user['id'] == 1) { //超级管理员的id为1
            $user['power'] = [];
        } else if (!empty($deny) && !empty($allow)) {
            $user['power'] = array_values(array_diff($deny, $allow));
        }else if (empty($deny)) {
            // 全是正向授权
            $upcPower = new Power();
            $allPower = $upcPower->retrieve(['limit'=>10000],'','');
            $allPower = array_column($allPower['data'], 'power');
            $user['power'] = array_values(array_diff($allPower, $allow));
        }else if (empty($allow)) {
            // 全是反向授权
            $user['power'] = array_values($deny);
        }
        $user['roles'] = ['admin'];
        return json(['code' => 1, 'data' => $user]);
    }
}