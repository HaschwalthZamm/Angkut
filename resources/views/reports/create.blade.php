@extends(Auth::check() ? 'layouts.masyarakat' : 'layouts.guest')

@section('header', 'Buat Laporan')

@section('content')
<div class="max-w-4xl mx-auto pb-4">
    
    <!-- TOMBOL KEMBALI DI AREA ATAS (LUAR KOTAK) -->
    <div class="mb-4 flex justify-start">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-100 text-angkut-deep font-fun font-bold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs transition-all hover:-translate-y-0.5 active:translate-y-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon-lg overflow-hidden">
        
        <!-- HEADER FORM -->
        <div class="p-6 md:p-8 border-b-4 border-angkut-deep bg-angkut-light relative">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white border-3 border-angkut-deep rounded-2xl flex items-center justify-center shadow-cartoon-xs transform -rotate-3 shrink-0">
                    <svg class="w-8 h-8 text-angkut-orange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h2 class="font-fun text-2xl md:text-3xl font-extrabold text-angkut-deep tracking-wide uppercase">Formulir Laporan</h2>
                    <p class="text-sm font-bold text-angkut-dark mt-1">Bantu kami menjaga Palembang tetap bersih.</p>
                </div>
            </div>
        </div>

        <!-- NOTIFIKASI ERROR -->
        @if ($errors->any())
            <div class="bg-rose-100 border-b-4 border-angkut-deep text-rose-800 font-bold p-6 font-fun text-sm">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                    <span>Mohon perbaiki kesalahan berikut:</span>
                </div>
                <ul class="list-disc pl-7 space-y-1 font-sans text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
            @csrf

            <!-- IDENTITAS PELAPOR (JIKA GUEST) -->
            @if($isGuest)
                <div class="bg-angkut-cream border-3 border-angkut-deep rounded-2xl p-6 shadow-cartoon-xs relative">
                    <div class="flex justify-between items-center mb-4 pb-4 border-b-2 border-angkut-deep/20">
                        <h3 class="font-fun font-bold text-lg text-angkut-deep">Identitas Pelapor</h3>
                        <span class="bg-angkut-pop text-angkut-deep font-fun text-xs font-bold px-3 py-1 border-2 border-angkut-deep rounded-lg shadow-sm">
                            Wajib Diisi
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-2">
                                <svg class="w-4 h-4 text-angkut-medium" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                Nama Lengkap
                            </label>
                            <input type="text" name="reporter_name" value="{{ old('reporter_name') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-bold text-angkut-deep bg-white focus:ring-4 focus:ring-angkut-orange/30 focus:border-angkut-orange transition-all outline-none" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-2">
                                <svg class="w-4 h-4 text-angkut-medium" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                                Nomor HP (WhatsApp)
                            </label>
                            <input type="text" name="reporter_phone" value="{{ old('reporter_phone') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-bold text-angkut-deep bg-white focus:ring-4 focus:ring-angkut-orange/30 focus:border-angkut-orange transition-all outline-none" placeholder="0812xxxxxx">
                        </div>
                    </div>
                    <p class="text-xs font-bold text-angkut-orange mt-4">*Simpan nomor HP ini untuk melacak status laporan Anda nanti.</p>
                </div>
            @endif

            <!-- DETAIL LAPORAN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-2">
                        <svg class="w-5 h-5 text-angkut-dark" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        Judul Laporan
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-bold text-lg text-angkut-deep focus:ring-4 focus:ring-angkut-orange/30 focus:border-angkut-orange transition-all outline-none" placeholder="Contoh: Sampah menumpuk di depan pasar">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-2">
                        <svg class="w-5 h-5 text-angkut-dark" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Kategori Sampah
                    </label>
                    <select name="report_category_id" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-bold text-angkut-deep focus:ring-4 focus:ring-angkut-orange/30 focus:border-angkut-orange transition-all outline-none bg-white cursor-pointer appearance-none">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('report_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kecamatan -->
                <div>
                    <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-2">
                        <svg class="w-5 h-5 text-angkut-dark" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Kecamatan
                    </label>
                    <select name="region_id" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-bold text-angkut-deep focus:ring-4 focus:ring-angkut-orange/30 focus:border-angkut-orange transition-all outline-none bg-white cursor-pointer appearance-none">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($regions as $r)
                            <option value="{{ $r->id }}" {{ old('region_id') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Prioritas -->
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-2">
                        <svg class="w-5 h-5 text-angkut-dark" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        Tingkat Urgensi
                    </label>
                    <select name="priority" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-bold text-angkut-deep focus:ring-4 focus:ring-angkut-orange/30 focus:border-angkut-orange transition-all outline-none bg-white cursor-pointer appearance-none">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah (Bisa menunggu)</option>
                        <option value="medium" {{ old('priority') == 'medium' || !old('priority') ? 'selected' : '' }}>Sedang (Biasa)</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi (Mengganggu)</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak (Bau/Medis)</option>
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-2">
                        <svg class="w-5 h-5 text-angkut-dark" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        Deskripsi Detail
                    </label>
                    <textarea name="description" rows="4" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold text-angkut-deep focus:ring-4 focus:ring-angkut-orange/30 focus:border-angkut-orange transition-all outline-none" placeholder="Ceritakan kondisi sampah secara detail (misal: bau, jumlah, atau akses jalan)...">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- PETA LEAFLET -->
            <div class="bg-slate-50 border-3 border-angkut-deep rounded-2xl p-4">
                <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-3">
                    <svg class="w-5 h-5 text-angkut-dark" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Geser Pin di Peta
                </label>
                <div id="map" class="w-full h-80 rounded-xl border-3 border-angkut-deep shadow-inner z-0"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', '-2.9909') }}" required>
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', '104.7565') }}" required>
                <input type="hidden" name="address" id="address" value="{{ old('address') }}">
                
                <div class="mt-3 bg-white p-3 border-2 border-slate-300 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-angkut-orange shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat Terdeteksi</p>
                        <p id="address-text" class="font-bold text-angkut-deep mt-0.5">Menghitung alamat...</p>
                    </div>
                </div>
            </div>

            <!-- Upload Foto -->
            <div>
                <label class="flex items-center gap-2 font-fun font-bold text-angkut-deep mb-2">
                    <svg class="w-5 h-5 text-angkut-dark" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Upload Foto Bukti
                </label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold text-slate-600 focus:ring-4 focus:ring-angkut-orange/30 focus:border-angkut-orange transition-all bg-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-2 file:border-angkut-deep file:text-sm file:font-bold file:bg-angkut-pop file:text-angkut-deep hover:file:bg-yellow-400 file:cursor-pointer file:transition-all file:shadow-cartoon-xs file:hover:-translate-y-0.5">
                <p class="text-xs font-bold text-slate-500 mt-2">Maksimal 5 foto. Format: JPG, PNG, WEBP. Maks 5MB/foto.</p>
            </div>

            <!-- Tombol Kirim Bawah -->
            <div class="pt-6 border-t-4 border-slate-100">
                <button type="submit" class="w-full bg-angkut-medium hover:bg-angkut-dark text-white font-fun text-xl font-extrabold px-8 py-5 border-4 border-angkut-deep rounded-2xl shadow-cartoon-lg transition-all hover:-translate-y-1 active:translate-y-1 active:shadow-cartoon-xs uppercase tracking-wider flex justify-center items-center gap-3">
                    <span>Kirim Laporan</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Koordinat awal (Palembang)
        let lat = parseFloat(document.getElementById('latitude').value) || -2.9909;
        let lng = parseFloat(document.getElementById('longitude').value) || 104.7565;

        // Inisialisasi Peta
        var map = L.map('map').setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Custom Icon Pin
        var customIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41]
        });

        // Buat Marker yang bisa digeser
        var marker = L.marker([lat, lng], { draggable: true, icon: customIcon }).addTo(map);

        // Fungsi untuk update input & alamat saat pin digeser
        function updateLocation(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);

            // Reverse Geocoding via Nominatim
            document.getElementById('address-text').innerText = 'Mencari alamat...';
            
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('address-text').innerText = data.display_name;
                        document.getElementById('address').value = data.display_name;
                    } else {
                        document.getElementById('address-text').innerText = 'Alamat tidak ditemukan.';
                    }
                })
                .catch(error => {
                    document.getElementById('address-text').innerText = 'Gagal mengambil alamat.';
                });
        }

        // Event listener saat marker selesai digeser
        marker.on('dragend', function (e) {
            var position = marker.getLatLng();
            updateLocation(position.lat, position.lng);
        });

        // Panggil pertama kali
        updateLocation(lat, lng);
    });
</script>
@endpush