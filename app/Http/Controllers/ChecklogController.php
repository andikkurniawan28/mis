<?php

namespace App\Http\Controllers;

use App\Models\Setup;
use App\Models\Checklog;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ChecklogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->ajax()) {
            $data = Checklog::with('employee')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('employee_id', function($row) {
                    return $row->employee ? $row->employee->name : 'N/A'; // Replace employee_id with employee name
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('Y-m-d H:i:s'); // Format created_at
                })
                ->make(true);
        }
        $setup = Setup::init();
        return view('checklog.index', compact('setup'));
    }
}
