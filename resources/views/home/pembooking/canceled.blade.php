<dialog id="modalCancelBooking" class="modal rounded-2xl shadow-2xl p-0 w-full max-w-md backdrop:bg-gray-900/50 open:animate-fade-in">
    <div class="bg-white dark:bg-gray-800 p-6 text-center">
        <div class="w-16 h-16 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Batalkan Booking?</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Status akan berubah menjadi <b>Cancelled</b>. Tindakan ini tidak dapat dikembalikan ke status Confirmed.</p>

        <form id="formCancelBooking" method="POST">
            @csrf
            @method('PATCH')
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="document.getElementById('modalCancelBooking').close()" class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-bold shadow-lg">Ya, Batalkan</button>
            </div>
        </form>
    </div>
</dialog>
