<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'subscription_id',
        'invoice_number',
        'amount',
        'payment_status',
        'payment_method',
        'transaction_id',
        'status',
    ];

    public function course()
    {
        return $this->hasOneThrough(Course::class, CourseUser::class, 'id', 'id', 'courseuser_id', 'course_id');
    }
    

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function user()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }
}
