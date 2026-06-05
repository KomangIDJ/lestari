<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report {{ $date }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .print-hidden { display: none !important; }
            body { background: #fff !important; }
        }
    </style>
</head>
<body class="bg-white text-slate-900" onload="window.print()">
    <div class="mx-auto max-w-7xl px-6 py-8">
        <div class="rounded-[2rem] border border-slate-200 p-8">
            <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-6 print-hidden">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-600">Daily report</p>
                    <h1 class="mt-2 text-3xl font-semibold text-slate-950">Work allocation and work completion</h1>
                    <p class="mt-1 text-sm text-slate-500">Date: {{ \Illuminate\Support\Carbon::parse($date)->format('d M Y') }}</p>
                </div>
                <button onclick="window.print()" class="rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Print</button>
            </div>

            <div class="grid gap-4 py-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">SPK count</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $summary['spk_count'] }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">SPK items</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $summary['spk_items'] }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">Nota count</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $summary['nota_count'] }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">Nota items</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $summary['nota_items'] }}</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-2">
                <div>
                    <h2 class="text-xl font-semibold text-slate-950">Daily work allocations</h2>
                    <div class="mt-4 space-y-4">
                        @forelse ($spkHeaders as $header)
                            <div class="rounded-3xl border border-slate-200 p-5">
                                <p class="font-semibold text-slate-950">{{ $header->sw }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ $header->employee_name ?? '—' }}{{ $header->employee_rank ? ' - ' . $header->employee_rank : '' }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ $header->process ?? '—' }} &bull; {{ \Illuminate\Support\Carbon::parse($header->trans_date)->format('d M Y') }}</p>
                                <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
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
                            <p class="text-sm text-slate-500">No SPK records found for this date.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-slate-950">Daily work completions</h2>
                    <div class="mt-4 space-y-4">
                        @forelse ($notaHeaders as $header)
                            <div class="rounded-3xl border border-slate-200 p-5">
                                <p class="font-semibold text-slate-950">{{ $header->work_allocation }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ $header->employee_name ?? '—' }}{{ $header->employee_rank ? ' - ' . $header->employee_rank : '' }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ $header->process ?? '—' }} &bull; {{ \Illuminate\Support\Carbon::parse($header->trans_date)->format('d M Y') }}</p>
                                <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
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
                            <p class="text-sm text-slate-500">No work completion records found for this date.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
