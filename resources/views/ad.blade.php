@extends('base')
@section('title', 'Fiche produit | GreenLabs')
@section('content')
<div class="bg-white pb-16">
    <a href="{{ route('categories', ['category_route' => $category->route]) }}" class="text-lg text-green-600 w-screen px-4">Voir tous les produits de {{ $category->name }}</a>
    <div class="mx-auto w-full px-4 py-16 sm:py-24 lg:max-w-7xl">
        <a class="text-3xl font-bold leading-none text-green-700" href="{{ route('home') }}">
            {{ $product->title }} <i class="fa-solid fa-leaf"></i>
        </a>
        <div class="mt-5 grid grid-cols-1 gap-x-16 gap-y-10 xl:gap-x-8 lg:grid-cols-3 sm:gap-x-0 md:gap-x-5">
            <div class="group col-span-1 sm:col-span-2">
                <div class="block sm:flex">
                    <div class="aspect-h-1 aspect-w-1 w-60 h-60 overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center">
                    </div>
                    <div class="flex flex-col ml-16">
                        <h3 class="mt-4 text-sm text-gray-700">{{ $product->title }}</h3>
                        <p class="mt-4 text-3xl font-medium text-gray-900">{{ $product->price }} <span class="text-sm">€</span></p>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $product->quantity }} <span class="text-sm">en stock</span></p>
                        <p class="mt-4 text-lg font-medium text-gray-900 flex">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $product->getAverageRatingAttribute())
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                @else
                                    <i class="fa-solid fa-star text-gray-300"></i>
                                @endif
                            @endfor
                        </p>
                        <div class="mt-4 flex items-center gap-4">
                            <a href="{{ route('chat.user', ['firstname' => strtolower($user->first_name), 'lastname' => strtolower($user->last_name)]) }}" class="bg-blue-500 hover:bg-blue-600 p-2 text-white px-4 rounded">
                                <i class="fa-solid fa-envelope mr-2"></i>
                                Contacter le vendeur
                            </a>
                        </div>
                    </div>
                </div>
                <p class="mt-5 text-lg text-gray-700 text-justify">{{ $product->description }}</p>
                <div class="bg-white mt-16 shadow rounded-lg p-6">
                    <h2 class="text-xl font-bold">Garanties <span class="text-green-600">GreenLabs <i class="fa-solid fa-leaf"></i></span></h2>
                    <ul class="mt-4 grid grid-cols-1 gap-y-0 sm:grid-cols-2 sm:gap-y-2">
                        <div class="col-span-1">
                            <li class="mb-2 flex items-center">
                                <i class="fa-solid fa-check text-green-600 mr-2"></i>
                                <span>Produit écologique</span>
                            </li>
                            <li class="mb-2 flex items-center">
                                <i class="fa-solid fa-check text-green-600 mr-2"></i>
                                <span>Emballage recyclé</span>
                            </li>
                        </div>
                        <div class="col-span-1">
                            <li class="mb-2 flex items-center">
                                <i class="fa-solid fa-check text-green-600 mr-2"></i>
                                <span>Expédition neutre en carbone</span>
                            </li>
                            <li class="mb-2 flex items-center">
                                <i class="fa-solid fa-check text-green-600 mr-2"></i>
                                <span>Garantie 1 an</span>
                            </li>
                        </div>
                    </ul>
                    <hr class="my-6 border-t border-gray-300">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 uppercase font-bold tracking-wider">Vendeur</span>
                        <a href="{{ route('profile', ['firstname' => strtolower($user->first_name), 'lastname' => strtolower($user->last_name)]) }}" class="text-green-600 hover:underline">
                            Voir le profil <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="bg-white mt-16 shadow rounded-lg p-6">
                    <h2 class="text-xl font-bold">Avis des <span class="text-green-600">GreenAddicts <i class="fa-solid fa-leaf"></i></span></h2>
                    <ul class="mt-4 grid grid-cols-1 gap-y-0 sm:grid-cols-2 sm:gap-y-2">
                        <div class="col-span-1">
                            <li class="mb-2 flex items-center">
                                <i class="fa-solid fa-star text-yellow-400 mr-2"></i>
                                <span>Produit de qualité</span>
                            </li>
                            <li class="mb-2 flex items-center">
                                <i class="fa-solid fa-star text-yellow-400 mr-2"></i>
                                <span>Expédition rapide</span>
                            </li>
                        </div>
                        <div class="col-span-1">
                            <li class="mb-2 flex items-center">
                                <i class="fa-solid fa-star text-yellow-400 mr-2"></i>
                                <span>Service client réactif</span>
                            </li>
                            <li class="mb-2 flex items-center">
                                <i class="fa-solid fa-star text-yellow-400 mr-2"></i>
                                <span>Emballage soigné</span>
                            </li>
                        </div>
                    </ul>
                    <hr class="my-6 border-t border-gray-300">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 uppercase font-bold tracking-wider">Laisser un avis</span>
                        <button class="text-green-600 hover:underline" data-modal-target="modal-review" data-modal-toggle="modal-review">
                            Écrire un avis <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                    <hr class="my-6 border-t border-gray-300">
                    @if ($reviews->isEmpty())
                        <p class="text-gray-700">Aucun avis pour le moment.</p>
                    @endif
                    @foreach ($reviews as $review)
                        @php
                            $author = App\Models\User::findOrFail($review->user_id);
                        @endphp
                        <div class="grid grid-cols-1 gap-x-16 gap-y-3 mb-16 xl:gap-x-8 md:grid-cols-3 sm:gap-y-0 sm:gap-x-0 md:gap-x-5">
                            <div class="col-span-1 flex items-center">
                                <img src="{{ asset('storage/' . $author->profile_picture) }}" class="w-12 h-12 bg-gray-300 rounded-full mr-4" alt="Profile Picture">
                                <div>
                                    <h3 class="text-lg font-bold">{{ $author->first_name }} {{ $author->last_name }}</h3>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fa-solid fa-star text-yellow-400"></i>
                                        @else
                                            <i class="fa-solid fa-star text-gray-300"></i>
                                        @endif
                                    @endfor
                                    <p class="text-gray-700 ml-3">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="mt-4 text-gray-700">{{ $review->content }}</p>
                            </div>
                        </div>
                    @endforeach                
                </div>
            </div>
            <div class="group col-span-1">
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
                        @if ($access)
                            <div class="mt-6 flex flex-wrap gap-4 justify-center">
                                <button class="bg-red-500 hover:bg-red-600 p-2 text-white text-sm px-4 rounded" data-modal-target="modal-delete" data-modal-toggle="modal-delete">
                                    <i class="fa-solid fa-trash mr-2"></i>
                                    Supprimer l'annonce
                                </button>
                            </div>
                            <div class="mt-1 flex flex-wrap gap-4 justify-center">
                                <a href="{{ route('ad.edit', ['category' => $category->route, 'ad_id' => $product->id]) }}" class="bg-blue-500 hover:bg-blue-600 p-2 text-white text-sm px-4 rounded">
                                    <i class="fa-solid fa-edit mr-2"></i>
                                    Modifier l'annonce
                                </a>
                            </div>
                        @else
                            <div class="mt-6 flex flex-wrap gap-4 justify-center">
                                <a href="{{ route('profile', ['firstname' => $user->first_name, 'lastname' => $user->last_name]) }}" class="bg-blue-500 hover:bg-blue-600 p-2 text-white text-sm px-4 rounded">
                                    Voir le profil
                                </a>
                            </div>
                        @endif
                    </div>
                    <hr class="my-6 border-t border-gray-300">
                    <div class="flex flex-col">
                        <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Statistiques</span>
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
            </div>
        </div>
    </div>
