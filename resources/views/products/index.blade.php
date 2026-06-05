@extends('layouts.app')

@section('page-title', 'Products')

@section('content')
<div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600">Product catalogue</p>
            <h3 class="mt-2 text-2xl font-semibold text-slate-950">Manage product records</h3>
            <p class="mt-2 text-sm text-slate-500">Keep product metadata updated and searchable.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-700">
                <span class="font-semibold text-slate-950">{{ $products->total() }}</span> total records
            </div>
            <a href="{{ route('products.create') }}" class="rounded-2xl bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Add Product</a>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Sub category</th>
                        <th class="px-6 py-4">Serial no</th>
                        <th class="px-6 py-4">Carat</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($products as $product)
                        <tr class="text-sm text-slate-700">
                            <td class="px-6 py-4 font-semibold text-slate-950">#{{ $product->id_product }}</td>
                            <td class="px-6 py-4">{{ $product->description ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $product->sub_category ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $product->serial_no ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $product->carat ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('products.show', $product) }}" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">View</a>
                                    <a href="{{ route('products.edit', $product) }}" class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:border-amber-300">Edit</a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:border-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                No products found. Add a product to populate the catalogue.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
