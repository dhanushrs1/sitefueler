<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Customer dashboard.
     */
    public function index(): View
    {
        return view('dashboard.index');
    }
}
