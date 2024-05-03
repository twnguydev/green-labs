@extends('base')
@section('title', 'Profil | GreenLabs')
@section('content')
    <div class="bg-gray-100 pt-10 mt-5 min-h-screen pb-16">
        <div class="container mx-auto py-16">
            <a class="text-3xl pl-4 font-bold leading-none text-green-700" href="{{ route('dashboard') }}">
                Dashboard de {{ $user->first_name }} <i class="fa-solid fa-leaf"></i>
            </a>
            <div class="grid grid-cols-1 mt-5 sm:grid-cols-2 gap-6 px-4">
                <div class="bg-white shadow rounded-lg p-6">
                    @if ($user->role === 'USER_PARTICULIER')
                        <button class="bg-yellow-500 p-2 text-white rounded cursor-default">
                            <i class="fa-solid fa-person mr-2"></i>
                            Particulier
                        </button>
                    @elseif ($user->role === 'USER_PROFESSIONNEL')
                        <button class="bg-green-500 p-2 text-white rounded cursor-default">
                            <i class="fa-solid fa-briefcase mr-2"></i>
                            Entreprise
                        </button>
                    @endif
                    <div class="flex flex-col items-center mt-8 sm:mt-0 md:mt-4">
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" class="w-32 h-32 bg-gray-300 rounded-full mb-4" alt="Profile Picture">
                        <h1 class="text-xl font-bold">{{ $user->first_name }} {{ $user->last_name }}</h1>
                        <p class="text-gray-700">{{ $user->city }}, {{ $user->country }}</p>
                        <div class="mt-6 flex flex-wrap gap-4 justify-center">
                            <button class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded" data-modal-target="modal-update" data-modal-toggle="modal-update">Modifier le profil</button>
                        </div>
                    </div>
                    <hr class="my-6 border-t border-gray-300">
                    <div class="flex flex-col">
                        <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Statistiques du compte</span>
                        <ul>
                            <li class="mb-2 flex items-center justify-between">
                                <span>Nombre de produits en ligne</span>
                                <span class="text-green-600 font-bold">{{ $user->count() }} <i class="fa-solid fa-leaf"></i></span>
                            </li>
                            <li class="mb-2 flex items-center justify-between">
                                <span>Nombre de ventes</span>
                                <span class="text-green-600 font-bold">12 <i class="fa-solid fa-leaf"></i></span>
                            </li>
                            <li class="mb-2 flex items-center justify-between">
                                <span>Moyenne des avis reçus</span>
                                <span class="text-green-600 font-bold">{{ $user->getAverageRatingAttribute() }} <i class="fa-solid fa-star text-yellow-400"></i></span>
                            </li>
                            <li class="mb-2 flex items-center justify-between">
                                <span>Délais de livraison moyen</span>
                                <span class="text-green-600 font-bold">3 jours <i class="fa-solid fa-car"></i></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bg-white shadow rounded-lg p-6">
                    <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">À propos de vous</span>
                    <p class="text-gray-700">{{ $user->biography }}</p>
                        <button class="mt-12 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded" data-modal-target="modal-update-biography" data-modal-toggle="modal-update-biography">Modifier la biographie</button>
                    <hr class="my-6 border-t border-gray-300">
                    <div class="flex flex-col">
                        <span class="text-gray-700 uppercase font-bold tracking-wider">Vos derniers articles en vente</span>
                        @if ($products->isEmpty())
                            <p class="text-lg mt-5 text-gray-700">Vous n'avez encore aucun article en ligne.</p>
                        @endif
                        <div class="grid grid-cols-1 gap-x-6 gap-y-10 mt-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                            @foreach ($products as $product)
                                @php
                                    $category = App\Models\Category::findOrFail($product->category_id);
                                    $category_route = $category->route;
                                @endphp
                                <a href="{{ route('ad.show', ['category' => $category_route, 'ad_id' => $product->id]) }}" class="group">
                                    <div class="aspect-h-1 aspect-w-1 w-30 h-40 overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="h-full w-full object-cover object-center">
                                    </div>
                                    <h3 class="mt-4 text-sm text-gray-700">{{ $product->title }}</h3>
                                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $product->price }} <i class="fa-solid fa-euro-sign"></i></p>
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $product->getAverageRatingAttribute() && $product->getAverageRatingAttribute() > 0)
                                            <i class="fa-solid fa-star text-yellow-400"></i>
                                        @else
                                            <i class="fa-solid fa-star text-gray-300"></i>
                                        @endif
                                    @endfor
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-4 justify-end">
                        <a class="mt-6 flex justify-center bg-green-500 w-40 hover:bg-green-600 text-white py-2 px-4 rounded" href="/dashboard/new">Ajouter un article</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-update" tabindex="-1" aria-hidden="true" class="hidden flex bg-gray-600 bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Modifier mon profil
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-update">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('profile.update', ['firstname' => strtolower($user->first_name), 'lastname' => strtolower($user->last_name)]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-y-4 pb-5 sm:grid-cols-2 sm:gap-x-4 sm:gap-y-5">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <div class="mt-1">
                                    <input type="text" name="first_name" id="first_name" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $user->first_name }}" required>
                                </div>
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                                <div class="mt-1">
                                    <input type="text" name="last_name" id="last_name" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $user->last_name }}"" required>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                                <div class="mt-1">
                                    <input type="email" name="email" id="email" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <div class="mt-1">
                                    <input type="tel" name="phone_number" id="phone_number" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $user->phone_number }}" required>
                                </div>
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                                <div class="mt-1">
                                    <input type="text" name="address" id="address" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $user->address }}" required>
                                </div>
                            </div>
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Code postal</label>
                                <div class="mt-1">
                                    <input type="text" name="postal_code" id="postal_code" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $user->postal_code }}" required>
                                </div>
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                                <div class="mt-1">
                                    <input type="text" name="city" id="city" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $user->city }}" required>
                                </div>
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Pays</label>
                                <div class="mt-1">
                                    <input type="text" name="country" id="country" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $user->country }}" required>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="profile_picture" class="block text-sm font-medium text-gray-700">Photo de profil</label>
                                <div class="mt-1">
                                    <input type="file" name="profile_picture" id="profile_picture" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="updateAccount" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Modifier mes informations</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-update-biography" tabindex="-1" aria-hidden="true" class="hidden flex bg-gray-600 bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Modifier ma biographie
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-update-biography">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('profile.update.biography', ['firstname' => strtolower($user->first_name), 'lastname' => strtolower($user->last_name)]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col gap-y-4 pb-5">
                            <label for="biography" class="block text-sm font-medium text-gray-700">Biographie</label>
                            <textarea id="biography" name="biography" rows="6" class="mt-1 block p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 resize-none focus:ring-blue-500 focus:border-blue-500">{{ $user->biography }}</textarea>
                        </div>
                        <button type="submit" id="updateAccount" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sauvegarder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection