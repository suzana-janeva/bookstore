{{-- Navbar --}}
<header class="sticky top-0 z-40 border-b border-black/5 bg-white/80 backdrop-blur">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        {{-- Wordmark --}}
        <a href="{{ route('home') }}" class="flex items-baseline gap-1.5 shrink-0">
            <span class="text-xl font-extrabold tracking-tight text-brand-600">Bookstore</span>
        </a>

        {{-- Search (hidden on small screens) --}}
        @if($showSearch ?? true)
            <form action="{{ route('books.index') }}" method="GET" class="hidden flex-1 max-w-md md:block">
                <div class="relative">
                    <input type="search" name="q" value="{{ request('q') }}"
                           placeholder="Search books or authors…"
                           class="w-full rounded-full border-gray-200 bg-canvas pl-11 pr-4 py-2 text-sm text-ink shadow-sm focus:border-brand-400 focus:ring-brand-400">
                    <svg class="pointer-events-none absolute left-4 top-2.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/>
                    </svg>
                </div>
            </form>
        @endif

        {{-- Right nav --}}
        <div class="flex items-center gap-1 sm:gap-3">
            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="relative rounded-lg p-2 text-gray-600 transition hover:text-brand-600" aria-label="Cart">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.4a1 1 0 0 1 .98.8L5 6m0 0 1.6 8a1.5 1.5 0 0 0 1.48 1.2h8.34a1.5 1.5 0 0 0 1.47-1.19L19.5 8.25H5Zm3 13.5a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z"/>
                </svg>
                @if($cartCount > 0)
                    <span class="absolute -right-0.5 -top-0.5 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-brand-600 px-1 text-[11px] font-bold text-white">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            @auth
                <div class="relative" x-data="{ open: false }" @keydown.escape="open = false">
                    <button @click="open = !open" class="flex items-center gap-1.5 rounded-lg px-2 py-2 text-sm font-medium text-gray-700 transition hover:text-brand-600">
                        <span class="hidden sm:inline">{{ Str::of(auth()->user()->name)->explode(' ')->first() }}</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="open" x-cloak @click.outside="open = false"
                         class="absolute right-0 mt-2 w-52 overflow-hidden rounded-xl bg-white py-1.5 shadow-card ring-1 ring-black/5">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm font-semibold text-brand-700 hover:bg-brand-50">Admin panel</a>
                            <div class="my-1 border-t border-gray-100"></div>
                        @endif
                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50">My orders</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-brand-50">Log out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:text-brand-600">Log in</a>
                <a href="{{ route('register') }}" class="btn-primary hidden sm:inline-flex">Sign up</a>
            @endauth
        </div>
    </nav>
</header>
