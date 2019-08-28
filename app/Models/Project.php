<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $table = 'projects';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id', 'name', 'description', 'date_start', 'date_finish', 'customer_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('date_start', 'date_finish')->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
