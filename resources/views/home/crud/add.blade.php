<dialog id="modalAddVila" class="modal rounded-2xl shadow-2xl p-0 w-full max-w-2xl backdrop:bg-gray-900/50 open:animate-fade-in">
    <div class="bg-white dark:bg-gray-800 h-full max-h-[90vh] flex flex-col">
        {{-- Header Modal --}}
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center sticky top-0 bg-white dark:bg-gray-800 z-10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Tambah Vila Baru</h3>
            <button type="button" onclick="closeModalAdd()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Form Content --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-6">
            <form action="{{ route('vilas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="formAddVila">

                @csrf

                {{-- 1. MULTIPLE IMAGE UPLOAD DENGAN LOGIKA BARU --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Vila (Urutan pertama otomatis jadi Cover)</label>

                    {{-- Area Dropzone --}}
                    <div class="w-full">
                        <label for="dropzone-file-add"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:bg-gray-800 dark:border-gray-600 transition relative">

                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                                <svg class="w-8 h-8 mb-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Klik untuk tambah foto</p>
                            </div>

                            {{-- Input File Asli (Hidden) --}}
                            <input id="dropzone-file-add" name="image[]" type="file" multiple class="hidden" onchange="handleFiles(this.files)" accept=".jpg,.jpeg,.png,.gif,.svg" />
                        </label>
                    </div>

                    {{-- Container Preview Gambar --}}
                    <div id="preview-container-add" class="grid grid-cols-4 gap-3 mt-4 hidden">
                        {{-- Gambar akan di-render di sini oleh JavaScript --}}
                    </div>
                </div>

                {{-- 2. INFORMASI DASAR --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Vila</label>
                    <input type="text" name="name" required placeholder="Contoh: Vila Mawar Puncak"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga per Malam</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" name="price" required placeholder="0"
                                class="w-full pl-10 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fasilitas</label>
                        <input type="text" name="facilities" placeholder="Wifi, Kolam Renang..."
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                {{-- 3. ALAMAT --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="2" required placeholder="Jln. Raya Puncak No..."
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                {{-- 4. WILAYAH --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Provinsi</label>
                        <select name="province_id" id="modalProvinceSelect" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kab/Kota</label>
                        <select name="regency_id" id="modalRegencySelect" disabled class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm">
                            <option value="">Pilih Provinsi Dulu</option>
                        </select>
                    </div>
                </div>

                {{-- 5. DESKRIPSI --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Detail</label>
                    <textarea name="description" rows="3" placeholder="Jelaskan keunggulan vila ini..."
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
            </form>
        </div>

        {{-- Footer Actions --}}
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex justify-end space-x-3 rounded-b-2xl">
            <button type="button" onclick="closeModalAdd()"
                class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition shadow-sm">
                Batal
            </button>
            <button type="submit" form="formAddVila"
                class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-bold transition shadow-lg shadow-indigo-200 dark:shadow-none">
                Simpan Vila
            </button>
        </div>
    </div>
</dialog>

<script>

    let dt = new DataTransfer();

    function handleFiles(files) {
        const container = document.getElementById('preview-container-add');

        for (let i = 0; i < files.length; i++) {
            let fileExists = false;
            for(let j=0; j<dt.items.length; j++){
                if(dt.items[j].getAsFile().name === files[i].name){
                    fileExists = true; break;
                }
            }
            if(!fileExists) {
                dt.items.add(files[i]);
            }
        }
        document.getElementById('dropzone-file-add').files = dt.files;
        renderPreview();
    }

    function handleFiles(files) {
        const container = document.getElementById('preview-container-add');

        // Daftar ekstensi yang diperbolehkan (Tanpa webp)
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileName = file.name;
            const fileExt = fileName.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(fileExt)) {
                // Notifikasi Error
                alert(`File "${fileName}" tidak dapat diupload.\nHanya format JPG, JPEG, PNG, GIF, dan SVG yang diperbolehkan.`);
                continue;
            }
            let fileExists = false;
            for (let j = 0; j < dt.items.length; j++) {
                if (dt.items[j].getAsFile().name === fileName) {
                    fileExists = true;
                    break;
                }
            }
            if (!fileExists) {
                dt.items.add(file);
            }
        }
        document.getElementById('dropzone-file-add').files = dt.files;

        renderPreview();
    }

    function renderPreview() {
        const container = document.getElementById('preview-container-add');
        container.innerHTML = '';

        if (dt.files.length > 0) {
            container.classList.remove('hidden');
            for (let i = 0; i < dt.files.length; i++) {
                const file = dt.files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = "relative group aspect-square rounded-xl overflow-hidden border border-gray-200 shadow-sm";
                    const badge = i === 0
                        ? '<span class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-md z-10">UTAMA</span>'
                        : '';

                    const deleteBtn = `
                        <button type="button" onclick="removeImage(${i})"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition opacity-0 group-hover:opacity-100 z-10">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    `;

                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover transition transform group-hover:scale-105">
                        ${badge}
                        ${deleteBtn}
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            }
        } else {
            container.classList.add('hidden');
        }
    }

    function removeImage(index) {
        dt.items.remove(index);
        document.getElementById('dropzone-file-add').files = dt.files;
        renderPreview();
    }

    function closeModalAdd() {
        document.getElementById('modalAddVila').close();
        document.getElementById('formAddVila').reset();
        dt = new DataTransfer();
        renderPreview();
    }

    document.addEventListener('DOMContentLoaded', async function() {
        const modalProvSelect = document.getElementById('modalProvinceSelect');
        const modalRegSelect = document.getElementById('modalRegencySelect');
        const API_URL = '/api/wilayah';

        try {
            const res = await fetch(`${API_URL}/provinces`);
            const data = await res.json();
            data.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.textContent = p.name;
                modalProvSelect.appendChild(opt);
            });
        } catch(e) { console.error('Gagal load provinsi', e); }

        modalProvSelect.addEventListener('change', async function() {
            modalRegSelect.innerHTML = '<option value="">Loading...</option>';
            modalRegSelect.disabled = true;
            if(this.value) {
                try {
                    const res = await fetch(`${API_URL}/regencies/${this.value}`);
                    const data = await res.json();
                    modalRegSelect.innerHTML = '<option value="">Pilih Kab/Kota</option>';
                    data.forEach(r => {
                        const opt = document.createElement('option');
                        opt.value = r.id;
                        opt.textContent = r.name;
                        modalRegSelect.appendChild(opt);
                    });
                    modalRegSelect.disabled = false;
                } catch(e) {}
            } else {
                modalRegSelect.innerHTML = '<option value="">Pilih Provinsi Dulu</option>';
            }
        });
    });


</script>
