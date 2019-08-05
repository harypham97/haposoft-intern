<?php
/**
 * Created by PhpStorm.
 * User: jvgiv
 * Date: 8/4/2019
 * Time: 7:06 AM
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $table = 'departments';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name', 'manager_id'];

    public function user()
    {
        return $this->hasMany('App\Model\User', 'manager_id');
    }
}