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

        // Pass user data to the view
        $data = [
            'title' => 'Dashboard',
            'user_name' => $session->get('user_name'),
        ];

        return view('dashboard', $data);
    }
}
