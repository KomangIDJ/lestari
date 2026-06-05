<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use App\Models\Workallocation;
use App\Models\Workallocationitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WorkallocationController extends Controller
{
    public function index()
    {
        $workallocations = Workallocation::with(['employeeRecord', 'items.product'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('workallocations.index', compact('workallocations'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name')->get();
        $products = Product::orderBy('description')->get();
        $previewNumber = $this->previewNumber(now()->toDateString());

        return view('workallocations.create', compact('employees', 'products', 'previewNumber'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($data) {
            $allocation = Workallocation::create([
                'remarks' => $data['remarks'] ?? null,
                'employee' => $data['employee'],
                'trans_date' => $data['trans_date'],
                'process' => $data['process'],
                'sw' => $this->generateNumber($data['trans_date']),
            ]);

            foreach ($data['items'] as $index => $item) {
                Workallocationitem::create([
                    'work_allocation_id' => $allocation->id,
                    'ordinal' => $index + 1,
                    'qty' => $item['qty'],
                    'weight' => $item['weight'] ?? null,
                    'fg' => $item['fg'],
                ]);
            }
        });

        return redirect()->route('workallocations.index')->with('success', 'Work allocation created successfully.');
    }

    public function show(Workallocation $workallocation)
    {
        $workallocation->load(['employeeRecord', 'items.product']);

        return view('workallocations.show', compact('workallocation'));
    }

    public function edit(Workallocation $workallocation)
    {
        $workallocation->load(['employeeRecord', 'items.product']);
        $employees = Employee::orderBy('name')->get();
        $products = Product::orderBy('description')->get();

        return view('workallocations.edit', compact('workallocation', 'employees', 'products'));
    }

    public function update(Request $request, Workallocation $workallocation)
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($data, $workallocation) {
            $workallocation->update([
                'remarks' => $data['remarks'] ?? null,
                'employee' => $data['employee'],
                'trans_date' => $data['trans_date'],
                'process' => $data['process'],
            ]);

            $workallocation->items()->delete();

            foreach ($data['items'] as $index => $item) {
                Workallocationitem::create([
                    'work_allocation_id' => $workallocation->id,
                    'ordinal' => $index + 1,
                    'qty' => $item['qty'],
                    'weight' => $item['weight'] ?? null,
                    'fg' => $item['fg'],
                ]);
            }
        });

        return redirect()->route('workallocations.index')->with('success', 'Work allocation updated successfully.');
    }

    public function destroy(Workallocation $workallocation)
    {
        DB::transaction(function () use ($workallocation) {
            $workallocation->items()->delete();
            $workallocation->delete();
        });

        return redirect()->route('workallocations.index')->with('success', 'Work allocation deleted successfully.');
    }

    public function print(Workallocation $workallocation)
    {
        $workallocation->load(['employeeRecord', 'items.product']);

        return view('workallocations.print', compact('workallocation'));
    }

    private function validatePayload(Request $request): array
    {
        $validated = $request->validate([
            'remarks' => ['nullable', 'string'],
            'employee' => ['required', 'integer', Rule::exists('employee', 'id_employee')],
            'trans_date' => ['required', 'date'],
            'process' => ['required', Rule::in(['Cor', 'Brush', 'Bombing', 'Slep'])],
            'items' => ['required', 'array', 'min:1'],
            'items.*.fg' => ['required', 'integer', Rule::exists('product', 'id_product')],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.weight' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['items'] = array_values(array_filter($validated['items'], function ($item) {
            return !empty($item['fg']) && !empty($item['qty']);
        }));

        if (count($validated['items']) === 0) {
            abort(422, 'Please add at least one product item.');
        }

        return $validated;
    }

    private function previewNumber(string $transDate): string
    {
        [$year, $month] = explode('-', substr($transDate, 0, 7));
        $prefix = 'SPKO' . substr($year, -2) . $month;

        return $this->nextSequenceForPrefix($prefix);
    }

    private function generateNumber(string $transDate): string
    {
        [$year, $month] = explode('-', substr($transDate, 0, 7));
        $prefix = 'SPKO' . substr($year, -2) . $month;

        return $this->nextSequenceForPrefix($prefix);
    }

    private function nextSequenceForPrefix(string $prefix): string
    {
        $latest = Workallocation::where('sw', 'like', $prefix . '%')->orderByDesc('sw')->value('sw');
        $sequence = $latest ? ((int) substr($latest, -3)) + 1 : 1;

        return $prefix . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT);
    }
}
