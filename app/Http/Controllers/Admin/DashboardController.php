<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\PortfolioItem;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_commissions'    => Commission::count(),
            'pending_commissions'  => Commission::where('status', 'pending')->count(),
            'in_progress'          => Commission::where('status', 'in_progress')->count(),
            'total_portfolio'      => PortfolioItem::count(),
        ];

        $recent_commissions = Commission::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_commissions'));
    }
}