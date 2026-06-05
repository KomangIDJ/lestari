@extends('layouts.app')

@section('page-title', 'Employee Details')

@section('content')
<div class="mx-auto max-w-4xl overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 bg-slate-50 px-6 py-6 sm:px-8">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-600">Employee detail</p>
        <h3 class="mt-2 text-2xl font-semibold text-slate-950">#{{ $employee->id_employee }} - {{ $employee->name }}</h3>
    </div>

    <div class="grid gap-6 p-6 sm:p-8 md:grid-cols-2">
        <div class="space-y-4">
            <div>
                <p class="text-sm text-slate-500">Name</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $employee->name }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Rank</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $employee->rank ?? '—' }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <p class="text-sm text-slate-500">Gender</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">
                    @if ($employee->gender === 'M')
                        Male
                    @elseif ($employee->gender === 'F')
                        Female
                    @elseif ($employee->gender === 'O')
                        Other
                    @else
                        —
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Entry date</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $employee->entry_date?->format('d M Y H:i') ?? '—' }}</p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 border-t border-slate-200 px-6 py-6 sm:px-8">
        <a href="{{ route('employees.edit', $employee) }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Edit Employee</a>
        <a href="{{ route('employees.index') }}" class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Back to List</a>
    </div>
</div>
@endsection
