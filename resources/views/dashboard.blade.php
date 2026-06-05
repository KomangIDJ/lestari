@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-slate-950 text-white shadow-2xl shadow-slate-900/10">
        <div class="grid gap-8 px-6 py-8 sm:px-8 lg:grid-cols-[1.4fr_0.9fr] lg:px-10 lg:py-10">
            <div class="space-y-5">
                <span class="inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-300">Operations snapshot</span>
                <div class="space-y-3">
                    <h3 class="max-w-2xl text-3xl font-semibold tracking-tight sm:text-4xl">Keep employee, product, and transaction data moving from one dashboard.</h3>
                    <p class="max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">Manage employees and products, then create surat perintah kerja and nota terima kerja from the same workspace with print-ready output.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('workallocations.create') }}" class="rounded-2xl bg-emerald-400 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">Create SPK</a>
                    <a href="{{ route('workcompletions.create') }}" class="rounded-2xl border border-white/15 bg-white/5 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10">Create Nota</a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm text-slate-300">Employees</p>
                    <div class="mt-3 flex items-end justify-between gap-4">
                        <p class="text-4xl font-semibold">{{ $totalEmployees }}</p>
                        <span class="rounded-2xl bg-emerald-400/15 px-3 py-1 text-sm font-medium text-emerald-300">Master data</span>
                    </div>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm text-slate-300">Products</p>
                    <div class="mt-3 flex items-end justify-between gap-4">
                        <p class="text-4xl font-semibold">{{ $totalProducts }}</p>
                        <span class="rounded-2xl bg-sky-400/15 px-3 py-1 text-sm font-medium text-sky-300">Master data</span>
                    </div>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm text-slate-300">SPK</p>
                    <div class="mt-3 flex items-end justify-between gap-4">
                        <p class="text-4xl font-semibold">{{ $totalWorkallocations }}</p>
                        <span class="rounded-2xl bg-amber-400/15 px-3 py-1 text-sm font-medium text-amber-300">Transactions</span>
                    </div>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm text-slate-300">Nota terima</p>
                    <div class="mt-3 flex items-end justify-between gap-4">
                        <p class="text-4xl font-semibold">{{ $totalWorkcompletions }}</p>
                        <span class="rounded-2xl bg-rose-400/15 px-3 py-1 text-sm font-medium text-rose-300">Transactions</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-600">Employees</p>
                    <h4 class="mt-1 text-xl font-semibold text-slate-950">Recent employees</h4>
                </div>
                <a href="{{ route('employees.create') }}" class="rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Add employee</a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse ($recentEmployees as $employee)
                    <div class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <div>
                            <p class="font-semibold text-slate-950">{{ $employee->name }}</p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $employee->rank ?? 'No rank yet' }}
                                <span class="mx-2 text-slate-300">&bull;</span>
                                {{ $employee->entry_date?->format('d M Y H:i') ?? 'No entry date' }}
                            </p>
                        </div>
                        <a href="{{ route('employees.edit', $employee) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Edit</a>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">
                        No employees yet. Create the first record to start tracking your team.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600">Products</p>
                    <h4 class="mt-1 text-xl font-semibold text-slate-950">Recent products</h4>
                </div>
                <a href="{{ route('products.create') }}" class="rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Add product</a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse ($recentProducts as $product)
                    <div class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <div>
                            <p class="font-semibold text-slate-950">{{ $product->description ?? ('Product #' . $product->id_product) }}</p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $product->sub_category ?? 'No sub category' }}
                                <span class="mx-2 text-slate-300">&bull;</span>
                                Serial {{ $product->serial_no ?? '-' }}
                            </p>
                        </div>
                        <a href="{{ route('products.edit', $product) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Edit</a>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">
                        No products yet. Add one to start building the catalogue.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-600">SPK</p>
                    <h4 class="mt-1 text-xl font-semibold text-slate-950">Recent work allocations</h4>
                </div>
                <a href="{{ route('workallocations.index') }}" class="rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Open module</a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse ($recentWorkallocations as $allocation)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-slate-950">{{ $allocation->sw }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $allocation->employeeRecord?->name ?? 'No operator' }} &bull; {{ $allocation->process ?? 'No process' }}</p>
                            </div>
                            <a href="{{ route('workallocations.show', $allocation) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:text-slate-950">View</a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">
                        No work allocations yet.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-rose-600">Nota</p>
                    <h4 class="mt-1 text-xl font-semibold text-slate-950">Recent work completions</h4>
                </div>
                <a href="{{ route('workcompletions.index') }}" class="rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Open module</a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse ($recentWorkcompletions as $completion)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-slate-950">{{ $completion->work_allocation }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $completion->employeeRecord?->name ?? 'No operator' }} &bull; {{ $completion->process ?? 'No process' }}</p>
                            </div>
                            <a href="{{ route('workcompletions.show', $completion) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:text-slate-950">View</a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">
                        No work completions yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection
