<div class="bg-white rounded-xl shadow-md p-4 mb-6">
    <nav class="flex flex-wrap gap-2">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.umkm') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.umkm') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
            UMKM
        </a>
        <a href="{{ route('admin.products') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.products') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
            Produk
        </a>
        <a href="{{ route('admin.articles') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.articles') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
            Artikel
        </a>
        <a href="{{ route('admin.events') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.events') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
            Event
        </a>
        <a href="{{ route('admin.messages') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.messages') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
            Pesan
        </a>
    </nav>
</div>
