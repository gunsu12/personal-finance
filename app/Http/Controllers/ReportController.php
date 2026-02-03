<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function monthly()
    {
        return view('reports.monthly');
    }

    public function yearly()
    {
        return view('reports.yearly');
    }
}
