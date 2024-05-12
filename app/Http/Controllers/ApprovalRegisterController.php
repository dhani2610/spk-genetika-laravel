<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ApprovalRegisterController extends Controller
{
    // disini view untuk list data approval user 
    public function index()
    {
        $data['page_title'] = 'Approval List';
        $data['breadcumb'] = 'Approval List';
        // disini code untuk get data user yang status approval nya masih pending di table users 
        $data['users'] = User::orderby('id', 'asc')->where('approval','Pending')->get();

        // disini kita return view data nya 
        return view('approval-user.index', $data);
    }

    // disini fungsi untuk approve user by id user tersebut 
    public function approval(Request $request, $id)
    {
        // disini dilakukan code update data user tersebut menjadi approve 
        $user = User::findOrFail($id);
        $user->approval = 'Approve';
        $user->save();
        return redirect()->route('approval-list')->with(['success' => 'Approv successfully!']);
    }

    // disini fungsi untuk approve user by id user tersebut 
    public function notApprove(Request $request, $id)
    {
        // disini dilakukan code update data user tersebut menjadi not approve 
        $user = User::findOrFail($id);
        $user->approval = 'Not Approve';
        $user->save();
        return redirect()->route('approval-list')->with(['success' => 'Not Approv successfully!']);
    }

}
