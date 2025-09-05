@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('admin-content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Pengguna</h1>
            <p class="mt-2 text-gray-600">Daftar semua pengguna dalam sistem</p>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Pengguna</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Total {{ $users->total() }} pengguna</p>
            </div>
            
            @if($users->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        <p class="text-xs text-gray-400">Bergabung {{ $user->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->role ?? 'user') }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    {{ $users->links() }}
                </div>
            @else
                <div class="px-4 py-8 text-center text-gray-500">
                    Belum ada pengguna
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
