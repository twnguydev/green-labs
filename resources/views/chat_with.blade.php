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
                <div class="flex flex-col divide-y h-full overflow-y-auto -mx-4">
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
    <div class="flex flex-col h-[calc(100vh-180px)] w-full bg-white px-4 py-6">
        <div class="flex flex-row items-center px-6 rounded-2xl shadow">
            <a href="{{ route('profile', ['firstname' => strtolower($userReceiver->first_name), 'lastname' => strtolower($userReceiver->last_name)]) }}" class="flex flex-row items-center w-full p-4 py-6 relative">
                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-100">
                    {{ substr($userReceiver->first_name, 0, 1) . substr($userReceiver->last_name, 0, 1) }}
                </div>
                <div class="flex flex-col ml-3">
                    <div class="font-semibold text-sm">{{ $userReceiver->first_name }} {{ $userReceiver->last_name }}</div>
                </div>
            </a>
        </div>
        <div class="h-full overflow-hidden py-4">
            <div class="h-full overflow-y-auto">
                <div id="message-container" class="grid grid-cols-12 gap-y-2">
                    @foreach ($messages as $message)
                        @php
                            $userSender = App\Models\User::findOrFail($message->user_sender_id);
                            $userReceiver = App\Models\User::findOrFail($message->user_receiver_id);
                        @endphp
                        @if ($message->user_sender_id === auth()->user()->id)
                            <div class="col-start-3 col-end-13 p-3 rounded-lg">
                                <div class="flex flex-row items-center justify-end">
                                    <div class="relative mr-3 text-sm bg-blue-500 text-white py-2 px-4 mr-5 shadow rounded-xl">
                                        <div>{{ $message->content }}</div>
                                    </div>
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-500 text-white flex-shrink-0">
                                        {{ substr($userSender->first_name, 0, 1) . substr($userSender->last_name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500 ml-2 text-right mt-2">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @elseif ($message->user_receiver_id === auth()->user()->id)
                            <div class="col-start-1 col-end-10 p-3 rounded-lg">
                                <div class="flex flex-row items-center">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-100 flex-shrink-0">
                                        {{ substr($userReceiver->first_name, 0, 1) . substr($userReceiver->last_name, 0, 1) }}
                                    </div>
                                    <div class="relative ml-3 text-sm bg-pink-500 text-white py-2 px-4 shadow rounded-xl">
                                        <div>{{ $message->content }}</div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500 ml-2 text-left mt-2">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <form action="{{ route('chat.send', ['firstname' => strtolower($userSender->first_name), 'lastname' => strtolower($userSender->last_name)]) }}" method="POST">
            @csrf
            <div class="flex flex-row items-center">
                <div class="flex flex-row items-center w-full border rounded-3xl h-12 px-2">
                    <div class="w-full">
                        <input type="text" name="message" class="border border-transparent w-full focus:outline-none text-sm h-10 flex items-center px-4" placeholder="Entrez votre message...">
                    </div>
                </div>
                <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i class="fa-regular fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const messageContainer = document.getElementById('message-container');
        messageContainer.scrollTop = messageContainer.scrollHeight;
    });
</script>
@endsection