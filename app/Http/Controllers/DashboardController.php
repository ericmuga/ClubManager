<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Query for the count of users by creation date
        $usersByDate = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                            ->where('user_type','member')
                            ->groupBy('date')
                            ->orderBy('date', 'asc')
                            ->get();

        $usersByMonth = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                     ->where('user_type','member')
                     ->groupBy('month')
                     ->orderBy('month')
                     ->get();

        // Query for the count of users by classification code
        $usersByClassification = User::selectRaw('classifications.code as classification_code, COUNT(users.id) as count')
            ->join('classifications', 'users.classification_id', '=', 'classifications.id')
            ->where('user_type','member')
            ->groupBy('classifications.code')
            ->get();


        // Query for the count of users by nationality
        $usersByNationality = User::selectRaw('nationality, COUNT(*) as count')
                                  ->where('user_type','member')
                                  ->groupBy('nationality')
                                  ->get();

        // Query for the count of users by status
        $usersByStatus = User::selectRaw('status, COUNT(*) as count')
                             ->where('user_type','member')
                             ->groupBy('status')
                             ->get();

        return inertia('Dashboard', compact('usersByDate',
                                            'usersByClassification',
                                            'usersByNationality',
                                            'usersByStatus',
                                            'usersByMonth'));
    }
}
