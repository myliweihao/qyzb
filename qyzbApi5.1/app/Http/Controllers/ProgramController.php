<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/14
 * Time: 11:17
 */

namespace App\Http\Controllers;


use App\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProgramController extends Controller
{
    //添加节目api
    public function program_insert(Request $request)
    {
        $program = new Program();
        $program->banned = $request->input('banned', 0); //1:禁播 0未禁播
        $program->name = $request->input('name');
        $program->programsrc = $request->input('programsrc');
        $program->remark = $request->input('remark');
        $program->reviewed = $request->input('reviewed', 1); // 1:审核通过 0:审核未通过
        $program->starttime = $request->input('starttime');
        $program->lasttime = $request->input('lasttime');
        $program->streamsrc = $request->input('streamsrc');
        $program->typeid = $request->input('typeid');
        $program->user_id = Session::get('user_id');

        if ($program->save())
            return success('program_insert successed');
        else
            return err('program_insert db failed');
    }

    //删除节目api
    public function program_delete(Request $request)
    {
        $id = $request->get('id');
        if (!$id) return err('id required');

        $program = Program::find($id);
        if (!$program) return err('invalid id');

        if (!($program->user_id == Session::get('user_id')))
            return err('permission denied');
        if ($program->delete())
            return success('program_delete successed');
        else
            return err('program_delete db failed');

    }

    //修改节目api
    public function program_update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) return err('id required');

        $program = Program::find($id);
        if (!$program) return err('id no exists');

        if (!($program->user_id == Session::get('user_id')))
            return err('permission denied');

        if ($request->has('banned'))
            $program->banned = $request->input('banned', 0);//1:禁播 0未禁播
        if ($request->has('name'))
            $program->name = $request->input('name');
        if ($request->has('programsrc'))
            $program->programsrc = $request->input('programsrc');
        if ($request->has('remark'))
            $program->remark = $request->input('remark');
        if ($request->has('reviewed'))
            $program->reviewed = $request->input('reviewed', 1); // 1:审核通过 0:审核未通过
        if ($request->has('starttime'))
            $program->starttime = $request->input('starttime');
        if ($request->has('lasttime'))
            $program->lasttime = $request->input('lasttime');
        if ($request->has('streamsrc'))
            $program->streamsrc = $request->input('streamsrc');
        if ($request->has('typeid'))
            $program->typeid = $request->input('typeid');
        if ($request->has('user_id'))
            $program->user_id = Session::get('user_id');

        if ($program->save())
            return success('program_update successed');
        else
            return err('program_update db failed');

    }

    //查找节目api
    public function program_select(Request $request)
    {

        $id = $request->get('id');

        if ($id)
            return success($id . ' - select successed ', Program::find($id));

        $limit = $request->get('limit') ?: 10;
        $result = Program::orderBy('id', 'asc')->limit($limit)->get()->keyBy('id');
        return success('all id  select successed ', $result);
    }

}