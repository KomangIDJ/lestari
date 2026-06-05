<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Workallocation;
use App\Models\Workcompletion;
use App\Models\Workcompletionitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkcompletionController extends Controller
{
    public function index()
    {
        $workcompletions = Workcompletion::with(['employeeRecord', 'items.product'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('workcompletions.index', compact('workcompletions'));
    }

    public function create(Request $request)
    {
        $allocations = Workallocation::with(['employeeRecord', 'items.product'])
            ->orderByDesc('id')
            ->get();
        $employees = Employee::orderBy('name')->get();
        $selectedAllocation = null;

        if ($request->filled('workallocation_id')) {
            $selectedAllocation = Workallocation::with(['employeeRecord', 'items.product'])
                ->findOrFail($request->integer('workallocation_id'));
        } elseif ($allocations->isNotEmpty()) {
            $selectedAllocation = $allocations->first();
        }

        return view('workcompletions.create', compact('allocations', 'employees', 'selectedAllocation'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'workallocation_id' => ['required', 'integer', 'exists:workallocation,id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $allocation = Workallocation::with(['employeeRecord', 'items.product'])->findOrFail($validated['workallocation_id']);

        DB::transaction(function () use ($allocation, $validated) {
            $completion = Workcompletion::create([
                'remarks' => $validated['remarks'] ?? $allocation->remarks,
                'employee' => $allocation->employee,
                'trans_date' => $allocation->trans_date,
                'process' => $allocation->process,
                'work_allocation' => $allocation->sw,
            ]);

            foreach ($allocation->items as $index => $item) {
                Workcompletionitem::create([
                    'work_completion_id' => $completion->id,
                    'ordinal' => $index + 1,
                    'qty' => $item->qty,
                    'weight' => $item->weight,
                    'link_id' => $item->idm,
                    'link_ord' => $item->ordinal,
                    'fg' => $item->fg,
                ]);
            }
        });

        return redirect()->route('workcompletions.index')->with('success', 'Work completion created successfully.');
    }

    public function show(Workcompletion $workcompletion)
    {
        $workcompletion->load(['employeeRecord', 'items.product']);

        return view('workcompletions.show', compact('workcompletion'));
    }

    public function edit(Workcompletion $workcompletion)
    {
        $allocations = Workallocation::with(['employeeRecord', 'items.product'])
            ->orderByDesc('id')
            ->get();
        $workcompletion->load(['employeeRecord', 'items.product']);
        $selectedAllocation = $allocations->firstWhere('sw', $workcompletion->work_allocation);

        return view('workcompletions.edit', compact('workcompletion', 'allocations', 'selectedAllocation'));
    }

    public function update(Request $request, Workcompletion $workcompletion)
    {
        $validated = $request->validate([
            'workallocation_id' => ['required', 'integer', 'exists:workallocation,id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $allocation = Workallocation::with(['employeeRecord', 'items.product'])->findOrFail($validated['workallocation_id']);

        DB::transaction(function () use ($allocation, $validated, $workcompletion) {
            $workcompletion->update([
                'remarks' => $validated['remarks'] ?? $allocation->remarks,
                'employee' => $allocation->employee,
                'trans_date' => $allocation->trans_date,
                'process' => $allocation->process,
                'work_allocation' => $allocation->sw,
            ]);

            $workcompletion->items()->delete();

            foreach ($allocation->items as $index => $item) {
                Workcompletionitem::create([
                    'work_completion_id' => $workcompletion->id,
                    'ordinal' => $index + 1,
                    'qty' => $item->qty,
                    'weight' => $item->weight,
                    'link_id' => $item->idm,
                    'link_ord' => $item->ordinal,
                    'fg' => $item->fg,
                ]);
            }
        });

        return redirect()->route('workcompletions.index')->with('success', 'Work completion updated successfully.');
    }

    public function destroy(Workcompletion $workcompletion)
    {
        DB::transaction(function () use ($workcompletion) {
            $workcompletion->items()->delete();
            $workcompletion->delete();
        });

        return redirect()->route('workcompletions.index')->with('success', 'Work completion deleted successfully.');
    }

    public function print(Workcompletion $workcompletion)
    {
        $workcompletion->load(['employeeRecord', 'items.product']);

        return view('workcompletions.print', compact('workcompletion'));
    }
}
