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

class Reports extends Model
{
    use SoftDeletes;
    protected $table = 'reports';
    protected $dates = ['deleted_at'];
<<<<<<< HEAD
    protected $fillable = ['id', 'email', 'full_name', 'company_name', 'phone_number', 'content', 'avatar'];
}
=======
    protected $fillable = ['id', 'name', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function tasks()
    {
        return $this->belongsToMany('App\Model\Task');
    }
}
>>>>>>> 2d0f237... crud login logout
