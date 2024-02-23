<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::latest()->get();

            $states = User::select('state')
                ->distinct('state')
                ->pluck('state');

            $cities = User::select('city')
                ->distinct('city')
                ->pluck('city');

            return view('users.index', compact('users', 'states', 'cities'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch users: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch users.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = new User($request->validated());
            $user->password = bcrypt($request->pass);
            $user->url = $request->url;
            $user->save();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create client.');
        }
    }

    /**
     * Method states
     */
    public function states(Request $request)
    {
        try {
            $query = $request->input('query');
            $states = User::where('state', 'like', '%' . $query . '%')
                ->distinct('state')
                ->pluck('state');

            return response()->json($states);
        } catch (\Exception $e) {
            Log::error('Failed to fetch states: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Method cities
     */
    public function cities(Request $request)
    {
        try {
            $query = $request->input('query');
            $cities = User::where('city', 'like', '%' . $query . '%')
                ->distinct('city')
                ->pluck('city');

            return response()->json($cities);
        } catch (\Exception $e) {
            Log::error('Failed to fetch cities: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->update($request->validated());

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Client updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update client.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Client deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete client.');
        }
    }
}
