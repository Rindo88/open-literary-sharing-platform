@extends('layouts.app')

@section('title', $discussion->title . ' - Diskusi ' . $book->title)

@section('content')
<!-- Alpine.js for mobile sidebar functionality -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    [x-cloak] { display: none !important; }
    
    .chat-container {
        height: calc(100vh - 200px);
    }
    
    .message-bubble {
        max-width: 70%;
        word-wrap: break-word;
    }
    
    .message-bubble.own {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        margin-left: auto;
    }
    
    .message-bubble.other {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }
    
    @media (max-width: 768px) {
        .chat-container {
            height: calc(100vh - 150px);
        }
        
        .message-bubble {
            max-width: 85%;
        }
    }
</style>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white border-b border-gray-200 sticky top-16 z-30 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('discussions.show', $book) }}" class="text-blue-700 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                                            <div class="flex items-center space-x-3">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" 
                                 alt="{{ $book->title }}"
                                 class="w-12 h-16 object-cover rounded-lg shadow-sm">
                        @else
                            <div class="w-12 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">{{ $discussion->title }}</h1>
                            <p class="text-sm text-gray-600 font-medium">{{ $book->title }}</p>
                        </div>
                    </div>
                    
                    <!-- Baca Buku Button -->
                    <a href="{{ route('books.read', $book->slug) }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Baca Buku</span>
                    </a>
                    </div>
                    
                    <!-- Mobile Participants Toggle Button -->
                    <!-- <button @click="showParticipants = !showParticipants" 
                            class="lg:hidden bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 shadow-sm flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span x-text="showParticipants ? 'Tutup' : 'Peserta'"></span>
                    </button> -->
                </div>
                
                @if($discussion->description)
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-900 font-medium">{{ $discussion->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex" x-data="{ showParticipants: false }">
            <!-- Main Chat Area -->
            <div class="flex-1 bg-white">
                <!-- Messages Container -->
                <div class="chat-container overflow-y-auto bg-gray-50">
                    <div class="p-4 space-y-4">
                        @forelse($discussion->messages as $message)
                            <div class="flex items-start space-x-3 {{ $message->user_id === auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                <!-- User Avatar -->
                                <div class="flex-shrink-0">
                                    @if($message->user->profile_photo)
                                        <img src="{{ Storage::url($message->user->profile_photo) }}" 
                                             alt="{{ $message->user->name }}" 
                                             class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                                    @else
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center border-2 border-blue-200">
                                            <span class="text-white text-sm font-medium">{{ substr($message->user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Message Content -->
                                <div class="flex-1 max-w-2xl {{ $message->user_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                    <div class="inline-block">
                                        <div class="flex items-center space-x-2 mb-1 {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                            <span class="text-sm font-semibold text-gray-800">{{ $message->user->name }}</span>
                                            <span class="text-xs text-gray-600 font-medium bg-gray-200 px-2 py-1 rounded">
                                                {{ $message->created_at->format('H:i') }}
                                            </span>
                                            @if($message->is_edited)
                                                <span class="text-xs text-gray-500 bg-yellow-100 px-2 py-1 rounded border border-yellow-200">(diedit)</span>
                                            @endif
                                        </div>
                                        
                                        <div class="message-bubble {{ $message->user_id === auth()->id() ? 'own' : 'other' }} rounded-2xl px-4 py-3 shadow-md">
                                            <p class="text-sm leading-relaxed font-medium">{{ $message->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-white rounded-lg border border-gray-200 mx-4">
                                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Pesan</h3>
                                <p class="text-gray-700 font-medium">Mulai diskusi dengan mengirim pesan pertama!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Message Input -->
                @if($discussion->isParticipant(auth()->user()))
                    <div class  ="bg-white border-t border-gray-200 p-4 shadow-lg">
                        <form action="{{ route('discussions.messages.store', ['book' => $book, 'discussion' => $discussion]) }}" method="POST" class="flex space-x-3">
                            @csrf
                            <div class="flex-1">
                                <input type="text" 
                                       name="message" 
                                       placeholder="Ketik pesan Anda..." 
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-800 font-medium placeholder-gray-500"
                                       required>
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-semibold transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                <span>Kirim</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-gray-100 border-t border-gray-200 p-6 text-center">
                        <p class="text-gray-700 mb-4 font-medium text-lg">Bergabunglah dengan diskusi untuk dapat mengirim pesan</p>
                        <form action="{{ route('discussions.join', ['book' => $book, 'discussion' => $discussion]) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 shadow-lg hover:shadow-xl">
                                Bergabung Sekarang
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Participants Sidebar -->
            <div class="fixed lg:relative inset-0 lg:inset-auto z-50 lg:z-auto"
                 x-show="showParticipants || $screen('lg')"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full lg:translate-x-0"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-full lg:translate-x-0"
                 @click.away="if ($screen('sm')) showParticipants = false"
                 x-cloak>
                
                <!-- Mobile Overlay -->
                <div class="lg:hidden fixed inset-0 bg-black bg-opacity-50" @click="showParticipants = false"></div>
                
                <!-- Sidebar Content -->
                <div class="fixed lg:relative right-0 top-0 lg:top-auto h-full lg:h-auto w-80 bg-white border-l border-gray-200 shadow-lg lg:shadow-none">
                    <!-- Header with Close Button for Mobile -->
                    <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Peserta Diskusi</h3>
                            <p class="text-sm text-gray-700">{{ $discussion->participants->count() }} orang bergabung</p>
                        </div>
                        <!-- Mobile Close Button -->
                        <button @click="showParticipants = false" 
                                class="lg:hidden p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-4 space-y-3 bg-white h-full lg:h-auto overflow-y-auto">
                        @foreach($discussion->participants as $participant)
                            <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex-shrink-0">
                                    @if($participant->profile_photo)
                                        <img src="{{ Storage::url($participant->profile_photo) }}" 
                                             alt="{{ $participant->name }}" 
                                             class="w-8 h-8 rounded-full object-cover border-2 border-gray-200">
                                    @else
                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center border-2 border-blue-200">
                                            <span class="text-white text-xs font-medium">{{ substr($participant->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $participant->name }}</p>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-600 font-medium">{{ $participant->pivot->role }}</span>
                                        @if($participant->pivot->role === 'moderator')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                Mod
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-xs text-gray-600 font-medium bg-gray-100 px-2 py-1 rounded">
                                    @if($participant->pivot->joined_at instanceof \Carbon\Carbon)
                                        {{ $participant->pivot->joined_at->format('d/m') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($participant->pivot->joined_at)->format('d/m') }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.querySelector('.chat-container');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>
@endsection
