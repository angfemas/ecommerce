<x-app-layout>

    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>

                <!-- Tambahkan ini untuk menampilkan Role -->
                <div class="mt-4 p-4 bg-gray-100 rounded">
                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Role:</strong>
                        @foreach(Auth::user()->getRoleNames() as $role)
                        <span class="px-2 py-1 bg-blue-500 text-black rounded">{{ $role }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>