<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeriodPageController extends ApiController
{
    public function index()
    {
        $token = session('api_token');
        // $response = $this->get('/api/period', $token); //Monolithic

         $response = $this->get('/api/query/period', $token); //CQRS


        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to fetch periods from API.']);
        }

        $periods = $response->json();
        return view('Periods.index', compact('periods')); // fixed view name
    }

    public function create()
    {
        return view('Periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $token = session('api_token');
        // $response = $this->post('/api/period', $validated, $token); //Monolithic

        $response = $this->post('/api/command/period', $validated, $token); //CQRS


        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to add period']);
        }

        return redirect()->route('Periods.index')->with('success', 'Period added successfully!'); // lowercase route name
    }

    public function edit($id)
    {
        $token = session('api_token');
        // $response = $this->get("/api/period/{$id}", $token); //Monolithic

         $response = $this->get("/api/query/period/{$id}", $token); //CQRS


        $period = $response->failed() ? null : $response->json();

        if (!$period) {
            return redirect()->route('Periods.index')->withErrors(['error' => 'Period not found']); // lowercase
        }

        return view('Periods.edit', compact('period'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $token = session('api_token');
        // $response = $this->put("/api/period/{$id}", $validated, $token); //Monolithic

         $response = $this->put("/api/command/period/{$id}", $validated, $token); //CQRS

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to update period']);
        }

        return redirect()->route('Periods.index')->with('success', 'Period updated successfully!');
    }

    public function destroy($id)
    {
        $token = session('api_token');
        // $response = $this->delete("/api/period/{$id}", $token); //Monolithic

         $response = $this->delete("/api/command/period/{$id}", $token); //CQRS

         if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to delete period']);
        }


        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to delete period']);
        }

        return redirect()->route('Periods.index')->with('success', 'Period deleted successfully!');
    }

    public function setActive($id)
{
    $token = session('api_token');

    // Send request to API to set active
    // $response = $this->put("/api/period/{$id}", ['is_active' => true], $token); //Monolithic

     $response = $this->put("/api/command/period/{$id}", ['is_active' => true], $token); //CQRS


    if ($response->failed()) {
        return back()->withErrors(['error' => 'Failed to set active period']);
    }

    return redirect()->route('Periods.index')->with('success', 'Active period updated!');
}

}
