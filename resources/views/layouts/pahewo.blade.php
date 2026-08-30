<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? __('pahewo.dashboard.title') }} - {{ __('pahewo.app_name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        {{-- Mobile overlay --}}
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"
            @click="sidebarOpen = false"
            x-cloak
        ></div>

        {{-- Mobile sidebar --}}
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition ease-in-out duration-200 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 lg:hidden"
            x-cloak
        >
            <x-sidebar />
        </div>

        {{-- Desktop sidebar --}}
        <div class="fixed inset-y-0 left-0 z-30 hidden lg:block">
            <x-sidebar />
        </div>

        <div class="lg:pl-[250px]">
            {{-- Top bar --}}
            <header class="sticky top-0 z-20 border-b border-gray-200 bg-white">
                <div class="flex h-14 items-center justify-between gap-4 px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 lg:hidden"
                            @click="sidebarOpen = true"
                            aria-label="{{ __('pahewo.common.menu') }}"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>

                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>

                    <div class="flex items-center gap-3">
                        @isset($toolbar)
                            {{ $toolbar }}
                        @endisset

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                {{ __('pahewo.common.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="px-4 pt-4 sm:px-6">
                    <x-alert type="success" :message="session('success')" />
                </div>
            @endif

            @if (session('error'))
                <div class="px-4 pt-4 sm:px-6">
                    <x-alert type="error" :message="session('error')" />
                </div>
            @endif

            @if ($errors->any())
                <div class="px-4 pt-4 sm:px-6">
                    <x-alert type="error">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                </div>
            @endif

            {{-- Main content --}}
            <main class="px-4 py-6 sm:px-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</body>
</html>
