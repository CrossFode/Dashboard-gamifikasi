<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPageController extends ApiController
{
    public function index()
{
    $token = session('api_token');
    $user = session('user');

//    $dashboardResponse = $this->get('/api/dashboard', $token); //Monolithic

     $dashboardResponse = $this->get('/api/query/dashboard', $token); 
     //CQRS
    if ($dashboardResponse->failed()) {
        return back()->withErrors(['error' => 'Failed to load dashboard data.']);
    }

    $data = $dashboardResponse->json();
    $topUsers = $data['top_users'] ?? [];
    $activePeriod = $data['active_period'] ?? null;
    $activeTasks = $data['active_tasks'] ?? [];

    // $completionsResponse = $this->get('/api/completions', $token); //monolithic

    // $completionsResponse = $this->get('/api/query/completions', $token); //CQRS
    // $totalCompletions = 0;

    // if ($completionsResponse->successful() && $activePeriod) {
    //     $completions = collect($completionsResponse->json());
    //     $totalCompletions = $completions->filter(function ($completion) use ($activePeriod) {
    //         $task = $completion['task'] ?? null;
    //         // NYOBA 
    //         return $task && ($task['period_id'] ?? null) == $activePeriod['id'];
    //     })->count();
    // }

    $data = $dashboardResponse->json();

$topUsers = $data['top_users'] ?? [];
$activePeriod = $data['active_period'] ?? null;
$activeTaskCount = $data['active_task_count'] ?? 0;
$totalCompletions = $data['total_completions'] ?? 0;

  return view('dashboard', compact(
    'user',
    'topUsers',
    'activePeriod',
    'activeTaskCount',
    'totalCompletions'

    
));

}

}
