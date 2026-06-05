@extends('layouts.app')

@section('page-title', 'Work Allocations')

@section('content')
<div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-600">SPK module</p>
            <h3 class="mt-2 text-2xl font-semibold text-slate-950">Surat perintah kerja</h3>
            <p class="mt-2 text-sm text-slate-500">Create, update, delete, and print SPK records from this screen.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-700">
                <span class="font-semibold text-slate-950">{{ $workallocations->total() }}</span> total records
            </div>
            <a href="{{ route('workallocations.create') }}" class="rounded-2xl bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Create SPK</a>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                        <th class="px-6 py-4">SPK No</th>
                        <th class="px-6 py-4">Operator</th>
                        <th class="px-6 py-4">Process</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Items</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($workallocations as $allocation)
                        <tr class="text-sm text-slate-700">
                            <td class="px-6 py-4 font-semibold text-slate-950">{{ $allocation->sw }}</td>
                            <td class="px-6 py-4">{{ $allocation->employeeRecord?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $allocation->process ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $allocation->trans_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $allocation->items->count() }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('workallocations.show', $allocation) }}" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">View</a>
                                    <a href="{{ route('workallocations.edit', $allocation) }}" class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:border-amber-300">Edit</a>
                                    <a href="{{ route('workallocations.print', $allocation) }}" target="_blank" class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:border-emerald-300">Print</a>
                                    <form method="POST" action="{{ route('workallocations.destroy', $allocation) }}" onsubmit="return confirm('Delete this SPK?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:border-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">No SPK records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $workallocations->links() }}
    </div>
</div>
@endsection
