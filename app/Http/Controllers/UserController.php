<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Posisi;
use App\Models\User;
Use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Foreach_;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
     
    }
    
    public function loginPost2(Request $request)
    {
        $val = $request->username;
        $password = $request->password;
        $cekMail = User::where('username',$val)->first();
   
            if($cekMail != null){
           
                    $credentials = ([
                        'username' => $val,
                        'password' => $password,
                    ]);

                    
                    if (Auth::attempt($credentials)) {
                            // return redirect()->route('dashboard.index');
                            return redirect()->route('jadwal');
                    }
        
            }elseif ($cekMail == null ){
                Alert::error('Failed', 'Gagal login');
                return redirect()->back();
            }
     
    }


    public function index()
    {
        $data['page_title'] = 'Users List';
        $data['breadcumb'] = 'Users List';
        $data['users'] = User::orderby('id', 'asc')->get();

        return view('users.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Users';
        $data['breadcumb'] = 'Add Users';
        $data['roles'] = Role::pluck('name')->all();

        return view('users.create', $data);
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
        ]);

        $user = new User();
        $user->name = $validateData['name'];
        $user->username = $validateData['username'];
        $user->email = $validateData['email'];
       
        if ($validateData['role'] == 'Admin') {
            $type = 1;
        }else{
            $type = 2;
        }
        $user->type = $type;

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

        return redirect()->route('users.index')->with(['success' => 'User added successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit User';
        $data['breadcumb'] = 'Edit User';
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::pluck('name')->all();

        return view('users.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name'   => 'required|string|min:3',
            'username'   => 'required|alpha_dash|unique:users,username,'.$id,
            'email'   => 'required|unique:users,email,'.$id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validateData['name'];
        $user->username = $validateData['username'];
        $user->email = $validateData['email'];
            
        if ($validateData['role'] == 'Admin') {
            $type = 1;
        }else{
            $type = 2;
        }
        $user->type = $type;
        

         if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/users/');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }

        $user->save();
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($validateData['role']);

        return redirect()->route('users.index')->with(['success' => 'User edited successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);
            $user->delete();
        });
        
        return redirect()->route('users.index')->with(['success' => ' successfully!']);
    }

    public function changePassword(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($validateData['password'], $user->password)) {
            $user->password = Hash::make($request->get('new_password'));
            $user->save();
    
            return redirect()->route('users.edit', Auth::user()->id)->with('success', 'Password changed successfully!');
        } else {
            return redirect()->route('users.edit', Auth::user()->id)->with('failed', 'Password change failed');
        }
    }

    public function loopUserCreate(){

        try {
            $tablePosisi = Posisi::get();
            $posisiCount = count($tablePosisi);
            foreach ($tablePosisi as $value) {
                for ($i=14; $i <= 26 ; $i++) { 
                    $user = new User();
                    $user->name = 'Karyawan'.$i;
                    $user->username = 'karyawan'.$i;
                    $user->email = 'karyawan'.$i.'@gmail.com';
                    $user->password = Hash::make('karyawan'.$i);
                    $user->type = 2;
                    $user->id_posisi = $tablePosisi[($i - 1) % $posisiCount]->id;
                    $user->save();
                    $user->assignRole('Karyawan');
                }
            }
            $tablePosisi = Posisi::get()->pluck('id','posisi');
            $user = User::where('type','2')->get()->pluck('id_posisi','name');
    

            return response()->json([
                'posisi' => $tablePosisi,
                'user' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }

    
    }
}
