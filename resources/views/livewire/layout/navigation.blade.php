<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/');
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-craft-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo - Left Side -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <svg class="w-10 h-10 text-craft-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <!-- Icon Toko/Store -->
                        <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
                    </svg>
                    <span class="font-extrabold text-2xl">
                        <span class="text-craft-600">UMKM</span><span class="text-craft-800">Tegal</span>
                    </span>
                </a>
            </div>

            <!-- Navigation Links + Auth - Right Side -->
            <div class="hidden sm:flex sm:items-center gap-8">
                <!-- Navigation Links -->
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    Beranda
                </x-nav-link>
                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    Produk
                </x-nav-link>
                <x-nav-link :href="route('umkm.index')" :active="request()->routeIs('umkm.index') || request()->routeIs('umkm.show')">
                    UMKM
                </x-nav-link>
                <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                    Artikel
                </x-nav-link>
                <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.*')">
                    Event
                </x-nav-link>

                @auth
                    @if(auth()->user()->isUmkm())
                    <x-nav-link :href="route('umkm.dashboard')" :active="request()->routeIs('umkm.dashboard') || request()->routeIs('umkm.profile') || request()->routeIs('umkm.products') || request()->routeIs('umkm.statistics')" class="!text-craft-600 !font-semibold">
                        Dashboard
                    </x-nav-link>
                    @elseif(auth()->user()->isAdmin())
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="!text-craft-600 !font-semibold">
                        Admin
                    </x-nav-link>
                    @endif

                    <!-- Settings Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-craft-600 bg-white hover:text-craft-800 focus:outline-none transition ease-in-out duration-150">
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')">
                                Profil Saya
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    Keluar
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-craft-600 hover:text-craft-800 text-sm font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-craft-500 hover:bg-craft-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Daftar</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-craft-400 hover:text-craft-500 hover:bg-craft-100 focus:outline-none focus:bg-craft-100 focus:text-craft-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Beranda
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                Produk
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('umkm.index')" :active="request()->routeIs('umkm.index') || request()->routeIs('umkm.show')">
                UMKM
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                Artikel
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.*')">
                Event
            </x-responsive-nav-link>
            @auth
            @if(auth()->user()->isUmkm())
            <x-responsive-nav-link :href="route('umkm.dashboard')" :active="request()->routeIs('umkm.dashboard')">
                Dashboard UMKM
            </x-responsive-nav-link>
            @elseif(auth()->user()->isAdmin())
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                Dashboard Admin
            </x-responsive-nav-link>
            @endif
            @endauth
        </div>

        @auth
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-craft-200">
            <div class="px-4">
                <div class="font-medium text-base text-craft-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-craft-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')">
                    Profil Saya
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        Keluar
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
        @else
        <div class="pt-4 pb-3 border-t border-craft-200 space-y-1">
            <x-responsive-nav-link :href="route('login')">
                Masuk
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">
                Daftar
            </x-responsive-nav-link>
        </div>
        @endauth
    </div>
</nav>
