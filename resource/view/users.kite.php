<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - KitePHP</title>
    <script src="{{ asset('tailwind.js') }}"></script>
    <script src="{{ asset('kite.js') }}"></script>
    <style>
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f111a;
        }

        ::-webkit-scrollbar-thumb {
            background: #2d3748;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #4a5568;
        }
    </style>
</head>

<body
    class="bg-[#0f111a] text-gray-300 font-sans p-6 md:p-12 min-h-screen selection:bg-blue-500/30 selection:text-blue-200"
    kite:data="{ isEdit: false, editId: '', name: '', email: '' }">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    Users CRUD Demo
                </h1>
                <p class="text-gray-400 mt-1 text-sm">A fast, single-page CRUD built with KiteJS</p>
            </div>
            <a href="{{ route('home') }}" kite:navigate
                class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded transition-colors text-sm font-medium border border-gray-700 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>

        <!-- Flash Messages -->
        @if(session()->has('success'))
        <div
            class="bg-green-900/30 border-l-4 border-green-500 text-green-300 px-4 py-3 rounded mb-8 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session()->get('success') }}
        </div>
        @endif
        @if(session()->has('error'))
        <div
            class="bg-red-900/30 border-l-4 border-red-500 text-red-300 px-4 py-3 rounded mb-8 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session()->get('error') }}
        </div>
        @endif

        <!-- Main Content -->
        <div class="bg-[#161b22] rounded-xl border border-gray-800 shadow-xl overflow-hidden">
            <div
                class="p-5 border-b border-gray-800 bg-[#1c2128] flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    Registered Users
                </h2>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                    <form action="{{ route('users.index') }}" method="GET" kite:submit kite:live
                        class="flex gap-2 w-full sm:w-auto">
                        <input type="text" name="search" placeholder="Search by name..." value="{{ $search ?? '' }}"
                            class="w-full sm:w-64 bg-[#0d1117] border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-200 focus:outline-none focus:border-blue-500 transition-colors"
                            autocomplete="off">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg text-sm font-medium transition-colors border border-gray-600">Search</button>
                        @if(!empty($search))
                        <a href="{{ route('users.index') }}" kite:navigate
                            class="px-3 py-2 bg-red-900/50 hover:bg-red-800/50 text-red-400 rounded-lg text-sm font-medium transition-colors border border-red-800/50 flex items-center"
                            title="Clear Search">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                        @endif
                    </form>

                    <button type="button" kite:click="isEdit = false; editId = ''; name = ''; email = ''; document.getElementById('userModal').classList.remove('hidden')"
                        class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded shadow-lg shadow-blue-900/20 transition-colors flex justify-center items-center gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add User
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-[#0d1117] text-gray-500 text-xs uppercase tracking-wider border-b border-gray-800">
                            <th class="py-3 px-5 font-semibold">ID</th>
                            <th class="py-3 px-5 font-semibold">User Details</th>
                            <th class="py-3 px-5 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-800/30 transition-colors">
                            <td class="py-4 px-5 text-sm text-gray-500">#{{ $user->id }}</td>
                            <td class="py-4 px-5">
                                <div class="text-sm font-semibold text-gray-200">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</div>
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" kite:click="isEdit = true; editId = '{{ $user->id }}'; name = '{{ $user->name }}'; email = '{{ $user->email }}'; document.getElementById('userModal').classList.remove('hidden')"
                                        class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">Edit</button>

                                    <form action="{{ route('users.delete', ['id' => $user->id]) }}" method="POST"
                                        kite:submit class="inline m-0">
                                        @csrf
                                        <button type="submit"
                                            class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @if(count($users) === 0)
                        <tr>
                            <td colspan="3" class="py-12 text-center">
                                <svg class="w-12 h-12 text-gray-700 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                <div class="text-gray-400 font-medium">No users found</div>
                                <div class="text-gray-600 text-sm mt-1">Click "Add User" to create one.</div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {!! $users->links() !!}
        </div>
    </div>

    <!-- Modal for Form -->
    <div id="userModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 @if(empty(errors())) hidden @endif">
        <div
            class="bg-[#161b22] w-full max-w-md rounded-xl border border-gray-800 shadow-2xl relative transition-all @if(errors()) ring-1 ring-red-500/50 @endif">
            <div class="p-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        
                        <span kite:show="isEdit" class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            Edit User
                        </span>
                        
                        <span kite:show="!isEdit" class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Add New User
                        </span>
                    </h2>

                    <button type="button" onclick="document.getElementById('userModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('users.save') }}" method="POST" kite:submit>
                    @csrf
                    <input type="hidden" name="editId">
                    
                    <!-- Reactive Engine Live Preview -->
                    <div class="mb-5 px-4 py-3 bg-blue-900/20 border border-blue-900/50 rounded-lg flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm">
                            <span class="text-blue-300 font-medium">Live Preview:</span>
                            <span class="text-white font-bold ml-1">{{ $name }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Full
                            Name</label>
                        <input type="text" name="name" placeholder="John Doe"
                            class="w-full bg-[#0d1117] border @if(errors('name')) border-red-500 @else border-gray-700 @endif rounded-lg px-4 py-2.5 text-gray-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-gray-600"
                            required>
                        @error('name')
                        <p class="text-red-400 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label
                            class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Email
                            Address</label>
                        <input type="email" name="email" placeholder="john@example.com"
                            class="w-full bg-[#0d1117] border @if(errors('email')) border-red-500 @else border-gray-700 @endif rounded-lg px-4 py-2.5 text-gray-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-gray-600"
                            required>
                        @error('email')
                        <p class="text-red-400 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors w-full shadow-lg shadow-blue-900/20">
                            <span kite:show="isEdit">Update User</span>
                            <span kite:show="!isEdit">Save User</span>
                        </button>
                        <button type="button" onclick="document.getElementById('userModal').classList.add('hidden')"
                            class="bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-2.5 px-4 rounded-lg text-center transition-colors border border-gray-700 w-full">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>