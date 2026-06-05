@extends('layouts.app')

@section('page-title', 'Product Details')

@section('content')
<div class="mx-auto max-w-4xl overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 bg-slate-50 px-6 py-6 sm:px-8">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600">Product detail</p>
        <h3 class="mt-2 text-2xl font-semibold text-slate-950">#{{ $product->id_product }} - {{ $product->description ?? 'Product' }}</h3>
    </div>

    <div class="grid gap-6 p-6 sm:p-8 md:grid-cols-2">
        <div class="space-y-4">
            <div>
                <p class="text-sm text-slate-500">Description</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $product->description ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Sub category</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $product->sub_category ?? '—' }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <p class="text-sm text-slate-500">Serial no</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $product->serial_no ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Carat</p>
                <p class="mt-1 text-lg font-semibold text-slate-950">{{ $product->carat ?? '—' }}</p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 border-t border-slate-200 px-6 py-6 sm:px-8">
        <a href="{{ route('products.edit', $product) }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Edit Product</a>
        <a href="{{ route('products.index') }}" class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Back to List</a>
    </div>
</div>
@endsection
