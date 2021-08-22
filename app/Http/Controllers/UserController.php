<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'note' => '',
            'last_login' => '',
            'last_app_login' => '',
            'role' => 'required',
            'password' => 'required|required_with:confirm_password|same:confirm_password|min:4',
            'confirm_password' => 'min:4',
        ]);

        $validated_data['password'] = Hash::make($validated_data['password']);

        User::create($validated_data);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        $validated_data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'note' => '',
            'last_login' => '',
            'last_app_login' => '',
            'role' => 'required',
            'is_disabled' => 'required',
            'password' => 'required|required_with:confirm_password|same:confirm_password|min:4',
            'confirm_password' => 'min:4',
        ]);

        if ($validated_data['password'] == $user->password) {
            $validated_data['password'] = $user->password;
        } else {
            $validated_data['password'] = Hash::make($validated_data['password']);
        }

        $user->update($validated_data);

        return redirect()->route('users.index')
                      ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        if($user) {
            $user->is_deleted = true;
            $user->deleted_at = Carbon::now();
            $user->save();

            return redirect()->route('users.index')
                      ->with('success', 'User deleted successfully.');
        } else {
            return redirect()->route('users.index')
                      ->with('success', 'User not found successfully.');
        }
    }

    public function getUsersFilter() {
        $users = User::all();
        return Datatables::of($users)
                    ->editColumn('name', function($e) {
                        return $e->name;
                    })
                    ->editColumn('role', function($e) {
                        return $e->role;
                    })
                    ->editColumn('phone', function($e) {
                        return $e->phone;
                    })
                    ->editColumn('email', function($e) {
                        return $e->email;
                    })
                    ->editColumn('last_login', function($e) {
                        return $e->last_login;
                    })
                    ->editColumn('disabled', function($e) {
                        return $e->is_disabled ? "Yes":"No";
                    })
                    ->setRowClass(function ($e) {
                        $class = '';
                        if($e->is_disabled) {
                            $class = $class.' deleted';
                        }
                        return $class;
                    })
                    ->make(true);
    }
}
