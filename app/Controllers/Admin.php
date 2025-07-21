<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Admin extends BaseController
{
    public function users()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('admin/users', ['users' => $users]);
    }

    public function toggleBlock($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user) {
            $newStatus = $user['is_blocked'] ? 0 : 1;
            $userModel->update($id, ['is_blocked' => $newStatus]);
        }

        return redirect()->back();
    }

    public function changeRole($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user) {
            $newRole = $user['role'] === 'admin' ? 'user' : 'admin';
            $userModel->update($id, ['role' => $newRole]);
        }

        return redirect()->back();
    }
}
