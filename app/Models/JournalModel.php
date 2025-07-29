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
        'quantity', 'qty_of_trades', 'pnl', 'self_rating',
        'entry_reason', 'exit_reason', 'mistake', 'lessons', 'user_id','calmness' ,'strategy_type',
    ];

    // ✅ Enable soft deletes
    protected $useSoftDeletes = false;
    protected $deletedField  = 'deleted_at';

    // Optional: Enable timestamps if you want created_at/updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getTradeStatsByDay($userId)
{
    return $this->select("DAYNAME(date) as day")
        ->selectCount('id', 'total')
        ->selectSum('sell_price - buy_price', 'net_pl')
        ->selectAvg('sell_price - buy_price', 'avg_pl')
        ->selectSum("CASE WHEN sell_price > buy_price THEN 1 ELSE 0 END", 'wins', false)
        ->where('user_id', $userId)
        ->groupBy('day')
        ->orderBy("FIELD(DAYNAME(date), 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')", '', false)
        ->findAll();
}

}
