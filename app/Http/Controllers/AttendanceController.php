<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Setup;
use App\Models\Shift;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\TimeOperation;
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
            $data = Attendance::with('employee')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('employee_id', function($row) {
                    return $row->employee ? $row->employee->name : '-';
                })
                ->editColumn('shift_id', function($row) {
                    return $row->shift ? $row->shift->name : '-';
                })
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

    public function store(Request $request)
    {
        $employee = Employee::findOrFail($request->employee_id);
        $basic_salary = Setup::dailyWage() * $employee->title->salary_multiplier;

        /* For Testing */
        $time = $request->time;
        $today = $request->today;

        /* For Production */
        // $time = date("H:i:s");
        // $today = date("Y-m-d");

        $yesterday = TimeOperation::decreaseDay($today, 1);
        $shift = self::determineShift($time);

        /* Update yesterday's incomplete attendance or today's new attendance */
        $attendance = self::checkIncompleteAttendance($request, $yesterday, $today);

        if ($attendance) {
            $interval = self::countInterval($attendance->shift->start, $time);
            $credit = self::countCredit($interval, $attendance->shift->salary_multiplier);
            $net_salary = self::countNetSalary($attendance->basic_salary, $credit);
            $early_late = self::countEarlyOrLate($attendance->shift->finish, $time);
            self::updateChecklog($attendance, $time, $credit, $net_salary, $early_late);
        } else {
            if ($shift) {
                $early_late = self::countEarlyOrLate($shift->start, $time);
                self::newChecklog($request, $today, $basic_salary, $time, $shift, $early_late);
            } else {
                return redirect()->route('attendance.index')->with("fail", "The time does not fall within any shift. Please come back later.");
            }
        }

        return redirect()->route('attendance.index')->with("success", "Attendance has been recorded");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect()->back()->with("success", "Attendance has been deleted");
    }

    public static function checkIncompleteAttendance($request, $yesterday, $today)
    {
        return Attendance::where("employee_id", $request->employee_id)
            ->whereIn("date", [$yesterday, $today])
            ->where("check_out", null)
            ->first();
    }

    public static function countCredit($interval, $salary_multiplier)
    {
        $real_credit = ($interval / 8) * 1;
        if($real_credit > 1) $credit = 1; else $credit = $real_credit;
        return $credit * $salary_multiplier;
    }

    public static function countInterval($check_in, $check_out)
    {
        $checkInTime = Carbon::createFromFormat('H:i:s', $check_in);
        $checkOutTime = Carbon::createFromFormat('H:i:s', $check_out);
        return $checkInTime->diffInHours($checkOutTime);
    }

    public static function determineShift($time)
    {
        $shifts = Shift::all();
        $currentTime = Carbon::createFromFormat('H:i:s', $time);
        $currentShift = null;
        foreach ($shifts as $shift) {
            $shiftStart = Carbon::createFromFormat('H:i:s', $shift->start);
            $startMinusOneHour = $shiftStart->copy()->subHour();
            $startPlusOneHour = $shiftStart->copy()->addHour();
            if ($currentTime->between($startMinusOneHour, $startPlusOneHour)) {
                $currentShift = $shift;
                break;
            }
        }
        return $currentShift;
    }

    public static function countEarlyOrLate($shift, $time)
    {
        $statedTime = Carbon::createFromFormat('H:i:s', $shift);
        $checkOutTime = Carbon::createFromFormat('H:i:s', $time);
        $diff = $statedTime->diffInMinutes($checkOutTime);
        $isLate = $checkOutTime->greaterThan($statedTime);
        $data = [
            "late" => $isLate ? $diff : 0,
            "early" => !$isLate ? $diff : 0,
        ];
        return $data;
    }

    public static function newChecklog($request, $today, $basic_salary, $time, $shift, $early_late)
    {
        Attendance::create([
            "employee_id" => $request->employee_id,
            "date" => $today,
            "basic_salary" => $basic_salary,
            "credit" => 0,
            "net_salary" => 0,
            "check_in" => $time,
            "shift_id" => $shift->id,
            "early_check_in" => $early_late["early"],
            "late_check_in" => $early_late["late"],
        ]);
    }

    public static function updateChecklog($attendance, $time, $credit, $net_salary, $early_late)
    {
        $attendance->update([
            "check_out" => $time,
            "credit" => $credit,
            "net_salary" => $net_salary,
            "early_check_out" => $early_late["early"],
            "late_check_out" => $early_late["late"],
        ]);
    }

    public static function countNetSalary($basic_salary, $credit)
    {
        return $basic_salary * $credit;
    }
}
