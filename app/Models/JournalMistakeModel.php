<?php
namespace App\Models;
use CodeIgniter\Model;

class JournalMistakeModel extends Model
{
    protected $table = 'journal_mistakes';
    protected $allowedFields = ['journal_id', 'mistake_id'];
    public $timestamps = false;
}
