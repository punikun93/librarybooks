<x-layout.admin>
    <div class="p-6">
        <div class="flex justify-between items-center text-3xl mb-6 font-semibold text-gray-900">
            <h1>Data Users</h1>
            <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                <button data-modal-target="createUserModal" data-modal-toggle="createUserModal"
                    class="inline-block border-e px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:relative"
                    id="createUserButton">Create Users</button>
            </span>
        </div>

        <!-- Table to display confirmed users -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Username</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Full
                            Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Alamat</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Role</th>
                        {{-- <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Created At</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Updated At</th> --}}
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anas_users as $user)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-200 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->Username }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->NamaLengkap }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->Alamat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ ucfirst($user->Role) }}</td>
                            {{-- <td class="px-6 py-4 text-sm text-gray-800">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->updated_at->diffForHumans() }}</td> --}}
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                                    <button
                                    class="inline-block border-e p-3 text-gray-700 hover:bg-gray-50 focus:relative editButton"
                                        data-modal-target="editUserModal{{ $user->UserID }}"
                                        data-modal-toggle="editUserModal{{ $user->UserID }}" title="Edit User">
                                        <!-- Edit icon -->
                                        <x-edit-icon />

                                    </button> 
                                    <button
                                        class="inline-block p-3 text-gray-700 hover:bg-gray-50 focus:relative deleteButton"
                                        data-modal-target="deleteUserModal{{ $user->UserID }}"
                                        data-modal-toggle="deleteUserModal{{ $user->UserID }}" title="Delete User">
                                        <x-delete-icon />

                                    </button>
                                </span>
                            </td>
                        </tr>

                        <!-- Modal Edit User -->
                        <div id="editUserModal{{ $user->UserID }}" tabindex="-1" aria-hidden="true"
                            class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden backdrop-blur">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="
                                relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div
                                        class="flex justify-between items-center p-4 rounded-t border-b dark:border-gray-600">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                            Edit User
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                            data-modal-hide="editUserModal{{ $user->UserID }}">
                                     <x-close-icon/>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('users.update', $user->UserID) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="p-4 space-y-4">
                                            <div>
                                                <label for="editUsername{{ $user->UserID }}"
                                                    class="block text-sm font-medium text-gray-700">Username</label>
                                                <input type="text" name="Username"
                                                    id="editUsername{{ $user->UserID }}"
                                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                                    value="{{ $user->Username }}" required>
                                            </div>
                                            <div>
                                                <label for="editEmail{{ $user->UserID }}"
                                                    class="block text-sm font-medium text-gray-700">Email</label>
                                                <input type="email" name="email" id="editEmail{{ $user->UserID }}"
                                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                                    value="{{ $user->email }}" required>
                                            </div>
                                            <div>
                                                <label for="editNamaLengkap{{ $user->UserID }}"
                                                    class="block text-sm font-medium text-gray-700">Full
                                                    Name</label>
                                                <input type="text" name="NamaLengkap"
                                                    id="editNamaLengkap{{ $user->UserID }}"
                                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                                    value="{{ $user->NamaLengkap }}" required>
                                            </div>
                                            <div>
                                                <label for="editPassword{{ $user->UserID }}"
                                                    class="block text-sm font-medium text-gray-700">Password
                                                    </label>
                                                <input type="text" name="password"
                                                    id="editPassword{{ $user->UserID }}"
                                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                                    value="{{ $user->password }}" required>
                                            </div>
                                            <div>
                                                <label for="editAlamat{{ $user->UserID }}"
                                                    class="block text-sm font-medium text-gray-700">Alamat</label>
                                                <input type="text" name="Alamat" id="editAlamat{{ $user->UserID }}"
                                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                                    value="{{ $user->Alamat }}" required>
                                            </div>
                                            <div>
                                                <label for="editRole{{ $user->UserID }}"
                                                    class="block text-sm font-medium text-gray-700">Role</label>
                                                <select name="Role" id="editRole{{ $user->UserID }}"
                                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                                    required>
                                                    <option value="peminjam"
                                                        {{ $user->Role == 'peminjam' ? 'selected' : '' }}>Peminjam
                                                    </option>
                                                    <option value="administrator"
                                                        {{ $user->Role == 'administrator' ? 'selected' : '' }}>
                                                        Administrator</option>
                                                    <option value="petugas"
                                                        {{ $user->Role == 'petugas' ? 'selected' : '' }}>Petugas
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center justify-end p-4 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                            <button data-modal-hide="editUserModal{{ $user->UserID }}" type="button"
                                                class="text-gray-500 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>




                        <!-- Modal Delete User -->
                        <div id="deleteUserModal{{ $user->UserID }}" tabindex="-1" aria-hidden="true"
                            class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden backdrop-blur">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div
                                        class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                            Delete User
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                            data-modal-hide="deleteUserModal{{ $user->UserID }}">
                                            <x-close-icon />
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <p class="text-base leading-relaxed text-gray-700 dark:text-gray-300">
                                            Are you sure you want to delete <span
                                                class="font-bold">{{ $user->Username }}</span>?
                                        </p>
                                    </div>
                                    <div
                                        class="flex items-center justify-end p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                        <button data-modal-hide="deleteUserModal{{ $user->UserID }}" type="button"
                                            class="text-gray-500 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Cancel
                                        </button>
                                        <form action="{{ route('users.destroy', $user->UserID) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-white  bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination controls -->
        <div class="mt-4">
            {{ $anas_users->links() }} <!-- Display pagination links -->
        </div>

        <!-- Modal Create User -->
        <div id="createUserModal" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden backdrop-blur">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex justify-between items-center p-4 rounded-t border-b dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Create User
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-hide="createUserModal">
                      <x-close-icon/>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="p-4 space-y-4">
                            <div>
                                <label for="Username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" name="Username" id="Username"
                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email"
                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>
                            <div>
                                <label for="NamaLengkap" class="block text-sm font-medium text-gray-700">Full
                                    Name</label>
                                <input type="text" name="NamaLengkap" id="NamaLengkap"
                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>
                            <div>
                                <label for="Alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <input type="text" name="Alamat" id="Alamat"
                                    class="mt-1 p-1.5 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-end p-4 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                            <button data-modal-hide="createUserModal" type="button"
                                class="text-gray-500  bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                Cancel
                            </button>
                            <button type="submit"
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</x-layout.admin>
