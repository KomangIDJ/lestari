<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print SPK {{ $workallocation->sw }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900">
    <div class="mx-auto max-w-5xl px-6 py-8">
        <div class="rounded-[2rem] border border-slate-200 p-8">
            <div class="flex items-start justify-between gap-6 border-b border-slate-200 pb-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-600">Work allocation</p>
                    <h1 class="mt-2 text-3xl font-semibold text-slate-950">{{ $workallocation->sw }}</h1>
                    <p class="mt-1 text-sm text-slate-500">Surat perintah kerja print view</p>
                </div>
                <button onclick="window.print()" class="rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white print:hidden">Print</button>
            </div>

            <div class="grid gap-6 py-6 md:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Operator</p>
                    <p class="mt-1 text-lg font-semibold text-slate-950">{{ $workallocation->employeeRecord?->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Process</p>
                    <p class="mt-1 text-lg font-semibold text-slate-950">{{ $workallocation->process ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Date</p>
                    <p class="mt-1 text-lg font-semibold text-slate-950">{{ $workallocation->trans_date?->format('d M Y') ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Remarks</p>
                    <p class="mt-1 text-lg font-semibold text-slate-950">{{ $workallocation->remarks ?? '—' }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                            <th class="px-6 py-4">Line</th>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Qty</th>
                            <th class="px-6 py-4">Weight</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach ($workallocation->items as $item)
                            <tr class="text-sm text-slate-700">
                                <td class="px-6 py-4 font-semibold text-slate-950">{{ $item->ordinal }}</td>
                                <td class="px-6 py-4">{{ $item->product?->description ?? ('Product #' . $item->fg) }}</td>
                                <td class="px-6 py-4">{{ $item->qty ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->weight ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
