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


class Task extends Model
{
    use SoftDeletes;
    protected $table = 'tasks';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name', 'hour', 'project_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Model\User','user_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Model\Project','project_id');
    }

    public function reports()
    {
        return $this->belongsToMany('App\Model\Report');
    }
}
