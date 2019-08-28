<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MailResetPasswordNotification;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use SoftDeletes, Authenticatable, CanResetPassword, Notifiable;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id', 'email', 'password', 'email_verified_at', 'name', 'dob', 'phone', 'city', 'avatar', 'description', 'role_id', 'department_id',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('date_start', 'date_finish')->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }
}
