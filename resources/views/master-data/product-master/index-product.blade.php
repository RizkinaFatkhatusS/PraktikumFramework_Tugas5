<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        <div class="mb-4">
            <a href="{{ route('product-create') }}">
                <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    Add product data
                </button>
            </a>
        </div>

        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="min-w-full border border-collapse border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200 w-16">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Product Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Unit</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Information</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Qty</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Producer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200 w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($data as $item)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-4 py-2 border border-gray-200">{{ $i++ }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{ $item->product_name }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{ $item->unit }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{ $item->type }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{ $item->information }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{ $item->qty }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{ $item->producer }}</td>
                            <td class="px-4 py-2 border border-gray-200 whitespace-nowrap">
                                <a href="{{ route('product-edit', $item->id) }}" class="px-2 text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out">
                                    Edit
                                </a>
                                {{-- Menggunakan modal kustom untuk konfirmasi penghapusan --}}
                                <button class="px-2 text-red-600 hover:text-red-800 transition duration-150 ease-in-out" 
                                        onclick="showDeleteModal('{{ route('product-delete', $item->id) }}', '{{ $item->product_name }}')">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- MODAL KONFIRMASI PENGHAPUSAN -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Penghapusan</h3>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus data produk <strong id="productNamePlaceholder"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
            
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-150">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition duration-150">
                        Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const modalContent = document.getElementById('modalContent');
        const productNamePlaceholder = document.getElementById('productNamePlaceholder');

        /**
         * Menampilkan modal konfirmasi penghapusan.
         * @param {string} deleteUrl URL untuk route DELETE.
         * @param {string} productName Nama produk yang akan dihapus.
         */
        function showDeleteModal(deleteUrl, productName) {
            deleteForm.action = deleteUrl;
            productNamePlaceholder.textContent = '"' + productName + '"';
            
            // Tampilkan modal dan animasikan
            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        /**
         * Menyembunyikan modal konfirmasi penghapusan.
         */
        function closeDeleteModal() {
            // Sembunyikan modal dengan animasi
            modalContent.classList.add('opacity-0', 'scale-95');
            modalContent.classList.remove('opacity-100', 'scale-100');
            
            setTimeout(() => {
                deleteModal.classList.add('hidden');
            }, 300); // Tunggu sampai animasi selesai
        }
        
        // Tutup modal jika user mengklik di luar area modal
        deleteModal.addEventListener('click', (e) => {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });

        // Pastikan tidak ada `confirmDelete` function lagi, karena sudah diganti modal
    </script>
</x-app-layout>