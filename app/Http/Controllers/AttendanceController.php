<?php

namespace App\Http\Controllers;

use App\Models\Setup;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setup = Setup::init();
        if ($request->ajax()) {
            $data = Attendance::with('employee', 'shift')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('employee_id', function($row) {
                    return $row->employee ? $row->employee->name : 'N/A'; // Replace employee_id with employee name
                })
                ->editColumn('shift_id', function($row) {
                    return $row->shift ? $row->shift->name : 'N/A'; // Replace shift_id with shift name
                })
                ->rawColumns(['skills'])
                ->make(true);
        }
        return view('attendance.index', compact('setup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setup = Setup::init();
        $employees = Employee::all();
        return view('attendance.create', compact('setup', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = date("Y-m-d");
        $checklog = date("Y-m-d H:i:s");
        $basic_salary = Setup::get()->last()->daily_wage;

        // $attendance = Attendance::where('employee_id', $request->employee_id)
        //     ->where('date', $date)
        //     ->first();

        // if ($attendance)
        // {
        //     $attendance->check_out = $checklog;
        //     $attendance->save();
        //     return redirect()->route('attendance.index')->with("success", "Attendance has been updated");
        // }
        // else
        // {
        //     $credit = 0;
        //     $net_salary = $basic_salary * $credit;
        //     Attendance::create([
        //         'date' => date("Y-m-d"),
        //         'employee_id' => $request->employee_id,
        //         'check_in' => date("Y-m-d H:i:s"),
        //         'shift_id' => 1,
        //         'credit' => $credit,
        //         'basic_salary' => $basic_salary,
        //         'net_salary' => $net_salary,
        //     ]);
        //     return redirect()->route('attendance.index')->with("success", "Attendance has been created");
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $setup = Setup::init();
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        return view('attendance.edit', compact('setup', 'attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|unique:attendances,name,' . $attendance->id,
        ]);
        $attendance->update($validated);
        return redirect()->route('attendance.index')->with("success", "Attendance has been updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect()->back()->with("success", "Attendance has been deleted");
    }
}
