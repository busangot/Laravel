<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['services']]);
    }
    

    public function index(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('pages.index')->with('posts', $user->posts);
    }

    public function services(){

        $data = array(
            'title' => 'Services',
            'services' => ['Reset Password','Register'],
            'ids' => ['/password/reset','/register',]
        );
        return view('pages.services')->with($data);
    }
}
