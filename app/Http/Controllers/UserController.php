<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();

            $states = User::select('state')
                ->distinct('state')
                ->pluck('state');

            $cities = User::select('city')
                ->distinct('city')
                ->pluck('city');

            return view('users.index', compact('users', 'states', 'cities'));
        } catch (\Exception $e) {
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

            $user = new User();
            $user->fill($request->validated());
            $user->password = bcrypt($request->pass);
            $user->save();

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create client.');
        }
    }

    /**
     * Method states
     *
     * @param Request $request [explicite description]
     *
     * @return void
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
            return response()->json([], 500);
        }
    }

    /**
     * Method cities
     *
     * @param Request $request [explicite description]
     *
     * @return void
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
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $user->update($request->all());

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Client updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
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

            return redirect()->route('users.index')
                ->with('success', 'Client deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete client.');
        }
    }
}
