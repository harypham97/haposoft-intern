<?php
/**
 * Created by PhpStorm.
 * User: jvgiv
 * Date: 8/1/2019
 * Time: 3:34 PM
 */

namespace App\Models;


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
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}
