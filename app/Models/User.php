<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Task;
use App\Models\Issue;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    // 
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    // 
    public function reportedIssues()
    {
        return $this->hasMany(Issue::class, 'reported_by');
    }

    // 
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}