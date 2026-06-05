@extends('layouts.app')

@section('page-title', 'Create Employee')

@section('content')
<div class="mx-auto max-w-4xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <div class="flex flex-col gap-2 border-b border-slate-200 pb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-600">Employee form</p>
        <h3 class="text-2xl font-semibold text-slate-950">Create a new employee</h3>
        <p class="text-sm text-slate-500">Use the fields below to add a new employee record.</p>
    </div>

    <form action="{{ route('employees.store') }}" method="POST" class="mt-6 space-y-6">
        @csrf

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="block text-sm font-semibold text-slate-700">Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rank" class="block text-sm font-semibold text-slate-700">Rank</label>
                <input type="text" id="rank" name="rank" value="{{ old('rank') }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                @error('rank')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gender" class="block text-sm font-semibold text-slate-700">Gender</label>
                <select id="gender" name="gender" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                    <option value="">Select gender</option>
                    <option value="M" @selected(old('gender') === 'M')>Male</option>
                    <option value="F" @selected(old('gender') === 'F')>Female</option>
                    <option value="O" @selected(old('gender') === 'O')>Other</option>
                </select>
                @error('gender')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="entry_date" class="block text-sm font-semibold text-slate-700">Entry date</label>
                <input type="datetime-local" id="entry_date" name="entry_date" value="{{ old('entry_date') }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200">
                <p class="mt-2 text-sm text-slate-500">Leave blank to use the current time.</p>
                @error('entry_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
            <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Create Employee</button>
            <a href="{{ route('employees.index') }}" class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">Cancel</a>
        </div>
    </form>
</div>
@endsection
