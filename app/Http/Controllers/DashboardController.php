<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Halaman Dashboard Dinamis berdasarkan Peran Pengguna (Klien / Developer / Admin)
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $totalProjects = Project::count();
            $totalBids = Bid::count();
            $openProjects = Project::where('status', 'terbuka')->count();
            $recentProjects = Project::with(['client', 'bids'])->latest()->take(5)->get();

            return view('dashboard.admin', compact('totalProjects', 'totalBids', 'openProjects', 'recentProjects'));
        }

        if ($user->isClient()) {
            $myProjects = Project::with(['bids.developer', 'winningBid.developer'])
                ->where('client_id', $user->id)
                ->latest()
                ->get();

            $totalPosted = $myProjects->count();
            $activePosted = $myProjects->where('status', 'terbuka')->count();

            return view('dashboard.klien', compact('myProjects', 'totalPosted', 'activePosted'));
        }

        // Role: Developer
        $myBids = Bid::with(['project.client'])
            ->where('developer_id', $user->id)
            ->latest()
            ->get();

        $wonBids = $myBids->where('is_winner', true)->count();
        $totalBids = $myBids->count();

        return view('dashboard.developer', compact('myBids', 'wonBids', 'totalBids'));
    }
}
