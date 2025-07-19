<?php

namespace App\Models;

use CodeIgniter\Model;

class WeeklySuggestionModel extends Model
{
    protected $table = 'weekly_suggestions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 'week_start', 'week_end', 'suggestions', 'is_manual','performance_score'
    ];

    protected $useTimestamps = true;
}
