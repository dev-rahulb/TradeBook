<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends Controller
{
    public function signup()
    {
        return view('signup');
    }

   public function signupPost()
{
    $email = $this->request->getPost('email');
    $name  = $this->request->getPost('name');
    $password = $this->request->getPost('password'); // ✅ 1. Get password

    $otp = rand(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    $userModel = new UserModel();

    $user = $userModel->where('email', $email)->first();
    if ($user) {
        return redirect()->back()->with('error', 'Email already registered');
    }

    // ✅ 2. Hash password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // ✅ 3. Insert user with password
    $userModel->insert([
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'otp' => $otp,
        'otp_expires_at' => $expiresAt,
    ]);

    // Send OTP
    $emailService = \Config\Services::email();
    $emailService->setTo($email);
    $emailService->setSubject('Your OTP - TradeBook');
    $emailService->setMessage("Your OTP is <b>$otp</b>. It expires in 15 minutes.");
    $emailService->send();

    return redirect()->to('/verify')->with('email', $email);
}


    public function verify()
    {
        return view('verify');
    }

    public function verifyPost()
    {
        $email = $this->request->getPost('email');
        $otp = $this->request->getPost('otp');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) return redirect()->back()->with('error', 'User not found.');

        if (empty($user['otp_expires_at']) || $user['otp'] !== $otp || strtotime($user['otp_expires_at']) < time()) {
            return redirect()->back()->with('error', 'Invalid or expired OTP.');
        }

        $userModel->update($user['id'], ['is_verified' => 1]);

        return "✅ OTP Verified. Account Created!";
    }

    // Render Login Page
public function login()
{
    return view('login');
}

// Handle Login POST
public function loginPost()
{
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('email', $email)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'Email not found.');
    }

    if (!$user['is_verified']) {
        return redirect()->back()->with('error', 'Please verify your email first.');
    }

    if (!password_verify($password, $user['password'])) {
        return redirect()->back()->with('error', 'Invalid credentials.');
    }

  
session()->set([
    'user_id'    => $user['id'],
    'user_name'  => $user['name'],
    'isLoggedIn' => true
]);


    return redirect()->to('/dashboard'); // Redirect to your main dashboard
}

public function logout()
{
    session()->destroy();
    return redirect()->to('/login')->with('success', 'Logged out successfully.');
}


}
