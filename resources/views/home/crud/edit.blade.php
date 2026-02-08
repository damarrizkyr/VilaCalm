<dialog id="modalEditVila"
    class="modal rounded-2xl shadow-2xl p-0 w-full max-w-2xl backdrop:bg-gray-900/50 open:animate-fade-in">
    <div class="bg-white dark:bg-gray-800 h-full max-h-[90vh] flex flex-col">
        {{-- Header --}}
        <div
            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center sticky top-0 bg-white dark:bg-gray-800 z-10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Edit Data Vila</h3>
            <button type="button" onclick="closeModalEdit()"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Form Content --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-6">
            <form id="formEditVila" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- 1. MANAJEMEN GAMBAR --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelola Foto
                        Vila</label>

                    {{-- A. Foto Lama (Dari Database) --}}
                    <div id="existing-images-container" class="mb-4">
                        <p class="text-xs text-gray-500 mb-2 font-bold">Foto Tersimpan (Klik X untuk hapus):</p>
                        <div id="existing-images-grid" class="grid grid-cols-4 gap-3">
                            {{-- Diisi via Javascript --}}
                        </div>
                    </div>

                    {{-- B. Upload Foto Baru (Cumulative) --}}
                    <div class="w-full">
                        <label for="dropzone-file-edit"
                            class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:bg-gray-800 dark:border-gray-600 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                                <svg class="w-6 h-6 mb-1 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Tambah Foto Baru (+)</p>
                            </div>
                            <input id="dropzone-file-edit" name="image[]" type="file" multiple class="hidden"
                                onchange="handleFilesEdit(this.files)" accept="image/*" />
                        </label>
                    </div>

                    {{-- Preview Foto Baru --}}
                    <div id="preview-container-edit" class="grid grid-cols-4 gap-3 mt-4 hidden"></div>
                </div>

                {{-- 2. INFORMASI DASAR (Sama seperti sebelumnya) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Vila</label>
                    <input type="text" name="name" id="editName" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" name="price" id="editPrice" required
                                class="w-full pl-10 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fasilitas</label>
                        <input type="text" name="facilities" id="editFacilities"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                    <textarea name="address" id="editAddress" rows="2" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Provinsi</label>
                        <select name="province_id" id="modalEditProvinceSelect"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kab/Kota</label>
                        <select name="regency_id" id="modalEditRegencySelect" disabled
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm">
                            <option value="">Pilih Provinsi Dulu</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="description" id="editDescription" rows="3"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div
            class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex justify-end space-x-3 rounded-b-2xl">
            <button type="button" onclick="closeModalEdit()"
                class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition">Batal</button>
            <button type="submit" form="formEditVila"
                class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-bold transition shadow-lg">Simpan
                Perubahan</button>
        </div>
    </div>
</dialog>

<script>
    let dtEdit = new DataTransfer();
    const API_URL_EDIT = '/api/wilayah';

    async function openModalEdit(vila) {
        document.getElementById('formEditVila').reset();
        dtEdit = new DataTransfer();
        document.getElementById('preview-container-edit').innerHTML = '';
        document.getElementById('preview-container-edit').classList.add('hidden');
        document.getElementById('existing-images-container').classList.remove('hidden');

        document.getElementById('formEditVila').action = `/vilas/${vila.id}`;

        document.getElementById('editName').value = vila.name;
        document.getElementById('editPrice').value = vila.price;
        document.getElementById('editFacilities').value = vila.facilities || '';
        document.getElementById('editAddress').value = vila.address;
        document.getElementById('editDescription').value = vila.description || '';

        renderExistingImages(vila.images);

        await loadProvincesEdit(vila.province_id);
        if (vila.province_id) await loadRegenciesEdit(vila.province_id, vila.regency_id);

        document.getElementById('modalEditVila').showModal();
    }

    function renderExistingImages(images) {
        const container = document.getElementById('existing-images-grid');
        container.innerHTML = '';

        if (images && images.length > 0) {
            images.forEach(img => {
                const div = document.createElement('div');
                div.className =
                    "relative group aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm";
                div.id = `existing-img-${img.id}`;

                const badge = img.is_primary ?
                    '<span class="absolute top-1 left-1 bg-green-500 text-white text-[10px] px-1.5 py-0.5 rounded shadow z-10">Utama</span>' :
                    '';

                const deleteBtn = `
                    <button type="button" onclick="deleteExistingImage(${img.id})"
                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition opacity-0 group-hover:opacity-100 z-10" title="Hapus Gambar Ini">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;

                div.innerHTML =
                    `<img src="/storage/${img.image_path}" class="w-full h-full object-cover">${badge}${deleteBtn}`;
                container.appendChild(div);
            });
        } else {
            container.innerHTML = '<p class="text-xs text-gray-400 col-span-4 italic">Belum ada foto.</p>';
        }
    }

    async function deleteExistingImage(imageId) {
        if (!confirm('Hapus gambar ini permanen?')) return;

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(`/vila-images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                document.getElementById(`existing-img-${imageId}`).remove();

                const container = document.getElementById('existing-images-grid');
                if (container.children.length === 0) {
                    container.innerHTML = '<p class="text-xs text-gray-400 col-span-4 italic">Belum ada foto.</p>';
                }
            } else {
                alert('Gagal menghapus gambar.');
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan sistem.');
        }
    }

    function handleFilesEdit(files) {
        const container = document.getElementById('preview-container-edit');

        for (let i = 0; i < files.length; i++) {
            let fileExists = false;
            for (let j = 0; j < dtEdit.items.length; j++) {
                if (dtEdit.items[j].getAsFile().name === files[i].name) {
                    fileExists = true;
                    break;
                }
            }
            if (!fileExists) dtEdit.items.add(files[i]);
        }

        document.getElementById('dropzone-file-edit').files = dtEdit.files;
        renderPreviewEdit();
    }

    function renderPreviewEdit() {
        const container = document.getElementById('preview-container-edit');
        container.innerHTML = '';

        if (dtEdit.files.length > 0) {
            container.classList.remove('hidden');
            for (let i = 0; i < dtEdit.files.length; i++) {
                const file = dtEdit.files[i];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className =
                        "relative group aspect-square rounded-xl overflow-hidden border border-indigo-200 shadow-sm";

                    const badge =
                        '<span class="absolute top-1 left-1 bg-blue-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow z-10">BARU</span>';

                    const deleteBtn =
                        `<button type="button" onclick="removeImageEdit(${i})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 z-10"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>`;

                    div.innerHTML =
                        `<img src="${e.target.result}" class="w-full h-full object-cover">${badge}${deleteBtn}`;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            }
        } else {
            container.classList.add('hidden');
        }
    }

    function removeImageEdit(index) {
        dtEdit.items.remove(index);
        document.getElementById('dropzone-file-edit').files = dtEdit.files;
        renderPreviewEdit();
    }

    function closeModalEdit() {
        document.getElementById('modalEditVila').close();
    }

    async function loadProvincesEdit(selectedId = null) {
        const select = document.getElementById('modalEditProvinceSelect');
        select.innerHTML = '<option value="">Pilih Provinsi</option>';
        try {
            const res = await fetch(`${API_URL_EDIT}/provinces`);
            const data = await res.json();
            data.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.textContent = p.name;
                if (p.id == selectedId) opt.selected = true;
                select.appendChild(opt);
            });
        } catch (e) {}
    }

    async function loadRegenciesEdit(provId, selectedId = null) {
        const select = document.getElementById('modalEditRegencySelect');
        select.innerHTML = '<option value="">Loading...</option>';
        select.disabled = true;
        try {
            const res = await fetch(`${API_URL_EDIT}/regencies/${provId}`);
            const data = await res.json();
            select.innerHTML = '<option value="">Pilih Kab/Kota</option>';
            data.forEach(r => {
                const opt = document.createElement('option');
                opt.value = r.id;
                opt.textContent = r.name;
                if (r.id == selectedId) opt.selected = true;
                select.appendChild(opt);
            });
            select.disabled = false;
        } catch (e) {}
    }

    document.getElementById('modalEditProvinceSelect').addEventListener('change', function() {
        if (this.value) loadRegenciesEdit(this.value);
        else document.getElementById('modalEditRegencySelect').disabled = true;
    });
</script>
