<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use App\Models\Workallocation;
use App\Models\Workcompletion;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalProducts = Product::count();
        $totalWorkallocations = Workallocation::count();
        $totalWorkcompletions = Workcompletion::count();
        $recentEmployees = Employee::orderByDesc('id_employee')->limit(5)->get();
        $recentProducts = Product::orderByDesc('id_product')->limit(5)->get();
        $recentWorkallocations = Workallocation::with('employeeRecord')->orderByDesc('id')->limit(5)->get();
        $recentWorkcompletions = Workcompletion::with('employeeRecord')->orderByDesc('id')->limit(5)->get();

        return view('dashboard', compact(
            'totalEmployees',
            'totalProducts',
            'totalWorkallocations',
            'totalWorkcompletions',
            'recentEmployees',
            'recentProducts',
            'recentWorkallocations',
            'recentWorkcompletions'
        ));
    }
}
