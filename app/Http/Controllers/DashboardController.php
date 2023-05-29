<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $context = [
            'title' => 'Dashboard'
        ];

        return view('dashboard', $context);
    }
}
