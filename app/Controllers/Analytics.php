<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class Analytics extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        $userId = session()->get('user_id');

        // Step 1: Get date range
        $dateQuery = $db->query("SELECT MIN(date) as start_date, MAX(date) as end_date FROM journal_entries WHERE user_id = ?", [$userId])->getRowArray();
        $startDate = $this->request->getGet('start_date') ?? $dateQuery['start_date'];
        $endDate   = $this->request->getGet('end_date') ?? $dateQuery['end_date'];

        // Step 2: Summary Stats
        $summary = $db->query("
            SELECT 
                COUNT(*) as total_trades,
                SUM(CASE WHEN pnl >= 0 THEN 1 ELSE 0 END) / COUNT(*) * 100 as win_rate,
                SUM(pnl) as net_pnl,
                ROUND(AVG(pnl), 2) as avg_pnl
            FROM journal_entries
            WHERE user_id = ? AND date BETWEEN ? AND ?
        ", [$userId, $startDate, $endDate])->getRowArray();

        $totalTrades = $summary['total_trades'] ?? 0;
        $averagePnL  = $summary['avg_pnl'] ?? 0;
        $netPnL      = $summary['net_pnl'] ?? 0;
        $winRate     = $summary['win_rate'] ?? 0;

        // Step 3: Total Profit & Loss
        $totalProfit = $db->query("
            SELECT SUM(pnl) as total_profit
            FROM journal_entries
            WHERE user_id = ? AND pnl > 0 AND date BETWEEN ? AND ?
        ", [$userId, $startDate, $endDate])->getRow('total_profit') ?? 0;

        $totalLoss = abs($db->query("
            SELECT SUM(pnl) as total_loss
            FROM journal_entries
            WHERE user_id = ? AND pnl < 0 AND date BETWEEN ? AND ?
        ", [$userId, $startDate, $endDate])->getRow('total_loss') ?? 0);

        // Step 4: Best & Worst Trades
        $bestTrades = $db->query("
            SELECT id, stock, pnl, date FROM journal_entries 
            WHERE user_id = ? AND date BETWEEN ? AND ?
            ORDER BY pnl DESC LIMIT 5
        ", [$userId, $startDate, $endDate])->getResultArray();

        $worstTrades = $db->query("
            SELECT id, stock, pnl, date FROM journal_entries 
            WHERE user_id = ? AND date BETWEEN ? AND ?
            ORDER BY pnl ASC LIMIT 5
        ", [$userId, $startDate, $endDate])->getResultArray();

        // Step 5: Monthly P&L
        $monthlyPL = $db->query("
            SELECT DATE_FORMAT(date, '%Y-%m') as month, SUM(pnl) as total_pnl
            FROM journal_entries
            WHERE user_id = ? AND date BETWEEN ? AND ?
            GROUP BY month ORDER BY month ASC
        ", [$userId, $startDate, $endDate])->getResultArray();

        $monthlyPnLData = [];
        foreach ($monthlyPL as $row) {
            $monthlyPnLData[$row['month']] = round($row['total_pnl'], 2);
        }

        // Step 6: Strategy Stats
        $strategyStats = $db->query("
            SELECT 
                IFNULL(strategy_type, 'No Strategy') as strategy, 
                COUNT(*) as trades, 
                SUM(pnl) as pnl
            FROM journal_entries
            WHERE user_id = ? AND date BETWEEN ? AND ?
            GROUP BY strategy
        ", [$userId, $startDate, $endDate])->getResultArray();

        $strategyCounts = [];
        foreach ($strategyStats as $row) {
            $strategyCounts[$row['strategy']] = $row['trades'];
        }

        // Step 7: Mistake Stats
        $mistakeStats = $db->query("
            SELECT m.reason as mistake, COUNT(jm.id) as count
            FROM journal_mistakes jm
            JOIN mistakes m ON jm.mistake_id = m.id
            JOIN journal_entries j ON jm.journal_id = j.id
            WHERE j.user_id = ? AND j.date BETWEEN ? AND ?
            GROUP BY mistake
        ", [$userId, $startDate, $endDate])->getResultArray();

        $mistakeCounts = [];
        foreach ($mistakeStats as $row) {
            $mistakeCounts[$row['mistake']] = $row['count'];
        }

        // Step 8: Calmness Distribution
        $calmnessData = $db->query("
            SELECT calmness, COUNT(*) as count
            FROM journal_entries
            WHERE user_id = ? AND date BETWEEN ? AND ?
            GROUP BY calmness
        ", [$userId, $startDate, $endDate])->getResultArray();

        $calmnessCounts = [];
        foreach ($calmnessData as $row) {
            $calmnessCounts[$row['calmness']] = $row['count'];
        }

        // Step 9: Day of Week Stats
        $dayStats = $db->query("
            SELECT DAYNAME(date) as day, COUNT(*) as trades, SUM(pnl) as pnl
            FROM journal_entries
            WHERE user_id = ? AND date BETWEEN ? AND ?
            GROUP BY day ORDER BY FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday')
        ", [$userId, $startDate, $endDate])->getResultArray();

        // Step 10: Profit Distribution
        $profitDistribution = $db->query("
            SELECT pnl FROM journal_entries 
            WHERE user_id = ? AND date BETWEEN ? AND ?
        ", [$userId, $startDate, $endDate])->getResultArray();

        // Step 11: Duration Stats
        $durationStats = $db->query("
            SELECT 
                ROUND(AVG(TIMESTAMPDIFF(MINUTE, buy_time, sell_time))) as avg_minutes,
                ROUND(MAX(TIMESTAMPDIFF(MINUTE, buy_time, sell_time))) as max_minutes,
                ROUND(MIN(TIMESTAMPDIFF(MINUTE, buy_time, sell_time))) as min_minutes
            FROM journal_entries
            WHERE user_id = ? AND date BETWEEN ? AND ?
        ", [$userId, $startDate, $endDate])->getRowArray();


        // Step 12: Top Strategy
$topStrategy = $db->query("
    SELECT IFNULL(strategy_type, 'No Strategy') as strategy, SUM(pnl) as total_pnl
    FROM journal_entries
    WHERE user_id = ? AND date BETWEEN ? AND ?
    GROUP BY strategy
    ORDER BY total_pnl DESC
    LIMIT 1
", [$userId, $startDate, $endDate])->getRowArray();

// Step 13: Average Risk-Reward Ratio
// Step 13: Average Risk-Reward Ratio (Calculated via logic)
$rrQuery = $db->query("
    SELECT 
        ROUND(AVG(
            CASE 
                WHEN trade_type = 'long' AND (buy_price - stop_loss) > 0 THEN 
                    (target - buy_price) / (buy_price - stop_loss)
                WHEN trade_type = 'short' AND (stop_loss - buy_price) > 0 THEN 
                    (buy_price - target) / (stop_loss - buy_price)
                ELSE NULL
            END
        ), 2) as avg_rr
    FROM journal_entries
    WHERE user_id = ? AND date BETWEEN ? AND ?
", [$userId, $startDate, $endDate])->getRowArray();




        // ✅ Return view with all data
        return view('analytics/index', [
            'start_date'           => $startDate,
            'end_date'             => $endDate,
            'totalTrades'          => $totalTrades,
            'totalProfit'          => $totalProfit,
            'totalLoss'            => $totalLoss,
            'netPnL'               => $netPnL,
            'averagePnL'           => $averagePnL,
            'winRate'              => $winRate,
            'bestTrades'           => $bestTrades,
            'worstTrades'          => $worstTrades,
            'monthlyPnL'           => $monthlyPnLData,
            'strategyStats'        => $strategyStats,
            'strategyCounts'       => $strategyCounts,
            'mistakeStats'         => $mistakeStats,
            'mistakeCounts'        => $mistakeCounts,
            'calmnessCounts'       => $calmnessCounts,
            'dayStats'             => $dayStats,
            'profitDistribution'   => $profitDistribution,
            'durationStats'        => $durationStats,
             'topStrategy'          => $topStrategy,
    'avgRiskReward'        => $rrQuery['avg_rr'] ?? null,
        ]);
    }
}
