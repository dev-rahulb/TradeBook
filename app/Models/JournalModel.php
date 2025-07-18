<?php
namespace App\Models;

use CodeIgniter\Model;

class JournalModel extends Model
{
    protected $table = 'journal_entries';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'date', 'stock', 'stop_loss', 'target',
        'buy_time', 'sell_time', 'buy_price', 'sell_price',
        'quantity', 'qty_of_trades', 'pnl', 'rating',
        'entry_reason', 'exit_reason', 'mistake', 'lessons', 'user_id','calmness' ,'strategy_type',
    ];

    // ✅ Enable soft deletes
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';

    // Optional: Enable timestamps if you want created_at/updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
