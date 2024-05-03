@extends('base')
@section('title', 'Messagerie | GreenLabs')
@section('content')
<div class="flex flex-row min-h-80 antialiased text-gray-800 mb-16">
    <div class="flex flex-row w-50 flex-shrink-0 bg-gray-100 p-4 h-[calc(100vh-180px)] md:w-64 lg:w-80">
        <div class="flex flex-col w-full h-full pl-4 pr-4 py-4 -mr-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-row items-center">
                    <div class="text-xl font-semibold">Messages</div>
                </div>
            </div>
            <div class="h-full overflow-hidden relative pt-2 mt-5">
                <div class="flex flex-col h-full overflow-y-auto -mx-4">
                    @foreach ($receiverNames as $receiver)
                        @php
                            $fullName = explode(' ', $receiver);
                            $firstName = $fullName[0];
                            $lastName = $fullName[1] ?? '';
                            $receiver = App\Models\User::where('first_name', $firstName)
                                ->where('last_name', $lastName)
                                ->firstOrFail();
                        @endphp
                        <div class="flex flex-row items-center">
                            <a href="{{ route('chat.user', ['firstname' => strtolower($receiver->first_name), 'lastname' => strtolower($receiver->last_name)]) }}" class="flex flex-row w-full items-center p-4 py-6 relative">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-300 font-bold flex-shrink-0">
                                    {{ substr($receiver->first_name, 0, 1) . substr($receiver->last_name, 0, 1) }}
                                </div>
                                <div class="flex flex-col flex-grow ml-3">
                                    <div class="text-sm font-medium">{{ $receiver->first_name }} {{ $receiver->last_name }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col h-[calc(100vh-180px)] w-full items-center justify-center bg-white px-4 py-6">
        <a class="text-3xl font-bold leading-none text-green-700" href="#">
            <span class="text-gray-900">Bienvenue dans votre espace</span> GreenChat <i class="fa-solid fa-leaf"></i>
        </a>
    </div>
</div>
@endsection