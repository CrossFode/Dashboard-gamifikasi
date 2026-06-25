<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UsersManagementController extends ApiController
{
    public function index(Request $request)
    {
        $token = session('api_token');

    //    $response = $this->get('/api/users', $token); //Monolithic
        $response = $this->get('/api/query/users', $token); //CQRS

        if ($response->failed()) {
            return redirect('/dashboard')->withErrors(['error' => 'Unable to fetch users list.']);
        }

        $allUsers = $response->json() ?: [];

        // paginate locally at 5 items per page
        $perPage = 5;
        $currentPage = $request->input('page', 1);
        $collection = collect($allUsers);
        $currentItems = $collection->forPage($currentPage, $perPage)->values()->all();

        $users = new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => url()->current(),
                'query' => $request->query(),
            ]
        );

        return view('Users.users', compact('users'));
    }

   public function destroyUser($id)
{
    $token = session('api_token');

    // Use the protected helper to call the API
//    $response = $this->delete("/api/users/{$id}", $token); //Monolithic
    $response = $this->delete("/api/command/users/{$id}", $token); //CQRS

    if ($response->failed()) {
        return back()->withErrors(['error' => 'Failed to delete user.']);
    }

    return redirect()->route('users.list')->with('success', 'User deleted successfully.');
}


    public function create()
    {
        return view('Users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|string',
            'password_hash' => 'required|string|min:6',
            'avatar_url' => 'nullable|url',
        ]);

        $token = session('api_token');
        //Monolithic
    //    $response = $this->post('/api/users', [
        //CQRS
        $response = $this->post('/api/command/users', [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password_hash' => $request->password_hash,
            'avatar_url' => $request->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($request->name),
        ], $token);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to create user.']);
        }

        // ✅ redirect to the users list
        return redirect()->route('users.list')->with('success', 'User created successfully.');
    }

    public function edit($id)
{
    $token = session('api_token');
//    $response = $this->get("/api/users/{$id}", $token); //Monolithic
    $response = $this->get("/api/query/users/{$id}", $token); //CQRS

    if ($response->failed()) {
        return redirect()->route('users.list')->withErrors(['error' => 'Failed to fetch user data.']);
    }

    $user = $response->json();
    return view('users.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'username' => 'required|string',
        'name' => 'required|string',
        'email' => 'required|email',
        'role' => 'required|string',
        'avatar_url' => 'nullable|url',
    ]);

    $token = session('api_token');
    //Monolithic
//   $response = $this->put("/api/users/{$id}", [
    //CQRS
    $response = $this->put("/api/command/users/{$id}", [
        'username' => $request->username,
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'avatar_url' => $request->avatar_url,
    ], $token);

    if ($response->failed()) {
        return back()->withErrors(['error' => 'Failed to update user.']);
    }

    return redirect()->route('users.list')->with('success', 'User updated successfully.');
}
}
