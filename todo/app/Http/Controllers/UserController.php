<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $users = User::select('id','name', 'email')
       ->orderBy('name')
       ->paginate(10);
       //return  $users;
       return view('user.index', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasRole('Admin')){
            return view('user.create');
        }else{
            return redirect(route('login'));
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:20'
        ]);

        $user = new User;
        $user->fill($request->all());
        //$user-> password = Hash::make($request->password);
        $user->save();
    
        return redirect(route('user.index'))->withSuccess('User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function forgot(){
        return view('user.forgot');
    }

    public function email(Request $request){
        $request->validate([
            'email' => ['required', 'email', 'exists:users']
        ]);

        $user = User::where('email', $request->email)->first();
        
        $tempPassword =  str::random(45);
        // $user->update([
        //     'temp_password' =>  $tempPassword 
        // ]);
        $user->temp_password = $tempPassword;
        $user->save();

        $userId= $user->id;
        // email
        $to_name = $user->name;
        $to_email = $user->email;      
        $body = "<a href='".route('user.reset', [$userId, $tempPassword])."'>Click here to reset</a>";

        Mail::send('user.mail', ['name'=>$to_name, 'body' =>$body], 
        function($message) use ($to_email){
            $message->to($to_email)->subject('Reset Password');
        });
        return  redirect(route('login'))->withSuccess('Please check your email to reset the password');
    
    }

    public function reset(User $user, $token){
       if($user->temp_password === $token){
            return view('user.reset');
       }
       return redirect(route('user.forgot'))->withErrors('Credentials does not match');
    }

    public function resetUpdate(User $user, $token, Request $request){
        if($user->temp_password === $token){
             $request->validate([
                'password' => 'required|max:20|min:6|confirmed'
             ]);
             $user->password = $request->password;
            // $user-> password = Hash::make($request->password);
             $user->temp_password = null;
             $user->save();
             return redirect(route('login'))->withSuccess('Password changed with success');
        }
        return redirect(route('user.forgot'))->withErrors('Credentials does not match');
     }
}
