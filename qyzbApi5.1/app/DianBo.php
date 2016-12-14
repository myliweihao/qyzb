<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DianBo extends Model
{
    protected $table = 'tb_dianbo';
    protected $primaryKey = 'id';

    protected function getDateFormat()
    {
        return time();
    }

    public function hasOneUser()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }

    public function hasOneType()
    {
        return $this->hasOne('App\ProgramType', 'id', 'type_id');
    }
}
