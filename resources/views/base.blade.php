<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        <title>@yield('title', 'FreeAds')</title>
    </head>
    <body>
            <nav class="relative px-4 py-4 flex justify-between z-50 items-center bg-white">
                <a class="text-3xl font-bold leading-none text-green-700" href="{{ route('home') }}">
                    GreenLabs <i class="fa-solid fa-leaf"></i>
                </a>
                <div class="lg:hidden">
                    <button class="navbar-burger flex items-center text-green-600 p-3">
                        <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Mobile menu</title>
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                        </svg>
                    </button>
                </div>
                <ul class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:items-center lg:w-auto lg:space-x-6">
                    <li><a class="text-sm {{ (request()->is('/')) ? 'text-green-600 hover:text-green-700 font-bold' : 'text-gray-400 hover:text-gray-500' }}" href="{{ route('home') }}">Accueil</a></li>
                    <li class="text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </li>
                    <li><a class="text-sm {{ (request()->is('services*')) ? 'text-green-600 hover:text-green-700 font-bold' : 'text-gray-400 hover:text-gray-500' }}" href="{{ route('services') }}">Services</a></li>
                    <li class="text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </li>
                    <div class="relative z-50">
                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-sm {{ (request()->is('categories*')) ? 'text-green-600 hover:text-green-700 font-bold' : 'text-gray-400 hover:text-gray-500' }}">Catégories</button>
                        <div id="dropdown" class="absolute mt-5 z-50 hidden bg-white divide-gray-100 rounded-lg shadow w-96 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('categories', $category->route) }}" class="flex justify-between items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            {{ $category->name }}
                                            <i class="fa-solid fa-leaf"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <li class="text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </li>
                    <li><a class="text-sm {{ (request()->is('chat*')) ? 'text-green-600 hover:text-green-700 font-bold' : 'text-gray-400 hover:text-gray-500' }}" href="{{ route('chat') }}">Messagerie</a></li>
                </ul>
                @if(auth()->check())
                    <a class="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-green-100 hover:bg-green-200 text-sm text-gray-900 font-bold rounded-xl transition duration-200" href="{{ route('dashboard') }}">Tableau de bord</a>
                    <form action="{{ route('logout') }}" method="POST" class="hidden lg:inline-block">
                        @csrf
                        <button type="submit" class="hidden lg:inline-block py-2 px-6 bg-red-500 hover:bg-red-600 text-sm text-white font-bold rounded-xl transition duration-200">Déconnexion</button>
                    </form>                    
                @else
                    <a class="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-gray-50 hover:bg-gray-100 text-sm text-gray-900 font-bold rounded-xl transition duration-200" href="{{ route('login') }}">Connexion</a>
                    <a class="hidden lg:inline-block py-2 px-6 bg-green-500 hover:bg-green-600 text-sm text-white font-bold rounded-xl transition duration-200" href="{{ route('signup') }}">Inscription</a>
                @endif
            </nav>
            <div class="navbar-menu relative z-50 hidden">
                <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
                <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-full max-w-sm py-6 px-6 bg-white border-r overflow-y-auto sm:min-w-screen">
                    <div class="flex items-center mb-8">
                        <a class="mr-auto text-2xl sm:text-3xl font-bold leading-none text-green-700" href="{{ route('home') }}">
                            GreenLabs <i class="fa-solid fa-leaf"></i>
                        </a>                        
                        <button class="navbar-close">
                            <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <ul>
                            <li class="mb-1">
                                <a class="block p-4 text-sm {{ (request()->is('/')) ? 'bg-green-50 text-green-600' : 'text-gray-400 hover:bg-green-50 hover:text-green-600' }} font-semibold rounded" href="{{ route('home') }}">Accueil</a>
                            </li>
                            <li class="mb-1">
                                <a class="block p-4 text-sm font-semibold {{ (request()->is('services*')) ? 'bg-green-50 text-green-600' : 'text-gray-400 hover:bg-green-50 hover:text-green-600' }} rounded" href="{{ route('services') }}">Services</a>
                            </li>
                            <li class="mb-1">
                                <button class="flex justify-between items-center p-4 w-full text-left text-sm font-semibold {{ (request()->is('categories*')) ? 'bg-green-50 text-green-600' : 'text-gray-400 hover:bg-green-50 hover:text-green-600' }} rounded" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                    Catégories
                                    <span id="chevron-toggle">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </span>
                                </button>
                                <ul id="dropdown-example" class="hidden py-2 space-y-2">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('categories', $category->route) }}" class="flex justify-between items-center p-4 w-full text-left text-sm font-semibold text-gray-400 hover:bg-green-50 hover:text-green-600 rounded">
                                                {{ $category->name }}
                                                <i class="fa-solid fa-leaf"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="mb-1">
                                <a class="block p-4 text-sm font-semibold {{ (request()->is('chat*')) ? 'bg-green-50 text-green-600' : 'text-gray-400 hover:bg-green-50 hover:text-green-600' }} rounded" href="{{ route('chat') }}">Messagerie</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-auto">
                        <div class="pt-6">
                            @if (auth()->check())
                                <a class="block px-4 py-3 mb-3 leading-loose text-xs text-center font-semibold leading-none bg-gray-50 hover:bg-gray-100 rounded-xl" href="{{ route('dashboard') }}">Tableau de bord</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block px-4 py-2 mb-2 leading-loose text-xs text-center text-white font-semibold bg-red-600 hover:bg-red-700 rounded-xl w-full">Déconnexion</button>
                                </form>
                            @else
                                <a class="block px-4 py-3 mb-3 leading-loose text-xs text-center font-semibold leading-none bg-gray-50 hover:bg-gray-100 rounded-xl" href="{{ route('login') }}">Connexion</a>
                                <a class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-green-600 hover:bg-green-700  rounded-xl" href="{{ route('signup') }}">Inscription</a>
                            @endif
                        </div>
                        <p class="my-4 text-xs text-center text-gray-400">
                            <span>Copyright © {{ date('Y') }}</span>
                        </p>
                    </div>
                </nav>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-10 rounded relative" role="alert">
                    <strong class="font-bold mr-5">Bravo ! <i class="fa-solid fa-leaf"></i></strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @elseif(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-10 rounded relative" role="alert">
                    <strong class="font-bold mr-5">Erreur ! <i class="fa-solid fa-warning"></i></strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @elseif(session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 mb-10 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold mr-5">Attention ! <i class="fa-solid fa-exclamation"></i></strong>
                    <span class="block sm:inline">{{ session('warning') }}</span>
                </div>
            @elseif(session('status'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 mb-10 rounded relative" role="alert">
                    <strong class="font-bold mr-5">Information ! <i class="fa-solid fa-info"></i></strong>
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <form class="w-full sm:w-auto flex justify-end" method="GET">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Rechercher</label>
                <div class="relative min-w-[20rem] sm:min-w-[30rem]">
                    <div class="absolute inset-y-0 start-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" name="search" id="default-search" class="block w-full sm:w-[25rem] p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white-50 focus:ring-green-500 focus:border-green-500" placeholder="Rechercher un article..." required />
                    <button type="submit" class="text-white absolute end-9 bottom-2.5 bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Rechercher</button>
                </div>
            </form>

            @if (!empty($productResults))
                @foreach ($productResults as $product)
                    <div class="flex flex-col items-center justify-center w-full p-4 sm:flex-row sm:items-start sm:justify-start sm:space-x-4 sm:space-y-0 sm:py-6 border-b border-gray-200">
                        <div class="w-full sm:w-1/4">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover rounded-lg" />
                        </div>
                        <div class="w-full sm:w-3/4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $product->description }}</p>
                            <p class="text-sm text-gray-500">Prix : {{ $product->price }} €</p>
                            <p class="text-sm text-gray-500">Quantité : {{ $product->quantity }}</p>
                            <a href="{{ route('ad.show', ['category' => $product->category->route, 'ad_id' => $product->id]) }}" class="text-sm text-green-600 hover:underline">Voir l'annonce</a>
                        </div>
                    </div>
                @endforeach
            @endif

            @yield('content')

            <footer class="fixed bottom-0 left-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow md:flex md:items-center md:justify-between md:p-6">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a href="{{ route('home') }}" class="hover:underline">GreenLabs™</a>. Tous droits réservés.
                </span>
            </footer>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const burger = document.querySelectorAll('.navbar-burger');
                    const menu = document.querySelectorAll('.navbar-menu');
                
                    if (burger.length && menu.length) {
                        for (var i = 0; i < burger.length; i++) {
                            burger[i].addEventListener('click', function() {
                                for (var j = 0; j < menu.length; j++) {
                                    menu[j].classList.toggle('hidden');
                                }
                            });
                        }
                    }
                
                    const close = document.querySelectorAll('.navbar-close');
                    const backdrop = document.querySelectorAll('.navbar-backdrop');
                
                    if (close.length) {
                        for (var i = 0; i < close.length; i++) {
                            close[i].addEventListener('click', function() {
                                for (var j = 0; j < menu.length; j++) {
                                    menu[j].classList.toggle('hidden');
                                }
                            });
                        }
                    }
                
                    if (backdrop.length) {
                        for (var i = 0; i < backdrop.length; i++) {
                            backdrop[i].addEventListener('click', function() {
                                for (var j = 0; j < menu.length; j++) {
                                    menu[j].classList.toggle('hidden');
                                }
                            });
                        }
                    }
                });
        
                const dropdownButton = document.getElementById('dropdownDefaultButton');
                const dropdown = document.getElementById('dropdown');
        
                dropdownButton.addEventListener('click', function() {
                    dropdown.classList.toggle('hidden');
                });
        
                const dropdownButtons = document.querySelectorAll('[data-collapse-toggle]');

                dropdownButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const targetId = this.getAttribute('aria-controls');
                        const targetDropdown = document.getElementById(targetId);
                        const isVisible = targetDropdown.classList.contains('hidden');
                        const chevron = this.querySelector('#chevron-toggle');
                        if (isVisible) {
                            chevron.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';
                            targetDropdown.classList.remove('hidden');
                        } else {
                            chevron.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
                            targetDropdown.classList.add('hidden');
                        }
                    });
                });

                document.querySelectorAll('[data-modal-toggle]').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var modalId = this.getAttribute('data-modal-target');
                        document.getElementById(modalId).classList.remove('hidden');
                    });
                });

                document.querySelectorAll('[data-modal-hide]').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var modalId = this.getAttribute('data-modal-hide');
                        document.getElementById(modalId).classList.add('hidden');
                    });
                });
            </script>
    </body>
</html>