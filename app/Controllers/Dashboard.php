<?php

namespace App\Controllers;

use CodeIgniter\Controller;

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
    ];

    return view('dashboard', $data);
}
public function analytics()
{
    $session = session();

    if (! $session->get('isLoggedIn')) {
        return redirect()->to('/login')->with('error', 'Login first to view analytics');
    }

    $userId = $session->get('user_id');
    $journalModel = new \App\Models\JournalModel();

    // Monthly P&L
    $monthlyPL = $journalModel->select("DATE_FORMAT(date, '%Y-%m') as month, SUM(pnl) as total_pl")
        ->where('user_id', $userId)
        ->groupBy('month')
        ->orderBy('month', 'ASC')
        ->findAll();

    // Strategy Stats
    $strategyStats = $journalModel->select("strategy_type, COUNT(*) as total, 
        SUM(CASE WHEN pnl > 0 THEN 1 ELSE 0 END) as wins")
        ->where('user_id', $userId)
        ->groupBy('strategy_type')
        ->findAll();

    // Trades by Day of Week with P&L
    $dayStats = $journalModel->select("DAYNAME(date) as day, COUNT(*) as total, SUM(pnl) as pl")
        ->where('user_id', $userId)
        ->groupBy('day')
        ->orderBy("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
        ->findAll();

    $data = [
        'monthlyPL' => $monthlyPL,
        'strategyStats' => $strategyStats,
        'dayStats' => $dayStats,
        'title' => 'Analytical Dashboard',
    ];

    return view('analytics', $data);
}


}
