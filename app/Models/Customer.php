<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;


class Customer extends Model implements Authenticatable
{
    use SoftDeletes, AuthenticableTrait;
    protected $guard = 'customer';
    protected $table = 'customers';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id', 'email', 'password', 'name', 'company', 'phone', 'avatar', 'role_id'
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

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
