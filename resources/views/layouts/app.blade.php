<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body class="h-full bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:flex">
        <aside class="border-b border-slate-800/60 bg-slate-950 text-slate-100 lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col lg:border-b-0 lg:border-r lg:border-slate-800">
            <div class="flex items-center gap-3 border-b border-slate-800 px-6 py-5">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-400/15 text-emerald-300 ring-1 ring-emerald-400/30">
                    <span class="text-lg font-semibold">L</span>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Lestari ERP</p>
                    <h1 class="text-lg font-semibold text-white">Operations Dashboard</h1>
                </div>
            </div>

            <nav class="flex-1 space-y-1 px-4 py-5">
                <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard') || request()->routeIs('home')) bg-emerald-400/10 text-emerald-300 ring-1 ring-inset ring-emerald-400/20 @else text-slate-300 hover:bg-slate-900 hover:text-white @endif flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                    <span class="text-base">⌂</span>
                    Dashboard
                </a>
                <a href="{{ route('employees.index') }}" class="@if(request()->routeIs('employees.*')) bg-emerald-400/10 text-emerald-300 ring-1 ring-inset ring-emerald-400/20 @else text-slate-300 hover:bg-slate-900 hover:text-white @endif flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                    <span class="text-base">◫</span>
                    Employees
                </a>
                <a href="{{ route('products.index') }}" class="@if(request()->routeIs('products.*')) bg-emerald-400/10 text-emerald-300 ring-1 ring-inset ring-emerald-400/20 @else text-slate-300 hover:bg-slate-900 hover:text-white @endif flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                    <span class="text-base">▣</span>
                    Products
                </a>
                <a href="{{ route('workallocations.index') }}" class="@if(request()->routeIs('workallocations.*')) bg-emerald-400/10 text-emerald-300 ring-1 ring-inset ring-emerald-400/20 @else text-slate-300 hover:bg-slate-900 hover:text-white @endif flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                    <span class="text-base">SP</span>
                    Work Allocation
                </a>
                <a href="{{ route('workcompletions.index') }}" class="@if(request()->routeIs('workcompletions.*')) bg-emerald-400/10 text-emerald-300 ring-1 ring-inset ring-emerald-400/20 @else text-slate-300 hover:bg-slate-900 hover:text-white @endif flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                    <span class="text-base">NT</span>
                    Work Completion
                </a>
            </nav>

            <div class="hidden border-t border-slate-800 px-6 py-5 lg:block">
                <p class="text-sm font-medium text-white">Quick links</p>
                <p class="mt-1 text-sm text-slate-400">Use the dashboard to review records and manage CRUD actions.</p>
            </div>
        </aside>

        <div class="flex min-h-screen flex-1 flex-col lg:pl-72">
            <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/85 backdrop-blur">
                <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.32em] text-emerald-600">Dashboard</p>
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    <div class="hidden items-center gap-3 sm:flex">
                        <a href="{{ route('employees.create') }}" class="rounded-2xl bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">New Employee</a>
                        <a href="{{ route('products.create') }}" class="rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">New Product</a>
                        <a href="{{ route('workallocations.create') }}" class="rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">New SPK</a>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                @if ($errors->any())
                    <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-sm">
                        <p class="font-semibold">Please fix the following:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-900 shadow-sm">
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
