<?php

//------------------public function--------
//return failed
function err($mes, $data = null)
{
    return $data ?
        ['status' => 0, 'mes' => $mes, 'data' => $data] :
        ['status' => 0, 'mes' => $mes];
}

//return successed
function success($mes, $data = null)
{
    return $data ?
        ['status' => 1, 'mes' => $mes, 'data' => $data] :
        ['status' => 1, 'mes' => $mes];
}


//------------------STart route------------
Route::get('/', function () {
    //return view('index');
    return success('if you can here, you well can normal get Api data');
});

//-----------------user route 
Route::any('api/user_exist', ['uses' => 'UserController@user_exist']);
Route::any('api/login_user_noexist', ['uses' => 'UserController@login_user_noexist']);
Route::any('api/user_register', ['uses' => 'UserController@user_register']);
Route::any('api/user_login', ['uses' => 'UserController@user_login']);
Route::any('api/user_logout', ['uses' => 'UserController@user_logout']);
Route::any('api/nologin', function () {
    $data = ['loginUrl' => 'client know', 'backUrl' => Session::get('url')];
    return err('login required', $data);
});
Route::any('api/user_get_public_data', ['uses' => 'UserController@user_get_public_data']);


//----------------zibo route
Route::any('api/zibo_select_all', ['uses' => 'ZiboController@zibo_select_all']);

//----------------dianbo route
Route::any('api/dianbo_select_all', ['uses' => 'DianBoController@dianbo_select_all']);

//----------------yubo route
Route::any('api/yubo_select_all', ['uses' => 'YuBoController@yubo_select_all']);


Route::group(['middleware' => ['checklogined']], function () {
    //----------------- user route
    Route::any('api/user_change_password', ['uses' => 'UserController@user_change_password']);
    Route::any('api/user_get_primary_data', ['uses' => 'UserController@user_get_primary_data']);
    Route::any('api/user_change_data', ['uses' => 'UserController@user_change_data']);

    //----------------- program route
    Route::any('api/program_insert', ['uses' => 'ProgramController@program_insert']);
    Route::any('api/program_delete', ['uses' => 'ProgramController@program_delete']);
    Route::any('api/program_update', ['uses' => 'ProgramController@program_update']);
    Route::any('api/program_select', ['uses' => 'ProgramController@program_select']);

    //----------------- programtype route
    Route::any('api/programtype_insert', ['uses' => 'ProgramTypeController@programtype_insert']);
    Route::any('api/programtype_delete', ['uses' => 'ProgramTypeController@programtype_delete']);

    //----------------- zibo route
    Route::any('api/zibo_insert', ['uses' => 'ZiBoController@zibo_insert']);
    Route::any('api/zibo_delete', ['uses' => 'ZiBoController@zibo_delete']);
    Route::any('api/zibo_update', ['uses' => 'ZiBoController@zibo_update']);
    Route::any('api/zibo_select_single', ['uses' => 'ZiBoController@zibo_select_single']);

    //----------------- dianbo route
    Route::any('api/dianbo_insert', ['uses' => 'DianBoController@dianbo_insert']);
    Route::any('api/dianbo_delete', ['uses' => 'DianBoController@dianbo_delete']);
    Route::any('api/dianbo_update', ['uses' => 'DianBoController@dianbo_update']);
    Route::any('api/dianbo_select_single', ['uses' => 'DianBoController@dianbo_select_single']);

    //----------------- yubo route
    Route::any('api/yubo_insert', ['uses' => 'YuBoController@yubo_insert']);
    Route::any('api/yubo_delete', ['uses' => 'YuBoController@yubo_delete']);
    Route::any('api/yubo_update', ['uses' => 'YuBoController@yubo_update']);
    Route::any('api/yubo_select_single', ['uses' => 'YuBoController@yubo_select_single']);

});


//---------------------admin route -----------------
Route::any('api/admin_register', ['uses' => 'AdminController@admin_register']);
Route::any('api/admin_login', ['uses' => 'AdminController@admin_login']);
Route::any('api/admin_logout', ['uses' => 'AdminController@admin_logout']);
Route::any('api/admin_change_password', ['uses' => 'AdminController@admin_change_password']);
Route::any('api/admin_get_data', ['uses' => 'AdminController@admin_get_data']);
Route::any('api/admin_change_data', ['uses' => 'AdminController@admin_change_data']);


Route::any('api/programtype_select', ['uses' => 'ProgramTypeController@programtype_select']);
Route::any('api/getuserdata', ['uses' => 'ZiBoController@getuserdata']);





