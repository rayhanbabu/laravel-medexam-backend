<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsubcategory extends Model
{
    use HasFactory;
    protected $table = 'subsubcategories';
    protected $fillable = [
        'course_id',
        'category_id',
        'sub_category_id',
        'sub_sub_category_name',
        'sub_sub_category_status',
        'created_by',
        'created_at',
        'updated_at'
    ];
}
