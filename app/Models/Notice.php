<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;

class Notice extends Model
{
    use HasFactory;
    // use LogsActivity;

    protected $fillable = [
        'title',
        'short_desc',
        'image',
        'date',
        'desc',
        'pagecategory_id',
        'notice_status',
    ];


    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['*']);
    //     // Chain fluent methods for configuration options
    // }
}
