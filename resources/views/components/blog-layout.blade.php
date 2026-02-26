<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    
    {{-- Ambil CSS asli lo --}}
    @vite(['resources/css/blog.css', 'resources/js/blog.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #020617; /* Slate 950 - Hitam Anime */
            color: #cbd5e1; /* Slate 300 - Abu terang */
        }
    </style>
</head>
<body class="antialiased">

    {{-- Navbar Simpel Ala Anime --}}
    <nav class="bg-black/80 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-orange-500 tracking-tighter uppercase italic">
                FARIS<span class="text-white font-light">ANIM</span>
            </a>
            <div class="flex gap-4 text-xs font-bold uppercase tracking-widest">
                <a href="/" class="hover:text-orange-500 transition">Home</a>
                <a href="/login" class="px-4 py-2 bg-white text-black rounded-full hover:bg-orange-500 hover:text-white transition">Login</a>
            </div>
        </div>
    </nav>

    {{-- Tempat Isi Konten --}}
    <main class="max-w-7xl mx-auto px-6 py-10">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-900 py-10 text-center text-[10px] text-slate-600 font-bold uppercase tracking-[0.3em]">
        &copy; {{ date('Y') }} {{ config('app.name') }} - Anime Portal Project
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
</body>
</html>