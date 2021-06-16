<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/uxh2ttg.css">
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="antialiased font-monsterrat font-bold tracking-wider text-gray-800">
<div class="min-h-screen border border-red-500 flex flex-col justify-center items-center relative">
    <div class="absolute bg-red-300 absolute top-0 left-0 z-10">
        <div class="bg-blue-500 "><img src="{{ asset('/images/woman1.png') }}" width="700px"></div>
    </div>

    <div class="z-50 absolute top-50 bottom-50 left-50 right-50">
        <div class="text-2xl pb-6"> Welcome to Twilio's MessageBird</div>
        @if (Route::has('login'))
            <div class="hidden px-6 py-4 sm:block text-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="transition duration-700 ease-in-out text-md text-white font-semibold bg-indigo-400 rounded-lg px-4 py-2 shadow-md">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="transition duration-700 ease-in-out  text-md text-white font-semibold bg-pink-400 rounded-lg px-4 py-2 shadow-md">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="transition duration-700 ease-in-out ml-4 text-md text-white font-semibold bg-indigo-400 rounded-lg px-4 py-2 shadow-md">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>

    <div class="absolute bottom-0 right-0">
        <div class="bg-gray-700 text-white"><img src="{{ asset('/images/man1.png') }}" width="1100px"/></div>
    </div>
</div>
</body>
</html>
