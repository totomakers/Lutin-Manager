<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    public $timestamps = false;

    public function rows()
    {
        return $this->hasMany('App\Models\OrderRow','item_id');
    }

}