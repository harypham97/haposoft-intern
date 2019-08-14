<?php
/**
 * Created by PhpStorm.
 * User: jvgiv
 * Date: 8/1/2019
 * Time: 5:29 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $table = 'roles';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function admin()
    {

    }
}
