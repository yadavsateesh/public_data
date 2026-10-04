<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class LeaveApplicationController extends Controller
{
    // Display the leave application form
    public function index(Request $request)
    {
        $get_leave = LeaveApplication::where('user_id', auth()->id())->with('user')->get();
        if ($request->ajax()) {

            return DataTables::of($get_leave)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })

                ->make(true);
        }

        return view('user.user_leave_list');
    }
    public function create()
    {
        return view('user.leave_apply');
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming request
        $request->validate([
            'leave_type' => 'required|string',
            'from_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:from_date',
            'reason'     => 'required|string|max:500',
        ]);

        // 2. Calculate the total days (inclusive of both start and end date)
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $totalDays = $start->diffInDays($end) + 1;

        // 3. Save to the database
        LeaveApplication::create([
            'user_id'    => auth()->id(), // Assumes the user is logged in
            'leave_type' => $request->leave_type,
            'start_date' => $request->from_date,
            'end_date'   => $request->end_date,
            'total_days' => $totalDays,
            'reason'     => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Leave application submitted successfully.');
    }
}
