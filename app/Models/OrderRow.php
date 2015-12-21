<?php
/**
 * Created by PhpStorm.
 * User: wbezou2015
 * Date: 21/12/2015
 * Time: 14:51
 */

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRow extends Model
{
    protected $table = 'order_row';

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function item()
    {
        return $this->hasOne('App\Models\Item','item_id');
    }
}