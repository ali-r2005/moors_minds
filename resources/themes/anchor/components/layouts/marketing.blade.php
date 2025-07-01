<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
            @include('theme::partials.head', ['seo' => ($seo ?? null) ])
    <style>
        @import url('https://fonts.cdnfonts.com/css/neuropol-2');
    </style>
</head>
<body x-data class="flex flex-col min-h-screen overflow-x-hidden @if($bodyClass ?? false){{ $bodyClass }}@endif" x-cloak>

    <x-marketing.elements.header />

    <main class="flex-grow overflow-x-hidden">
        {{ $slot }}
    </main>

    @livewire('notifications')
    @include('theme::partials.footer')
    @include('theme::partials.footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    {{ $javascript ?? '' }}
    @stack('javascript')

</body>
</html>
