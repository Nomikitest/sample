<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest',[
			'only' => ['create']
		]);
	}
	public function create()
	{
		return view('sessions.create');
	}

	public function store(Request $request)
	{
		$this->validate($request,[
			'email' => 'required|email|max:255',
			'password' => 'required'
		]);

		$credentials = [
			'email' => $request->email,
			'password' => $request->password,
		];
		
		if (Auth::attempt($credentials, $request->has('remember')))
		{
			if(Auth::user()->activated)
			{
				session()->flash('success','welcome back');
				return redirect()->intended(route('users.show',[Auth::user()]));
			}else
			{
				Auth::logout();
				session()->flash('warning','Your account did not actived please check your email');
				return redirect('/');
			}
		}else
		{
			session()->flash('danger','sorry, your email and password did not match.');
			return redirect()->back();
		}
	}
	
	public function destroy()
	{
		Auth::logout();
		session()->flash('success','exited');
		return redirect('login');
	}
}
