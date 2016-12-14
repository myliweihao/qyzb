<?php
/**
 * Created by PhpStorm.
 * User: ��ΰ��
 * Date: 2016/11/19
 * Time: 19:18
 */

namespace App\Http\Controllers;


use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //注册管理员api
    public function admin_register(Request $request)
    {

        $username = $request->get('username');
        $password = $request->get('password');

        if (!$username)
            return err('username required');
        if (!$password)
            return err('password required');

        $admin = new Admin();
        $admin->username = $username;
        $admin->password = Hash::make($password);

        if ($admin->save())
            return success('admin_register successed');
        else
            return err('admin_register failed(db) ');
    }

    //登陆管理员api
    public function admin_login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        if (!$username)
            return err('username required');
        if (!$password)
            return err('password required');

        $admin = Admin::where('username', $username)->first();
        if (!$admin)
            return err('username not exists');
        if (!Hash::check($password, $admin->password))
            return err('username or password is failed');

        Session::put('admin_id', $admin->id);
        Session::put('admin_username', $admin->username);

        return success('login successed');
    }

    //登出管理员api
    public function admin_logout()
    {
        Session::forget('admin_id');
        Session::forget('admin_username');
        return success('logout successed');
    }

    //修改管理员密码api
    public function admin_change_password(Request $request)
    {
        $admin_id = Session::get('admin_id');
        if (!$admin_id)
            return err('login required');

        $old_password = $request->get('old_password');
        $new_password = $request->get('new_password');

        if (!$old_password)
            return err('old_password required');

        if (!$new_password)
            return err('new_password required');

        $admin = Admin::find($admin_id)->first();
        if (!$admin)
            return err('user not exists');
        if (!Hash::check($old_password, $admin->password))
            return err('invalid old_password');
        $admin->password = Hash::make($new_password);
        if ($admin->save())
            return success('change_password successed');
        else
            return err('change_password failed(db)');
    }

    //获得管理员资料api
    public function admin_get_data(Request $request)
    {

        $admin_id = Session::get('admin_id');
        if (!$admin_id)
            return err('login required');

        $data = [
            'username', 'address', 'email', 'mobile', 'sex',
            'login_at', 'login_id', 'created_at', 'updated_at'
        ];
        $admin = Admin::find($admin_id, $data);

        return success('admin_get_data successed', $admin);
    }

    //修改管理员资料api
    public function admin_change_data(Request $request)
    {
        $admin_id = Session::get('admin_id');
        if (!$admin_id)
            return err('login required');
        $admin = Admin::find($admin_id);

        if ($request->has('username'))
            $admin->username = $request->get('username');
        if ($request->has('address'))
            $admin->address = $request->get('address');
        if ($request->has('email'))
            $admin->email = $request->get('email');
        if ($request->has('mobile'))
            $admin->mobile = $request->get('mobile');
        if ($request->has('sex'))
            $admin->sex = $request->get('sex');

        if ($admin->save())
            return success('admin_change_data successed');
        else
            return err('admin_change_data failed(db)');

    }


}