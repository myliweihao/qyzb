<?php

namespace App\Http\Controllers;

use App\DianBo;
use App\ProgramType;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class DianBoController extends Controller
{
    //增加点播节目单api
    public function dianbo_insert(Request $request)
    {
        if (!$request->has('title'))
            return err('title required');
        if (!$request->has('type_id'))
            return err('type_id required');
        if (!ProgramType::find($request->input('type_id')))
            return err('invalid type_id');

        $dianbo = new DianBo();
        if ($request->has('describe')) $dianbo->describe = $request->input('describe');
        if ($request->has('dianbosrc')) $dianbo->dianbosrc = $request->input('dianbosrc');
        if ($request->has('starttime')) $dianbo->starttime = $request->input('starttime');
        if ($request->has('lasttime')) $dianbo->lasttime = $request->input('lasttime');
        $dianbo->title = $request->input('title');
        $dianbo->type_id = $request->input('type_id');
        $dianbo->user_id = Session::get('user_id');
        $dianbo->banned = 0;  //$request->input('banned') ? 1 : 0;       // 1:禁播 0：没禁播
        $dianbo->reviewed = 0;  //$request->input('reviewed') ? 1 : 0;  //  1:通过审核 0：没通过审核

        if ($dianbo->save())
            return success('dianbo_insert successed');
        else
            return err('dianbo_insert failed(db)');
    }

    //删除点播节目单api
    public function dianbo_delete(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $dianbo = DianBo::find($id);
        if (!$dianbo) return err('invalid id');
        if (Session::get('user_id') != $dianbo->user_id) return err('permission denied');
        if ($dianbo->delete())
            return success('dianbo_delete successed');
        else
            return err('dianbo_delete failed(db)');
    }

    //修改点播节目单api
    public function dianbo_update(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $dianbo = DianBo::find($id);
        if (!$dianbo) return err('invalid id');
        if (Session::get('user_id') != $dianbo->user_id) return err('permission denied');

        if ($request->has('title')) $dianbo->title = $request->input('title');
        if ($request->has('describe')) $dianbo->describe = $request->input('describe');
        if ($request->has('starttime')) $dianbo->starttime = $request->input('starttime');
        if ($request->has('lasttime')) $dianbo->lasttime = $request->input('lasttime');
        if ($request->has('dianbosrc')) $dianbo->dianbosrc = $request->input('dianbosrc');
        if ($request->has('type_id')) $dianbo->type_id = $request->input('type_id');

        if ($dianbo->save())
            return success('dianbo_update successed');
        else
            return err('dianbo_update failed(db)');
    }

    //查找单个点播节目单api
    public function dianbo_select_single(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $dianbo = DianBo::find($id);
        if (!$dianbo) return err('invalid id');
        if (Session::get('user_id') != $dianbo->user_id) return err('permission denied');
        return success('dianbo_select_single program successed', $dianbo) ?: err('dianbo_select_single program failed');
    }

    //查找所有点播节目单api
    public function dianbo_select_all(Request $request)
    {
        $dianbo = new DianBo();
        return success('dianbo_select all program successed',
            $dianbo->with('hasOneUser')->with('hasOneType')->orderBy('starttime')->get()->keyBy('id')) ?: err('dianbo_select all program failed');
    }

    //系统管理员操作api
}
