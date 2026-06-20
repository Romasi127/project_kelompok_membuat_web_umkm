@extends('layouts.admin')

@section('page_title', 'Edit Menu Makanan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-8">
        <h2 class="text-xl font-bold text-slate-800 border-b border-slate-50 pb-4 mb-6">Formulir Edit Menu</h2>

        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Menu</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kategori</label>
                    <select name="category" id="category" required
                            class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm font-semibold">
                        <option value="Makanan" {{ $menu->category === 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Ikan Nila" {{ $menu->category === 'Ikan Nila' ? 'selected' : '' }}>Ikan Nila</option>
                        <option value="Ikan Gurami" {{ $menu->category === 'Ikan Gurami' ? 'selected' : '' }}>Ikan Gurami</option>
                        <option value="Ikan Bawal" {{ $menu->category === 'Ikan Bawal' ? 'selected' : '' }}>Ikan Bawal</option>
                        <option value="Ikan Kakap" {{ $menu->category === 'Ikan Kakap' ? 'selected' : '' }}>Ikan Kakap</option>
                        <option value="Ikan Gembung" {{ $menu->category === 'Ikan Gembung' ? 'selected' : '' }}>Ikan Gembung</option>
                        <option value="Udang" {{ $menu->category === 'Udang' ? 'selected' : '' }}>Udang</option>
                        <option value="Kepiting" {{ $menu->category === 'Kepiting' ? 'selected' : '' }}>Kepiting</option>
                        <option value="Cumi" {{ $menu->category === 'Cumi' ? 'selected' : '' }}>Cumi</option>
                        <option value="Minuman" {{ $menu->category === 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Lain-lain" {{ $menu->category === 'Lain-lain' ? 'selected' : '' }}>Lain-lain / Nasi</option>
                    </select>
                    @error('category')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="price_display" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Harga (Rupiah)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400 pointer-events-none">Rp</span>
                    <input type="text" id="price_display" inputmode="numeric" required
                           value="{{ old('price') ? number_format((int)str_replace(['.', ','], '', old('price')), 0, ',', '.') : number_format($menu->price, 0, ',', '.') }}"
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm @error('price') border-rose-500 @enderror">
                    <input type="hidden" name="price" id="price" value="{{ old('price', $menu->price) }}">
                </div>
                @error('price')
                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm @error('description') border-rose-500 @enderror">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Pilihan Masakan &amp; Harga (Opsional)</label>
                <p class="text-slate-400 text-[10px] mb-3">Tambahkan variasi cara memasak beserta harga masing-masing. Kosongkan jika tidak ada variasi.</p>

                <!-- Hidden JSON input -->
                <input type="hidden" name="cooking_options" id="cooking_options_json">

                <!-- Dynamic rows -->
                <div id="cooking_options_rows" class="space-y-2 mb-3">
                    <!-- rows will be injected by JS -->
                </div>

                <button type="button" id="add_cooking_row"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-600 hover:text-teal-800 bg-teal-50 hover:bg-teal-100 px-3 py-2 rounded-xl transition-all border border-teal-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Pilihan Masakan
                </button>

                @error('cooking_options')
                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current image preview & replace -->
            <div class="space-y-3">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Foto Menu Saat Ini</label>
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-50 border border-slate-200">
                        <img src="{{ asset($menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow">
                        <label for="image" class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5">Ganti Foto (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                        @error('image')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.menus.index') }}" class="flex-grow bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3.5 px-4 rounded-xl transition-all text-center text-sm">
                    Batal
                </a>
                <button type="submit" class="flex-grow bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md shadow-teal-600/10 text-center text-sm">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    /* ===== Harga utama format rupiah ===== */
    const display = document.getElementById('price_display');
    const hidden  = document.getElementById('price');

    display.addEventListener('input', function () {
        const raw = this.value.replace(/\D/g, '');
        this.value   = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
        hidden.value = raw;
    });
    display.closest('form').addEventListener('submit', function (e) {
        e.preventDefault();
        hidden.value = display.value.replace(/\D/g, '');
        serializeCookingOptions();
        this.submit();
    });
    if (display.value) hidden.value = display.value.replace(/\D/g, '');

    /* ===== Pilihan Masakan Dinamis ===== */
    const rowsContainer = document.getElementById('cooking_options_rows');
    const jsonInput     = document.getElementById('cooking_options_json');
    const addBtn        = document.getElementById('add_cooking_row');

    // Load data existing dari database
    const existingOptions = @json($menu->cooking_options ?? []);
    existingOptions.forEach(opt => {
        if (typeof opt === 'object' && opt !== null) {
            addRow(opt.name || '', opt.price || '');
        } else {
            // Kompatibel dengan format lama (string biasa)
            addRow(String(opt), '');
        }
    });

    addBtn.addEventListener('click', () => addRow('', ''));

    function addRow(name, price) {
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 cooking-row';
        row.innerHTML = `
            <div class="flex-grow">
                <input type="text" placeholder="Nama masakan (cth: Goreng Tepung)"
                       value="${escHtml(name)}"
                       class="cooking-name w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 outline-none transition-all font-semibold">
            </div>
            <div class="w-36 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-400 pointer-events-none">Rp</span>
                <input type="text" inputmode="numeric" placeholder="Harga"
                       value="${price ? parseInt(price).toLocaleString('id-ID') : ''}"
                       class="cooking-price w-full pl-7 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 outline-none transition-all font-bold">
            </div>
            <button type="button" class="remove-row flex-shrink-0 p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        `;

        const priceInput = row.querySelector('.cooking-price');
        priceInput.addEventListener('input', function() {
            const raw = this.value.replace(/\D/g, '');
            this.value = raw ? parseInt(raw).toLocaleString('id-ID') : '';
        });

        row.querySelector('.remove-row').addEventListener('click', () => row.remove());
        rowsContainer.appendChild(row);
    }

    function serializeCookingOptions() {
        const rows = rowsContainer.querySelectorAll('.cooking-row');
        const options = [];
        rows.forEach(row => {
            const name  = row.querySelector('.cooking-name').value.trim();
            const price = row.querySelector('.cooking-price').value.replace(/\D/g, '');
            if (name) options.push({ name, price: price ? parseInt(price) : 0 });
        });
        jsonInput.value = options.length ? JSON.stringify(options) : '';
    }

    function escHtml(str) {
        return String(str).replace(/&/g,'&amp;').replace(/"/g,'&quot;');
    }
})();
</script>
@endpush
