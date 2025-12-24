<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /** Relationships */

    // A course has many types
    public function courseTypes()
    {
        return $this->hasMany(CourseType::class);
    }

    // A course has many leads
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
