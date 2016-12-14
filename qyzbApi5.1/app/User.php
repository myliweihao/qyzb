<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = 'tb_user';
    protected $primaryKey = 'user_id';

    protected function getDateFormat()
    {
        return time();
    }

    /*protected function asDateTime($val)
    {
        return $val;
    }*/

}
