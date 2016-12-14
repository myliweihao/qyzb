<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'tb_program';
    protected $primaryKey = 'id';

    protected function getDateFormat()
    {
        return time();
    }

    /*protected function asDateTime($val)
    {
        return $val;
    }*/

}