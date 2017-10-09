<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use Mail;

class UserController extends Controller
{
		public function __construct()
		{
			$this->middleware('auth',[
				'except' => ['show','create','store','index','confirmEmail']
			]);
		}
		public function index()
		{
			$users = User::paginate(10);
			return view('users.index',compact('users'));
		}
    public function create()
    {
			return view('users.create');
    }

    public function show(User $user)
    {
			$statuses = $user->statuses()
												->orderBy('created_at','desc')
												->paginate(30);
			return view('users.show', compact('user','statuses'));
    }

		public function store(Request $request)
		{
			$this->validate($request, [
				'name' => 'required|max:50',
				'email' => 'required|email|unique:users|max:255',
				'password' => 'required|confirmed|min:6'
			]);

			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password),
			]);

			$this->sendEmailConfirmationTo($user);
			session()->flash('success','Confirm mail had send your email');
			return redirect('/');			
		}
	
		public function edit(User $user)
		{
			$this->authorize('update',$user);
			return view('users.edit',compact('user'));
		}	
	
		public function update(User $user, Request $request)
		{
			$this->validate($request,[
				'name' => 'required|max:50',
				'password' => 'nullable|confirmed|min:6'
			]);
			
			$this->authorize('update',$user);		
	
			$data = [];
			$data['name'] = $request->name;
			if ($request->password)
			{
				$data['password'] = bcrypt($request->password);
			}
			$user->update($data);
		
			session()->flash('success','edit success!');
			
			return redirect()->route('users.show', $user->id);
		}
		public function destroy(User $user)
		{
			$this->authorize('destroy',$user);
			$user->delete();
			session()->flash('success','delete successful!');
			return back();
		}
		protected function sendEmailConfirmationTo($user)
		{
			$view = 'emails.confirm';
			$data = compact('user');
			$from = 'aufree@yousails.com';
			$name = 'Aufree';
			$to = $user->email;
			$subject = "Appciate use Sample APP! Please comfirm your email.";
			
			Mail::send($view,$data,function($message) use ($from,$name,$to,$subject){
				$message->from($from,$name)->to($to)->subject($subject);
			});
		}
		public function confirmEmail($token)
		{
			$user = User::where('activation_token',$token)->firstOrFail();
			
			$user->activated = true;
			$user->activation_token = null;
			$user->save();

			Auth::login($user);
			session()->flash('success','Congratulations! It works!');
			return redirect()->route('users.show',[$user]);
		}
}
