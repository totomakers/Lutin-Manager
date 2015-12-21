<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 21/12/2015
 * Time: 13:54
 */

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable as Authenticatable;

class User implements AuthenticatableContract
{
    use Authenticatable;

    public $timestamps = false;

    protected $table = 'user';

    protected $hidden = ['sha1_password', 'remember_token']; //exclude from the api
}