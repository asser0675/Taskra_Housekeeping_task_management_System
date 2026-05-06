<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelSetting extends Model
{
    protected $fillable = [
        'hotel_name',
        'currency',
        'timezone',
        'language',
        'task_notifications',
        'issue_alerts',
        'email_notifications',
    ];

    protected function casts(): array
    {
        return [
            'task_notifications' => 'boolean',
            'issue_alerts' => 'boolean',
            'email_notifications' => 'boolean',
        ];
    }
}