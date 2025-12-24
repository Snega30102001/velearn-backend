<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'source',
        'course_id',
        'course_type_id',
        'assigned_to',
        'status',
        'created_by',
    ];

    /** Relationships */

    // Lead created by a user
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Lead belongs to a course
    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    // Lead belongs to a course type
    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    // Lead has many timeline logs
    public function timeLines()
    {
        return $this->hasMany(LeadTimeLine::class);
    }

    // Lead belongs to a assigned user
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

}
