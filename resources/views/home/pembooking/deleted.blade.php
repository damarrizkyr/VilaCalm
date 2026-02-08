<dialog id="modalDeleteBooking" class="modal rounded-2xl shadow-2xl p-0 w-full max-w-md backdrop:bg-gray-900/50 open:animate-fade-in">
    <div class="bg-white dark:bg-gray-800 p-6 text-center">
        <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Data Permanen?</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Data booking <span id="deleteBookingName" class="font-bold"></span> akan dihapus dari database dan tidak bisa dipulihkan.</p>

        <form id="formDeleteBooking" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="document.getElementById('modalDeleteBooking').close()" class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-lg">Hapus Permanen</button>
            </div>
        </form>
    </div>
</dialog>
