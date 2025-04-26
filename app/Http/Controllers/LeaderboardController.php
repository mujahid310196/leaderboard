<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'day');
        $userId = $request->get('user_id');

        $query = User::select('users.id', 'users.name', DB::raw('SUM(activities.points) as total_points'))
            ->leftJoin('activities', 'users.id', '=', 'activities.user_id');

        if ($filter === 'day') {
            $query->whereDate('activities.performed_at', now());
        } elseif ($filter === 'month') {
            $query->whereMonth('activities.performed_at', now()->month);
        } elseif ($filter === 'year') {
            $query->whereYear('activities.performed_at', now()->year);
        }

        $query->groupBy('users.id', 'users.name')
            ->orderByDesc('total_points');

        $users = $query->get();

        //Calculate Ranks
        $rank = 1;
        $lastPoints = null;
        $lastRank = 1;

        foreach ($users as $key => $user) {
            if ($user->total_points === $lastPoints) {
                $user->rank = $lastRank;
            } else {
                $user->rank = $rank;
                $lastRank = $rank;
            }
            $lastPoints = $user->total_points;
            $rank++;
        }

        if ($userId) {
            $users = $users->sortByDesc(function ($user) use ($userId) {
                return $user->id == $userId ? 1 : 0;
            })->values();
        }

        return view('leaderboard', compact('users', 'filter', 'userId'));
    }

    public function recalculate()
    {
        $users = User::with('activities')->get();

        foreach ($users as $user) {
            $totalPoints = $user->activities->sum('points');
            $user->update(['rank' => $totalPoints]);
        }

        return redirect()->back();
    }
}

