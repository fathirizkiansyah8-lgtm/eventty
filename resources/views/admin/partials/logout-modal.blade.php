{{-- Reusable logout confirmation modal --}}
<div class="admin-modal-overlay" id="logoutModal">
    <div class="admin-modal">
        <div class="admin-modal-hd">
            <div class="admin-modal-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <h3 class="admin-modal-title">Konfirmasi Keluar</h3>
        </div>
        <div class="admin-modal-body">Apakah Anda yakin ingin keluar dari akun Admin?</div>
        <div class="admin-modal-ft">
            <button type="button" class="abtn abtn-secondary" id="cancelLogoutBtn">Batal</button>
            <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="abtn abtn-danger">Ya, Keluar</button>
            </form>
        </div>
    </div>
</div>
