<?php
namespace App\Models;
use CodeIgniter\Model;

class JournalEntryReasonModel extends Model
{
    protected $table = 'journal_entry_reasons';
    protected $allowedFields = ['journal_id', 'reason_id'];
    public $timestamps = false;
}
