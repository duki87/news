<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Notification;
use Validator;
use Auth;
use App\Notifications\AddAdminNotification;
use Illuminate\Support\Facades\Input;

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
        if(Auth::user()->super_admin == 1) {
          return view('admin.add-admin');
        } else {
          return redirect()->back()->with(['error_message' => 'Немате овлашћење да користите овај део сајта!']);
        }
    }

    public function admins()
    {
        if(Auth::user()->super_admin == 1) {
          $admins = Admin::where('id', '!=', auth()->id())->paginate(5);
          return view('admin.admins')->with(['admins' => $admins]);
        } else {
          return redirect()->back()->with(['error_message' => 'Немате овлашћење да користите овај део сајта!']);
        }
    }

    public function store(Request $request)
    {
        $super = false;
        if($request->super_admin == true) {
          $super = true;
        }
        $validator = Validator::make($request->all(), [
           'email' => 'required|email|unique:admins|max:255',
           'name' => 'required',
           'job' => 'required'
       ]);
       if($validator->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput(Input::all());
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

    public function edit($id)
    {
      if(Auth::user()->super_admin == 1) {
        $admin = Admin::where(['id' => $id])->first();
        return view('admin.edit-admin')->with(['admin' => $admin]);
      } else {
        return redirect()->back()->with(['error_message' => 'Немате овлашћење да користите овај део сајта!']);
      }
    }

    public function change_status($id)
    {
      $admin = Admin::where(['id' => $id])->first();
      if(Auth::user()->super_admin == 1) {
        if($admin->super_admin == 1) {
          Admin::where(['id' => $id])->update(['super_admin' => 0]);
        } else {
          Admin::where(['id' => $id])->update(['super_admin' => 1]);
        }
        return redirect()->back()->with(['admin_message' => 'Статус администратора је успешно промењен!']);
      } else {
        return redirect()->back()->with(['error_message' => 'Немате овлашћење да користите овај део сајта!']);
      }
    }

    public function remove($id)
    {
      if(Auth::user()->super_admin == 1) {
        $admin = Admin::where(['id' => $id])->delete();
        if($admin) {
          return redirect()->back()->with(['admin_message' => 'Администратор је уклоњен!']);
        } else {
          return redirect()->back()->with(['admin_message' => 'Администратор је уклоњен!']);
        }
      } else {
        return redirect()->back()->with(['error_message' => 'Немате овлашћење да користите овај део сајта!']);
      }
    }

}
