{{-- Reusable logout confirmation modal --}}
{{-- Iconify CDN untuk semua admin pages --}}
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js" defer></script>
<div class="admin-modal-overlay" id="logoutModal">
    <div class="logout-modal">
        <button type="button" class="logout-modal-close" onclick="document.getElementById('logoutModal').classList.remove('active')" aria-label="Tutup">
            <iconify-icon icon="solar:close-circle-linear" width="20" height="20"></iconify-icon>
        </button>
        <div class="logout-modal-body-wrapper">
            <div class="logout-modal-icon-badge">
                <iconify-icon icon="solar:logout-3-bold-duotone" width="26" height="26"></iconify-icon>
            </div>
            <div class="logout-modal-content">
                <h3 class="logout-modal-title">Konfirmasi Keluar</h3>
                <p class="logout-modal-desc">
                    Apakah Anda yakin ingin keluar dari akun Admin? Sesi Anda saat ini akan diakhiri.
                </p>
            </div>
        </div>
        <div class="logout-modal-actions">
            <button type="button" class="btn-logout-cancel" id="cancelLogoutBtn">
                <iconify-icon icon="solar:close-square-linear" width="18" height="18"></iconify-icon>
                <span>Batal</span>
            </button>
            <form action="{{ url('/logout') }}" method="POST" class="logout-form-inline">
                @csrf
                <button type="submit" class="btn-logout-confirm">
                    <iconify-icon icon="solar:logout-2-bold" width="18" height="18"></iconify-icon>
                    <span>Ya, Keluar</span>
                </button>
            </form>
        </div>
    </div>
</div>
