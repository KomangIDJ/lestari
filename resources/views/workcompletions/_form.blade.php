@php
    $isEdit = isset($workcompletion) && $workcompletion;
    $formAction = $action ?? ($isEdit ? route('workcompletions.update', $workcompletion) : route('workcompletions.store'));
    $selectedAllocationId = old('workallocation_id');
    if ($selectedAllocationId === null) {
        $selectedAllocationId = $selectedAllocation?->id;
    }

    $selectedRemarks = old('remarks', $isEdit ? $workcompletion->remarks : '');
    $allocationsPayload = $allocations->map(function ($allocation) {
        return [
            'id' => $allocation->id,
            'sw' => $allocation->sw,
            'employee' => $allocation->employeeRecord?->name,
            'process' => $allocation->process,
            'trans_date' => $allocation->trans_date?->format('d M Y'),
            'remarks' => $allocation->remarks,
            'items' => $allocation->items->map(function ($item) {
                return [
                    'line' => $item->ordinal,
                    'product' => $item->product?->description ?? ('Product #' . $item->fg),
                    'qty' => $item->qty,
                    'weight' => $item->weight,
                ];
            })->values(),
        ];
    })->values();
@endphp

<div class="mx-auto max-w-5xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <div class="flex flex-col gap-2 border-b border-slate-200 pb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-rose-600">Work completion</p>
        <h3 class="text-2xl font-semibold text-slate-950">{{ $title ?? ($isEdit ? 'Edit nota terima kerja' : 'Create nota terima kerja') }}</h3>
        <p class="text-sm text-slate-500">Choose an SPK and the nota will inherit the operator, process, date, and product lines.</p>
    </div>

    <form action="{{ $formAction }}" method="POST" class="mt-6 space-y-8">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="workallocation_id">Source SPK</label>
                    <select id="workallocation_id" name="workallocation_id" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                        <option value="">Select SPK</option>
                        @foreach ($allocations as $allocation)
                            <option value="{{ $allocation->id }}" @selected((string) $selectedAllocationId === (string) $allocation->id)>{{ $allocation->sw }} - {{ $allocation->employeeRecord?->name ?? 'No operator' }}</option>
                        @endforeach
                    </select>
                    @error('workallocation_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="remarks">Remarks</label>
                    <textarea id="remarks" name="remarks" rows="6" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">{{ $selectedRemarks }}</textarea>
                    @error('remarks')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-3xl border border-sky-200 bg-sky-50 p-5">
                    <p class="text-sm font-semibold text-sky-800">How it works</p>
                    <p class="mt-2 text-sm leading-6 text-sky-900">The note will copy the selected SPK's operator, process, date, and item list. You only need to choose the source and add any extra remarks if needed.</p>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-700">SPK preview</p>
                        <p class="mt-1 text-sm text-slate-500">The note will follow this document.</p>
                    </div>
                </div>

                <div id="completion-preview" class="mt-5 space-y-4">
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-4 py-6 text-sm text-slate-500">
                        Select an SPK to preview its data.
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
            <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">{{ $submitLabel ?? 'Save Nota' }}</button>
            <a href="{{ route('workcompletions.index') }}" class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Cancel</a>
        </div>
    </form>
</div>

<script>
    window.__workAllocationData = @json($allocationsPayload);
</script>

@section('scripts')
<script>
(() => {
    const select = document.getElementById('workallocation_id');
    const preview = document.getElementById('completion-preview');
    const data = window.__workAllocationData || [];

    if (!select || !preview) {
        return;
    }

    const render = (allocationId) => {
        const allocation = data.find((entry) => String(entry.id) === String(allocationId));

        if (!allocation) {
            preview.innerHTML = '<div class="rounded-3xl border border-dashed border-slate-300 bg-white px-4 py-6 text-sm text-slate-500">Select an SPK to preview its data.</div>';
            return;
        }

        const items = allocation.items.length
            ? allocation.items.map((item) => `
                <div class="rounded-3xl border border-slate-200 bg-white px-4 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold text-slate-950">${item.product}</p>
                            <p class="mt-1 text-sm text-slate-500">Qty ${item.qty} &bull; Weight ${item.weight ?? '-'}</p>
                        </div>
                        <span class="rounded-2xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-600">Line ${item.line}</span>
                    </div>
                </div>
            `).join('')
            : '<div class="rounded-3xl border border-dashed border-slate-300 bg-white px-4 py-6 text-sm text-slate-500">No items available.</div>';

        preview.innerHTML = `
            <div class="rounded-3xl border border-slate-200 bg-white px-4 py-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">SPK No</p>
                <p class="mt-2 text-xl font-semibold text-slate-950">${allocation.sw}</p>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white px-4 py-4">
                    <p class="text-sm text-slate-500">Operator</p>
                    <p class="mt-1 text-base font-semibold text-slate-950">${allocation.employee ?? '-'}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white px-4 py-4">
                    <p class="text-sm text-slate-500">Process</p>
                    <p class="mt-1 text-base font-semibold text-slate-950">${allocation.process ?? '-'}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white px-4 py-4">
                    <p class="text-sm text-slate-500">Date</p>
                    <p class="mt-1 text-base font-semibold text-slate-950">${allocation.trans_date ?? '-'}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white px-4 py-4">
                    <p class="text-sm text-slate-500">Remarks</p>
                    <p class="mt-1 text-base font-semibold text-slate-950">${allocation.remarks ?? '-'}</p>
                </div>
            </div>
            <div class="space-y-3">
                ${items}
            </div>
        `;
    };

    select.addEventListener('change', (event) => {
        render(event.target.value);
    });

    render(select.value);
})();
</script>
@endsection
