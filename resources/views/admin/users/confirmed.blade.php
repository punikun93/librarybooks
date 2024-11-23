<x-layout.admin>
    <div class="p-6">
        <div class="flex justify-center items-center text-3xl mb-6 font-semibold text-gray-900">Confirmed Users</div>

        <!-- Table to display confirmed users -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Username</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Full
                            Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Role
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Created At</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anas_users as $user)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-200 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->Username }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->NamaLengkap }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ ucfirst($user->Role) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-xs">
                                    {{ $user->Status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <div class="flex space-x-4">
                                    <!-- Confirmed Button with Check Icon -->
                                    <form action="{{ route('confirmed', $user->UserID) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="inline-block border-e p-3 text-green-600 hover:bg-green-50 focus:relative" title="Confirm User">
                                            <x-done-icon></x-done-icon>
                                        </button>
                                    </form>
                                    

                                    <!-- Delete Button with Form Submission -->
                                    <form action="{{ route('users.destroy', $user->UserID) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="inline-block p-3 text-red-600 hover:bg-red-50 focus:relative"
                                            title="Delete User">
                                            <x-delete-icon />

                                        </button>
                                    </form>
                                </div>


                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-sm text-gray-600 py-4">No Pending Users</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout.admin>
