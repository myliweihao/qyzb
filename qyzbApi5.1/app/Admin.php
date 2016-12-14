<?php
/**
 * Created by PhpStorm.
 * User: ÀîÎ°ºÀ
 * Date: 2016/11/19
 * Time: 19:08
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tb_admin';
    protected $primaryKey = 'id';

    protected function getDateFormat()
    {
        return time();
    }
}