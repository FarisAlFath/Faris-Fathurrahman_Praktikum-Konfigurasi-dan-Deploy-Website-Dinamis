<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @isset($title)
            {{ ucfirst($title) }} -
        @endisset
        {{ config('app.name') }}
    </title>

    @vite(['resources/css/blog.css', 'resources/js/blog.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        .anime-card-shadow {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        /* Custom scrollbar biar makin keren */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #020617; }
        ::-webkit-scrollbar-thumb { background: #f97316; border-radius: 10px; }
    </style>
</head>

<body class="bg-slate-950 text-slate-300 antialiased">
    {{-- Flash Messages --}}
    @if (Session::has('message') || Session::has('error'))
        <div class="max-w-7xl mx-auto px-6 mt-6" x-data="{ show: true }" x-show="show">
            <div class="rounded-lg border border-slate-700 bg-slate-900 shadow-xl p-4 flex items-start gap-3">
                <i class="fas {{ Session::has('message') ? 'fa-check text-green-500' : 'fa-exclamation-triangle text-red-500' }} mt-1"></i>
                <p class="text-slate-300 text-sm flex-1">
                    {{ Session::get('message') ?? Session::get('error') }}
                </p>
                <button @click="show=false">
                    <i class="fas fa-times text-slate-500 hover:text-white"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- Top Bar / Navbar --}}
    <nav class="w-full bg-slate-950/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-8">
                {{-- Logo --}}
                <a href="{{ route('webhome') }}"
                    class="font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-yellow-400 text-2xl tracking-tighter uppercase">
                    {{ config('app.name') }}
                </a>

                {{-- Links --}}
                <ul class="hidden md:flex items-center gap-6 text-sm font-bold uppercase tracking-widest">
                    @foreach ($pages_nav as $page)
                        <li>
                            <a href="{{ route('page.show', $page->slug) }}"
                                class="transition-all duration-300 {{ request()->routeIs('page.show') && request('slug') == $page->slug ? 'text-orange-500' : 'text-slate-400 hover:text-orange-400' }}">
                                {{ $page->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex items-center gap-4">
                {{-- Auth --}}
                @auth
                    @can('admin-login')
                        <a href="{{ route('admin.index') }}" class="px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-full transition uppercase tracking-tighter">
                            Dashboard
                        </a>
                    @endcan
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-slate-400 hover:text-red-500 font-bold text-xs uppercase transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-100 hover:text-orange-500 font-bold text-xs uppercase transition">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-slate-100 text-slate-900 text-xs font-bold rounded-full hover:bg-orange-500 hover:text-white transition uppercase">Join</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Header --}}
    <header class="relative overflow-hidden py-16 bg-slate-900/30">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-black text-white mb-4 uppercase italic tracking-tighter">
                Explore <span class="text-orange-500">Universe</span>
            </h1>
            <p class="max-w-2xl mx-auto text-slate-400 text-base font-medium">
                {{ $setting->description }}
            </p>
        </div>
    </header>

    {{-- Category Menu --}}
    <div class="bg-slate-900 border-y border-slate-800 sticky top-[73px] z-40">
        <div class="max-w-7xl mx-auto px-6 overflow-x-auto">
            @include('front.partials.category-menu', [
                'categories' => $categories,
                'level' => 0,
                'orientation' => 'horizontal',
            ])
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- Slot Konten (Akan jadi grid nanti) --}}
            <div class="flex-1">
                {{ $slot }}
            </div>

            {{-- SIDEBAR --}}
            @if (!request()->routeIs('page.show'))
                <aside class="w-full lg:w-80 flex flex-col space-y-8">
                    {{-- About --}}
                    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6 anime-card-shadow">
                        <h3 class="text-xs font-black text-orange-500 uppercase tracking-[0.2em] mb-4">About Portal</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $setting->about }}</p>
                    </div>

                    {{-- Tags --}}
                    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6 anime-card-shadow">
                        <h3 class="text-xs font-black text-orange-500 uppercase tracking-[0.2em] mb-4">Trending Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                                <a href="{{ route('tag.show', $tag->name) }}"
                                    class="px-3 py-1.5 text-[10px] font-bold border border-slate-700 rounded-lg bg-slate-800 text-slate-300 hover:border-orange-500 hover:text-orange-500 transition-all">
                                    #{{ strtoupper($tag->name) }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Top Writers --}}
                    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6 anime-card-shadow">
                        <h3 class="text-xs font-black text-orange-500 uppercase tracking-[0.2em] mb-4">Elite Authors</h3>
                        <div class="space-y-4">
                            @foreach ($top_users as $top)
                                <div class="flex items-center gap-3 group">
                                    <img src="{{ $top->avatar }}" class="w-10 h-10 rounded-full border-2 border-slate-700 group-hover:border-orange-500 transition">
                                    <div class="flex-1">
                                        <p class="text-xs text-slate-100 font-bold group-hover:text-orange-400 transition">{{ $top->name }}</p>
                                        <p class="text-[10px] text-slate-500 uppercase font-black">{{ $top->posts_count }} Articles</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>
            @endif
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-black border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12 text-center">
            <div class="mb-8">
                <a href="#" class="text-2xl font-black text-white uppercase italic tracking-tighter">
                    {{ config('app.name') }}<span class="text-orange-500">.</span>
                </a>
            </div>
            <div class="flex flex-wrap justify-center gap-6 mb-8 text-xs font-bold uppercase tracking-widest text-slate-500">
                @foreach ($pages_footer as $page)
                    <a href="{{ route('page.show', $page->slug) }}" class="hover:text-orange-500 transition">
                        {{ $page->name }}
                    </a>
                @endforeach
            </div>
            <p class="text-slate-600 text-[10px] uppercase font-bold tracking-widest">
                &copy; {{ date('Y') }} {{ $setting->copy_rights }}
            </p>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
</body>
</html>