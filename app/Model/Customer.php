<?php
/**
 * Created by PhpStorm.
 * User: jvgiv
 * Date: 8/1/2019
 * Time: 3:34 PM
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use SoftDeletes;
    protected $table = 'customers';
    protected $dates = ['deleted_at'];
<<<<<<< HEAD
    protected $fillable = ['id', 'email', 'full_name', 'company_name', 'phone_number', 'content', 'avatar'];
}
=======
    protected $fillable = ['id', 'email', 'password', 'name', 'company', 'phone', 'avatar', 'role_id'];

    public function role()
    {
        return $this->belongsTo('App\Model\Role', 'role_id');
    }

    public function projects()
    {
        return $this->hasMany('App\Model\Project');
    }
}
>>>>>>> 2d0f237... crud login logout
