<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Major;
use App\Models\Setup;
use App\Models\Title;
use App\Models\Campus;
use App\Models\Employee;
use App\Models\Religion;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Models\MaritalStatus;
use App\Models\EmployeeStatus;
use App\Models\EmployeeIdentity;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setup = Setup::init();
        if ($request->ajax()) {
            $data = Employee::with('title')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('title_id', function($row) {
                    return $row->title ? $row->title->name : 'N/A'; // Replace title_id with employee_status name
                })
                ->make(true);
        }
        return view('employee.index', compact('setup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setup = Setup::init();
        $employee_statuses = EmployeeStatus::all();
        $titles = Title::all();
        $educations = Education::all();
        $campuses = Campus::all();
        $majors = Major::all();
        $religions = Religion::all();
        $marital_statuses = MaritalStatus::all();
        $banks = Bank::all();
        $employee_identities = EmployeeIdentity::all();
        return view('employee.create', compact('setup', 'employee_statuses', 'titles', 'educations',  'campuses', 'majors', 'religions', 'marital_statuses', 'banks', 'employee_identities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee_identities = EmployeeIdentity::all();
        $validation_rules = [
            "id" => "required|unique:employees",
            "name" => "required|unique:employees",
            "address" => "required",
            "place_of_birth" => "required",
            "birthday" => "required|date",
            "title_id" => "required|exists:titles,id",
            "employee_status_id" => "required|exists:employee_statuses,id",
            "education_id" => "required|exists:education,id",
            "campus_id" => "required|exists:campuses,id",
            "major_id" => "required|exists:majors,id",
            "religion_id" => "required|exists:religions,id",
            "marital_status_id" => "required|exists:marital_statuses,id",
            "bank_id" => "required|exists:banks,id",
        ];
        foreach($employee_identities as $employee_identity){
            $column_name = str_replace(' ', '_', $employee_identity->name);
            $validation_rules[$column_name] = "nullable";
        }
        $validated = $request->validate($validation_rules);
        $employee = Employee::create($validated);
        return redirect()->back()->with("success", "Employee has been created");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $setup = Setup::init();
        $employee = Employee::findOrFail($id);
        $employee_identities = EmployeeIdentity::all();
        return view('employee.show', compact('setup', 'employee', 'employee_identities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $setup = Setup::init();
        $employee = Employee::findOrFail($id);
        $employee_statuses = EmployeeStatus::all();
        $titles = Title::all();
        $educations = Education::all();
        $campuses = Campus::all();
        $majors = Major::all();
        $religions = Religion::all();
        $marital_statuses = MaritalStatus::all();
        $banks = Bank::all();
        $employee_identities = EmployeeIdentity::all();
        return view('employee.edit', compact('setup', 'employee', 'employee_statuses', 'titles', 'educations',  'campuses', 'majors', 'religions', 'marital_statuses', 'banks', 'employee_identities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee_identities = EmployeeIdentity::all();
        $validation_rules = [
            'id' => 'required|unique:employees,id,' . $employee->id,
            'name' => 'required|unique:employees,name,' . $employee->id,
            "address" => "required",
            "place_of_birth" => "required",
            "birthday" => "required|date",
            "title_id" => "required|exists:titles,id",
            "employee_status_id" => "required|exists:employee_statuses,id",
            "education_id" => "required|exists:education,id",
            "campus_id" => "required|exists:campuses,id",
            "major_id" => "required|exists:majors,id",
            "religion_id" => "required|exists:religions,id",
            "marital_status_id" => "required|exists:marital_statuses,id",
            "bank_id" => "required|exists:banks,id",
        ];
        foreach($employee_identities as $employee_identity){
            $column_name = str_replace(' ', '_', $employee_identity->name);
            $validation_rules[$column_name] = "nullable";
        }
        $validated = $request->validate($validation_rules);
        $employee->update($validated);
        return redirect()->route('employee.index')->with("success", "Employee has been updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return redirect()->back()->with("success", "Employee has been deleted");
    }
}
