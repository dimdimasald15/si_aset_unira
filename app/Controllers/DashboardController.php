<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{

    public function __construct()
    {
        helper('url');
        $session = session();
        if (isset($session->username)) {
            return redirect()->to('admin/dashboard');
        } else {
            // jika variabel $_SESSION['username'] belum didefinisikan, redirect ke halaman login
            return redirect()->to('/auth');
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'nav' => 'Dashboard',
        ];

        return view('dashboard/index', $data);
    }
}
