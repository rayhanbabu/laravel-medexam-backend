<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'course_id',
        'category_id',
        'sub_category_id',
        'sub_sub_category_id',
        'created_by',
        'updated_by',
        'status',
        'description'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $attributes = [
        'status' => 1, // Default value for status
    ];
    
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