</div>
<div id="modal-review" class="modal hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50">
    <div class="modal-dialog bg-white w-1/2 mx-auto my-12 p-6 rounded-lg">
        <div class="modal-header flex items-center justify-between">
            <h3 class="text-xl font-bold">Laisser un avis</h3>
            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-review">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <div class="modal-body mt-6">
            <form action="{{ route('ad.review.post', ['category' => $category->route, 'ad_id' => $product->id]) }}" method="POST">
                @csrf
                <div class="flex flex-col">
                    <div class="mt-6">
                        <label for="rating" class="block text-sm font-medium text-gray-700">Note</label>
                        <div class="mt-1">
                            <select name="rating" id="rating" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="content" class="block text-sm font-medium text-gray-700">Commentaire</label>
                        <div class="mt-1">
                            <textarea name="content" id="content" rows="10" class="block resize-none w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Votre avis" required></textarea>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset focus:ring-green-500">
                            Laisser un avis
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal-delete" class="modal hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50">
    <div class="modal-dialog bg-white w-1/3 mx-auto my-12 p-6 rounded-lg">
        <div class="modal-header flex items-center justify-between">
            <h3 class="text-xl font-bold">Supprimer l'annonce</h3>
            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-delete">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <div class="modal-body mt-6">
            <p class="text-gray-700">Êtes-vous sûr de vouloir supprimer cette annonce ?</p>
            <div class="mt-6 flex justify-between">
                <button class="bg-blue-500 hover:bg-blue-600 p-2 text-white text-sm px-4 rounded" data-modal-hide="modal-delete">
                    Annuler
                </button>
                <form action="{{ route('ad.delete', ['category' => $category->route, 'ad_id' => $product->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 p-2 text-white text-sm px-4 rounded">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection