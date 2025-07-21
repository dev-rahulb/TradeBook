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

    $otp         = rand(100000, 999999);
    $expiresAt   = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Handle New User Registration
    if (!$existingUser) {
        $userModel->insert([
            'name'           => $name,
            'email'          => $email,
            'password'       => $hashedPassword,
            'otp'            => $otp,
            'otp_expires_at' => $expiresAt,
            'is_verified'    => 0,
            'role'           => 'user'
        ]);

        // Send OTP
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Your OTP - TradeBook');
        $emailService->setMessage("Your OTP is <b>$otp</b>. It will expire in 15 minutes.");
        $emailService->send();

        return redirect()->to('/signup')
            ->with('showOtpForm', true)
            ->with('signup_email', $email)
            ->with('success', 'OTP sent to your email. Please verify your account.');
    }

    // ✅ Handle Already Registered but Not Verified
    if ($existingUser['is_verified'] == 0) {
        $expiresAtTimestamp = strtotime($existingUser['otp_expires_at']);
        $now = time();

        if ($expiresAtTimestamp > $now) {
            $minutesLeft = ceil(($expiresAtTimestamp - $now) / 60);
            return redirect()->to('/signup')
                ->with('showOtpForm', true)
                ->with('signup_email', $email)
                ->with('error', "OTP already sent. Please wait $minutesLeft minutes before requesting again.");
        }

        // Generate new OTP and update
        $otp       = rand(100000, 999999);
        $newExpiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

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

    // ❌ Already Verified
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
        if ($user['is_blocked']) {
            return redirect()->back()->with('error', 'Your account is blocked. Please contact admin.');
        }

        // Login successful — set session
        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'role' => $user['role'], 
            'isLoggedIn' => true
        ]);


        $slogans = [
  'Discipline Over Emotion',
  'Trade with Calm & Clarity',
  'Every Trade is a Lesson',
  'Stick to the Plan',
  'Risk Less, Win More',
];
session()->set('slogan', $slogans[array_rand($slogans)]);

        return redirect()->to('/dashboard');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }

    public function profile()
{
  
    $userModel = new \App\Models\UserModel();
    $user = $userModel->find(session()->get('user_id'));
// print_r($user); // Will show the full array or null
// die;
    return view('auth/profile', ['user' => $user]);
}

public function changePassword()
{
    return view('auth/change_password');
}

public function changePasswordPost()
{
    $userId = session()->get('user_id');
    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($userId);

    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    if (!password_verify($currentPassword, $user['password'])) {
        return redirect()->back()->with('error', 'Current password is incorrect.');
    }

    if ($newPassword !== $confirmPassword) {
        return redirect()->back()->with('error', 'New passwords do not match.');
    }

    $userModel->update($userId, [
        'password' => password_hash($newPassword, PASSWORD_DEFAULT),
    ]);

    return redirect()->to('/profile')->with('success', 'Password changed successfully.');
}
public function forgotPassword()
{
    return view('auth/forgot_password');
}

public function forgotPasswordPost()
{
    $email = $this->request->getPost('email');
    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('email', $email)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'No account found with this email.');
    }

    // Check if existing OTP is still valid
    if (!empty($user['otp']) && !empty($user['otp_expires_at'])) {
        $now = new \DateTime();
        $expiry = new \DateTime($user['otp_expires_at']);
        if ($expiry > $now) {
            $remaining = $expiry->getTimestamp() - $now->getTimestamp();
            $minutes = ceil($remaining / 60);
            return redirect()->back()->with('error', "An OTP was already sent. Please wait $minutes minute(s) before requesting again.");
        }
    }

    // Generate new OTP
    $otp = rand(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    $userModel->update($user['id'], [
        'otp' => $otp,
        'otp_expires_at' => $expiresAt
    ]);

    // Send email
    // $emailService = \Config\Services::email();
    // $emailService->setTo($email);
    // $emailService->setSubject('Reset Password OTP - TradeBook');
    // $emailService->setMessage("Your OTP for resetting password is <b>$otp</b>. It will expire in 15 minutes.");
    // $emailService->send();

    return redirect()->to('/reset-password')->with('reset_email', $email)->with('success', 'OTP sent to your email.');
}



public function resetPasswordForm()
{
    return view('auth/reset_password');
}

public function handleResetPassword()
{
   $email    = $this->request->getPost('email');
    $otp      = $this->request->getPost('otp');
    $password = $this->request->getPost('password');

    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('email', $email)->first();
    if (!$user || $user['otp'] != $otp) {
        return redirect()->back()->with('error', 'Invalid OTP or email.');
    }

    $now = time();
    $expires = strtotime($user['otp_expires_at']);
    if ($expires < $now) {
        return redirect()->back()->with('error', 'OTP expired. Try again.');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $userModel->update($user['id'], [
        'password' => $hashedPassword,
        'otp' => null,
        'otp_expires_at' => null
    ]);

    return redirect()->to('/login')->with('success', 'Password reset successfully. You can now log in.');
}
}
