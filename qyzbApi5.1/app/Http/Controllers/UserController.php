<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    //验证注册用户是否存在
    public function user_exist(Request $request)
    {
        $username = $request->input('mobile');
        $user_exists = User::where('mobile', $username)->get()->count();
        if ($user_exists)
            return success('user exists');
        return err('user not exists');
    }

    //用户注册api
    public function user_register(Request $request)
    {
        $username = $request->input('mobile');
        $password = $request->input('password');

        if (!$username || !$password)
            return err('mobile or password is empty');

        $user_exists = User::where('mobile', $username)->get()->count();
        if ($user_exists)
            return err('user is exists');
        $hashed_password = Hash::make($password);


        $user = new User();
        $user->mobile = $request->input('mobile');
        $user->password = $hashed_password;
        $user->nickname = $request->input('mobile');

        /*
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->email = $request->input('email');
        $user->loginip = $request->input('loginip');
        $user->loginstatus = $request->input('loginstatus');
        $user->photosrc = $request->input('photosrc');
        $user->sex = $request->input('sex');
        $user->type = $request->input('type');*/

        if ($user->save())
            return success('register successed');
        else
            return err('db insert failed');
    }

    //验证登陆的用户是否不存在
    public function login_user_noexist(Request $request)
    {
        $username = $request->input('mobile');
        if (!$username) return err('mobile requird');
        $user_exists = User::where('mobile', $username)->get()->count();
        if (!$user_exists)
            return success('user noexists');
        return err('user exists');
    }


    //用户登陆api
    public function user_login(Request $request)
    {
        $username = $request->input('mobile');
        $password = $request->input('password');

        if (!$username || !$password)
            return err('mobile or password is empty');

        $user = User::where('mobile', $username)->first();

        if (!$user)
            return err('user not exists');

        if (!Hash::check($password, $user->password))
            return err('username or password is failed');

        Session::put('user_id', $user->user_id);
        Session::put('nickname', $user->nickname);
        $session_qianduan = ['user_id' => $user->user_id, 'nickname' => $user->nickname];
        return success('login success', $session_qianduan);
    }

    //用户登出api
    public function user_logout()
    {
        Session::forget('user_id');
        Session::forget('nickname');

        return success('logout successed');
    }

    //用户修改密码api
    public function user_change_password(Request $request)
    {
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');

        if (!$old_password || !$new_password)
            return err('old_password or new_password is empty');

        $user = User::find(Session::get('user_id'));
        if (!Hash::check($old_password, $user->password))
            return err('invalid old_password');

        $user->password = Hash::make($new_password);

        if ($user->save())
            return success('change_password successed');
        else
            return err('change_password failed');

    }

    //用户找回密码api
    //-----------------------------------

    //获得用户公开资料api
    public function user_get_public_data(Request $request)
    {
        $user_id = $request->input('user_id');
        if (!$user_id) return err('user_id required');

        $get = ['address', 'name', 'nickname', 'photosrc', 'sex', 'type'];
        $user = User::find($user_id, $get);

        if (!$user) return err('user_id donot exists');
        return success('get_user_data successed', $user);

    }

    //获得用户私密资料api
    public function user_get_primary_data(Request $request)
    {
        $user_id = $request->get('user_id');
        if (!$user_id) return err('user_id required');

        if (!($user_id == Session::get('user_id')))
            return err('permission denied');

        $get = ['user_id', 'address', 'email', 'mobile', 'name', 'nickname', 'photosrc', 'sex', 'type'];
        $user = User::find($user_id, $get);

        if (!$user) return err('user_id donot exists');
        return success('get_user_data successed', $user->toArray());
    }

    //修改用户资料api
    public function user_change_data(Request $request)
    {
        $user_id = $request->get('user_id');
        if (!$user_id) return err('user_id required');

        if (!($user_id == Session::get('user_id')))
            return err('permission denied');
        $user = User::find($user_id);

        if ($request->has('address'))
            $user->address = $request->input('address');
        if ($request->has('email'))
            $user->email = $request->input('email');
        if ($request->has('mobile'))
            $user->mobile = $request->input('mobile', $user->mobile);
        if ($request->has('name'))
            $user->name = $request->input('name');
        if ($request->has('nickname'))
            $user->nickname = $request->input('nickname');
        if ($request->has('photosrc'))
            $user->photosrc = $request->input('photosrc');
        if ($request->has('sex'))
            $user->sex = $request->input('sex');
        if ($request->has('type'))
            $user->type = $request->input('type');

        if ($user->save())
            return success('change_user_data successed');
        else
            return err('db update failed');
    }


}
