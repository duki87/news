<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct() {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm() {
      return view('admin.admin_auth.login');
    }

    public function login(Request $request) {
      //validate the form data
      $this->validate($request, [
        'email'    => 'required|email',
        'password' => 'required|min:10'
      ]);
      //attempt to login user
      if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password], $request->remember)) {
        //if successful, redirect to location
        return redirect()->intended(route('admin.index'));
      }
      //if unsuccessful, redirect back with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout() {
      Auth::guard('admin')->logout();
      return redirect('/admin/login');
    }
}
