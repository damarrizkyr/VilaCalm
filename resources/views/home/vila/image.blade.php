<div x-data="{
    galleryOpen: false,
    activeImage: 0,
    images: [
        @foreach ($vila->images as $img)
            '{{ asset('storage/' . $img->image_path) }}', @endforeach
    ]
}">

    {{-- LAYOUT GALERI --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 h-[350px] md:h-[450px] rounded-2xl overflow-hidden">

        {{-- 1. GAMBAR UTAMA (KIRI) --}}
        {{-- class 'relative' + 'h-full' penting agar child absolute mengikuti tinggi ini --}}
        <div class="md:col-span-2 relative h-full group cursor-pointer overflow-hidden"
            @click="galleryOpen = true; activeImage = 0">
            @if ($vila->images->count() > 0)
                {{-- Gunakan 'absolute inset-0' agar gambar dipaksa memenuhi kotak induk --}}
                <img src="{{ asset('storage/' . $vila->images[0]->image_path) }}"
                    class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-500"></div>
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
            @endif
        </div>

        {{-- 2. GAMBAR SAMPING (KANAN) --}}
        {{-- Gunakan Flexbox Vertical --}}
        <div class="hidden md:flex flex-col gap-2 h-full">

            {{-- Gambar Samping Atas --}}
            {{-- 'flex-1' membagi tinggi rata. 'relative' jadi acuan gambar absolute --}}
            <div class="relative flex-1 w-full cursor-pointer overflow-hidden group"
                @click="galleryOpen = true; activeImage = 1">
                @if (isset($vila->images[1]))
                    <img src="{{ asset('storage/' . $vila->images[1]->image_path) }}"
                        class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110">
                @else
                    <div class="absolute inset-0 bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                        Kosong</div>
                @endif
            </div>

            {{-- Gambar Samping Bawah --}}
            <div class="relative flex-1 w-full cursor-pointer overflow-hidden group"
                @click="galleryOpen = true; activeImage = 2">
                @if (isset($vila->images[2]))
                    <img src="{{ asset('storage/' . $vila->images[2]->image_path) }}"
                        class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110">

                    {{-- Overlay Hitung Sisa --}}
                    @if ($vila->images->count() > 3)
                        <div
                            class="absolute inset-0 bg-black/50 flex items-center justify-center transition group-hover:bg-black/60 z-10">
                            <span class="text-white font-bold text-lg">+{{ $vila->images->count() - 3 }} Foto</span>
                        </div>
                    @endif
                @else
                    <div class="absolute inset-0 bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                        Kosong</div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL FULLSCREEN (Kode Modal Tetap Sama seperti sebelumnya) --}}
    <div x-show="galleryOpen" style="display: none;" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/95 backdrop-blur-sm p-4">

        <button @click="galleryOpen = false"
            class="absolute top-6 right-6 text-white hover:text-gray-300 z-50 p-2 bg-black/20 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="relative w-full max-w-6xl h-full flex items-center justify-center"
            @click.outside="galleryOpen = false">
            <button @click.stop="activeImage = activeImage === 0 ? images.length - 1 : activeImage - 1"
                class="absolute left-0 p-4 text-white hover:bg-white/10 rounded-full transition hidden md:block z-50">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <img :src="images[activeImage]"
                class="max-h-[90vh] max-w-full rounded shadow-2xl object-contain select-none">

            <button @click.stop="activeImage = activeImage === images.length - 1 ? 0 : activeImage + 1"
                class="absolute right-0 p-4 text-white hover:bg-white/10 rounded-full transition hidden md:block z-50">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <div class="absolute bottom-4 text-white text-sm bg-black/50 px-4 py-1.5 rounded-full backdrop-blur-sm">
                Foto <span x-text="activeImage + 1"></span> / <span x-text="images.length"></span>
            </div>
        </div>
    </div>
</div>
