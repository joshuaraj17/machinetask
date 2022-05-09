<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',        
        'job_position',
        'started_year',
        'started_month',
        'end_year',
        'end_month',
        'created_at',
        'updated_at',
    ];
}
