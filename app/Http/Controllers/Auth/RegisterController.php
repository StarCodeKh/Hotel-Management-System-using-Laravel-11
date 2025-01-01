<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use DB;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'role_name'    => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'position'     => 'required|string|max:255',
            'department'   => 'required|string|max:255',
            'password'     => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        
        $dt       = Carbon::now();
        $join_date = $dt->toDayDateTimeString();

        if(!empty($profile)) {
            $image = time().'.'.$profile->extension();  
            $profile->move(public_path('assets/img'), $image);
        } else {
            $image = ' ';
        }
        
        $user = new User();
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->join_date    = $join_date;
        $user->role_name    = $request->role_name;
        $user->position     = $request->position;
        $user->department   = $request->department;
        $user->avatar       = $image;
        $user->password     = Hash::make($request->password);
        $user->save();
    
        flash()->success('Create new account successfully :)');
        return redirect('login');
    }
}
