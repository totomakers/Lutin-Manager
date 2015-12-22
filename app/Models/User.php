<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable as Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    public $timestamps = false;

    protected $table = 'user';

    protected $hidden = ['sha1_password', 'remember_token']; //exclude from the api

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'user_id');
    }
}