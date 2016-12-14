<?php
/**
 * Created by PhpStorm.
 * User: ��ΰ��
 * Date: 2016/11/19
 * Time: 17:56
 */

namespace App\Http\Controllers;


use App\ProgramType;
use Illuminate\Http\Request;

class ProgramTypeController extends Controller
{
    //添加节目类型api
    public function programtype_insert(Request $request)
    {
        $programtype = new ProgramType();

        $programtype->id = $request->get('description');
        $programtype->name = $request->get('name');

        if ($programtype->save())
            return success('programtype_insert successed');
        else
            return err('programtype_insert db failed');
    }

    //添加节目类型api
    public function programtype_delete(Request $request)
    {
        $id = $request->get('id');
        if (!$id)
            return err('id required');

    }


    //查询节目类型
    public function programtype_select()
    {
        $programtype = ProgramType::get();
        if (!$programtype) return err('programtype_select failed');
        return success('programtype_select successed', $programtype);

    }

}