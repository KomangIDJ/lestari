@extends('layouts.app')

@section('page-title', 'Work Completion Details')

@section('content')
<div class="mx-auto max-w-6xl overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 bg-slate-50 px-6 py-6 sm:px-8">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-rose-600">Nota detail</p>
        <h3 class="mt-2 text-2xl font-semibold text-slate-950">{{ $workcompletion->work_allocation }}</h3>
        <p class="mt-1 text-sm text-slate-500">Operator {{ $workcompletion->employeeRecord?->name ?? '—' }} &bull; {{ $workcompletion->process ?? '—' }}</p>
    </div>

    <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-2">
        <div class="space-y-4">
            <div>
                <p class="text-sm text-slate-500">Transaction date</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $workcompletion->trans_date?->format('d M Y') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Process</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $workcompletion->process ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Remarks</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $workcompletion->remarks ?? '—' }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <div>
                <p class="text-sm font-semibold text-slate-700">Items copied from SPK</p>
                <p class="mt-1 text-sm text-slate-500">This note mirrors the selected work allocation.</p>
            </div>

            <div class="mt-5 space-y-3">
                @forelse ($workcompletion->items as $item)
                    <div class="rounded-3xl border border-slate-200 bg-white px-4 py-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-slate-950">{{ $item->product?->description ?? ('Product #' . $item->fg) }}</p>
                                <p class="mt-1 text-sm text-slate-500">Qty {{ $item->qty ?? '-' }} &bull; Weight {{ $item->weight ?? '-' }}</p>
                            </div>
                            <span class="rounded-2xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-600">Line {{ $item->ordinal }}</span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-4 py-8 text-center text-sm text-slate-500">No items found.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 border-t border-slate-200 px-6 py-6 sm:px-8">
        <a href="{{ route('workcompletions.edit', $workcompletion) }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Edit Nota</a>
        <a href="{{ route('workcompletions.print', $workcompletion) }}" target="_blank" class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 transition hover:border-emerald-300">Print</a>
        <a href="{{ route('workcompletions.index') }}" class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Back to List</a>
    </div>
</div>
@endsection
