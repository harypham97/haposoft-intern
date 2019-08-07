<?php
/**
 * Created by PhpStorm.
 * User: jvgiv
 * Date: 8/1/2019
 * Time: 3:32 PM
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'email', 'password', 'email_verified_at', 'name', 'dob', 'city', 'avatar', 'description', 'role_id'];

    public function role()
    {
        return $this->belongsTo('Roles', 'role_id', 'id');
    }

    public function project()
    {

    }

    public function task()
    {

    }

    public function report()
    {

    }
<<<<<<< HEAD

}
=======
}
>>>>>>> 2d0f237... crud login logout
