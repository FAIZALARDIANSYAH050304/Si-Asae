<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $logName = $request->get('log_name');
        
        $activities = Activity::with(['causer'])
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                        ->orWhereHas('causer', function($causer) use ($search) {
                            $causer->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($logName, function($query) use ($logName) {
                $query->where('log_name', $logName);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $logNames = Activity::distinct()->pluck('log_name');

        return view('activity-log.index', [
            'activities' => $activities,
            'logNames' => $logNames,
            'filters' => [
                'search' => $search,
                'log_name' => $logName
            ]
        ]);
    }
}
