<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courseuser extends Model
{
    use HasFactory;

    protected $table = 'courseusers';

    protected $fillable = [
        'user_id',
        'course_id',
        'subscription_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
   
}
