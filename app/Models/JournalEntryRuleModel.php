<?php
namespace App\Models;

use CodeIgniter\Model;

class JournalEntryRuleModel extends Model
{
    protected $table = 'journal_entry_rules';
    protected $primaryKey = 'id';
    protected $allowedFields = ['journal_entry_id', 'rule_id', 'status'];
}
