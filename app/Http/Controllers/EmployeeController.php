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

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setup = Setup::init();
        $employees = Employee::all();
        return view('employee.index', compact('setup', 'employees'));
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
        return view('employee.create', compact('setup', 'employee_statuses', 'titles', 'educations',  'campuses', 'majors', 'religions', 'marital_statuses', 'banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
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
        ]);
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
        return view('employee.show', compact('setup', 'employee'));
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
        return view('employee.edit', compact('setup', 'employee', 'employee_statuses', 'titles', 'educations',  'campuses', 'majors', 'religions', 'marital_statuses', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $validated = $request->validate([
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
        ]);
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
