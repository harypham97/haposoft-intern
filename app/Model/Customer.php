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

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customers';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'email', 'password', 'name', 'company', 'phone', 'avatar', 'role_id'];

    public function role()
    {
        return $this->belongsTo('App\Model\Role', 'role_id');
    }

    public function project()
    {
        return $this->hasMany('App\Model\Project');
    }
}