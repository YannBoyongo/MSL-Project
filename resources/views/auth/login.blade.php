<x-guest-layout>
    <div class="min-h-screen w-full flex flex-col md:flex-row">
        <!-- Left Side: Hero Image with Branding & Donors -->
        <div class="hidden md:flex md:w-1/2 relative min-h-screen bg-cover bg-center bg-no-repeat flex-col justify-between p-8 lg:p-12 overflow-hidden"
             style="background-image: url('{{ asset('images/Picture1.jpg') }}');">
            <!-- Dark Overlay for High Contrast -->
            <div class="absolute inset-0 bg-black/45 z-0"></div>

            <!-- Top spacer -->
            <div class="relative z-10"></div>

            <!-- Center: MUPAKA SHAMBA LETU Branding -->
            <div class="relative z-10 max-w-lg">
                <h1 class="text-3xl lg:text-4xl xl:text-5xl font-black text-yellow-400 uppercase tracking-tight leading-[1.1] drop-shadow-md">
                    MUPAKA<br>SHAMBA LETU
                </h1>
                <p class="mt-3 text-white text-sm lg:text-base font-semibold tracking-wide drop-shadow">
                    Commerce Transfrontalier pour la paix
                </p>
            </div>

            <!-- Bottom: Partner Logos -->
            <div class="relative z-10 flex items-center justify-between gap-4 pt-6">
                <div class="bg-white px-3 py-2 shadow-md inline-flex items-center">
                    <img src="{{ asset('images/swiss.jpg') }}" alt="Confédération suisse" class="h-8 lg:h-9 w-auto object-contain">
                </div>

                <div class="bg-white px-3 py-2 shadow-md inline-flex items-center">
                    <img src="{{ asset('images/swede.png') }}" alt="Suède Sverige" class="h-8 lg:h-9 w-auto object-contain">
                </div>
            </div>
        </div>

        <!-- Right Side: Clean Login Form -->
        <div class="w-full md:w-1/2 min-h-screen flex items-center justify-center bg-white px-6 sm:px-12 md:px-10 lg:px-16 xl:px-20 py-12">
            <div class="w-full max-w-[420px] mx-auto">
                <!-- Organization Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/alert.png') }}" alt="International Alert" class="h-20 sm:h-24 w-auto object-contain">
                </div>

                <!-- Header Title & Subtitle -->
                <div class="mb-7">
                    <h1 class="text-2xl sm:text-[28px] font-black text-gray-900 tracking-tight mb-1">Bienvenue</h1>
                    <p class="text-sm text-gray-700 font-normal">Connectez-vous à votre compte pour continuer.</p>
                </div>

                <!-- Session Status Alert -->
                <x-auth-session-status class="mb-5" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <!-- Email ou Utilisateur -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-1.5">
                            Email ou Utilisateur
                        </label>
                        <input
                            id="email"
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full px-3.5 py-2.5 bg-white border @error('email') border-red-500 @else border-gray-400 @enderror rounded-none text-gray-900 text-sm focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition shadow-none"
                            placeholder=""
                        >
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-bold text-gray-900 mb-1.5">
                            Mot de passe
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-3.5 py-2.5 bg-white border @error('password') border-red-500 @else border-gray-400 @enderror rounded-none text-gray-900 text-sm focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition shadow-none"
                            placeholder=""
                        >
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rester connecté -->
                    <div class="flex items-center justify-between mb-8 mt-5">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 rounded-none border border-gray-400 text-black focus:ring-0 focus:ring-offset-0 focus:outline-none cursor-pointer"
                            >
                            <span class="ms-2.5 text-sm font-bold text-gray-900">Rester connecté</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-xs text-gray-500 hover:text-black hover:underline" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Se Connecter Button -->
                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-black hover:bg-neutral-800 active:bg-neutral-900 text-white font-bold text-sm tracking-wide rounded-none transition duration-150 ease-in-out cursor-pointer text-center shadow-none"
                    >
                        Se Connecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
