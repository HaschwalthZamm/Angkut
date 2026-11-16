<div class="relative" id="notification-container">
    <!-- Tombol Lonceng -->
    <button id="notification-button" class="relative p-2 text-angkut-deep hover:bg-slate-100 rounded-xl transition focus:outline-none">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <!-- Badge Merah (Unread Count) -->
        <span id="notification-badge" class="hidden absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full border-2 border-white"></span>
    </button>

    <!-- Dropdown Notifikasi -->
    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border-4 border-angkut-deep rounded-2xl shadow-cartoon z-50 overflow-hidden">
        <div class="p-3 border-b-4 border-angkut-deep bg-angkut-soft flex justify-between items-center">
            <h3 class="font-fun font-bold text-angkut-deep text-sm">Notifikasi</h3>
            <button id="mark-all-read" class="text-xs font-bold text-angkut-medium hover:text-angkut-dark">Tandai Semua Dibaca</button>
        </div>
        <div id="notification-list" class="max-h-80 overflow-y-auto">
            <!-- List akan diisi oleh Javascript -->
            <div class="p-4 text-center text-sm font-semibold text-slate-500">Memuat notifikasi...</div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('notification-button');
    const dropdown = document.getElementById('notification-dropdown');
    const badge = document.getElementById('notification-badge');
    const list = document.getElementById('notification-list');
    const markAllBtn = document.getElementById('mark-all-read');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let isOpen = false;

    // Toggle Dropdown
    btn.addEventListener('click', () => {
        isOpen = !isOpen;
        dropdown.classList.toggle('hidden', !isOpen);
        if (isOpen) fetchNotifications();
    });

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', (e) => {
        if (!document.getElementById('notification-container').contains(e.target)) {
            isOpen = false;
            dropdown.classList.add('hidden');
        }
    });

    // Ambil Data Notifikasi
    function fetchNotifications() {
        fetch('{{ route("notifications.index") }}')
            .then(res => res.json())
            .then(data => {
                // Update Badge
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }

                // Render List
                if (data.notifications.length === 0) {
                    list.innerHTML = '<div class="p-4 text-center text-sm font-semibold text-slate-500">Tidak ada notifikasi.</div>';
                    return;
                }

                list.innerHTML = data.notifications.map(notif => {
                    const isUnread = notif.read_at === null;
                    const bgClass = isUnread ? 'bg-angkut-soft/50' : 'bg-white';
                    const dot = isUnread ? '<span class="w-2 h-2 bg-red-500 rounded-full mt-1.5 shrink-0"></span>' : '';
                    
                    const url = notif.data.url || '#';
                    
                    return `
                        <a href="${url}" onclick="markAsRead('${notif.id}')" class="block p-3 border-b-2 border-slate-100 hover:bg-slate-50 transition ${bgClass}">
                            <div class="flex items-start gap-2">
                                ${dot}
                                <div>
                                    <p class="text-xs font-bold text-angkut-deep leading-tight mb-1">${notif.data.message}</p>
                                    <p class="text-[10px] text-slate-400 font-semibold">${new Date(notif.created_at).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                        </a>
                    `;
                }).join('');
            });
    }

    // Tandai satu sudah dibaca
    window.markAsRead = function(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
    };

    // Tandai semua sudah dibaca
    markAllBtn.addEventListener('click', () => {
        fetch('{{ route("notifications.readAll") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(() => fetchNotifications());
    });

    // Fetch pertama kali untuk set badge
    fetchNotifications();
});
</script>