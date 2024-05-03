@extends('base')
@section('title', 'Connexion | GreenLabs')
@section('content')
  <div class="bg-white">
    <div class="mx-auto max-w-xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-2xl lg:px-8">
      <div class="mt-5">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Connexion</h2>
        <p class="mt-2 text-lg text-gray-500">Connectez-vous à votre compte pour accéder au marketplace <span class="font-bold text-green-600">GreenLabs <i class="fa-solid fa-leaf"></i></span>.</p>
      </div>
      <div class="mt-12">
        <form action="{{ route('login.post') }}" method="POST">
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
          <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 sm:gap-y-8">
            <div class="sm:col-span-2">
              <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
              <div class="mt-1">
                <input type="email" name="email" id="email" class="block w-full px-3 py-2 border
                    border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="john.doe@adress.com" required>
                </div>
                <span class="text-sm text-gray-500">Nous ne partagerons jamais votre adresse email.</span>
            </div>
            <div class="sm:col-span-2">
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <div class="mt-1">
                    <input type="password" name="password" id="password" class="block w-full px-3 py-2 border
                        border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="••••••••••••••••" required>
                </div>
            </div>
            <div class="sm:col-span-2 flex items-center gap-4">
                <input id="remember_me" name="remember_me" type="checkbox" class="h-3 w-3 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">Se souvenir de moi</label>
            </div>
            <div class="sm:col-span-2">
              <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Se connecter
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection