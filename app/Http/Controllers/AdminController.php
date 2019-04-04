<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Notification;
use App\Notifications\AddAdminNotification;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index');
    }

    public function create()
    {
        return view('admin.add-admin');
    }

    public function admins()
    {
        return view('admin.add-admin');
    }

    public function store(Request $request)
    {
        $check = Admin::where(['email' => $request->email])->first();
        if($check) {
          return redirect()->back()->with(['admin_message_err' => 'Дошло је до грешке! Е-маил који сте унели већ користи други корисник.']);
        }
        $super = false;
        if($request->super_admin == true) {
          $super = true;
        }
        $password = Str::random(12);
        $hash = Hash::make($password);
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->job = $request->job;
        $admin->super_admin = $super;
        $admin->password = $hash;
        $save = $admin->save();
        if($save) {
          Notification::route('mail', $admin->email)->notify(new AddAdminNotification($request->email, $password));
          return redirect('/admin/admins')->with(['admin_message' => 'Нов корисник је успешно додат!']);
        } else {
          return redirect()->back()->with(['admin_message_err' => 'Дошло је до грешке!']);
        }
    }
}
