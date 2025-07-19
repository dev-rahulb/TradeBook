<?php

namespace App\Controllers;

use App\Models\JournalModel;
use CodeIgniter\Controller;
use App\Models\EntryReasonModel;
use App\Models\ExitReasonModel;
use App\Models\MistakeModel;

class Journal extends BaseController
{
    protected $journal;

    public function __construct()
    {
        $this->journal = new JournalModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['entries'] = $this->journal
            ->where('user_id', session()->get('user_id'))
            ->orderBy('date', 'DESC')
            ->findAll();

        return view('journal/journal_list', $data);
    }

    public function create()
    {
         $entryModel = new EntryReasonModel();
    $exitModel = new ExitReasonModel();
    $mistakeModel = new MistakeModel();

    $entryReasons = $entryModel->asObject()->findAll();
    $exitReasons = $exitModel->asObject()->findAll();
    $mistakes = $mistakeModel->asObject()->findAll();
        return view('journal/create_entry', [
        'entryReasons' => $entryReasons,
        'exitReasons' => $exitReasons,
        'mistakes' => $mistakes,
    ]);
    }

  public function store()
{
    // Load models
    $entryModel   = new \App\Models\JournalEntryReasonModel();
    $exitModel    = new \App\Models\JournalExitReasonModel();
    $mistakeModel = new \App\Models\JournalMistakeModel();

    // Save main journal
    $journalData = [
        'user_id'       => session()->get('user_id'),
        'date'          => $this->request->getPost('date'),
        'stock'         => $this->request->getPost('stock'),
        'stop_loss'     => $this->request->getPost('stop_loss'),
        'target'        => $this->request->getPost('target'),
        'buy_time'      => $this->request->getPost('buy_time'),
        'sell_time'     => $this->request->getPost('sell_time'),
        'buy_price'     => $this->request->getPost('buy_price'),
        'sell_price'    => $this->request->getPost('sell_price'),
        'quantity'      => $this->request->getPost('qty'),
        'pnl'           => $this->request->getPost('pnl'),
        'lessons'       => $this->request->getPost('lesson'),
        'strategy_type' => $this->request->getPost('strategy_type'),
        'calmness'      => $this->request->getPost('calmness'),
        'trade_type'    => $this->request->getPost('trade_type'),
    ];

    $this->journal->save($journalData);
    $journalId = $this->journal->getInsertID();

    // Save Entry Reasons
    $entryReasons = $this->request->getPost('entry_reason');
    if ($entryReasons && is_array($entryReasons)) {
        foreach ($entryReasons as $reasonId) {
            $entryModel->save([
                'journal_id' => $journalId,
                'reason_id'  => $reasonId
            ]);
        }
    }

    // Save Exit Reasons
    $exitReasons = $this->request->getPost('exit_reason');
    if ($exitReasons && is_array($exitReasons)) {
        foreach ($exitReasons as $reasonId) {
            $exitModel->save([
                'journal_id' => $journalId,
                'reason_id'  => $reasonId
            ]);
        }
    }

    // Save Mistakes
    $mistakes = $this->request->getPost('mistake');
    if ($mistakes && is_array($mistakes)) {
        foreach ($mistakes as $mistakeId) {
            $mistakeModel->save([
                'journal_id'  => $journalId,
                'mistake_id'  => $mistakeId
            ]);
        }
    }

    return redirect()->to('/journal')->with('message', 'Entry added successfully.');
}



  public function edit($id)
{
    $entry = $this->journal
      ->asObject() // 🔁 make result an object
        ->where('id', $id)
        ->where('user_id', session()->get('user_id'))
        ->where('deleted_at', null)
        ->first();

    if (!$entry) {
        return redirect()->to('/journal')->with('error', 'Entry not found or deleted.');
    }

    $entryModel = new EntryReasonModel();
    $exitModel = new ExitReasonModel();
    $mistakeModel = new MistakeModel();

    $entryReasons = $entryModel->asObject()->findAll();
    $exitReasons = $exitModel->asObject()->findAll();
    $mistakes = $mistakeModel->asObject()->findAll();

    // ✅ Fetch selected reason IDs from pivot tables
    $db = \Config\Database::connect();

    $selectedEntryReasons = $db->table('journal_entry_reasons')
        ->select('reason_id')
        ->where('journal_id', $id)
        ->get()
        ->getResultArray();

    $selectedExitReasons = $db->table('journal_exit_reasons')
        ->select('reason_id')
        ->where('journal_id', $id)
        ->get()
        ->getResultArray();

    $selectedMistakes = $db->table('journal_mistakes')
        ->select('mistake_id')
        ->where('journal_id', $id)
        ->get()
        ->getResultArray();

    // Extract just the IDs into flat arrays
    $selectedEntryReasons = array_column($selectedEntryReasons, 'reason_id');
    $selectedExitReasons = array_column($selectedExitReasons, 'reason_id');
    $selectedMistakes = array_column($selectedMistakes, 'mistake_id');

    return view('journal/edit_entry', [
        'entry' => $entry,
        'entryReasons' => $entryReasons,
        'exitReasons' => $exitReasons,
        'mistakes' => $mistakes,
        'selectedEntryReasons' => $selectedEntryReasons,
        'selectedExitReasons' => $selectedExitReasons,
        'selectedMistakes' => $selectedMistakes,
    ]);
}



