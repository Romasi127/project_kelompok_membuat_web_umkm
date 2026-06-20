<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Seafood 2000')</title>
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex text-slate-800">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 hidden md:flex flex-col border-r border-slate-800">
        <div class="h-16 flex items-center justify-center border-b border-slate-800 px-6">
            <span class="text-xl font-bold tracking-tight text-white flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-teal-500 rounded-full animate-ping"></span>
                SEAFOOD 2000
            </span>
        </div>
        <div class="flex-grow py-6 px-4 space-y-7">
            <div>
                <span class="text-xs uppercase tracking-wider text-slate-500 font-bold px-3">Menu Utama</span>
                <nav class="mt-3 space-y-1">
                    <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('admin.orders*') ? 'bg-slate-800 text-white border-l-4 border-teal-500 pl-2' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        Kelola Pesanan
                    </a>
                    <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('admin.menus*') ? 'bg-slate-800 text-white border-l-4 border-teal-500 pl-2' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        Kelola Menu
                    </a>
                    <a href="{{ route('admin.revenue') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('admin.revenue*') ? 'bg-slate-800 text-white border-l-4 border-teal-500 pl-2' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                        </svg>
                        Laporan Pendapatan
                    </a>
                </nav>
            </div>
            
            <div class="border-t border-slate-800 pt-6">
                <a href="{{ route('menu.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs hover:bg-slate-800 hover:text-white transition-all">
                    Lihat Website User
                </a>
            </div>
        </div>

        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center justify-between">
                <div class="text-xs">
                    <p class="font-bold text-white">{{ Auth::user()->name }}</p>
                    <p class="text-slate-500">Administrator</p>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-1.5 bg-slate-800 rounded-lg text-rose-500 hover:text-rose-400 hover:bg-slate-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-h-screen">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-4">
                <h1 class="text-lg font-bold text-slate-800">@yield('page_title', 'Dashboard')</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-sm text-slate-500 font-semibold md:hidden flex gap-2">
                    <a href="{{ route('admin.orders') }}" class="hover:text-teal-600">Pesanan</a>
                    <span>|</span>
                    <a href="{{ route('admin.menus.index') }}" class="hover:text-teal-600">Menu</a>
                    <span>|</span>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-rose-500 hover:text-rose-600 font-semibold">Keluar</button>
                    </form>
                </div>
                
                <div class="text-xs text-slate-500 font-semibold bg-slate-100 px-3 py-1.5 rounded-full hidden md:block">
                    Logged in as Admin
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-grow p-6">
            <!-- Toast notification messages -->
            @if(session('success'))
                <div class="mb-6 bg-teal-50 border border-teal-200 text-teal-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm max-w-4xl">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-teal-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm max-w-4xl">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-rose-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="h-12 border-t border-slate-200 bg-white flex items-center justify-between px-6 text-xs text-slate-400">
            <p>&copy; Seafood 2000 Admin Portal.</p>
            <p>v1.0.0</p>
        </footer>

    </div>

    @stack('scripts')
</body>
</html>
