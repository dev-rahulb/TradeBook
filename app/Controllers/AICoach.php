<?php namespace App\Controllers;

use App\Models\JournalModel;
use App\Models\WeeklySuggestionModel;
use CodeIgniter\Controller;


class AICoach extends Controller
{


    public function index()
    {
        $model = new WeeklySuggestionModel();
        $userId = session()->get('user_id');

        $data['suggestions'] = $model->where('user_id', $userId)
                                     ->orderBy('week_start', 'DESC')
                                     ->findAll();

                                     
        return view('ai_coach/index', $data);
    }

 public function generate()
{
    $weekStart = $this->request->getPost('week');
    $weekEnd = date('Y-m-d', strtotime($weekStart . ' +6 days'));

    $model = new \App\Models\WeeklySuggestionModel();
    $existing = $model->where('week_start', $weekStart)->first();

    if ($existing) {
        return redirect()->back()->with('error', 'Suggestion for this week already exists.');
    }

    $userId = session()->get('user_id');

    // Fetch journal entries for the week
    $journalModel = new \App\Models\JournalModel();
    $journalEntries = $journalModel
        ->where('user_id', $userId)
        ->where('date >=', $weekStart)
        ->where('date <=', $weekEnd)
        ->orderBy('date', 'ASC')
        ->findAll();

    if (empty($journalEntries)) {
        return redirect()->back()->with('error', 'No journal entries found for this week.');
    }

    // Summarize entries
    $entrySummaries = [];
$entryReasonModel   = new \App\Models\JournalEntryReasonModel();
$exitReasonModel    = new \App\Models\JournalExitReasonModel();
$mistakeModel       = new \App\Models\JournalMistakeModel();

foreach ($journalEntries as $entry) {
    $entryId = $entry['id'];

    // Fetch related reasons and mistakes
    $entryReasons = $entryReasonModel
        ->select('entry_reasons.reason')
        ->join('entry_reasons', 'entry_reasons.id = journal_entry_reasons.reason_id')
        ->where('journal_id', $entryId)
        ->findAll();

    $exitReasons = $exitReasonModel
        ->select('exit_reasons.reason')
        ->join('exit_reasons', 'exit_reasons.id = journal_exit_reasons.reason_id')
        ->where('journal_id', $entryId)
        ->findAll();

    $mistakes = $mistakeModel
        ->select('mistakes.reason')
        ->join('mistakes', 'mistakes.id = journal_mistakes.mistake_id')
        ->where('journal_id', $entryId)
        ->findAll();

    // Convert to readable strings
    $entryReasonText = implode(', ', array_column($entryReasons, 'reason'));
    $exitReasonText  = implode(', ', array_column($exitReasons, 'reason'));
    $mistakeText     = implode(', ', array_column($mistakes, 'reason'));

    // Compile
    $entrySummaries[] = "📅 Date: {$entry['date']}
📈 Stock: {$entry['stock']}
📊 Strategy: {$entry['strategy_type']}
😌 Calmness: {$entry['calmness']}
💰 P&L: ₹{$entry['pnl']}
📝 Entry Reasons: {$entryReasonText}
🏁 Exit Reasons: {$exitReasonText}
❌ Mistakes: {$mistakeText}
📘 Lesson: {$entry['lessons']}";
}
// echo "<pre>";
// print_r($entrySummaries);die;

    $compiledEntries = implode("\n\n", $entrySummaries);

    // Construct AI prompt
    $prompt = <<<EOT
I am a trader who made the following trades during the week starting from {$weekStart} to {$weekEnd}:

$compiledEntries

Please review these trades and provide:
1. A personalized weekly trading improvement summary.
2. Highlight patterns in mistakes or lessons.
3. Give 3 actionable tips to improve next week's trading performance.
4. Give a performance score out of 10 based on discipline, strategy, risk management, and consistency. Format it like this: "Performance Score: X/10"
EOT;

    // Send prompt to AI
    $apiKey = getenv('OPENROUTER_API_KEY');
    $endpoint = 'https://openrouter.ai/api/v1/chat/completions';

    $headers = [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
        'HTTP-Referer: http://localhost:3000',
        'X-Title: SmartDocBot',
    ];

    $postData = [
        'model' => 'mistralai/mistral-7b-instruct:free',
        'messages' => [
            ['role' => 'user', 'content' => $prompt],
        ],
        'max_tokens' => 800,
    ];

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return redirect()->back()->with('error', 'AI generation failed: ' . $error_msg);
    }

    curl_close($ch);
    $data = json_decode($response, true);
    $suggestion = $data['choices'][0]['message']['content'] ?? 'No suggestion generated.';

    // Extract performance score using regex
    preg_match('/Performance Score:\s*([0-9]+(?:\.[0-9])?)\/10/i', $suggestion, $matches);
    $performanceScore = isset($matches[1]) ? floatval($matches[1]) : null;

    // Save suggestion
    $model->save([
        'week_start'        => $weekStart,
        'week_end'          => $weekEnd,
        'suggestions'       => $suggestion,
        'generated_by'      => 'AI',
        'user_id'           => $userId,
        'performance_score' => $performanceScore,
    ]);

    return redirect()->to('ai-coach')->with('success', 'AI-generated suggestion and score saved!');
}




public function delete($id)
{
    $model = new WeeklySuggestionModel();
    $userId = session()->get('user_id');

    // Check if the suggestion belongs to the logged-in user
    $suggestion = $model->where('id', $id)
                        ->where('user_id', $userId)
                        ->first();

    if ($suggestion) {
        $model->delete($id);
        return redirect()->to('/ai-coach')->with('success', 'Suggestion deleted successfully.');
    }

    return redirect()->to('/ai-coach')->with('error', 'Suggestion not found or unauthorized.');
}


}
