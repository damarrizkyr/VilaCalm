<dialog id="modalDeleteVila" class="modal rounded-2xl shadow-2xl p-0 w-full max-w-sm backdrop:bg-gray-900/60 open:animate-fade-in-up">
    <div class="bg-white dark:bg-gray-800 p-6 text-center">
        {{-- Icon Warning --}}
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 mb-4">
            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="deleteModalTitle">Hapus Vila?</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
            Apakah Anda yakin ingin menghapus data vila <b id="deleteVilaName" class="text-gray-800 dark:text-gray-200"></b>?
            Tindakan ini tidak bisa dibatalkan.
        </p>

        {{-- Form Hapus --}}
        <form id="formDeleteVila" method="POST" class="mt-6 flex justify-center gap-3">
            @csrf
            @method('DELETE')

            <button type="button" onclick="document.getElementById('modalDeleteVila').close()"
                class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 font-semibold transition">
                Batal
            </button>
            <button type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold shadow-lg transition">
                Ya, Hapus
            </button>
        </form>
    </div>
</dialog>

<script>
    function openModalDelete(id, name) {
        document.getElementById('formDeleteVila').action = `/vilas/${id}`;
        document.getElementById('deleteVilaName').textContent = name;
        document.getElementById('modalDeleteVila').showModal();
    }
</script>
