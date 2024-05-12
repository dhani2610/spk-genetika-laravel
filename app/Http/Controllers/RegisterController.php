<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Kelas;
Use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Master App';
        $data['breadcumb'] = 'Master App';
        $data['roles'] = Role::pluck('name')->all();
        $data['kelas'] = Kelas::orderby('id', 'asc')->get();

        return view('auth.register', $data);
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'name'   => 'required|string|min:3',
            'username'   => 'required|unique:users,username|alpha_dash',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'role' => 'required',
            'id_kelas' => 'required',
            'tipe' => 'required',
        ]);

        $user = new User();
        $user->name = $validateData['name'];
        $user->username = $validateData['username'];
        $user->email = $validateData['email'];
        $user->id_kelas = $validateData['id_kelas'];
        $user->tipe = $validateData['tipe'];
        $user->password = Hash::make($validateData['password']);

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/users/');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }

        $user->save();
        $user->assignRole($validateData['role']);

        return redirect()->route('user.login')->with(['success' => 'Register Berhasil']);
    }
}
