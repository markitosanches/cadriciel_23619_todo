<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatsController extends Controller
{
    public function __contruct(){
        $this->middleware('auth');
    }

    public function index(){

        return Inertia::render('Chat');
    }

    public function fetchMessages(){
        return Message::with('user')->get();
    }

    public function store(Request $request){
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);
        return Message::with('user')->get();
    }
}
