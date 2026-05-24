<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Room;
use App\Models\Issue;

class Task extends Model
{
    protected $fillable = [
        'room_id',
        'assigned_to',
        'created_by',
        'task_type',
        'status',
        'priority',
        'deadline'
    ];

    protected $casts = [
        'deadline' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    //  Task → Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    //  
    public function housekeeper()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Task → Creator (Head/Manager)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Task → Issues
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}