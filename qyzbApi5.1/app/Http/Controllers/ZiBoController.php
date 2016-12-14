<?php

namespace App\Http\Controllers;

use App\ZiBo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ZiBoController extends Controller
{
    //增加直播节目单api
    public function zibo_insert(Request $request)
    {
        if (!$request->has('title'))
            return err('title required');
        if (!$request->has('type_id'))
            return err('type_id required');
        if (!ProgramType::find($request->input('type_id')))
            return err('invalid type_id');

        $zibo = new ZiBo();
        if ($request->has('describe')) $zibo->describe = $request->input('describe');
        if ($request->has('zibosrc')) $zibo->zibosrc = $request->input('zibosrc');
        if ($request->has('starttime')) $zibo->starttime = $request->input('starttime');
        if ($request->has('lasttime')) $zibo->lasttime = $request->input('lasttime');
        $zibo->title = $request->input('title');
        $zibo->type_id = $request->input('type_id');
        $zibo->user_id = Session::get('user_id');
        $zibo->banned = 0;  //$request->input('banned') ? 1 : 0;       // 1:禁播 0：没禁播
        $zibo->reviewed = 0;  //$request->input('reviewed') ? 1 : 0;  //  1:通过审核 0：没通过审核

        if ($zibo->save())
            return success('zibo_insert successed');
        else
            return err('zibo_insert failed(db)');
    }

    //删除直播节目单api
    public function zibo_delete(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $zibo = ZiBo::find($id);
        if (!$zibo) return err('invalid id');
        if (Session::get('user_id') != $zibo->user_id) return err('permission denied');
        if ($zibo->delete())
            return success('zibo_delete successed');
        else
            return err('zibo_delete failed(db)');
    }

    //修改直播节目单api
    public function zibo_update(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $zibo = ZiBo::find($id);
        if (!$zibo) return err('invalid id');
        if (Session::get('user_id') != $zibo->user_id) return err('permission denied');

        if ($request->has('title')) $zibo->title = $request->input('title');
        if ($request->has('describe')) $zibo->describe = $request->input('describe');
        if ($request->has('starttime')) $zibo->starttime = $request->input('starttime');
        if ($request->has('lasttime')) $zibo->lasttime = $request->input('lasttime');
        if ($request->has('zibosrc')) $zibo->zibosrc = $request->input('zibosrc');
        if ($request->has('type_id')) $zibo->type_id = $request->input('type_id');

        if ($zibo->save())
            return success('zibo_update successed');
        else
            return err('zibo_update failed(db)');
    }

    //查找单个直播节目单api
    public function zibo_select_single(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $zibo = ZiBo::find($id);
        if (!$zibo) return err('invalid id');
        if (Session::get('user_id') != $zibo->user_id) return err('permission denied');
        return success('zibo_select_single program successed', $zibo) ?: err('zibo_select_single program failed');
    }

    //查找所有直播节目单api
    public function zibo_select_all(Request $request)
    {
        $zibo = new ZiBo();
        return success('zibo_select all program successed',
            $zibo->with('hasOneUser')->with('hasOneProgramType')->orderBy('starttime')->get()->where('banned', '=', 0)) ?: err('zibo_select all program failed');
    }

    public function getuserdata()
    {
        return success('test', ZiBo::find(20)->user);
    }

    //系统管理员操作api

}
