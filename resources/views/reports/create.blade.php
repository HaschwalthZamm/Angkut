@extends(Auth::check() ? 'layouts.masyarakat' : 'layouts.guest')

@section('header', 'Buat Laporan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
        
        <div class="p-6 border-b-4 border-angkut-deep bg-angkut-light">
            <h2 class="font-fun text-2xl font-extrabold text-angkut-deep">Formulir Pelaporan Sampah</h2>
            <p class="text-sm font-semibold text-angkut-dark">Geser pin di peta untuk menentukan lokasi tepatnya.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-b-4 border-angkut-deep text-red-800 font-bold p-4 font-fun">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf

            <!-- Jika Guest, minta Nama & No HP -->
            @if($isGuest)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-angkut-soft border-3 border-angkut-deep rounded-2xl">
                    <div>
                        <label class="block font-fun font-bold text-angkut-deep mb-2">Nama Lengkap</label>
                        <input type="text" name="reporter_name" value="{{ old('reporter_name') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="Masukkan nama Anda">
                    </div>
                    <div>
                        <label class="block font-fun font-bold text-angkut-deep mb-2">Nomor HP (WhatsApp)</label>
                        <input type="text" name="reporter_phone" value="{{ old('reporter_phone') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="0812xxxxxx">
                    </div>
                    <p class="text-xs text-angkut-dark col-span-1 md:col-span-2">*Simpan nomor HP ini untuk melacak status laporan Anda nanti.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Judul Laporan</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="Contoh: Sampah menumpuk di depan pasar">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Kategori Sampah</label>
                    <select name="report_category_id" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('report_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kecamatan -->
                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Kecamatan</label>
                    <select name="region_id" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium bg-white">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($regions as $r)
                            <option value="{{ $r->id }}" {{ old('region_id') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Prioritas -->
                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Tingkat Urgensi</label>
                    <select name="priority" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium bg-white">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah (Bisa menunggu)</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }} selected>Sedang (Biasa)</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi (Mengganggu)</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak (Bau/Medis)</option>
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Deskripsi Detail</label>
                    <textarea name="description" rows="4" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="Jelaskan kondisi sampah...">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- PETA LEAFLET -->
            <div>
                <label class="block font-fun font-bold text-angkut-deep mb-2">Lokasi Kejadian (Geser Pin)</label>
                <div id="map" class="w-full h-80 rounded-2xl border-4 border-angkut-deep shadow-inner z-0"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', '-2.9909') }}" required>
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', '104.7565') }}" required>
                <input type="hidden" name="address" id="address" value="{{ old('address') }}">
                <p class="text-xs font-semibold text-slate-500 mt-2">Alamat terdeteksi: <span id="address-text" class="font-bold text-angkut-dark">Menghitung alamat...</span></p>
            </div>

            <!-- Upload Foto -->
            <div>
                <label class="block font-fun font-bold text-angkut-deep mb-2">Upload Foto (Maksimal 5 foto)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium bg-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-2 file:border-angkut-deep file:text-sm file:font-bold file:bg-angkut-pop file:text-angkut-deep hover:file:bg-yellow-400">
            </div>

            <div class="pt-4 border-t-4 border-slate-100">
                <button type="submit" class="w-full bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun text-xl font-extrabold px-8 py-4 border-4 border-angkut-deep rounded-2xl shadow-cartoon transition-all hover:-translate-y-1 active:translate-y-1">
                    🚀 Kirim Laporan Sekarang
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