<?php
/**
 * Created by PhpStorm.
 * User: wbezou2015
 * Date: 21/12/2015
 * Time: 14:37
 */

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    public $timestamps = false;
}