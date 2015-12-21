<?php
/**
 * Created by PhpStorm.
 * User: wbezou2015
 * Date: 21/12/2015
 * Time: 14:39
 */

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $timestamps = false;

    static const WAITING = 0;
    static const IN_PROGRESS = 1;
    static const VALIDATE = 2;

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id');
    }

    public function rows()
    {
        return $this->hasMany('App\Models\OrderRow','order_id','id');
    }
}