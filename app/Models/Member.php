<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Member extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'plot_id',
        'phone',
        'password',
        'email',
        'member_no',
        'bangla_name',
        'member_name',
        'dept',
        'member_category',
        'member_type',
        'member_status',
        'deed_no',
        'date_of_deed',
        'farm_no',
        'plot_buy',
        'plot_sell',
        'land_registration_name',
        'tax_year',
    ];

    //  protected static $logAttributes = ['*'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }



}
