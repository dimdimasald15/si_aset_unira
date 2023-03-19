<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BarangController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Barang',
            'nav' => 'barang',
        ];

        return view('barang/index', $data);
    }
}
