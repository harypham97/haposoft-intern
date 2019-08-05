<?php
/**
 * Created by PhpStorm.
 * User: jvgiv
 * Date: 8/1/2019
 * Time: 5:29 PM
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $table = 'roles';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name'];

    public function user()
    {
        return $this->hasMany('App\Model\User');
    }

    public function customer()
    {
        return $this->hasMany('App\Model\Customer');
    }

    public function admin()
    {

    }
}