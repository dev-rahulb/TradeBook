<?php
namespace App\Models;
use CodeIgniter\Model;

class JournalExitReasonModel extends Model
{
    protected $table = 'journal_exit_reasons';
    protected $allowedFields = ['journal_id', 'reason_id'];
    public $timestamps = false;
}
