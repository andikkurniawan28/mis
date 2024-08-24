<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClosingEntryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return redirect()->back()->with('success', 'Report has been closed');
    }
}
