<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Setup;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setup = Setup::init();
        $warehouses = Warehouse::all();
        return view('warehouse.index', compact('setup', 'warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setup = Setup::init();
        return view('warehouse.create', compact('setup'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|unique:warehouses",
        ]);
        $warehouse = Warehouse::create($validated);
        return redirect()->back()->with("success", "Warehouse has been created");
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $setup = Setup::init();
        $warehouse = Warehouse::findOrFail($id);
        return view('warehouse.edit', compact('setup', 'warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|unique:warehouses,name,' . $warehouse->id,
        ]);
        $warehouse->update($validated);
        return redirect()->route('warehouse.index')->with("success", "Warehouse has been updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Warehouse::findOrFail($id)->delete();
        return redirect()->back()->with("success", "Warehouse has been deleted");
    }
}
