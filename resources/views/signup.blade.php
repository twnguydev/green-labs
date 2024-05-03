@extends('base')
@section('title', 'Inscription | GreenLabs')
@section('content')
  <div class="bg-white">
    <div class="mx-auto max-w-xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-2xl lg:px-8">
      <div class="mt-5">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Inscription</h2>
        <p class="mt-2 text-lg text-gray-500">Créez un compte pour accéder au marketplace <span class="font-bold text-green-600">GreenLabs <i class="fa-solid fa-leaf"></i></span>.</p>
      </div>
      <div class="my-12">
        <form action="{{ route('signup.post') }}" method="POST">
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
            <div>
              <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
              <div class="mt-1">
                <input type="text" name="first_name" id="first_name" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="John" required>
              </div>
            </div>
            <div>
              <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
              <div class="mt-1">
                <input type="text" name="last_name" id="last_name" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Doe" required>
              </div>
            </div>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
              <div class="mt-1">
                <input type="email" name="email" id="email" class="block w-full px-3 py-2 border
                    border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="john.doe@adress.com" required>
                </div>
                <span class="text-sm text-gray-500">Nous ne partagerons jamais votre adresse email.</span>
            </div>
            <div>
              <label for="phone_number" class="block text-sm font-medium text-gray-700">Téléphone</label>
              <div class="mt-1">
                <input type="tel" name="phone_number" id="phone_number" class="block w-full px-3 py-2 border
                    border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="06 12 34 56 78" required>
              </div>
            </div>
            <div class="sm:col-span-2">
                <label for="birthdate" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                <div class="mt-1">
                  <input type="date" name="birthdate" id="birthdate" class="block w-full px-3 py-2 border
                      border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" max="{{ now()->subYears(18)->format('Y-m-d') }}" required>
                </div>
                <span class="text-sm text-gray-500">Vous devez avoir au moins 18 ans pour vous inscrire.</span>
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                <div class="mt-1">
                  <input type="text" name="address" id="address" class="block w-full px-3 py-2 border
                      border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="1 rue de la Paix" required>
                </div>
            </div>
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700">Code postal</label>
                <div class="mt-1">
                  <input type="text" name="postal_code" id="postal_code" class="block w-full px-3 py-2 border
                      border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="75000" required>
                </div>
            </div>
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                <div class="mt-1">
                  <input type="text" name="city" id="city" class="block w-full px-3 py-2 border
                      border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Paris" required>
                </div>
            </div>
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700">Pays</label>
                <div class="mt-1">
                  <input type="text" name="country" id="country" class="block w-full px-3 py-2 border
                      border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="France" required>
                </div>
            </div>
            <div class="sm:col-span-2">
              <label for="role" class="block text-sm font-medium text-gray-700">Vous êtes ...</label>
              <div class="mt-1">
                <select id="role" name="role" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                  <option value="USER_PARTICULIER">Un particulier</option>
                  <option value="USER_ENTREPRISE">Une entreprise</option>
                </select>
              </div>
            </div>
            <div class="flex justify-between gap-4 sm:col-span-2">
                <div class="w-full">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password" class="block w-full px-3 py-2 border
                            border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="••••••••••••••••" required>
                    </div>
                </div>
                <div class="w-full">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirmation du mot de passe</label>
                    <div class="mt-1">
                        <input type="password" name="confirm_password" id="confirm_password" class="block w-full px-3 py-2 border
                            border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="••••••••••••••••" required>
                    </div>
                </div>
            </div>
            <div class="sm:col-span-2">
              <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                S'inscrire
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection