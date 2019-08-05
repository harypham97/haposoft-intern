<?php
/**
 * Created by PhpStorm.
 * User: jvgiv
 * Date: 8/1/2019
 * Time: 3:33 PM
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $table = 'projects';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name', 'description', 'date_start', 'date_finish', 'customer_id'];

    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }

    public function tasks()
    {
        return $this->hasMany('App\Model\Task');
    }

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id');
    }
}