<?php
namespace App\Models;

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
        return $this->belongsTo('App\Models\Item','item_id');
    }
}