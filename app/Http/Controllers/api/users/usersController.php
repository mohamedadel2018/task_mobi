<?php

namespace App\Http\Controllers\api\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // dd($request->header());
        $users = User::latest()->get();
        return response()->json( $users,200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, User $user)
    {

        if($request->password != null ){
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed',
            ]);
        }else{
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => isset($request->password) ? bcrypt($request->password) :  $user->password 
        ]);

         return response()->json('Done',200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
    }
}
