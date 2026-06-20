<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seafood 2000 - Pemesanan Makanan Online')</title>
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
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800">
    
    <!-- Navbar -->
    <header class="bg-white border-b border-slate-100 sticky top-0 z-40 backdrop-blur-md bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('menu.index') }}" class="flex items-center gap-2">
                        <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-teal-600 to-cyan-500 bg-clip-text text-transparent">
                            SEAFOOD 2000
                        </span>
                    </a>
                </div>

                <!-- Nav links & Cart & Auth -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <a href="{{ route('menu.index') }}" class="text-sm font-semibold text-slate-600 hover:text-teal-600 transition-colors">
                        Menu
                    </a>

                    <!-- Cart Link with Badge -->
                    @php
                        $cart = session()->get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-600 hover:text-teal-600 transition-all hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-rose-500 rounded-full animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Auth buttons -->
                    @if(Auth::check())
                        <div class="flex items-center gap-3">
                            <span class="hidden md:inline-block text-xs text-slate-500 font-medium bg-slate-100 px-2.5 py-1 rounded-full">
                                {{ Auth::user()->name }} ({{ Auth::user()->role }})
                            </span>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.orders') }}" class="text-xs font-semibold text-teal-700 bg-teal-50 px-3 py-1.5 rounded-lg border border-teal-200/50 hover:bg-teal-100 transition-colors">
                                    Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('order.myOrders') }}" class="text-xs font-semibold text-slate-700 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200/50 hover:bg-slate-100 transition-colors flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                    </svg>
                                    Pesanan Saya
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg border border-rose-200/50 transition-colors">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-teal-600 px-3 py-2 transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 px-4 py-2 rounded-xl transition-all shadow-md shadow-teal-600/10">
                                Daftar
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Success/Error Messages -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if(session('success'))
                <div class="mb-4 bg-teal-50 border border-teal-200 text-teal-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-teal-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-rose-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('warning') }}</span>
                    </div>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16">

                {{-- Col 1: Brand --}}
                <div>
                    <h3 class="text-white text-lg font-bold mb-3">SEAFOOD 2000</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Menyediakan aneka hidangan laut segar dan hidangan tradisional khas Indonesia dengan cita rasa istimewa.</p>
                </div>

                {{-- Col 2: Contact --}}
                <div class="pr-8">
                    <h3 class="text-white text-sm font-semibold mb-4 tracking-wider uppercase">Kontak Kami</h3>
                    <ul class="space-y-3 text-sm">

                        {{-- Maps Thumbnail --}}
                        <li>
                            <p class="text-slate-400 text-xs mb-2 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                </svg>
                                Jl. Ringroad - Medan
                            </p>
                            {{-- Google Maps Embed sebagai gambar interaktif --}}
                            <a href="https://maps.app.goo.gl/hLhhbLVeEGBaNAxE6" target="_blank" rel="noopener noreferrer"
                               class="block relative group rounded-xl overflow-hidden border border-slate-700 hover:border-teal-500 transition-all shadow-md mb-4"
                               style="width: 140px; height: 140px;"
                               title="Buka di Google Maps">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.0!2d98.6722!3d3.5952!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM8KwMzUnNDIuNyJOIDk4wrA0MCczOS45IkU!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                                    width="140"
                                    height="140"
                                    style="border:0; display:block; pointer-events:none;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                                {{-- Overlay dengan icon klik --}}
                                <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/30 flex items-center justify-center transition-all">
                                    <span class="opacity-0 group-hover:opacity-100 transition-all bg-white text-slate-800 text-[10px] font-bold px-2 py-1 rounded-full shadow-lg flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                        </svg>
                                        Buka Maps
                                    </span>
                                </div>
                            </a>
                        </li>

                        {{-- WhatsApp --}}
                        <li>
                            <a href="https://wa.me/6285833709981" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2.5 text-slate-300 hover:text-green-400 transition-colors group">
                                {{-- WhatsApp Icon --}}
                                <span class="flex-shrink-0 w-8 h-8 bg-green-500/10 group-hover:bg-green-500/20 border border-green-500/30 rounded-full flex items-center justify-center transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-400" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-medium leading-none mb-0.5">Chat WhatsApp</p>
                                    <p class="text-sm font-semibold">0858 3370 9981</p>
                                </div>
                            </a>
                        </li>

                        {{-- Jam Operasional --}}
                        <li class="flex items-center gap-2 text-slate-400 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-teal-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Buka Setiap Hari: 10:00 – 22:00 WIB
                        </li>
                    </ul>
                </div>

                {{-- Col 3: Admin --}}
                @if(!Auth::check() || Auth::user()->isAdmin())
                <div>
                    <h3 class="text-white text-sm font-semibold mb-4 tracking-wider uppercase">Portal Admin</h3>
                    <p class="text-sm text-slate-400 mb-3">Akses khusus untuk administrator Seafood 2000.</p>
                    <a href="{{ route('admin.login') }}" class="inline-flex items-center text-xs font-semibold text-teal-400 hover:text-teal-300 transition-colors">
                        Login Admin &rarr;
                    </a>
                </div>
                @endif
            </div>

            <div class="border-t border-slate-800 mt-10 pt-8 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Seafood 2000. Hak Cipta Dilindungi Undang-Undang.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
