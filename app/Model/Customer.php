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

class Customers extends Model
{
    use SoftDeletes;
    protected $table = 'customers';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'email', 'full_name', 'company_name', 'phone_number', 'content', 'avatar'];
}