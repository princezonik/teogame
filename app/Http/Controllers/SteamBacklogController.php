<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SteamBacklog;

class SteamBacklogController extends Controller
{
    public function showForm()
    {
        return view('steam_backlog.backlog');
    }

    /**
     * Calculate the estimated number of days to finish the backlog.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function calculateBacklog(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'total_backlog_hours' => 'required|numeric|min:1', // Total backlog hours
            'average_weekly_playtime' => 'required|numeric|min:1', // Average weekly playtime
        ]);

        // Extract values from the validated data
        $totalBacklogHours = $validated['total_backlog_hours'];
        $averageWeeklyPlaytime = $validated['average_weekly_playtime'];

        // Calculate the number of days to finish backlog
        // Total backlog hours divided by weekly playtime, then divided by 7 (days in a week)
        $daysToFinish = ($totalBacklogHours / $averageWeeklyPlaytime) * 7;

        // Save the result in the database
        $steamBacklog = SteamBacklog::create([
            'total_backlog_hours' => $totalBacklogHours,
            'average_weekly_playtime' => $averageWeeklyPlaytime,
            'days_to_finish' => $daysToFinish,
        ]);

        // Return the result to the user
        return view('steam_backlog.result', [
            'total_backlog_hours' => $totalBacklogHours,
            'average_weekly_playtime' => $averageWeeklyPlaytime,
            'days_to_finish' => $daysToFinish,
        ]);
    }
}
