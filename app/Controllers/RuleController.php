<?php
namespace App\Controllers;

use App\Models\RuleModel;
use CodeIgniter\Controller;
class RuleController extends BaseController
{
    protected $ruleModel;

    public function __construct()
    {
        $this->ruleModel = new RuleModel();
    }

    public function index()
    {
        $userId = session()->get('user_id'); // adjust if your auth is different
        $data['rules'] = $this->ruleModel->where('user_id', $userId)->findAll();

        return view('rules/index', $data);
    }

    public function create()
    {
        return view('rules/create');
    }

    public function store()
    {
        $this->ruleModel->save([
            'user_id' => session()->get('user_id'),
            'rule_text' => $this->request->getPost('rule_text'),
        ]);

        return redirect()->to('/rules')->with('success', 'Rule added.');
    }

    public function edit($id)
    {
        $data['rule'] = $this->ruleModel->find($id);
        return view('rules/edit', $data);
    }

    public function update($id)
    {
        $this->ruleModel->update($id, [
            'rule_text' => $this->request->getPost('rule_text'),
        ]);

        return redirect()->to('/rules')->with('success', 'Rule updated.');
    }

    public function delete($id)
    {
        $this->ruleModel->delete($id);
        return redirect()->to('/rules')->with('success', 'Rule deleted.');
    }
}

