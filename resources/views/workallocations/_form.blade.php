@php
    $isEdit = isset($workallocation) && $workallocation;
    $formAction = $action ?? ($isEdit ? route('workallocations.update', $workallocation) : route('workallocations.store'));
    $swValue = $isEdit ? $workallocation->sw : ($previewNumber ?? 'Auto-generated on save');
    $items = old('items');

    if ($items === null) {
        $items = $isEdit
            ? $workallocation->items->mapWithKeys(fn ($item, $index) => [
                $index => [
                    'fg' => $item->fg,
                    'qty' => $item->qty,
                    'weight' => $item->weight,
                ],
            ])->all()
            : [
                0 => ['fg' => '', 'qty' => 1, 'weight' => ''],
            ];
    }

    if (empty($items)) {
        $items = [
            0 => ['fg' => '', 'qty' => 1, 'weight' => ''],
        ];
    }

    $selectedEmployee = old('employee', $isEdit ? $workallocation->employee : '');
    $selectedProcess = old('process', $isEdit ? $workallocation->process : '');
    $selectedTransDate = old('trans_date', $isEdit ? $workallocation->trans_date?->format('Y-m-d') : now()->format('Y-m-d'));
    $selectedRemarks = old('remarks', $isEdit ? $workallocation->remarks : '');
@endphp

<div class="mx-auto max-w-6xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <div class="flex flex-col gap-2 border-b border-slate-200 pb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-600">Work allocation</p>
        <h3 class="text-2xl font-semibold text-slate-950">{{ $title ?? ($isEdit ? 'Edit SPK' : 'Create SPK') }}</h3>
        <p class="text-sm text-slate-500">Select an operator, choose multiple products, and record the process for the transaction.</p>
    </div>

    <form action="{{ $formAction }}" method="POST" class="mt-6 space-y-8">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-sm font-semibold text-slate-700">SPK number</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $swValue }}</p>
                    <p class="mt-1 text-sm text-slate-500">Generated from the transaction date and a monthly sequence.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="employee">Operator</label>
                    <select id="employee" name="employee" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                        <option value="">Select operator</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id_employee }}" @selected((string) $selectedEmployee === (string) $employee->id_employee)>{{ $employee->name }}{{ $employee->rank ? ' - ' . $employee->rank : '' }}</option>
                        @endforeach
                    </select>
                    @error('employee')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="trans_date">Transaction date</label>
                        <input id="trans_date" type="date" name="trans_date" value="{{ $selectedTransDate }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                        @error('trans_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="process">Process</label>
                        <select id="process" name="process" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                            <option value="">Select process</option>
                            @foreach (['Cor', 'Brush', 'Bombing', 'Slep'] as $process)
                                <option value="{{ $process }}" @selected($selectedProcess === $process)>{{ $process }}</option>
                            @endforeach
                        </select>
                        @error('process')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="remarks">Remarks</label>
                    <textarea id="remarks" name="remarks" rows="5" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">{{ $selectedRemarks }}</textarea>
                    @error('remarks')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Products in this SPK</p>
                        <p class="mt-1 text-sm text-slate-500">Add more than one product and fill the requested quantity for each line.</p>
                    </div>
                    <button type="button" id="add-allocation-item" class="rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Add item</button>
                </div>

                <div class="mt-5 space-y-3" id="allocation-items">
                    @foreach ($items as $index => $item)
                        <div class="grid gap-3 rounded-3xl border border-slate-200 bg-white p-4 md:grid-cols-[1.4fr_0.4fr_0.5fr_auto] md:items-end" data-allocation-row data-row-index="{{ $index }}">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Product</label>
                                <select name="items[{{ $index }}][fg]" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                                    <option value="">Select product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id_product }}" @selected((string)($item['fg'] ?? '') === (string) $product->id_product)>{{ $product->description ?? ('Product #' . $product->id_product) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Qty</label>
                                <input type="number" min="1" name="items[{{ $index }}][qty]" value="{{ $item['qty'] ?? 1 }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Weight</label>
                                <input type="number" min="0" step="0.01" name="items[{{ $index }}][weight]" value="{{ $item['weight'] ?? '' }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                            </div>
                            <button type="button" class="remove-allocation-item rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 transition hover:border-red-300">Remove</button>
                        </div>
                    @endforeach
                </div>

                @error('items')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('items.*.fg')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('items.*.qty')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-4 text-sm text-slate-500">Each row becomes one item in the transaction.</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
            <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">{{ $submitLabel ?? 'Save SPK' }}</button>
            <a href="{{ route('workallocations.index') }}" class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Cancel</a>
        </div>
    </form>
</div>

<template id="allocation-item-template">
    <div class="grid gap-3 rounded-3xl border border-slate-200 bg-white p-4 md:grid-cols-[1.4fr_0.4fr_0.5fr_auto] md:items-end" data-allocation-row>
        <div>
            <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Product</label>
            <select name="items[__INDEX__][fg]" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                <option value="">Select product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id_product }}">{{ $product->description ?? ('Product #' . $product->id_product) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Qty</label>
            <input type="number" min="1" name="items[__INDEX__][qty]" value="1" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
        </div>
        <div>
            <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Weight</label>
            <input type="number" min="0" step="0.01" name="items[__INDEX__][weight]" value="" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
        </div>
        <button type="button" class="remove-allocation-item rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 transition hover:border-red-300">Remove</button>
    </div>
</template>

@section('scripts')
<script>
(() => {
    const container = document.getElementById('allocation-items');
    const template = document.getElementById('allocation-item-template');
    const addButton = document.getElementById('add-allocation-item');

    if (!container || !template || !addButton) {
        return;
    }

    const nextIndex = () => {
        const indexes = [...container.querySelectorAll('[data-row-index]')]
            .map((row) => Number(row.dataset.rowIndex))
            .filter((value) => Number.isFinite(value));

        return indexes.length ? Math.max(...indexes) + 1 : 0;
    };

    const updateRemoveState = () => {
        const rows = container.querySelectorAll('[data-allocation-row]');
        rows.forEach((row) => {
            const button = row.querySelector('.remove-allocation-item');
            if (button) {
                button.disabled = rows.length === 1;
                button.classList.toggle('opacity-50', rows.length === 1);
                button.classList.toggle('cursor-not-allowed', rows.length === 1);
            }
        });
    };

    addButton.addEventListener('click', () => {
        const index = nextIndex();
        const html = template.innerHTML.replaceAll('__INDEX__', index);
        container.insertAdjacentHTML('beforeend', html);
        updateRemoveState();
    });

    container.addEventListener('click', (event) => {
        const button = event.target.closest('.remove-allocation-item');
        if (!button) {
            return;
        }

        const rows = container.querySelectorAll('[data-allocation-row]');
        if (rows.length > 1) {
            button.closest('[data-allocation-row]')?.remove();
            updateRemoveState();
        }
    });

    updateRemoveState();
})();
</script>
@endsection
