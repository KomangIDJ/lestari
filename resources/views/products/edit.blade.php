@extends('layouts.app')

@section('page-title', 'Edit Product')

@section('content')
<div class="mx-auto max-w-4xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <div class="flex flex-col gap-2 border-b border-slate-200 pb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600">Product form</p>
        <h3 class="text-2xl font-semibold text-slate-950">Edit product #{{ $product->id_product }}</h3>
        <p class="text-sm text-slate-500">Update product metadata and save the record.</p>
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="description" class="block text-sm font-semibold text-slate-700">Description</label>
                <input type="text" id="description" name="description" value="{{ old('description', $product->description) }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sub_category" class="block text-sm font-semibold text-slate-700">Sub category</label>
                <input type="text" id="sub_category" name="sub_category" value="{{ old('sub_category', $product->sub_category) }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                @error('sub_category')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="serial_no" class="block text-sm font-semibold text-slate-700">Serial no</label>
                <input type="number" id="serial_no" name="serial_no" value="{{ old('serial_no', $product->serial_no) }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                @error('serial_no')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="carat" class="block text-sm font-semibold text-slate-700">Carat</label>
                <input type="text" id="carat" name="carat" value="{{ old('carat', $product->carat) }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                @error('carat')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
            <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Update Product</button>
            <a href="{{ route('products.index') }}" class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Cancel</a>
        </div>
    </form>
</div>
@endsection
