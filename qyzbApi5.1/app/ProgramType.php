<?php
/**
 * Created by PhpStorm.
 * User: ÀîÎ°ºÀ
 * Date: 2016/11/19
 * Time: 17:53
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ProgramType extends Model
{
    protected $table = 'tb_programtype';

    protected $primaryKey = 'id';

    protected function getDateFormat()
    {
        return time();
    }

}