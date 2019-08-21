<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
    protected $table = 'reports';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id', 'name', 'description', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('date','time_start','time_end')->withTimestamps();
    }
}
