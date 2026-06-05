@extends('layouts.app')

@section('page-title', 'Daily Report')

@section('content')
<div class="space-y-6">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-600">Daily report</p>
                <h3 class="mt-2 text-2xl font-semibold text-slate-950">Work allocation and work completion</h3>
                <p class="mt-2 text-sm text-slate-500">Filter the report by date to review SPK and nota terima created on that day.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('reports.daily.print', ['date' => $date]) }}" target="_blank" class="rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Print</a>
            </div>
        </div>

        <form method="GET" action="{{ route('reports.daily') }}" class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-end">
            <div class="w-full sm:max-w-xs">
                <label for="date" class="block text-sm font-semibold text-slate-700">Report date</label>
                <input id="date" type="date" name="date" value="{{ $date }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
            </div>
            <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Load report</button>
        </form>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">SPK count</p>
            <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $summary['spk_count'] }}</p>
        </div>
        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">SPK items</p>
            <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $summary['spk_items'] }}</p>
        </div>
        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Nota count</p>
            <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $summary['nota_count'] }}</p>
        </div>
        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Nota items</p>
            <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $summary['nota_items'] }}</p>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-600">SPK</p>
                    <h4 class="mt-1 text-xl font-semibold text-slate-950">Daily work allocations</h4>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($spkHeaders as $header)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                            <div>
                                <p class="text-lg font-semibold text-slate-950">{{ $header->sw }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $header->employee_name ?? '—' }}{{ $header->employee_rank ? ' - ' . $header->employee_rank : '' }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $header->process ?? '—' }} &bull; {{ \Illuminate\Support\Carbon::parse($header->trans_date)->format('d M Y') }}</p>
                            </div>
                            <div class="text-sm text-slate-600">
                                <p>Items: <span class="font-semibold text-slate-950">{{ $header->item_count }}</span></p>
                                <p>Qty: <span class="font-semibold text-slate-950">{{ $header->total_qty }}</span></p>
                            </div>
                        </div>

                        <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr class="text-left text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                                        <th class="px-4 py-3">Line</th>
                                        <th class="px-4 py-3">Product</th>
                                        <th class="px-4 py-3">Qty</th>
                                        <th class="px-4 py-3">Weight</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @foreach (($spkItems[$header->id] ?? []) as $item)
                                        <tr class="text-sm text-slate-700">
                                            <td class="px-4 py-3 font-semibold text-slate-950">{{ $item->ordinal }}</td>
                                            <td class="px-4 py-3">{{ $item->product_description ?? '—' }}</td>
                                            <td class="px-4 py-3">{{ $item->qty ?? '—' }}</td>
                                            <td class="px-4 py-3">{{ $item->weight ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center text-sm text-slate-500">
                        No SPK records found for this date.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-rose-600">Nota</p>
                    <h4 class="mt-1 text-xl font-semibold text-slate-950">Daily work completions</h4>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($notaHeaders as $header)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                            <div>
                                <p class="text-lg font-semibold text-slate-950">{{ $header->work_allocation }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $header->employee_name ?? '—' }}{{ $header->employee_rank ? ' - ' . $header->employee_rank : '' }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $header->process ?? '—' }} &bull; {{ \Illuminate\Support\Carbon::parse($header->trans_date)->format('d M Y') }}</p>
                            </div>
                            <div class="text-sm text-slate-600">
                                <p>Items: <span class="font-semibold text-slate-950">{{ $header->item_count }}</span></p>
                                <p>Qty: <span class="font-semibold text-slate-950">{{ $header->total_qty }}</span></p>
                            </div>
                        </div>

                        <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr class="text-left text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                                        <th class="px-4 py-3">Line</th>
                                        <th class="px-4 py-3">Product</th>
                                        <th class="px-4 py-3">Qty</th>
                                        <th class="px-4 py-3">Weight</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @foreach (($notaItems[$header->id] ?? []) as $item)
                                        <tr class="text-sm text-slate-700">
                                            <td class="px-4 py-3 font-semibold text-slate-950">{{ $item->ordinal }}</td>
                                            <td class="px-4 py-3">{{ $item->product_description ?? '—' }}</td>
                                            <td class="px-4 py-3">{{ $item->qty ?? '—' }}</td>
                                            <td class="px-4 py-3">{{ $item->weight ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center text-sm text-slate-500">
                        No work completion records found for this date.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection
