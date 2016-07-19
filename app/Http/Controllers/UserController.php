<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Hash;
use Auth;
class UserController extends Controller {

	public function getAdd () {
		return view('admin.user.add');
	}

	public function postAdd (UserRequest $request) {
		$user = new User();
		$user->username 		= $request->txtUser;
		if ($request->txtPass === $request->txtRePass) {
			$user->password = Hash::make($request->txtPass);
		}
		$user->email 	 		= $request->txtEmail;
		$user->level 			= $request->rdoLevel;
		$user->remember_token 	= $request->_token;
		$user->save();
		return redirect()->route('admin.user.list')->with(['flash_level'=>'success','flash_message'=>'Success ! Complete Add User']);
	}

	public function getList () {
		$data = User::select('id','username','level')->orderBy('id','DESC')->get()->toArray();
		return view('admin.user.list',compact('data'));
	}

	public function getDelete ($id) {
		$id_user_current_login = Auth::user()->id;
		$user = User::find($id);
		if (($user["level"] == 1 && $id_user_current_login != 7) || ($id == 7) ) {
			return redirect()->route('admin.user.list')->with(['flash_level'=>'danger','flash_message'=>'Sorry ! You Can\'t Delete This User']);
		} else {
			$user->delete($id);
			return redirect()->route('admin.user.list')->with(['flash_level'=>'success','flash_message'=>'Success ! Complete Delete User']); 
		}
	}

	public function getEdit ($id) {
		$user = User::find($id)->toArray();
		if ( (Auth::user()->id != 7) && ($id == 7 || ($user['level']) == 1 && (Auth::user()->id != $id)) ) {
			return redirect()->route('admin.user.list')->with(['flash_level'=>'danger','flash_message'=>'Sorry ! You Can\'t Edit This User']); 
		}
		return view('admin.user.edit',compact('user','id'));
	}

	public function postEdit ($id,Request $request) {
		$user = User::find($id);
		if (($request->input('txtPass')) || ($request->input('txtRePass'))) {
			$this->validate($request,
			[
				'txtPass'	=> 	'required',
				'txtRePass' => 'required|same:txtPass'	
			],
			[
				'txtPass.required' => 	'Please Enter Password',
				'txtRePass.required' => 'Please Enter Re-Password',
				'txtRePass.same' => 'Two Password Don\'t Match'
			]);
			$pass = $request->input('txtPass');
			$user->password = Hash::make($pass);
		}
		$user->level = $request->rdoLevel;
		$user->email = $request->txtEmail;
		$user->remember_token = $request->_token;
		$user->save();
		return redirect()->route('admin.user.list')->with(['flash_level'=>'success','flash_message'=>'Success ! Complete Update User']); 
	}



}
