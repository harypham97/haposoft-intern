<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Model
{
    use SoftDeletes;
    protected $table = 'tasks';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id', 'name', 'hour', 'project_id', 'user_id', 'description'
    ];

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
        return $this->belongsToMany(Report::class)->withPivot('date','time_start','time_end')->withTimestamps();
    }
}
