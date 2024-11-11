<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Str;

class apiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "ok";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->input();

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($user->save()) {
            return response()->json(["result" => "Data stored successfully"], 200);
        } else {
            return ["result" => "Data stored not store"];
        }
    }
    /**
     * Display the specified resource.
     */
    public function authLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials.'
            ], 401);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Generate a new token
        $token = $user->createToken('API Token')->plainTextToken;

        // Return the token
        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => $user
        ]);
    }




    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);


        $user = User::where('email', $request->email)->first();

        if ($user) {

            $token = Str::random(50);


            return response()->json(['result' => "token generate successfully", "token" => $token]);
        } else {
            return response()->json(['error' => "record not found"]);
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json(['result' => $user]);
        }

        return response()->json(['result' => 'record not found']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
