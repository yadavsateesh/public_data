<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LeaveApplication;
use Illuminate\Support\Facades\Hash;
// use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function leaveList(Request $request)
    {
        $get_leave = LeaveApplication::with('user')->get();
        if ($request->ajax()) {

            return DataTables::of($get_leave)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })->addColumn('status_btn', function ($row) {
                    $statusClass ='btn-success';
                    return '<button type="button" class="btn btn-sm ' . $statusClass . ' status-btn" data-id="' . $row->id . '" data-status="' . $row->status . '">Update status
                        </button>';
                })

                ->rawColumns(['status_btn'])

                ->make(true);
        }

        return view('admin.admin_leave_list');
    }

    public function updateStatus(Request $request)
    {
        $user = LeaveApplication::find($request->id);
        if ($user) {
            $user->status = $request->status;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Record not found!'], 404);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['id', 'name', 'email', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.user_list');
    }
    public function create()
    {
        return view('admin.user_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 0,
        ]);
        return response()->json([
            'success' => 'Form submitted successfully!'
        ]);


        // return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }
}
