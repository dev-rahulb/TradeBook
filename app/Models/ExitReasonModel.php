<?php
namespace App\Models;

use CodeIgniter\Model;

class ExitReasonModel extends Model
{
    protected $table = 'exit_reasons';
    protected $primaryKey = 'id';
    protected $allowedFields = ['reason'];
}
