<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'task_id', 'reported_by', 'description', 'status'
    ];

    public function task() {
        return $this->belongsTo(Task::class);
    }

    public function reporter() {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
