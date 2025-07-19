<?php

namespace App\Models;

use CodeIgniter\Model;

class EntryReasonModel extends Model
{
    protected $table = 'entry_reasons';
    protected $primaryKey = 'id';
    protected $allowedFields = ['reason'];
}
