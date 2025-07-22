<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;
class Dashboard extends Controller
{
   public function index()
{
    $session = session();

    // Check if the user is logged in
    if (! $session->get('isLoggedIn')) {
        return redirect()->to('/login')->with('error', 'Please login to access dashboard');
    }

    $userId = $session->get('user_id');
    $userName = $session->get('user_name');

    $journalModel = new \App\Models\JournalModel();

    // Calculate analytics
    $totalEntries = $journalModel->where('user_id', $userId)->countAllResults();
    $totalPL = $journalModel->where('user_id', $userId)->selectSum('pnl')->first()['pnl'] ?? 0;
    $winningTrades = $journalModel->where('user_id', $userId)->where('pnl >', 0)->countAllResults();
    $losingTrades = $journalModel->where('user_id', $userId)->where('pnl <', 0)->countAllResults();
    $recentEntries = $journalModel->where('user_id', $userId)->orderBy('date', 'DESC')->limit(5)->findAll();
$totalTrades = $winningTrades + $losingTrades;
$winRate = $totalTrades > 0 ? round(($winningTrades / $totalTrades) * 100, 2) : 0;

 $db = Database::connect();
        // Step 12: Top Strategy
$topStrategy= $db->query("
    SELECT IFNULL(strategy_type, 'No Strategy') as strategy, SUM(pnl) as total_pnl
    FROM journal_entries
    WHERE user_id = ?  
    GROUP BY strategy
    ORDER BY total_pnl DESC
    LIMIT 1
", [$userId])->getRowArray();
$topStrategy = $topStrategy['strategy'] ?? 'NA';


// Fetch Fear Days (Overtrading or Big Loss Days)
$fearDays = $db->query("
    SELECT DATE(date) as trade_date, COUNT(*) as total_trades, SUM(pnl) as net_pnl
    FROM journal_entries
    WHERE user_id = ?
    GROUP BY trade_date
    HAVING total_trades > 5 OR net_pnl < -1000
    ORDER BY
        net_pnl ASC,
        CASE
            WHEN net_pnl < -3000 THEN 1
            WHEN net_pnl < -1000 THEN 2
            WHEN total_trades > 10 THEN 3
            ELSE 4
        END,
        trade_date DESC
    LIMIT 5
", [$userId])->getResultArray();

$fearData = [];

foreach ($fearDays as $day) {
    $date = $day['trade_date'];

    $trades = $db->query("
        SELECT je.id, je.pnl, je.date, je.stock, je.strategy_type, je.lessons
        FROM journal_entries je
        WHERE user_id = ? AND DATE(date) = ?
    ", [$userId, $date])->getResultArray();

    $noMistakeCount = 0;
    $mistakeSet = [];
    $lessons = [];

    foreach ($trades as $trade) {
        if (!empty($trade['lessons'])) {
            $lessons[] = $trade['lessons'];
        }

        $mistakes = $db->query("
            SELECT m.reason
            FROM journal_mistakes jm
            JOIN mistakes m ON jm.mistake_id = m.id
            WHERE jm.journal_id = ?
        ", [$trade['id']])->getResultArray();

        if (empty($mistakes)) {
            $noMistakeCount++;
        } else {
            foreach ($mistakes as $m) {
                $mistakeSet[] = $m['reason'];
            }
        }
    }

    $fearReason = [];
    if ($day['net_pnl'] < -1000) $fearReason[] = 'Big Loss';
    if ($day['total_trades'] > 5) $fearReason[] = 'Overtrading';

    $fearData[] = [
        'date' => $date,
        'total_trades' => $day['total_trades'],
        'net_pnl' => $day['net_pnl'],
        'no_mistake_count' => $noMistakeCount,
        'unique_mistakes' => array_unique($mistakeSet),
        'lessons' => array_unique($lessons),
        'fear_reason' => implode(', ', $fearReason),
    ];
}

    // Prepare data
    $data = [
        'title' => 'Dashboard',
        'user_name' => $userName,
        'totalEntries' => $totalEntries,
        'totalPL' => $totalPL,
        'winningTrades' => $winningTrades,
        'losingTrades' => $losingTrades,
        'recentEntries' => $recentEntries,
        'winRate'=>$winRate,
        'topStrategy'=>$topStrategy,
        'fearDays'             => $fearData, // ← Add this
    ];

    return view('dashboard', $data);
}
}
