<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator; // added

class TaskPageController extends ApiController
{
    public function index(Request $request)
    {
        $token = session('api_token');
        $selectedPeriod = $request->query('period_id');

        // fetch periods for the dropdown
        // $periodResponse = $this->get('/api/period', $token); //Monolithic
        $periodResponse = $this->get('/api/query/period', $token); //CQRS
        $periods = $periodResponse->successful() ? $periodResponse->json() : [];

        // fetch tasks, include period filter if provided
        // $uri = '/api/tasks'; //Monolithic
        $uri = '/api/query/tasks'; //CQRS
        if ($selectedPeriod) {
            $uri .= '?period_id=' . urlencode($selectedPeriod);
        }

        $response = $this->get($uri, $token);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to fetch tasks from API.']);
        }

        $allTasks = $response->json() ?: [];

        // paginate locally at 5 items per page
        $perPage = 5;
        $currentPage = $request->input('page', 1);
        $collection = collect($allTasks);
        $currentItems = $collection->forPage($currentPage, $perPage)->values()->all();

        $tasks = new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => url()->current(),
                'query' => $request->query(),
            ]
        );

        return view('Tasks.index', compact('tasks', 'periods', 'selectedPeriod'));
        
    }

    public function create()
    {
        $token = session('api_token');

        // fetch periods to populate the select
        // $periodResponse = $this->get('/api/period', $token); //Monolithic
        $periodResponse = $this->get('/api/query/period', $token); //CQRS
        $periods = $periodResponse->successful() ? $periodResponse->json() : [];

        return view('Tasks.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'points' => 'nullable|integer',
            'period_id' => 'nullable|integer', // added validation
        ]);

        $token = session('api_token');
        //Monolithic
        // $response = $this->post('/api/tasks', [
        //CQRS
        $response = $this->post('/api/command/tasks', [
            'title' => $request->title,
            'description' => $request->description,
            'points' => $request->points,
            'period_id' => $request->period_id, // include period_id
        ], $token);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to create task.']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit($id)
    {
        $token = session('api_token');

        // fetch task
        // $taskResponse = $this->get("/api/tasks/{$id}", $token); //Monolithic
        $taskResponse = $this->get("/api/query/tasks/{$id}", $token); //CQRS
        if ($taskResponse->failed()) {
            return redirect()->route('tasks.index')->withErrors(['error' => 'Failed to fetch task.']);
        }
        $task = $taskResponse->json();

        // fetch periods to populate the select on edit page
        $periodResponse = $this->get('/api/period', $token); //Monolithic
       //  $periodResponse = $this->get('/api/query/period', $token); //CQRS
        $periods = $periodResponse->successful() ? $periodResponse->json() : [];

        return view('Tasks.edit', compact('task', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'points' => 'nullable|integer',
            'period_id' => 'nullable|integer',
        ]);

        $token = session('api_token');
        //Monolithic
        $response = $this->put("/api/tasks/{$id}", [
        //CQRS
       //  $response = $this->put("/api/command/tasks/{$id}", [
            'title' => $request->title,
            'description' => $request->description,
            'points' => $request->points,
            'period_id' => $request->period_id,
        ], $token);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to update task.']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy($id)
    {
        $token = session('api_token');
    //    $response = $this->delete("/api/tasks/{$id}", $token); //Monolithic
         $response = $this->delete("/api/command/tasks/{$id}", $token); //CQRS

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to delete task.']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
