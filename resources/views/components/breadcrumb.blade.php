@props(['items' => [], 'containerClass' => 'max-w-4xl'])

<nav aria-label="Breadcrumb" class="w-full bg-white pt-6 pb-4 px-4 sm:px-6 lg:px-8">
    <div class="{{ $containerClass }} mx-auto flex items-center space-x-2 text-xs font-medium text-gray-600">
        <a href="{{ route('home') }}" class="hover:text-black transition">
            Accueil
        </a>

        @foreach($items as $label => $url)
            <span class="text-gray-400 font-bold text-xs">&rsaquo;</span>
            @if($url && !$loop->last)
                <a href="{{ $url }}" class="hover:text-black transition">
                    {{ $label }}
                </a>
            @else
                <span class="font-bold text-black" aria-current="page">
                    {{ $label }}
                </span>
            @endif
        @endforeach
    </div>
</nav>
