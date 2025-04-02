<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4">
                        {{ session('error') }}
                    </div>
                    @endif

                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Name</th>
                                <th class="border border-gray-300 px-4 py-2">Email</th>
                                <th class="border border-gray-300 px-4 py-2">Role</th>
                                <th class="border border-gray-300 px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $user->getRoleNames()->first() }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if(!$user->hasRole('owner') || auth()->user()->hasRole('owner'))
                                    <form action="{{ route('update.role', $user->id) }}" method="POST">
                                        @csrf
                                        <select name="role" class="border rounded px-2 py-1">
                                            @foreach($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <button type="submit"
                                            class="ml-2 bg-blue-500 text-white px-3 py-1 rounded">Update</button>
                                    </form>
                                    @else
                                    <span class="text-gray-500">Tidak bisa diubah</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>