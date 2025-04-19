<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $fillable = [
        'course_name',
        'course_description',
        'course_image',
        'course_status',
        'created_by',
        'updated_by',
        'serial',
    ];

    public function category()
      {
          return $this->hasMany(Category::class);
      }


      public function subcategory()
      {
          return $this->hasMany(Subcategory::class);
      }


      public function subsubcategory()
      {
          return $this->hasMany(Subsubcategory::class);
      }

   

}
