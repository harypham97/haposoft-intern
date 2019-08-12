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

class Report extends Model
{
    use SoftDeletes;
    protected $table = 'reports';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
