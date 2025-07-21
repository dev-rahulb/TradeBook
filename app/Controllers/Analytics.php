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

        // Default to current month
        $currentMonthStart = date('Y-m-01');
        $currentMonthEnd   = date('Y-m-t');

        $startDate = $this->request->getGet('start_date') ?? $currentMonthStart;
        $endDate   = $this->request->getGet('end_date') ?? $currentMonthEnd;

        // Summary Stats
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

        // Best & Worst Trades
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

        // Monthly P&L
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

        // Mistake Stats
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

        // Day of Week Stats
        $dayStats = $db->query("
            SELECT DAYNAME(date) as day, COUNT(*) as trades, SUM(pnl) as pnl
            FROM journal_entries
            WHERE user_id = ? AND date BETWEEN ? AND ?
            GROUP BY day ORDER BY FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday')
        ", [$userId, $startDate, $endDate])->getResultArray();

        // Profit Distribution
        $profitDistribution = $db->query("
            SELECT pnl FROM journal_entries 
            WHERE user_id = ? AND date BETWEEN ? AND ?
        ", [$userId, $startDate, $endDate])->getResultArray();

        // Top Strategy (only if shown)
        $topStrategy = $db->query("
            SELECT IFNULL(strategy_type, 'No Strategy') as strategy, SUM(pnl) as total_pnl
            FROM journal_entries
            WHERE user_id = ? AND date BETWEEN ? AND ?
            GROUP BY strategy
            ORDER BY total_pnl DESC
            LIMIT 1
        ", [$userId, $startDate, $endDate])->getRowArray();

        return view('analytics/index', [
            'start_date'           => $startDate,
            'end_date'             => $endDate,
            'totalTrades'          => $totalTrades,
            'netPnL'               => $netPnL,
            'averagePnL'           => $averagePnL,
            'winRate'              => $winRate,
            'bestTrades'           => $bestTrades,
            'worstTrades'          => $worstTrades,
            'monthlyPnL'           => $monthlyPnLData,
            'mistakeCounts'        => $mistakeCounts,
            'dayStats'             => $dayStats,
            'profitDistribution'   => $profitDistribution,
            'topStrategy'          => $topStrategy,
        ]);
    }
}
