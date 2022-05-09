<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_name',        
        'institution_name',
        'year',
        'percentage',
        'created_at',
        'updated_at',
    ];
}
