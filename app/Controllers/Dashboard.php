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
}
