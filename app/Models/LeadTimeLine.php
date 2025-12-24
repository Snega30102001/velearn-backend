<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadTimeLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'event',
        'remarks',
        'event_time',
        'added_by',
    ];

    /** Relationships */

    // Timeline belongs to a lead
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    // Added by user
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
