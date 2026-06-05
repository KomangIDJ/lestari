<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = Employee::paginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'entry_date' => 'nullable|date',
            'name' => 'required|string|max:100',
            'rank' => 'nullable|string|max:20',
            'gender' => 'nullable|in:M,F,O',
        ]);

        if (empty($validated['entry_date'])) {
            unset($validated['entry_date']);
        }

        Employee::create($validated);

        return redirect()->route('employees.index')
                       ->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'entry_date' => 'nullable|date',
            'name' => 'required|string|max:100',
            'rank' => 'nullable|string|max:20',
            'gender' => 'nullable|in:M,F,O',
        ]);

        if (empty($validated['entry_date'])) {
            unset($validated['entry_date']);
        }

        $employee->update($validated);

        return redirect()->route('employees.index')
                       ->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
                       ->with('success', 'Employee deleted successfully');
    }
}
