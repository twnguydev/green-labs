@extends('base')
@section('title', 'Modifier une annonce | GreenLabs')
@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 pb-24 sm:px-6 sm:py-24 lg:max-w-3xl lg:px-8">
        <div class="mt-5">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Modifier l'annonce &mdash; {{ $product->title }}</h2>
            <p class="mt-2 text-lg text-gray-500">Modifiez les informations de votre annonce sur le marketplace <span class="font-bold text-green-600">GreenLabs <i class="fa-solid fa-leaf"></i></span>.</p>
        </div>
        <div class="my-12">
            <form action="{{ route('ad.edit.post', ['category' => $product->category->route, 'ad_id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                <div class="bg-red-100 my-6 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Erreur !</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="flex flex-col">
                    <div class="mt-6">
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <div class="mt-1">
                            <input type="text" name="title" id="title" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $product->title }}" required>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea name="description" id="description" rows="10" class="block resize-none w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="price" class="block text-sm font-medium text-gray-700">Prix</label>
                        <div class="mt-1">
                            <input type="text" name="price" id="price" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $product->price }}" required pattern="[0-9]+([\.][0-9]+)?" title="Entrez un nombre valide (un entier ou une décimale avec un point)">
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantité</label>
                        <div class="mt-1">
                            <input type="number" name="quantity" id="quantity" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="{{ $product->quantity }}" min="1" required>
                        </div>
                    </div>  
                    <div class="mt-6">
                        <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <div class="mt-1">
                            <select name="category" id="category" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                @foreach ($categories as $category)
                                    @if ($category->id === $product->category_id)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <div class="mt-1">
                            <input type="file" name="image" id="image" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Modifier l'annonce
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection