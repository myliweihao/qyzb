<?php

namespace App\Http\Controllers;

use App\ProgramType;
use App\YuBo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class YuBoController extends Controller
{
    //增加点播节目单api
    public function yubo_insert(Request $request)
    {
        if (!$request->has('title'))
            return err('title required');
        if (!$request->has('type_id'))
            return err('type_id required');
        if (!ProgramType::find($request->input('type_id')))
            return err('invalid type_id');

        $yubo = new YuBo();
        if ($request->has('describe')) $yubo->describe = $request->input('describe');
        if ($request->has('imagesrc')) $yubo->imagesrc = $request->input('imagesrc');
        if ($request->has('starttime')) $yubo->starttime = $request->input('starttime');
        if ($request->has('lasttime')) $yubo->lasttime = $request->input('lasttime');
        $yubo->title = $request->input('title');
        $yubo->type_id = $request->input('type_id');
        $yubo->user_id = Session::get('user_id');
        $yubo->banned = 0;  //$request->input('banned') ? 1 : 0;       // 1:禁播 0：没禁播
        $yubo->reviewed = 0;  //$request->input('reviewed') ? 1 : 0;  //  1:通过审核 0：没通过审核

        if ($yubo->save())
            return success('yubo_insert successed');
        else
            return err('yubo_insert failed(db)');
    }

    //删除点播节目单api
    public function yubo_delete(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $yubo = YuBo::find($id);
        if (!$yubo) return err('invalid id');
        if (Session::get('user_id') != $yubo->user_id) return err('permission denied');
        if ($yubo->delete())
            return success('yubo_delete successed');
        else
            return err('yubo_delete failed(db)');
    }

    //修改点播节目单api
    public function yubo_update(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $yubo = YuBo::find($id);
        if (!$yubo) return err('invalid id');
        if (Session::get('user_id') != $yubo->user_id) return err('permission denied');

        if ($request->has('title')) $yubo->title = $request->input('title');
        if ($request->has('describe')) $yubo->describe = $request->input('describe');
        if ($request->has('starttime')) $yubo->starttime = $request->input('starttime');
        if ($request->has('lasttime')) $yubo->lasttime = $request->input('lasttime');
        if ($request->has('imagesrc')) $yubo->imagesrc = $request->input('imagesrc');
        if ($request->has('type_id')) $yubo->type_id = $request->input('type_id');

        if ($yubo->save())
            return success('yubo_update successed');
        else
            return err('yubo_update failed(db)');
    }

    //查找单个点播节目单api
    public function yubo_select_single(Request $request)
    {
        $id = $request->input('id');
        if (!$id) return err('id required');
        $yubo = YuBo::find($id);
        if (!$yubo) return err('invalid id');
        if (Session::get('user_id') != $yubo->user_id) return err('permission denied');
        return success('yubo_select_single program successed', $yubo) ?: err('yubo_select_single program failed');
    }

    //查找所有点播节目单api
    public function yubo_select_all(Request $request)
    {
        $yubo = new YuBo();
        return success('yubo_select all program successed',
            $yubo->with('hasOneUser')->with('hasOneType')->orderBy('starttime')->get()->keyBy('id')) ?: err('yubo_select all program failed');
    }

    //系统管理员操作api
}
