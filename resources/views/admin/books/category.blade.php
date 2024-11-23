<x-layout.admin>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6 text-3xl font-semibold text-gray-900">
            <h1>Category</h1>
            <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                <button data-modal-target="createCategoryModal" data-modal-toggle="createCategoryModal"
                    class="inline-block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:relative"
                    id="createCategoryButton">Create Category</button>
            </span>
        </div>

        <!-- Table to display categories -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Category Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anas_kategori as $category)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-200 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $category->NamaKategori }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <span class="inline-flex border-e overflow-hidden rounded-md border bg-white shadow-sm">
                                    <button data-modal-target="editCategoryModal{{ $category->KategoriID }}" data-modal-toggle="editCategoryModal{{ $category->KategoriID }}"
                                        class="inline-block p-3 border-e text-gray-700 hover:bg-gray-50 focus:relative" title="Edit Category">
                                        <x-edit-icon />
                                    </button>
                                    <button data-modal-target="deleteCategoryModal{{ $category->KategoriID }}" data-modal-toggle="deleteCategoryModal{{ $category->KategoriID }}"
                                        class="inline-block p-3 text-gray-700 hover:bg-gray-50 focus:relative" title="Delete Category">
                                        <x-delete-icon />
                                    </button>
                                </span>
                            </td>
                        </tr>

                        <!-- Modal Edit Category -->
                        <div id="editCategoryModal{{ $category->KategoriID }}" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50 backdrop-blur">
                            <div class="bg-white p-6 rounded-lg w-full sm:w-80 md:w-96 shadow-lg">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Category</h2>
                                <form action="{{ route('category.update', $category->KategoriID) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="editCategoryName{{ $category->KategoriID }}" class="block text-sm font-medium text-gray-700">Category Name</label>
                                        <input type="text" name="NamaKategori" id="editCategoryName{{ $category->KategoriID }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500"
                                            value="{{ $category->NamaKategori }}" required>
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Save</button>
                                        <button type="button" data-modal-target="editCategoryModal{{ $category->KategoriID }}" data-modal-toggle="editCategoryModal{{ $category->KategoriID }}" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none cursor-pointer closeModal" data-modal-hide="editCategoryModal{{ $category->KategoriID }}">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Delete Category -->
                        <div id="deleteCategoryModal{{ $category->KategoriID }}" class="fixed inset-0 flex items-center justify-center hidden z-50 bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded-lg w-full sm:w-80 md:w-96 shadow-lg">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Delete Category</h2>
                                <p class="text-lg text-gray-700 mb-6">Are you sure you want to delete <span class="font-bold">{{ $category->NamaKategori }}</span>?</p>
                                <form action="{{ route('category.destroy', $category->KategoriID) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-end space-x-3">
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Delete</button>
                                        <button type="button" class="px-4 py-2 rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 focus:outline-none cursor-pointer closeModal" data-modal-hide="deleteCategoryModal{{ $category->KategoriID }}">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination controls -->
        <div class="mt-4">
            {{ $anas_kategori->links() }}
        </div>
    </div>

    <!-- Create Category Modal -->
    <div id="createCategoryModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50 backdrop-blur">
        <div class="bg-white p-6 rounded-lg w-full sm:w-80 md:w-96 shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Create Category</h2>
            <form method="POST" action="{{ route('category.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="categoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" id="categoryName" name="NamaKategori" required class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" data-modal-hide="createCategoryModal" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300 focus:outline-none cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-layout.admin>
