@extends('base')
@section('title', 'Produits | GreenLabs')
@section('content')
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <a class="text-3xl font-bold leading-none text-green-700" href="{{ route('home') }}">
                Tous les produits de {{ $categoryName }} <i class="fa-solid fa-leaf"></i>
            </a>
            @if ($products->isEmpty())
                <p class="text-lg mt-5 text-gray-700">Aucun produit n'est disponible pour le moment.</p>
                <p class="text-lg text-gray-700">Revenez plus tard pour découvrir de nouveaux produits écologiques !</p>
            @endif
            <div class="grid grid-cols-1 gap-x-6 gap-y-10 mt-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                @foreach ($products as $product)
                    @php
                        $category = App\Models\Category::findOrFail($product->category_id);
                        $category_route = $category->route;
                    @endphp
                    <a href="{{ route('ad.show', ['category' => $category_route, 'ad_id' => $product->id]) }}" class="group">
                        <div class="aspect-h-1 aspect-w-1 w-60 h-60 overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center">
                        </div>
                        <h3 class="mt-4 text-sm text-gray-700">{{ $product->title }}</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $product->price }} €</p>
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
    </div>
@endsection