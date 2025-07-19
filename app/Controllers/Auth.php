<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends Controller
{
    // Show Signup Form
    public function signup()
    {
        return view('signup');
    }

    // Handle Signup Form POST
   public function signupPost()
{
    $email    = $this->request->getPost('email');
    $name     = $this->request->getPost('name');
    $password = $this->request->getPost('password');

    $userModel = new UserModel();
    $existingUser = $userModel->where('email', $email)->first();

    $otp       = rand(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($existingUser) {
    if ($existingUser['is_verified'] == 0) {
        // Check if existing OTP is still valid (cooldown active)
        $expiresAt = strtotime($existingUser['otp_expires_at']);
        $now = time();

        if ($expiresAt > $now) {
            $minutesLeft = ceil(($expiresAt - $now) / 60);
            return redirect()->to('/signup')
                ->with('showOtpForm', true)
                ->with('signup_email', $email)
                ->with('error', "OTP already sent. Please wait $minutesLeft minutes before requesting again.");
        }

        // If expired, generate new OTP and update
        $otp       = rand(100000, 999999);
        $newExpiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userModel->update($existingUser['id'], [
            'otp'            => $otp,
            'otp_expires_at' => $newExpiry,
            'password'       => $hashedPassword
        ]);

        // Send new OTP
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Your New OTP - TradeBook');
        $emailService->setMessage("Your new OTP is <b>$otp</b>. It will expire in 15 minutes.");
        $emailService->send();

        return redirect()->to('/signup')
            ->with('showOtpForm', true)
            ->with('signup_email', $email)
            ->with('success', 'Your OTP has expired. New OTP sent. Please verify within 15 minutes.');
    }
    }
    // Verified user
    return redirect()->back()->with('error', 'Email already registered and verified.');
}



    // Handle OTP Verification
   public function verifyPost()
{
    $email = $this->request->getPost('email') ?? session('signup_email');
    $otp   = $this->request->getPost('otp');

    $userModel = new UserModel();
    $user = $userModel->where('email', $email)->first();

    if ($user && $user['otp'] == $otp && strtotime($user['otp_expires_at']) > time()) {
        // Valid OTP
        $userModel->update($user['id'], ['is_verified' => 1]);
        session()->remove('signup_email');

        return redirect()->to('/login')->with('success', 'Email verified successfully!');
    }

    // ❌ Invalid or expired OTP
    return redirect()->to('/signup')
        ->with('showOtpForm', true)
        ->with('signup_email', $email)
        ->with('error', 'Invalid or expired OTP. Please try again.');
}


    // Show Login Form
    public function login()
    {
        return view('login');
    }

    // Handle Login POST
    public function loginPost()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
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

        // Login successful — set session
        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'isLoggedIn' => true
        ]);

        return redirect()->to('/dashboard');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }
}
