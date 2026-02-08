<dialog id="modalEditBooking" class="modal rounded-2xl shadow-2xl p-0 w-full max-w-lg backdrop:bg-gray-900/50 open:animate-fade-in">
    <div class="bg-white dark:bg-gray-800 h-full flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-white dark:bg-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Edit Data Pembooking</h3>
            <button type="button" onclick="document.getElementById('modalEditBooking').close()" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>

        <form id="formEditBooking" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            {{-- Hidden Duration Store --}}
            <input type="hidden" id="editDuration" value="">

            {{-- 1. Kode Booking (Readonly) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Booking</label>
                <input type="text" id="editBookingCode" readonly class="w-full bg-gray-100 text-gray-500 rounded-xl border-gray-300 cursor-not-allowed">
            </div>

            {{-- 2. Check In (Logic Restriction) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-In</label>
                <input type="date" name="check_in" id="editCheckIn" class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                <p id="dateWarning" class="text-xs text-red-500 mt-1 hidden">Tanggal tidak bisa diubah (Sudah H-1).</p>
            </div>

            {{-- 3. Check Out (Readonly - Auto Calculated) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-Out (Otomatis)</label>
                <input type="date" id="editCheckOut" readonly class="w-full bg-gray-100 text-gray-500 rounded-xl border-gray-300 cursor-not-allowed">
                <p class="text-xs text-gray-400 mt-1">*Durasi menginap tetap sama.</p>
            </div>

            {{-- 4. Status (Only Confirmed -> Completed) --}}
            <div id="statusContainer">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" id="editStatus" class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl shadow-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</dialog>

<script>
    const editCheckInInput = document.getElementById('editCheckIn');

    editCheckInInput.addEventListener('change', function() {
        const newDate = new Date(this.value);
        const duration = parseInt(document.getElementById('editDuration').value);

        if(!isNaN(newDate.getTime()) && duration) {
            newDate.setDate(newDate.getDate() + duration);
            document.getElementById('editCheckOut').value = newDate.toISOString().split('T')[0];
        }
    });
</script>
