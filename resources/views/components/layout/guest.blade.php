@props(['title' => 'Flux'])
<!doctype html>
<html>

<head>
    {{-- <link rel="icon" href="{{ asset('images/emoji.png') }}"> --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (app()->environment('production'))
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
        <script src="{{ asset('build/assets/app.js') }}" defer></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <title class="uppercase">{{ $title ? ucfirst("Flux | $title") : 'Flux ' }}</title>
</head>

<body class="max-w-screen bg-background flex min-h-screen items-center justify-center px-8 py-4 text-white">
    <x-ui.card class="w-full max-w-lg">
        {{ $slot }}
    </x-ui.card>
</body>

</html>
