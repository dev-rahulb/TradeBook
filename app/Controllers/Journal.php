<?php

namespace App\Controllers;

use App\Models\JournalModel;
use CodeIgniter\Controller;

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
        return view('journal/create_entry');
    }

   public function store()
{
  
    $this->journal->save([
        'user_id'         => session()->get('user_id'),
        'date'            => $this->request->getPost('date'),
        'stock'           => $this->request->getPost('stock'),
        'stop_loss'       => $this->request->getPost('stop_loss'),
        'target'          => $this->request->getPost('target'),
        'buy_time'        => $this->request->getPost('buy_time'),
        'sell_time'       => $this->request->getPost('sell_time'),
        'buy_price'       => $this->request->getPost('buy_price'),
        'sell_price'      => $this->request->getPost('sell_price'),
        'quantity'        => $this->request->getPost('qty'),
        'pnl'             => $this->request->getPost('pnl'),
        'entry_reason'    => $this->request->getPost('entry_reason'),
        'exit_reason'     => $this->request->getPost('exit_reason'),
        'mistake'         => $this->request->getPost('mistake'),
        'lessons'  => $this->request->getPost('lesson'),
        'strategy_type' => $this->request->getPost('strategy_type'),
        'calmness' => $this->request->getPost('calmness'),
    ]);

    return redirect()->to('/journal')->with('message', 'Entry added successfully.');
}


   public function edit($id)
{
    $entry = $this->journal
        ->where('id', $id)
        ->where('user_id', session()->get('user_id'))
        ->where('deleted_at', null) // 🛡 prevent access to soft-deleted
        ->first();

    if (!$entry) {
        return redirect()->to('/journal')->with('error', 'Entry not found or deleted.');
    }

    return view('journal/edit_entry', ['entry' => $entry]);
}


    public function update($id)
    {
        $this->journal->update($id, [
           'date'            => $this->request->getPost('date'),
        'stock'           => $this->request->getPost('stock'),
        'stop_loss'       => $this->request->getPost('stop_loss'),
        'target'          => $this->request->getPost('target'),
        'buy_time'        => $this->request->getPost('buy_time'),
        'sell_time'       => $this->request->getPost('sell_time'),
        'buy_price'       => $this->request->getPost('buy_price'),
        'sell_price'      => $this->request->getPost('sell_price'),
        'quantity'        => $this->request->getPost('qty'),
        'pnl'             => $this->request->getPost('pnl'),
        'entry_reason'    => $this->request->getPost('entry_reason'),
        'exit_reason'     => $this->request->getPost('exit_reason'),
        'mistake'         => $this->request->getPost('mistake'),
        'lessons'  => $this->request->getPost('lesson'),
        'strategy_type' => $this->request->getPost('strategy_type'),
           'calmness' => $this->request->getPost('calmness'),
        ]);

        return redirect()->to('/journal')->with('message', 'Entry updated successfully.');
    }

    public function delete($id)
    {
        $this->journal->where('id', $id)
            ->where('user_id', session()->get('user_id'))
            ->delete();

        return redirect()->to('/journal')->with('message', 'Entry deleted successfully.');
    }
}