  public function update($id)
{
    // Load models
    $entryModel   = new \App\Models\JournalEntryReasonModel();
    $exitModel    = new \App\Models\JournalExitReasonModel();
    $mistakeModel = new \App\Models\JournalMistakeModel();

    // ✅ Update main journal entry
    $journalData = [
        'date'          => $this->request->getPost('date'),
        'stock'         => $this->request->getPost('stock'),
        'stop_loss'     => $this->request->getPost('stop_loss'),
        'target'        => $this->request->getPost('target'),
        'buy_time'      => $this->request->getPost('buy_time'),
        'sell_time'     => $this->request->getPost('sell_time'),
        'buy_price'     => $this->request->getPost('buy_price'),
        'sell_price'    => $this->request->getPost('sell_price'),
        'quantity'      => $this->request->getPost('qty'),
        'pnl'           => $this->request->getPost('pnl'),
        'lessons'       => $this->request->getPost('lesson'),
        'strategy_type' => $this->request->getPost('strategy_type'),
        'calmness'      => $this->request->getPost('calmness'),
        'trade_type'    => $this->request->getPost('trade_type'),
    ];

    $this->journal->update($id, $journalData);

    // 🧹 Clear old pivot data
    $entryModel->where('journal_id', $id)->delete();
    $exitModel->where('journal_id', $id)->delete();
    $mistakeModel->where('journal_id', $id)->delete();

    // 🔁 Save Entry Reasons
    $entryReasons = $this->request->getPost('entry_reason');
    if (is_array($entryReasons)) {
        foreach ($entryReasons as $reasonId) {
            $entryModel->save([
                'journal_id' => $id,
                'reason_id'  => $reasonId
            ]);
        }
    }

    // 🔁 Save Exit Reasons
    $exitReasons = $this->request->getPost('exit_reason');
    if (is_array($exitReasons)) {
        foreach ($exitReasons as $reasonId) {
            $exitModel->save([
                'journal_id' => $id,
                'reason_id'  => $reasonId
            ]);
        }
    }

    // 🔁 Save Mistakes
    $mistakes = $this->request->getPost('mistake');
    if (is_array($mistakes)) {
        foreach ($mistakes as $mistakeId) {
            $mistakeModel->save([
                'journal_id'  => $id,
                'mistake_id'  => $mistakeId
            ]);
        }
    }

    return redirect()->to('/journal')->with('message', 'Entry updated successfully.');
}


    public function delete($id)
    {
        $this->journal->where('id', $id)
            ->where('user_id', session()->get('user_id'))
            ->delete();

        return redirect()->to('/journal')->with('message', 'Entry deleted successfully.');
    }
public function calendar()
{
    $journalModel = new JournalModel();

    // Fetch journal entries for the logged-in user
    $entries = $journalModel
        ->where('user_id', session()->get('user_id'))
        ->orderBy('date', 'DESC')
        ->findAll();

    // Prepare events for FullCalendar
    $events = [];

    foreach ($entries as $entry) {
        $pnl = $entry['pnl'] ?? 0;

        $events[] = [
            'title' => '₹' . $pnl,
            'start' => $entry['date'],
            'color' => $pnl > 0 ? '#28a745' : ($pnl < 0 ? '#dc3545' : '#ffc107'), // Green = profit, Red = loss, Yellow = 0
        ];
    }
    // Pass events to view
    return view('journal/calendar', ['calendarEvents' => $events]);
}


public function dayView($date)
{
    $model = new JournalModel();
    $entries = $model->where('date', $date)->findAll();

    return view('journal/day_view', [
        'date' => $date,
        'entries' => $entries,
    ]);
}
private function syncPivot($db, $table, $foreignKey, $foreignId, $relatedKey, $newIds)
{
    // Get current related IDs from pivot table
    $current = $db->table($table)
        ->select($relatedKey)
        ->where($foreignKey, $foreignId)
        ->get()
        ->getResultArray();

    $currentIds = array_column($current, $relatedKey);

    // Calculate differences
    $toAdd = array_diff($newIds, $currentIds);
    $toRemove = array_diff($currentIds, $newIds);

    // Insert new relations
    foreach ($toAdd as $rid) {
        $db->table($table)->insert([
            $foreignKey => $foreignId,
            $relatedKey => $rid,
        ]);
    }

    // Delete removed relations
    foreach ($toRemove as $rid) {
        $db->table($table)
            ->where($foreignKey, $foreignId)
            ->where($relatedKey, $rid)
            ->delete();
    }
}

}
