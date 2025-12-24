<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
    ];

    /** Relationships */

    // Course type belongs to a course
    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    // Course type has many leads
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
