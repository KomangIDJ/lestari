@extends('layouts.app')

@section('page-title', 'Employees')

@section('content')
<div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-600">Employee directory</p>
            <h3 class="mt-2 text-2xl font-semibold text-slate-950">Manage employee records</h3>
            <p class="mt-2 text-sm text-slate-500">Create, review, update, or remove employees from one place.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-700">
                <span class="font-semibold text-slate-950">{{ $employees->total() }}</span> total records
            </div>
            <a href="{{ route('employees.create') }}" class="rounded-2xl bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Add Employee</a>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Rank</th>
                        <th class="px-6 py-4">Gender</th>
                        <th class="px-6 py-4">Entry date</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($employees as $employee)
                        <tr class="text-sm text-slate-700">
                            <td class="px-6 py-4 font-semibold text-slate-950">#{{ $employee->id_employee }}</td>
                            <td class="px-6 py-4">{{ $employee->name }}</td>
                            <td class="px-6 py-4">{{ $employee->rank ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @if ($employee->gender === 'M')
                                    <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">Male</span>
                                @elseif ($employee->gender === 'F')
                                    <span class="inline-flex rounded-full bg-pink-100 px-3 py-1 text-xs font-semibold text-pink-700">Female</span>
                                @elseif ($employee->gender === 'O')
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Other</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $employee->entry_date?->format('d M Y H:i') ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('employees.show', $employee) }}" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">View</a>
                                    <a href="{{ route('employees.edit', $employee) }}" class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:border-amber-300">Edit</a>
                                    <form method="POST" action="{{ route('employees.destroy', $employee) }}" onsubmit="return confirm('Delete this employee?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:border-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                No employees found. Start by adding the first record.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $employees->links() }}
    </div>
</div>
@endsection
