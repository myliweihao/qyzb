<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZiBo extends Model
{
    //
    protected $table = 'tb_zibo';
    protected $primaryKey = 'id';

    protected function getDateFormat()
    {
        return time();
    }

    public function hasOneUser()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }

    public function hasOneProgramType()
    {
        return $this->belongsTo('App\ProgramType', 'type_id', 'id');
    }

}
