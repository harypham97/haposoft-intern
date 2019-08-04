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

class Projects extends Model
{
    use SoftDeletes;
    protected $table = 'projects';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'email', 'full_name', 'company_name', 'phone_number', 'content', 'avatar'];
}